<?php

declare (strict_types=1);
namespace Stripe\Http_Client;

use Stripe\Exception;
use Stripe\Stripe;
use Stripe\Util;
// @codingStandardsIgnoreStart
// PSR2 requires all constants be upper case. Sadly, the CURL_SSLVERSION
// constants do not abide by those rules.
// Note the values come from their position in the enums that
// defines them in cURL's source code.
// Available since PHP 5.5.19 and 5.6.3
if (!\defined('CURL_SSLVERSION_TLSv1_2')) {
    \define('CURL_SSLVERSION_TLSv1_2', 6);
}
// @codingStandardsIgnoreEnd
// Available since PHP 7.0.7 and cURL 7.47.0
if (!\defined('CURL_HTTP_VERSION_2TLS')) {
    \define('CURL_HTTP_VERSION_2TLS', 4);
}
class Curl_Client implements Client_Interface, Streaming_Client_Interface
{
    protected static $instance;
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    /** @var \Stripe\Util\RandomGenerator */
    protected $random_generator;
    protected $user_agent_info;
    protected $enable_persistent_connections = true;
    protected $enable_http2;
    protected $curl_handle;
    protected $request_status_callback;
    /**
     * CurlClient constructor.
     *
     * Pass in a callable to $defaultOptions that returns an array of CURLOPT_* values to start
     * off a request with, or an flat array with the same format used by curl_setopt_array() to
     * provide a static set of options. Note that many options are overridden later in the request
     * call, including timeouts, which can be set via setTimeout() and setConnectTimeout().
     *
     * Note that request() will silently ignore a non-callable, non-array $defaultOptions, and will
     * throw an exception if $defaultOptions returns a non-array value.
     *
     * @param null|array|callable $defaultOptions
     * @param null|\Stripe\Util\RandomGenerator $randomGenerator
     */
    public function __construct(protected $default_options = null, $random_generator = null)
    {
        $this->random_generator = $random_generator ?: new Util\Random_Generator();
        $this->init_user_agent_info();
        $this->enable_http2 = $this->can_safely_use_http2();
    }
    public function __destruct()
    {
        $this->close_curl_handle();
    }
    public function init_user_agent_info(): void
    {
        $curl_version = \curl_version();
        $this->user_agent_info = ['httplib' => 'curl ' . $curl_version['version'], 'ssllib' => $curl_version['ssl_version']];
    }
    public function get_default_options()
    {
        return $this->default_options;
    }
    public function get_user_agent_info()
    {
        return $this->user_agent_info;
    }
    /**
     * @return bool
     */
    public function get_enable_persistent_connections()
    {
        return $this->enable_persistent_connections;
    }
    /**
     * @param bool $enable
     */
    public function set_enable_persistent_connections($enable): void
    {
        $this->enable_persistent_connections = $enable;
    }
    /**
     * @return bool
     */
    public function get_enable_http2()
    {
        return $this->enable_http2;
    }
    /**
     * @param bool $enable
     */
    public function set_enable_http2($enable): void
    {
        $this->enable_http2 = $enable;
    }
    /**
     * @return null|callable
     */
    public function get_request_status_callback()
    {
        return $this->request_status_callback;
    }
    /**
     * Sets a callback that is called after each request. The callback will
     * receive the following parameters:
     * <ol>
     *   <li>string $rbody The response body</li>
     *   <li>integer $rcode The response status code</li>
     *   <li>\Stripe\Util\CaseInsensitiveArray $rheaders The response headers</li>
     *   <li>integer $errno The curl error number</li>
     *   <li>string|null $message The curl error message</li>
     *   <li>boolean $shouldRetry Whether the request will be retried</li>
     *   <li>integer $numRetries The number of the retry attempt</li>
     * </ol>.
     *
     * @param null|callable $requestStatusCallback
     */
    public function set_request_status_callback($request_status_callback): void
    {
        $this->request_status_callback = $request_status_callback;
    }
    // USER DEFINED TIMEOUTS
    public const DEFAULT_TIMEOUT = 80;
    public const DEFAULT_CONNECT_TIMEOUT = 30;
    private int $timeout = self::DEFAULT_TIMEOUT;
    private int $connect_timeout = self::DEFAULT_CONNECT_TIMEOUT;
    public function set_timeout($seconds): static
    {
        $this->timeout = (int) \max($seconds, 0);
        return $this;
    }
    public function set_connect_timeout($seconds): static
    {
        $this->connect_timeout = (int) \max($seconds, 0);
        return $this;
    }
    public function get_timeout()
    {
        return $this->timeout;
    }
    public function get_connect_timeout()
    {
        return $this->connect_timeout;
    }
    // END OF USER DEFINED TIMEOUTS
    private function construct_request($method, $abs_url, $headers, $params, $has_file): array
    {
        $method = \strtolower((string) $method);
        $opts = [];
        if (\is_callable($this->default_options)) {
            // call defaultOptions callback, set options to return value
            $opts = \call_user_func_array($this->default_options, \func_get_args());
            if (!\is_array($opts)) {
                throw new Exception\UnexpectedValueException('Non-array value returned by defaultOptions CurlClient callback');
            }
        } elseif (\is_array($this->default_options)) {
            // set default curlopts from array
            $opts = $this->default_options;
        }
        $params = Util\Util::objects_to_ids($params);
        if ('get' === $method) {
            if ($has_file) {
                throw new Exception\UnexpectedValueException('Issuing a GET request with a file parameter');
            }
            $opts[\CURLOPT_HTTPGET] = 1;
            if (\count($params) > 0) {
                $encoded = Util\Util::encode_parameters($params);
                $abs_url = "{$abs_url}?{$encoded}";
            }
        } elseif ('post' === $method) {
            $opts[\CURLOPT_POST] = 1;
            $opts[\CURLOPT_POSTFIELDS] = $has_file ? $params : Util\Util::encode_parameters($params);
        } elseif ('delete' === $method) {
            $opts[\CURLOPT_CUSTOMREQUEST] = 'DELETE';
            if (\count($params) > 0) {
                $encoded = Util\Util::encode_parameters($params);
                $abs_url = "{$abs_url}?{$encoded}";
            }
        } else {
            throw new Exception\UnexpectedValueException("Unrecognized method {$method}");
        }
        // It is only safe to retry network failures on POST requests if we
        // add an Idempotency-Key header
        if ('post' === $method && Stripe::$max_network_retries > 0) {
            if (!$this->has_header($headers, 'Idempotency-Key')) {
                $headers[] = 'Idempotency-Key: ' . $this->random_generator->uuid();
            }
        }
        // By default for large request body sizes (> 1024 bytes), cURL will
        // send a request without a body and with a `Expect: 100-continue`
        // header, which gives the server a chance to respond with an error
        // status code in cases where one can be determined right away (say
        // on an authentication problem for example), and saves the "large"
        // request body from being ever sent.
        //
        // Unfortunately, the bindings don't currently correctly handle the
        // success case (in which the server sends back a 100 CONTINUE), so
        // we'll error under that condition. To compensate for that problem
        // for the time being, override cURL's behavior by simply always
        // sending an empty `Expect:` header.
        $headers[] = 'Expect: ';
        $abs_url = Util\Util::utf8($abs_url);
        $opts[\CURLOPT_URL] = $abs_url;
        $opts[\CURLOPT_RETURNTRANSFER] = true;
        $opts[\CURLOPT_CONNECTTIMEOUT] = $this->connect_timeout;
        $opts[\CURLOPT_TIMEOUT] = $this->timeout;
        $opts[\CURLOPT_HTTPHEADER] = $headers;
        $opts[\CURLOPT_CAINFO] = Stripe::get_ca_bundle_path();
        if (!Stripe::get_verify_ssl_certs()) {
            $opts[\CURLOPT_SSL_VERIFYPEER] = false;
        }
        if (!isset($opts[\CURLOPT_HTTP_VERSION]) && $this->get_enable_http2()) {
            // For HTTPS requests, enable HTTP/2, if supported
            $opts[\CURLOPT_HTTP_VERSION] = \CURL_HTTP_VERSION_2TLS;
        }
        // If the user didn't explicitly specify a CURLOPT_IPRESOLVE option, we
        // force IPv4 resolving as Stripe's API servers are only accessible over
        // IPv4 (see. https://github.com/stripe/stripe-php/issues/1045).
        // We let users specify a custom option in case they need to say proxy
        // through an IPv6 proxy.
        if (!isset($opts[\CURLOPT_IPRESOLVE])) {
            $opts[\CURLOPT_IPRESOLVE] = \CURL_IPRESOLVE_V4;
        }
        return [$opts, $abs_url];
    }
    public function request($method, $abs_url, $headers, $params, $has_file): array
    {
        [$opts, $abs_url] = $this->construct_request($method, $abs_url, $headers, $params, $has_file);
        [$rbody, $rcode, $rheaders] = $this->execute_request_with_retries($opts, $abs_url);
        return [$rbody, $rcode, $rheaders];
    }
    public function request_stream($method, $abs_url, $headers, $params, $has_file, $read_body_chunk): array
    {
        [$opts, $abs_url] = $this->construct_request($method, $abs_url, $headers, $params, $has_file);
        $opts[\CURLOPT_RETURNTRANSFER] = false;
        [$rbody, $rcode, $rheaders] = $this->execute_streaming_request_with_retries($opts, $abs_url, $read_body_chunk);
        return [$rbody, $rcode, $rheaders];
    }
    /**
     * Curl permits sending \CURLOPT_HEADERFUNCTION, which is called with lines
     * from the header and \CURLOPT_WRITEFUNCTION, which is called with bytes
     * from the body. You usually want to handle the body differently depending
     * on what was in the header.
     *
     * This function makes it easier to specify different callbacks depending
     * on the contents of the heeder. After the header has been completely read
     * and the body begins to stream, it will call $determineWriteCallback with
     * the array of headers. $determineWriteCallback should, based on the
     * headers it receives, return a "writeCallback" that describes what to do
     * with the incoming HTTP response body.
     *
     * @param callable $determineWriteCallback
     *
     */
    private function use_headers_to_determine_write_callback(\Closure $determine_write_callback): array
    {
        $rheaders = new Util\Case_Insensitive_Array();
        $header_callback = function ($curl, $header_line) use (&$rheaders) {
            return self::parse_line_into_header_array($header_line, $rheaders);
        };
        $write_callback = null;
        $write_callback_wrapper = function ($curl, $data) use (&$write_callback, &$rheaders, &$determine_write_callback) {
            if (null === $write_callback) {
                $write_callback = \call_user_func_array($determine_write_callback, [$rheaders]);
            }
            return \call_user_func_array($write_callback, [$curl, $data]);
        };
        return [$header_callback, $write_callback_wrapper];
    }
    private static function parse_line_into_header_array($line, array &$headers): int
    {
        if (!str_contains((string) $line, ':')) {
            return \strlen((string) $line);
        }
        [$key, $value] = \explode(':', \trim((string) $line), 2);
        $headers[\trim($key)] = \trim($value);
        return \strlen((string) $line);
    }
    /**
     * Like `executeRequestWithRetries` except:
     *   1. Does not buffer the body of a successful (status code < 300)
     *      response into memory -- instead, calls the caller-provided
     *      $readBodyChunk with each chunk of incoming data.
     *   2. Does not retry if a network error occurs while streaming the
     *      body of a successful response.
     *
     * @param array $opts cURL options
     * @param string $absUrl
     * @param callable $readBodyChunk
     */
    public function execute_streaming_request_with_retries(array $opts, $abs_url, $read_body_chunk): array
    {
        /** @var bool */
        $should_retry = false;
        /** @var int */
        $num_retries = 0;
        // Will contain the bytes of the body of the last request
        // if it was not successful and should not be retries
        /** @var null|string */
        $rbody = null;
        // Status code of the last request
        /** @var null|bool */
        $rcode = null;
        // Array of headers from the last request
        /** @var null|array */
        $last_r_headers = null;
        $errno = null;
        $message = null;
        $determine_write_callback = function ($rheaders) use (&$read_body_chunk, &$should_retry, &$rbody, &$num_retries, &$rcode, &$last_r_headers, &$errno): \Closure {
            $last_r_headers = $rheaders;
            $errno = \curl_errno($this->curl_handle);
            $rcode = \curl_getinfo($this->curl_handle, \CURLINFO_HTTP_CODE);
            // Send the bytes from the body of a successful request to the caller-provided $readBodyChunk.
            if ($rcode < 300) {
                $rbody = null;
                return function ($curl, $data) use (&$read_body_chunk): int {
                    // Don't expose the $curl handle to the user, and don't require them to
                    // return the length of $data.
                    \call_user_func_array($read_body_chunk, [$data]);
                    return \strlen($data);
                };
            }
            $should_retry = $this->should_retry($errno, $rcode, $rheaders, $num_retries);
            // Discard the body from an unsuccessful request that should be retried.
            if ($should_retry) {
                return fn($curl, $data) => \strlen($data);
            }
            // Otherwise, buffer the body into $rbody. It will need to be parsed to determine
            // which exception to throw to the user.
            $rbody = '';
            return function ($curl, string $data) use (&$rbody): int {
                $rbody .= $data;
                return \strlen($data);
            };
        };
        while (true) {
            [$header_callback, $write_callback] = $this->use_headers_to_determine_write_callback($determine_write_callback);
            $opts[\CURLOPT_HEADERFUNCTION] = $header_callback;
            $opts[\CURLOPT_WRITEFUNCTION] = $write_callback;
            $should_retry = false;
            $rbody = null;
            $this->reset_curl_handle();
            \curl_setopt_array($this->curl_handle, $opts);
            $result = \curl_exec($this->curl_handle);
            $errno = \curl_errno($this->curl_handle);
            if (0 !== $errno) {
                $message = \curl_error($this->curl_handle);
            }
            if (!$this->get_enable_persistent_connections()) {
                $this->close_curl_handle();
            }
            if (\is_callable($this->get_request_status_callback())) {
                \call_user_func_array($this->get_request_status_callback(), [$rbody, $rcode, $last_r_headers, $errno, $message, $should_retry, $num_retries]);
            }
            if ($should_retry) {
                ++$num_retries;
                $sleep_seconds = $this->sleep_time($num_retries, $last_r_headers);
                \usleep((int) ($sleep_seconds * 1000000));
            } else {
                break;
            }
        }
        if (0 !== $errno) {
            $this->handle_curl_error($abs_url, $errno, $message, $num_retries);
        }
        return [$rbody, $rcode, $last_r_headers];
    }
    /**
     * @param array $opts cURL options
     * @param string $absUrl
     */
    public function execute_request_with_retries(array $opts, $abs_url): array
    {
        $num_retries = 0;
        while (true) {
            $rcode = 0;
            $errno = 0;
            $message = null;
            // Create a callback to capture HTTP headers for the response
            $rheaders = new Util\Case_Insensitive_Array();
            $header_callback = function ($curl, $header_line) use (&$rheaders) {
                return Curl_Client::parse_line_into_header_array($header_line, $rheaders);
            };
            $opts[\CURLOPT_HEADERFUNCTION] = $header_callback;
            $this->reset_curl_handle();
            \curl_setopt_array($this->curl_handle, $opts);
            $rbody = \curl_exec($this->curl_handle);
            if (false === $rbody) {
                $errno = \curl_errno($this->curl_handle);
                $message = \curl_error($this->curl_handle);
            } else {
                $rcode = \curl_getinfo($this->curl_handle, \CURLINFO_HTTP_CODE);
            }
            if (!$this->get_enable_persistent_connections()) {
                $this->close_curl_handle();
            }
            $should_retry = $this->should_retry($errno, $rcode, $rheaders, $num_retries);
            if (\is_callable($this->get_request_status_callback())) {
                \call_user_func_array($this->get_request_status_callback(), [$rbody, $rcode, $rheaders, $errno, $message, $should_retry, $num_retries]);
            }
            if ($should_retry) {
                ++$num_retries;
                $sleep_seconds = $this->sleep_time($num_retries, $rheaders);
                \usleep((int) ($sleep_seconds * 1000000));
            } else {
                break;
            }
        }
        if (false === $rbody) {
            $this->handle_curl_error($abs_url, $errno, $message, $num_retries);
        }
        return [$rbody, $rcode, $rheaders];
    }
    /**
     * @param string $url
     * @param string $message
     *
     * @throws Exception\ApiConnectionException
     */
    private function handle_curl_error($url, int $errno, ?string $message, int $num_retries): void
    {
        $msg = match ($errno) {
            \CURLE_COULDNT_CONNECT, \CURLE_COULDNT_RESOLVE_HOST, \CURLE_OPERATION_TIMEOUTED => "Could not connect to Stripe ({$url}).  Please check your " . 'internet connection and try again.  If this problem persists, ' . "you should check Stripe's service status at " . 'https://twitter.com/stripestatus, or',
            \CURLE_SSL_CACERT, \CURLE_SSL_PEER_CERTIFICATE => "Could not verify Stripe's SSL certificate.  Please make sure " . 'that your network is not intercepting certificates.  ' . "(Try going to {$url} in your browser.)  " . 'If this problem persists,',
            default => 'Unexpected error communicating with Stripe.  ' . 'If this problem persists,',
        };
        $msg .= ' let us know at support@stripe.com.';
        $msg .= "\n\n(Network error [errno {$errno}]: {$message})";
        if ($num_retries > 0) {
            $msg .= "\n\nRequest was retried {$num_retries} times.";
        }
        throw new Exception\Api_Connection_Exception($msg);
    }
    /**
     * Checks if an error is a problem that we should retry on. This includes both
     * socket errors that may represent an intermittent problem and some special
     * HTTP statuses.
     *
     * @param int $rcode
     * @param array|\Stripe\Util\CaseInsensitiveArray $rheaders
     *
     */
    private function should_retry(int $errno, $rcode, $rheaders, int $num_retries): bool
    {
        if ($num_retries >= Stripe::get_max_network_retries()) {
            return false;
        }
        // Retry on timeout-related problems (either on open or read).
        if (\CURLE_OPERATION_TIMEOUTED === $errno) {
            return true;
        }
        // Destination refused the connection, the connection was reset, or a
        // variety of other connection failures. This could occur from a single
        // saturated server, so retry in case it's intermittent.
        if (\CURLE_COULDNT_CONNECT === $errno) {
            return true;
        }
        // The API may ask us not to retry (eg; if doing so would be a no-op)
        // or advise us to retry (eg; in cases of lock timeouts); we defer to that.
        if (isset($rheaders['stripe-should-retry'])) {
            if ('false' === $rheaders['stripe-should-retry']) {
                return false;
            }
            if ('true' === $rheaders['stripe-should-retry']) {
                return true;
            }
        }
        // 409 Conflict
        if (409 === $rcode) {
            return true;
        }
        // Retry on 500, 503, and other internal errors.
        //
        // Note that we expect the stripe-should-retry header to be false
        // in most cases when a 500 is returned, since our idempotency framework
        // would typically replay it anyway.
        if ($rcode >= 500) {
            return true;
        }
        return false;
    }
    /**
     * Provides the number of seconds to wait before retrying a request.
     *
     * @param array|\Stripe\Util\CaseInsensitiveArray $rheaders
     * @return int
     */
    private function sleep_time(int $num_retries, $rheaders)
    {
        // Apply exponential backoff with $initialNetworkRetryDelay on the
        // number of $numRetries so far as inputs. Do not allow the number to exceed
        // $maxNetworkRetryDelay.
        $sleep_seconds = \min(Stripe::get_initial_network_retry_delay() * 1.0 * 2 ** ($num_retries - 1), Stripe::get_max_network_retry_delay());
        // Apply some jitter by randomizing the value in the range of
        // ($sleepSeconds / 2) to ($sleepSeconds).
        $sleep_seconds *= 0.5 * (1 + $this->random_generator->rand_float());
        // But never sleep less than the base sleep seconds.
        $sleep_seconds = \max(Stripe::get_initial_network_retry_delay(), $sleep_seconds);
        // And never sleep less than the time the API asks us to wait, assuming it's a reasonable ask.
        $retry_after = isset($rheaders['retry-after']) ? (float) $rheaders['retry-after'] : 0.0;
        if (\floor($retry_after) === $retry_after && $retry_after <= Stripe::get_max_retry_after()) {
            return \max($sleep_seconds, $retry_after);
        }
        return $sleep_seconds;
    }
    /**
     * Initializes the curl handle. If already initialized, the handle is closed first.
     */
    private function init_curl_handle(): void
    {
        $this->close_curl_handle();
        $this->curl_handle = \curl_init();
    }
    /**
     * Closes the curl handle if initialized. Do nothing if already closed.
     */
    private function close_curl_handle(): void
    {
        if (null !== $this->curl_handle) {
            \curl_close($this->curl_handle);
            $this->curl_handle = null;
        }
    }
    /**
     * Resets the curl handle. If the handle is not already initialized, or if persistent
     * connections are disabled, the handle is reinitialized instead.
     */
    private function reset_curl_handle(): void
    {
        if (null !== $this->curl_handle && $this->get_enable_persistent_connections()) {
            \curl_reset($this->curl_handle);
        } else {
            $this->init_curl_handle();
        }
    }
    /**
     * Indicates whether it is safe to use HTTP/2 or not.
     */
    private function can_safely_use_http2(): bool
    {
        // Versions of curl older than 7.60.0 don't respect GOAWAY frames
        // (cf. https://github.com/curl/curl/issues/2416), which Stripe use.
        $curl_version = \curl_version()['version'];
        return \version_compare($curl_version, '7.60.0') >= 0;
    }
    /**
     * Checks if a list of headers contains a specific header name.
     *
     * @param string[] $headers
     *
     */
    private function has_header($headers, string $name): bool
    {
        foreach ($headers as $header) {
            if (0 === \strncasecmp($header, "{$name}: ", \strlen($name) + 2)) {
                return true;
            }
        }
        return false;
    }
}
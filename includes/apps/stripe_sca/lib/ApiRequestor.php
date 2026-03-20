<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class ApiRequestor.
 */
class Api_Requestor
{
    /**
     * @var string
     */
    private $_api_base;
    /**
     * @var HttpClient\ClientInterface
     */
    private static $_http_client;
    /**
     * @var HttpClient\StreamingClientInterface
     */
    private static $_streaming_http_client;
    private static ?\Stripe\Request_Telemetry $request_telemetry = null;
    private static array $OPTIONS_KEYS = ['api_key', 'idempotency_key', 'stripe_account', 'stripe_version', 'api_base'];
    /**
     * ApiRequestor constructor.
     *
     * @param null|string $_apiKey
     * @param null|string $apiBase
     */
    public function __construct(private $_api_key = null, $api_base = null)
    {
        if (!$api_base) {
            $api_base = Stripe::$api_base;
        }
        $this->_api_base = $api_base;
    }
    /**
     * Creates a telemetry json blob for use in 'X-Stripe-Client-Telemetry' headers.
     *
     * @static
     *
     * @param RequestTelemetry $requestTelemetry
     */
    private static function _telemetry_json($request_telemetry): string
    {
        $payload = ['last_request_metrics' => ['request_id' => $request_telemetry->request_id, 'request_duration_ms' => $request_telemetry->request_duration]];
        $result = \json_encode($payload);
        if (false !== $result) {
            return $result;
        }
        Stripe::get_logger()->error('Serializing telemetry payload failed!');
        return '{}';
    }
    /**
     * @static
     *
     * @param ApiResource|array|bool|mixed $d
     *
     * @return ApiResource|array|mixed|string
     */
    private static function _encode_objects($d)
    {
        if ($d instanceof Api_Resource) {
            return Util\Util::utf8($d->id);
        }
        if (true === $d) {
            return 'true';
        }
        if (false === $d) {
            return 'false';
        }
        if (\is_array($d)) {
            $res = [];
            foreach ($d as $k => $v) {
                $res[$k] = self::_encode_objects($v);
            }
            return $res;
        }
        return Util\Util::utf8($d);
    }
    /**
     * @param string     $method
     * @param string     $url
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws Exception\ApiErrorException
     *
     * @return array tuple containing (ApiReponse, API key)
     */
    public function request($method, $url, $params = null, $headers = null): array
    {
        $params = $params ?: [];
        $headers = $headers ?: [];
        [$rbody, $rcode, $rheaders, $my_api_key] = $this->_request_raw($method, $url, $params, $headers);
        $json = $this->_interpret_response($rbody, $rcode, $rheaders);
        $resp = new Api_Response($rbody, $rcode, $rheaders, $json);
        return [$resp, $my_api_key];
    }
    /**
     * @param string     $method
     * @param string     $url
     * @param callable $readBodyChunkCallable
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws Exception\ApiErrorException
     */
    public function request_stream($method, $url, $read_body_chunk_callable, $params = null, $headers = null): void
    {
        $params = $params ?: [];
        $headers = $headers ?: [];
        [$rbody, $rcode, $rheaders, $my_api_key] = $this->_request_raw_streaming($method, $url, $params, $headers, $read_body_chunk_callable);
        if ($rcode >= 300) {
            $this->_interpret_response($rbody, $rcode, $rheaders);
        }
    }
    /**
     * @param string $rbody a JSON string
     * @param int $rcode
     * @param array $rheaders
     * @param array $resp
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     */
    public function handle_error_response($rbody, $rcode, $rheaders, $resp): void
    {
        if (!\is_array($resp) || !isset($resp['error'])) {
            $msg = "Invalid response object from API: {$rbody} " . "(HTTP response code was {$rcode})";
            throw new Exception\UnexpectedValueException($msg);
        }
        $error_data = $resp['error'];
        $error = null;
        if (\is_string($error_data)) {
            $error = self::_specific_o_auth_error($rbody, $rcode, $rheaders, $resp, $error_data);
        }
        if (!$error) {
            $error = self::_specific_api_error($rbody, $rcode, $rheaders, $resp, $error_data);
        }
        throw $error;
    }
    /**
     * @static
     *
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     * @param array  $resp
     *
     * @return Exception\ApiErrorException
     */
    private static function _specific_api_error($rbody, $rcode, $rheaders, $resp, array $error_data)
    {
        $msg = $error_data['message'] ?? null;
        $param = $error_data['param'] ?? null;
        $code = $error_data['code'] ?? null;
        $type = $error_data['type'] ?? null;
        $decline_code = $error_data['decline_code'] ?? null;
        switch ($rcode) {
            case 400:
                // 'rate_limit' code is deprecated, but left here for backwards compatibility
                // for API versions earlier than 2015-09-08
                if ('rate_limit' === $code) {
                    return Exception\Rate_Limit_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }
                if ('idempotency_error' === $type) {
                    return Exception\Idempotency_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
                }
            // no break
            case 404:
                return Exception\Invalid_Request_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
            case 401:
                return Exception\Authentication_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
            case 402:
                return Exception\Card_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $decline_code, $param);
            case 403:
                return Exception\Permission_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
            case 429:
                return Exception\Rate_Limit_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
            default:
                return Exception\Unknown_Api_Error_Exception::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
        }
    }
    /**
     * @static
     *
     * @param bool|string $rbody
     * @param int         $rcode
     * @param array       $rheaders
     *
     * @return Exception\OAuth\OAuthErrorException
     */
    private static function _specific_o_auth_error($rbody, $rcode, $rheaders, array $resp, string $error_code)
    {
        $description = $resp['error_description'] ?? $error_code;
        return match ($error_code) {
            'invalid_client' => Exception\O_Auth\Invalid_Client_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
            'invalid_grant' => Exception\O_Auth\Invalid_Grant_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
            'invalid_request' => Exception\O_Auth\Invalid_Request_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
            'invalid_scope' => Exception\O_Auth\Invalid_Scope_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
            'unsupported_grant_type' => Exception\O_Auth\Unsupported_Grant_Type_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
            'unsupported_response_type' => Exception\O_Auth\Unsupported_Response_Type_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
            default => Exception\O_Auth\Unknown_O_Auth_Error_Exception::factory($description, $rcode, $rbody, $resp, $rheaders, $error_code),
        };
    }
    /**
     * @static
     *
     * @param null|array $appInfo
     *
     * @return null|string
     */
    private static function _format_app_info(array $app_info)
    {
        $string = $app_info['name'];
        if (null !== $app_info['version']) {
            $string .= '/' . $app_info['version'];
        }
        if (null !== $app_info['url']) {
            $string .= ' (' . $app_info['url'] . ')';
        }
        return $string;
    }
    /**
     * @static
     *
     * @param string $disableFunctionsOutput - String value of the 'disable_function' setting, as output by \ini_get('disable_functions')
     * @param string $functionName - Name of the function we are interesting in seeing whether or not it is disabled
     */
    private static function _is_disabled(string|bool $disable_functions_output, string $function_name): bool
    {
        $disabled_functions = \explode(',', $disable_functions_output);
        foreach ($disabled_functions as $disabled_function) {
            if (\trim($disabled_function) === $function_name) {
                return true;
            }
        }
        return false;
    }
    /**
     * @static
     *
     *
     */
    private static function _default_headers(string $api_key, $client_info = null): array
    {
        $ua_string = 'Stripe/v1 PhpBindings/' . Stripe::VERSION;
        $lang_version = \PHP_VERSION;
        $uname_disabled = static::_is_disabled(\ini_get('disable_functions'), 'php_uname');
        $uname = $uname_disabled ? '(disabled)' : \php_uname();
        $app_info = Stripe::get_app_info();
        $ua = ['bindings_version' => Stripe::VERSION, 'lang' => 'php', 'lang_version' => $lang_version, 'publisher' => 'stripe', 'uname' => $uname];
        if ($client_info) {
            $ua = \array_merge($client_info, $ua);
        }
        if (null !== $app_info) {
            $ua_string .= ' ' . self::_format_app_info($app_info);
            $ua['application'] = $app_info;
        }
        return ['X-Stripe-Client-User-Agent' => \json_encode($ua), 'User-Agent' => $ua_string, 'Authorization' => 'Bearer ' . $api_key];
    }
    private function _prepare_request(string $url, $params, $headers): array
    {
        $my_api_key = $this->_api_key;
        if (!$my_api_key) {
            $my_api_key = Stripe::$api_key;
        }
        if (!$my_api_key) {
            $msg = 'No API key provided.  (HINT: set your API key using ' . '"Stripe::setApiKey(<API-KEY>)".  You can generate API keys from ' . 'the Stripe web interface.  See https://stripe.com/api for ' . 'details, or email support@stripe.com if you have any questions.';
            throw new Exception\Authentication_Exception($msg);
        }
        // Clients can supply arbitrary additional keys to be included in the
        // X-Stripe-Client-User-Agent header via the optional getUserAgentInfo()
        // method
        $client_ua_info = null;
        if (\method_exists($this->http_client(), 'getUserAgentInfo')) {
            $client_ua_info = $this->http_client()->get_user_agent_info();
        }
        if ($params && \is_array($params)) {
            $option_keys_in_params = \array_filter(static::$OPTIONS_KEYS, fn($key) => \array_key_exists($key, $params));
            if (\count($option_keys_in_params) > 0) {
                $message = \sprintf('Options found in $params: %s. Options should ' . 'be passed in their own array after $params. (HINT: pass an ' . 'empty array to $params if you do not have any.)', \implode(', ', $option_keys_in_params));
                \trigger_error($message, \E_USER_WARNING);
            }
        }
        $abs_url = $this->_api_base . $url;
        $params = self::_encode_objects($params);
        $default_headers = self::_default_headers($my_api_key, $client_ua_info);
        if (Stripe::$api_version) {
            $default_headers['Stripe-Version'] = Stripe::$api_version;
        }
        if (Stripe::$account_id) {
            $default_headers['Stripe-Account'] = Stripe::$account_id;
        }
        if (Stripe::$enable_telemetry && null !== self::$request_telemetry) {
            $default_headers['X-Stripe-Client-Telemetry'] = self::_telemetry_json(self::$request_telemetry);
        }
        $has_file = false;
        foreach ($params as $k => $v) {
            if (\is_resource($v)) {
                $has_file = true;
                $params[$k] = self::_process_resource_param($v);
            } elseif ($v instanceof \Curl_File) {
                $has_file = true;
            }
        }
        if ($has_file) {
            $default_headers['Content-Type'] = 'multipart/form-data';
        } else {
            $default_headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }
        $combined_headers = \array_merge($default_headers, $headers);
        $raw_headers = [];
        foreach ($combined_headers as $header => $value) {
            $raw_headers[] = $header . ': ' . $value;
        }
        return [$abs_url, $raw_headers, $params, $has_file, $my_api_key];
    }
    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     *
     * @throws Exception\AuthenticationException
     * @throws Exception\ApiConnectionException
     */
    private function _request_raw($method, $url, $params, $headers): array
    {
        [$abs_url, $raw_headers, $params, $has_file, $my_api_key] = $this->_prepare_request($url, $params, $headers);
        $request_start_ms = Util\Util::current_time_millis();
        [$rbody, $rcode, $rheaders] = $this->http_client()->request($method, $abs_url, $raw_headers, $params, $has_file);
        if (isset($rheaders['request-id']) && \is_string($rheaders['request-id']) && '' !== $rheaders['request-id']) {
            self::$request_telemetry = new Request_Telemetry($rheaders['request-id'], Util\Util::current_time_millis() - $request_start_ms);
        }
        return [$rbody, $rcode, $rheaders, $my_api_key];
    }
    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param callable $readBodyChunkCallable
     *
     * @throws Exception\AuthenticationException
     * @throws Exception\ApiConnectionException
     */
    private function _request_raw_streaming($method, $url, $params, $headers, $read_body_chunk_callable): array
    {
        [$abs_url, $raw_headers, $params, $has_file, $my_api_key] = $this->_prepare_request($url, $params, $headers);
        $request_start_ms = Util\Util::current_time_millis();
        [$rbody, $rcode, $rheaders] = $this->streaming_http_client()->request_stream($method, $abs_url, $raw_headers, $params, $has_file, $read_body_chunk_callable);
        if (isset($rheaders['request-id']) && \is_string($rheaders['request-id']) && '' !== $rheaders['request-id']) {
            self::$request_telemetry = new Request_Telemetry($rheaders['request-id'], Util\Util::current_time_millis() - $request_start_ms);
        }
        return [$rbody, $rcode, $rheaders, $my_api_key];
    }
    /**
     * @param resource $resource
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return \CURLFile|string
     */
    private function _process_resource_param($resource): \Curl_File
    {
        if ('stream' !== \get_resource_type($resource)) {
            throw new Exception\InvalidArgumentException('Attempted to upload a resource that is not a stream');
        }
        $meta_data = \stream_get_meta_data($resource);
        if ('plainfile' !== $meta_data['wrapper_type']) {
            throw new Exception\InvalidArgumentException('Only plainfile resource streams are supported');
        }
        // We don't have the filename or mimetype, but the API doesn't care
        return new \Curl_File($meta_data['uri']);
    }
    /**
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     *
     * @return array
     */
    private function _interpret_response($rbody, $rcode, $rheaders)
    {
        $resp = \json_decode($rbody, true);
        $json_error = \json_last_error();
        if (null === $resp && \JSON_ERROR_NONE !== $json_error) {
            $msg = "Invalid response body from API: {$rbody} " . "(HTTP response code was {$rcode}, json_last_error() was {$json_error})";
            throw new Exception\UnexpectedValueException($msg, $rcode);
        }
        if ($rcode < 200 || $rcode >= 300) {
            $this->handle_error_response($rbody, $rcode, $rheaders, $resp);
        }
        return $resp;
    }
    /**
     * @static
     *
     * @param HttpClient\ClientInterface $client
     */
    public static function set_http_client($client): void
    {
        self::$_http_client = $client;
    }
    /**
     * @static
     *
     * @param HttpClient\StreamingClientInterface $client
     */
    public static function set_streaming_http_client($client): void
    {
        self::$_streaming_http_client = $client;
    }
    /**
     * @static
     *
     * Resets any stateful telemetry data
     */
    public static function reset_telemetry(): void
    {
        self::$request_telemetry = null;
    }
    /**
     * @return HttpClient\ClientInterface
     */
    private function http_client()
    {
        if (!self::$_http_client) {
            self::$_http_client = Http_Client\Curl_Client::instance();
        }
        return self::$_http_client;
    }
    /**
     * @return HttpClient\StreamingClientInterface
     */
    private function streaming_http_client()
    {
        if (!self::$_streaming_http_client) {
            self::$_streaming_http_client = Http_Client\Curl_Client::instance();
        }
        return self::$_streaming_http_client;
    }
}
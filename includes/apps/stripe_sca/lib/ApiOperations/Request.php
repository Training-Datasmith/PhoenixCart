<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for resources that need to make API requests.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Request
{
    /**
     * @param null|array|mixed $params The list of parameters to validate
     *
     * @throws \Stripe\Exception\InvalidArgumentException if $params exists and is not an array
     */
    protected static function _validate_params($params = null)
    {
        if ($params && !\is_array($params)) {
            $message = 'You must pass an array as the first argument to Stripe API ' . 'method calls.  (HINT: an example call to create a charge ' . "would be: \"Stripe\\Charge::create(['amount' => 100, " . "'currency' => 'usd', 'source' => 'tok_1234'])\")";
            throw new \Stripe\Exception\InvalidArgumentException($message);
        }
    }
    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array $params list of parameters for the request
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return array tuple containing (the JSON response, $options)
     */
    protected function _request($method, $url, $params = [], $options = null): array
    {
        $opts = $this->_opts->merge($options);
        [$resp, $options] = static::_static_request($method, $url, $params, $opts);
        $this->set_last_response($resp);
        return [$resp->json, $options];
    }
    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param callable $readBodyChunk function that will receive chunks of data from a successful request body
     * @param array $params list of parameters for the request
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     */
    protected function _request_stream($method, $url, $read_body_chunk, $params = [], $options = null)
    {
        $opts = $this->_opts->merge($options);
        static::_static_streaming_request($method, $url, $read_body_chunk, $params, $opts);
    }
    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array $params list of parameters for the request
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return array tuple containing (the JSON response, $options)
     */
    protected static function _static_request($method, $url, $params, $options): array
    {
        $opts = \Stripe\Util\Request_Options::parse($options);
        $base_url = $opts->api_base ?? static::base_url();
        $requestor = new \Stripe\Api_Requestor($opts->api_key, $base_url);
        [$response, $opts->api_key] = $requestor->request($method, $url, $params, $opts->headers);
        $opts->discard_non_persistent_headers();
        return [$response, $opts];
    }
    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param callable $readBodyChunk function that will receive chunks of data from a successful request body
     * @param array $params list of parameters for the request
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     */
    protected static function _static_streaming_request($method, $url, $read_body_chunk, $params, $options)
    {
        $opts = \Stripe\Util\Request_Options::parse($options);
        $base_url = $opts->api_base ?? static::base_url();
        $requestor = new \Stripe\Api_Requestor($opts->api_key, $base_url);
        $requestor->request_stream($method, $url, $read_body_chunk, $params, $opts->headers);
    }
}
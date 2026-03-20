<?php

declare (strict_types=1);
namespace Stripe\Exception;

/**
 * Implements properties and methods common to all (non-SPL) Stripe exceptions.
 */
abstract class Api_Error_Exception extends \Exception implements Exception_Interface
{
    protected $error;
    protected $http_body;
    protected $http_headers;
    protected $http_status;
    protected $json_body;
    protected $request_id;
    protected $stripe_code;
    /**
     * Creates a new API error exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|\Stripe\Util\CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $stripeCode the Stripe error code
     *
     * @return static
     */
    public static function factory($message, $http_status = null, $http_body = null, $json_body = null, $http_headers = null, $stripe_code = null)
    {
        $instance = new static($message);
        $instance->set_http_status($http_status);
        $instance->set_http_body($http_body);
        $instance->set_json_body($json_body);
        $instance->set_http_headers($http_headers);
        $instance->set_stripe_code($stripe_code);
        $instance->set_request_id(null);
        if ($http_headers && isset($http_headers['Request-Id'])) {
            $instance->set_request_id($http_headers['Request-Id']);
        }
        $instance->set_error($instance->construct_error_object());
        return $instance;
    }
    /**
     * Gets the Stripe error object.
     *
     * @return null|\Stripe\ErrorObject
     */
    public function get_error()
    {
        return $this->error;
    }
    /**
     * Sets the Stripe error object.
     *
     * @param null|\Stripe\ErrorObject $error
     */
    public function set_error($error): void
    {
        $this->error = $error;
    }
    /**
     * Gets the HTTP body as a string.
     *
     * @return null|string
     */
    public function get_http_body()
    {
        return $this->http_body;
    }
    /**
     * Sets the HTTP body as a string.
     *
     * @param null|string $httpBody
     */
    public function set_http_body($http_body): void
    {
        $this->http_body = $http_body;
    }
    /**
     * Gets the HTTP headers array.
     *
     * @return null|array|\Stripe\Util\CaseInsensitiveArray
     */
    public function get_http_headers()
    {
        return $this->http_headers;
    }
    /**
     * Sets the HTTP headers array.
     *
     * @param null|array|\Stripe\Util\CaseInsensitiveArray $httpHeaders
     */
    public function set_http_headers($http_headers): void
    {
        $this->http_headers = $http_headers;
    }
    /**
     * Gets the HTTP status code.
     *
     * @return null|int
     */
    public function get_http_status()
    {
        return $this->http_status;
    }
    /**
     * Sets the HTTP status code.
     *
     * @param null|int $httpStatus
     */
    public function set_http_status($http_status): void
    {
        $this->http_status = $http_status;
    }
    /**
     * Gets the JSON deserialized body.
     *
     * @return null|array<string, mixed>
     */
    public function get_json_body()
    {
        return $this->json_body;
    }
    /**
     * Sets the JSON deserialized body.
     *
     * @param null|array<string, mixed> $jsonBody
     */
    public function set_json_body($json_body): void
    {
        $this->json_body = $json_body;
    }
    /**
     * Gets the Stripe request ID.
     *
     * @return null|string
     */
    public function get_request_id()
    {
        return $this->request_id;
    }
    /**
     * Sets the Stripe request ID.
     *
     * @param null|string $requestId
     */
    public function set_request_id($request_id): void
    {
        $this->request_id = $request_id;
    }
    /**
     * Gets the Stripe error code.
     *
     * Cf. the `CODE_*` constants on {@see \Stripe\ErrorObject} for possible
     * values.
     *
     * @return null|string
     */
    public function get_stripe_code()
    {
        return $this->stripe_code;
    }
    /**
     * Sets the Stripe error code.
     *
     * @param null|string $stripeCode
     */
    public function set_stripe_code($stripe_code): void
    {
        $this->stripe_code = $stripe_code;
    }
    /**
     * Returns the string representation of the exception.
     */
    public function __toString(): string
    {
        $status_str = null === $this->get_http_status() ? '' : "(Status {$this->get_http_status()}) ";
        $id_str = null === $this->get_request_id() ? '' : "(Request {$this->get_request_id()}) ";
        return "{$status_str}{$id_str}{$this->get_message()}";
    }
    protected function construct_error_object()
    {
        if (null === $this->json_body || !\array_key_exists('error', $this->json_body)) {
            return null;
        }
        return \Stripe\Error_Object::construct_from($this->json_body['error']);
    }
}
<?php

declare (strict_types=1);
namespace Stripe\Exception;

/**
 * InvalidRequestException is thrown when a request is initiated with invalid
 * parameters.
 */
class Invalid_Request_Exception extends Api_Error_Exception
{
    protected $stripe_param;
    /**
     * Creates a new InvalidRequestException exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|\Stripe\Util\CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $stripeCode the Stripe error code
     * @param null|string $stripeParam the parameter related to the error
     *
     * @return InvalidRequestException
     */
    public static function factory($message, $http_status = null, $http_body = null, $json_body = null, $http_headers = null, $stripe_code = null, $stripe_param = null)
    {
        $instance = parent::factory($message, $http_status, $http_body, $json_body, $http_headers, $stripe_code);
        $instance->set_stripe_param($stripe_param);
        return $instance;
    }
    /**
     * Gets the parameter related to the error.
     *
     * @return null|string
     */
    public function get_stripe_param()
    {
        return $this->stripe_param;
    }
    /**
     * Sets the parameter related to the error.
     *
     * @param null|string $stripeParam
     */
    public function set_stripe_param($stripe_param): void
    {
        $this->stripe_param = $stripe_param;
    }
}
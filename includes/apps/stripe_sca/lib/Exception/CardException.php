<?php

declare (strict_types=1);
namespace Stripe\Exception;

/**
 * CardException is thrown when a user enters a card that can't be charged for
 * some reason.
 */
class Card_Exception extends Api_Error_Exception
{
    protected $decline_code;
    protected $stripe_param;
    /**
     * Creates a new CardException exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|\Stripe\Util\CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $stripeCode the Stripe error code
     * @param null|string $declineCode the decline code
     * @param null|string $stripeParam the parameter related to the error
     *
     * @return CardException
     */
    public static function factory($message, $http_status = null, $http_body = null, $json_body = null, $http_headers = null, $stripe_code = null, $decline_code = null, $stripe_param = null)
    {
        $instance = parent::factory($message, $http_status, $http_body, $json_body, $http_headers, $stripe_code);
        $instance->set_decline_code($decline_code);
        $instance->set_stripe_param($stripe_param);
        return $instance;
    }
    /**
     * Gets the decline code.
     *
     * @return null|string
     */
    public function get_decline_code()
    {
        return $this->decline_code;
    }
    /**
     * Sets the decline code.
     *
     * @param null|string $declineCode
     */
    public function set_decline_code($decline_code): void
    {
        $this->decline_code = $decline_code;
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
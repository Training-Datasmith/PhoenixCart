<?php

declare (strict_types=1);
namespace Stripe\Exception;

/**
 * SignatureVerificationException is thrown when the signature verification for
 * a webhook fails.
 */
class Signature_Verification_Exception extends \Exception implements Exception_Interface
{
    protected $http_body;
    protected $sig_header;
    /**
     * Creates a new SignatureVerificationException exception.
     *
     * @param string $message the exception message
     * @param null|string $httpBody the HTTP body as a string
     * @param null|string $sigHeader the `Stripe-Signature` HTTP header
     */
    public static function factory($message, $http_body = null, $sig_header = null): static
    {
        $instance = new static($message);
        $instance->set_http_body($http_body);
        $instance->set_sig_header($sig_header);
        return $instance;
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
     * Gets the `Stripe-Signature` HTTP header.
     *
     * @return null|string
     */
    public function get_sig_header()
    {
        return $this->sig_header;
    }
    /**
     * Sets the `Stripe-Signature` HTTP header.
     *
     * @param null|string $sigHeader
     */
    public function set_sig_header($sig_header): void
    {
        $this->sig_header = $sig_header;
    }
}
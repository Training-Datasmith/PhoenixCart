<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Interface for a Stripe client.
 */
interface Base_Stripe_Client_Interface
{
    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function get_api_key();
    /**
     * Gets the client ID used by the client in OAuth requests.
     *
     * @return null|string the client ID used by the client in OAuth requests
     */
    public function get_client_id();
    /**
     * Gets the base URL for Stripe's API.
     *
     * @return string the base URL for Stripe's API
     */
    public function get_api_base();
    /**
     * Gets the base URL for Stripe's OAuth API.
     *
     * @return string the base URL for Stripe's OAuth API
     */
    public function get_connect_base();
    /**
     * Gets the base URL for Stripe's Files API.
     *
     * @return string the base URL for Stripe's Files API
     */
    public function get_files_base();
}
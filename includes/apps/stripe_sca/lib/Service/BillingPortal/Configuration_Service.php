<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Billing_Portal;

class Configuration_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of configurations that describe the functionality of the customer
     * portal.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\BillingPortal\Configuration>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/billing_portal/configurations', $params, $opts);
    }
    /**
     * Creates a configuration that describes the functionality and behavior of a
     * PortalSession.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BillingPortal\Configuration
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/billing_portal/configurations', $params, $opts);
    }
    /**
     * Retrieves a configuration that describes the functionality of the customer
     * portal.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BillingPortal\Configuration
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/billing_portal/configurations/%s', $id), $params, $opts);
    }
    /**
     * Updates a configuration that describes the functionality of the customer portal.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BillingPortal\Configuration
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/billing_portal/configurations/%s', $id), $params, $opts);
    }
}
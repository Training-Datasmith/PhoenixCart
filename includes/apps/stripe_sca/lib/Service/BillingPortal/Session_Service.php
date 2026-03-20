<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Billing_Portal;

class Session_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Creates a session of the customer portal.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BillingPortal\Session
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/billing_portal/sessions', $params, $opts);
    }
}
<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers\Treasury;

class Outbound_Payment_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Transitions a test mode created OutboundPayment to the <code>failed</code>
     * status. The OutboundPayment must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\OutboundPayment
     */
    public function fail($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/outbound_payments/%s/fail', $id), $params, $opts);
    }
    /**
     * Transitions a test mode created OutboundPayment to the <code>posted</code>
     * status. The OutboundPayment must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\OutboundPayment
     */
    public function post($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/outbound_payments/%s/post', $id), $params, $opts);
    }
    /**
     * Transitions a test mode created OutboundPayment to the <code>returned</code>
     * status. The OutboundPayment must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\OutboundPayment
     */
    public function return_outbound_payment($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/outbound_payments/%s/return', $id), $params, $opts);
    }
}
<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers\Treasury;

class Outbound_Transfer_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Transitions a test mode created OutboundTransfer to the <code>failed</code>
     * status. The OutboundTransfer must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\OutboundTransfer
     */
    public function fail($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/outbound_transfers/%s/fail', $id), $params, $opts);
    }
    /**
     * Transitions a test mode created OutboundTransfer to the <code>posted</code>
     * status. The OutboundTransfer must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\OutboundTransfer
     */
    public function post($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/outbound_transfers/%s/post', $id), $params, $opts);
    }
    /**
     * Transitions a test mode created OutboundTransfer to the <code>returned</code>
     * status. The OutboundTransfer must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\OutboundTransfer
     */
    public function return_outbound_transfer($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/outbound_transfers/%s/return', $id), $params, $opts);
    }
}
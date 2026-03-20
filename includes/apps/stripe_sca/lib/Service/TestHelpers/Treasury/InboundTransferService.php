<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers\Treasury;

class Inbound_Transfer_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Transitions a test mode created InboundTransfer to the <code>failed</code>
     * status. The InboundTransfer must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\InboundTransfer
     */
    public function fail($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/inbound_transfers/%s/fail', $id), $params, $opts);
    }
    /**
     * Marks the test mode InboundTransfer object as returned and links the
     * InboundTransfer to a ReceivedDebit. The InboundTransfer must already be in the
     * <code>succeeded</code> state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\InboundTransfer
     */
    public function return_inbound_transfer($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/inbound_transfers/%s/return', $id), $params, $opts);
    }
    /**
     * Transitions a test mode created InboundTransfer to the <code>succeeded</code>
     * status. The InboundTransfer must already be in the <code>processing</code>
     * state.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\InboundTransfer
     */
    public function succeed($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/treasury/inbound_transfers/%s/succeed', $id), $params, $opts);
    }
}
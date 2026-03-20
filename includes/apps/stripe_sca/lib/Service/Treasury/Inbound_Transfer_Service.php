<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Treasury;

class Inbound_Transfer_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of InboundTransfers sent from the specified FinancialAccount.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Treasury\InboundTransfer>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/treasury/inbound_transfers', $params, $opts);
    }
    /**
     * Cancels an InboundTransfer.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\InboundTransfer
     */
    public function cancel($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/treasury/inbound_transfers/%s/cancel', $id), $params, $opts);
    }
    /**
     * Creates an InboundTransfer.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\InboundTransfer
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/treasury/inbound_transfers', $params, $opts);
    }
    /**
     * Retrieves the details of an existing InboundTransfer.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\InboundTransfer
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/treasury/inbound_transfers/%s', $id), $params, $opts);
    }
}
<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Treasury;

class Received_Debit_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of ReceivedDebits.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Treasury\ReceivedDebit>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/treasury/received_debits', $params, $opts);
    }
    /**
     * Retrieves the details of an existing ReceivedDebit by passing the unique
     * ReceivedDebit ID from the ReceivedDebit list.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\ReceivedDebit
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/treasury/received_debits/%s', $id), $params, $opts);
    }
}
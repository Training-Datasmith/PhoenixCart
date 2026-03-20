<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Treasury;

class Transaction_Entry_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Retrieves a list of TransactionEntry objects.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Treasury\TransactionEntry>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/treasury/transaction_entries', $params, $opts);
    }
    /**
     * Retrieves a TransactionEntry object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\TransactionEntry
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/treasury/transaction_entries/%s', $id), $params, $opts);
    }
}
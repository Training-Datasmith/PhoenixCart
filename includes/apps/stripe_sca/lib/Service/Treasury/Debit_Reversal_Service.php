<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Treasury;

class Debit_Reversal_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of DebitReversals.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Treasury\DebitReversal>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/treasury/debit_reversals', $params, $opts);
    }
    /**
     * Reverses a ReceivedDebit and creates a DebitReversal object.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\DebitReversal
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/treasury/debit_reversals', $params, $opts);
    }
    /**
     * Retrieves a DebitReversal object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\DebitReversal
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/treasury/debit_reversals/%s', $id), $params, $opts);
    }
}
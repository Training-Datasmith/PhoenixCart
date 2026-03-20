<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Financial_Connections;

class Account_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of Financial Connections <code>Account</code> objects.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\FinancialConnections\Account>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/financial_connections/accounts', $params, $opts);
    }
    /**
     * Lists all owners for a given <code>Account</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\FinancialConnections\AccountOwner>
     */
    public function all_owners($id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/financial_connections/accounts/%s/owners', $id), $params, $opts);
    }
    /**
     * Disables your access to a Financial Connections <code>Account</code>. You will
     * no longer be able to access data associated with the account (e.g. balances,
     * transactions).
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\FinancialConnections\Account
     */
    public function disconnect($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/financial_connections/accounts/%s/disconnect', $id), $params, $opts);
    }
    /**
     * Refreshes the data associated with a Financial Connections <code>Account</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\FinancialConnections\Account
     */
    public function refresh($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/financial_connections/accounts/%s/refresh', $id), $params, $opts);
    }
    /**
     * Retrieves the details of an Financial Connections <code>Account</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\FinancialConnections\Account
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/financial_connections/accounts/%s', $id), $params, $opts);
    }
}
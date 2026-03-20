<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers;

class Customer_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Create an incoming testmode bank transfer.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function fund_cash_balance($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/customers/%s/fund_cash_balance', $id), $params, $opts);
    }
}
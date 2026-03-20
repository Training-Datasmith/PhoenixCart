<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers\Terminal;

class Reader_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Presents a payment method on a simulated reader. Can be used to simulate
     * accepting a payment, saving a card or refunding a transaction.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function present_payment_method($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/terminal/readers/%s/present_payment_method', $id), $params, $opts);
    }
}
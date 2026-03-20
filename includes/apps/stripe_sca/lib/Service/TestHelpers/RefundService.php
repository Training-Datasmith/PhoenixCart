<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers;

class Refund_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Expire a refund with a status of <code>requires_action</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Refund
     */
    public function expire($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/refunds/%s/expire', $id), $params, $opts);
    }
}
<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers\Issuing;

class Card_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Updates the shipping status of the specified Issuing <code>Card</code> object to
     * <code>delivered</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Issuing\Card
     */
    public function deliver_card($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/issuing/cards/%s/shipping/deliver', $id), $params, $opts);
    }
    /**
     * Updates the shipping status of the specified Issuing <code>Card</code> object to
     * <code>failure</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Issuing\Card
     */
    public function fail_card($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/issuing/cards/%s/shipping/fail', $id), $params, $opts);
    }
    /**
     * Updates the shipping status of the specified Issuing <code>Card</code> object to
     * <code>returned</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Issuing\Card
     */
    public function return_card($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/issuing/cards/%s/shipping/return', $id), $params, $opts);
    }
    /**
     * Updates the shipping status of the specified Issuing <code>Card</code> object to
     * <code>shipped</code>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Issuing\Card
     */
    public function ship_card($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/test_helpers/issuing/cards/%s/shipping/ship', $id), $params, $opts);
    }
}
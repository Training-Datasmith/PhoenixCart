<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Payment_Link_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of your payment links.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\PaymentLink>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/payment_links', $params, $opts);
    }
    /**
     * When retrieving a payment link, there is an includable
     * <strong>line_items</strong> property containing the first handful of those
     * items. There is also a URL where you can retrieve the full (paginated) list of
     * line items.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\LineItem>
     */
    public function all_line_items($id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/payment_links/%s/line_items', $id), $params, $opts);
    }
    /**
     * Creates a payment link.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentLink
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/payment_links', $params, $opts);
    }
    /**
     * Retrieve a payment link.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentLink
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/payment_links/%s', $id), $params, $opts);
    }
    /**
     * Updates a payment link.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentLink
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/payment_links/%s', $id), $params, $opts);
    }
}
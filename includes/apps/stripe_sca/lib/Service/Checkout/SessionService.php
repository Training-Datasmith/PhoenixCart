<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Checkout;

class Session_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of Checkout Sessions.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Checkout\Session>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/checkout/sessions', $params, $opts);
    }
    /**
     * When retrieving a Checkout Session, there is an includable
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
        return $this->request_collection('get', $this->build_path('/v1/checkout/sessions/%s/line_items', $id), $params, $opts);
    }
    /**
     * Creates a Session object.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Checkout\Session
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/checkout/sessions', $params, $opts);
    }
    /**
     * A Session can be expired when it is in one of these statuses: <code>open</code>.
     *
     * After it expires, a customer can’t complete a Session and customers loading the
     * Session see a message saying the Session is expired.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Checkout\Session
     */
    public function expire($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/checkout/sessions/%s/expire', $id), $params, $opts);
    }
    /**
     * Retrieves a Session object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Checkout\Session
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/checkout/sessions/%s', $id), $params, $opts);
    }
}
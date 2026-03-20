<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Terminal;

class Reader_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of <code>Reader</code> objects.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Terminal\Reader>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/terminal/readers', $params, $opts);
    }
    /**
     * Cancels the current reader action.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function cancel_action($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/terminal/readers/%s/cancel_action', $id), $params, $opts);
    }
    /**
     * Creates a new <code>Reader</code> object.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/terminal/readers', $params, $opts);
    }
    /**
     * Deletes a <code>Reader</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function delete($id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/terminal/readers/%s', $id), $params, $opts);
    }
    /**
     * Initiates a payment flow on a Reader.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function process_payment_intent($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/terminal/readers/%s/process_payment_intent', $id), $params, $opts);
    }
    /**
     * Initiates a setup intent flow on a Reader.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function process_setup_intent($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/terminal/readers/%s/process_setup_intent', $id), $params, $opts);
    }
    /**
     * Retrieves a <code>Reader</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/terminal/readers/%s', $id), $params, $opts);
    }
    /**
     * Sets reader display to show cart details.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function set_reader_display($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/terminal/readers/%s/set_reader_display', $id), $params, $opts);
    }
    /**
     * Updates a <code>Reader</code> object by setting the values of the parameters
     * passed. Any parameters not provided will be left unchanged.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Reader
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/terminal/readers/%s', $id), $params, $opts);
    }
}
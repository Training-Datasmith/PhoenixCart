<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Terminal;

class Configuration_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of <code>Configuration</code> objects.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Terminal\Configuration>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/terminal/configurations', $params, $opts);
    }
    /**
     * Creates a new <code>Configuration</code> object.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Configuration
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/terminal/configurations', $params, $opts);
    }
    /**
     * Deletes a <code>Configuration</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Configuration
     */
    public function delete($id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/terminal/configurations/%s', $id), $params, $opts);
    }
    /**
     * Retrieves a <code>Configuration</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Configuration
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/terminal/configurations/%s', $id), $params, $opts);
    }
    /**
     * Updates a new <code>Configuration</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Terminal\Configuration
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/terminal/configurations/%s', $id), $params, $opts);
    }
}
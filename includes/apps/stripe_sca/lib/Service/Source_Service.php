<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Source_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * List source transactions for a given source.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\SourceTransaction>
     */
    public function all_source_transactions($id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/sources/%s/source_transactions', $id), $params, $opts);
    }
    /**
     * Creates a new source object.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Source
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/sources', $params, $opts);
    }
    /**
     * Delete a specified source for a given customer.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Source
     */
    public function detach($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/customers/%s/sources/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Retrieves an existing source object. Supply the unique source ID from a source
     * creation request and Stripe will return the corresponding up-to-date source
     * object information.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Source
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/sources/%s', $id), $params, $opts);
    }
    /**
     * Updates the specified source by setting the values of the parameters passed. Any
     * parameters not provided will be left unchanged.
     *
     * This request accepts the <code>metadata</code> and <code>owner</code> as
     * arguments. It is also possible to update type specific information for selected
     * payment methods. Please refer to our <a href="/docs/sources">payment method
     * guides</a> for more detail.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Source
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/sources/%s', $id), $params, $opts);
    }
    /**
     * Verify a given source.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Source
     */
    public function verify($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/sources/%s/verify', $id), $params, $opts);
    }
}
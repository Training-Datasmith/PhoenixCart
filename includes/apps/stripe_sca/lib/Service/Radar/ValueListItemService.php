<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Radar;

class Value_List_Item_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of <code>ValueListItem</code> objects. The objects are sorted in
     * descending order by creation date, with the most recently created object
     * appearing first.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Radar\ValueListItem>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/radar/value_list_items', $params, $opts);
    }
    /**
     * Creates a new <code>ValueListItem</code> object, which is added to the specified
     * parent value list.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Radar\ValueListItem
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/radar/value_list_items', $params, $opts);
    }
    /**
     * Deletes a <code>ValueListItem</code> object, removing it from its parent value
     * list.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Radar\ValueListItem
     */
    public function delete($id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/radar/value_list_items/%s', $id), $params, $opts);
    }
    /**
     * Retrieves a <code>ValueListItem</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Radar\ValueListItem
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/radar/value_list_items/%s', $id), $params, $opts);
    }
}
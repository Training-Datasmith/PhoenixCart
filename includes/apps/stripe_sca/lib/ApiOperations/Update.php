<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for updatable resources. Adds an `update()` static method and a
 * `save()` method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Update
{
    /**
     * @param string $id the ID of the resource to update
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return static the updated resource
     */
    public static function update($id, $params = null, $opts = null)
    {
        self::_validate_params($params);
        $url = static::resource_url($id);
        [$response, $opts] = static::_static_request('post', $url, $params, $opts);
        $obj = \Stripe\Util\Util::convert_to_stripe_object($response->json, $opts);
        $obj->set_last_response($response);
        return $obj;
    }
    /**
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return static the saved resource
     *
     * @deprecated The `save` method is deprecated and will be removed in a
     *     future major version of the library. Use the static method `update`
     *     on the resource instead.
     */
    public function save($opts = null)
    {
        $params = $this->serialize_parameters();
        if (\count($params) > 0) {
            $url = $this->instance_url();
            [$response, $opts] = $this->_request('post', $url, $params, $opts);
            $this->refresh_from($response, $opts);
        }
        return $this;
    }
}
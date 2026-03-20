<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for resources that have nested resources.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Nested_Resource
{
    /**
     * @param string $method
     * @param string $url
     * @param null|array $params
     * @param null|array|string $options
     *
     * @return \Stripe\StripeObject
     */
    protected static function _nested_resource_operation($method, $url, $params = null, $options = null)
    {
        self::_validate_params($params);
        [$response, $opts] = static::_static_request($method, $url, $params, $options);
        $obj = \Stripe\Util\Util::convert_to_stripe_object($response->json, $opts);
        $obj->set_last_response($response);
        return $obj;
    }
    /**
     * @param string $id
     * @param null|string $nestedId
     *
     */
    protected static function _nested_resource_url($id, string $nested_path, $nested_id = null): string
    {
        $url = static::resource_url($id) . $nested_path;
        if (null !== $nested_id) {
            $url .= "/{$nested_id}";
        }
        return $url;
    }
    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\StripeObject
     */
    protected static function _create_nested_resource($id, $nested_path, $params = null, $options = null)
    {
        $url = static::_nested_resource_url($id, $nested_path);
        return self::_nested_resource_operation('post', $url, $params, $options);
    }
    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\StripeObject
     */
    protected static function _retrieve_nested_resource($id, $nested_path, $nested_id, $params = null, $options = null)
    {
        $url = static::_nested_resource_url($id, $nested_path, $nested_id);
        return self::_nested_resource_operation('get', $url, $params, $options);
    }
    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\StripeObject
     */
    protected static function _update_nested_resource($id, $nested_path, $nested_id, $params = null, $options = null)
    {
        $url = static::_nested_resource_url($id, $nested_path, $nested_id);
        return self::_nested_resource_operation('post', $url, $params, $options);
    }
    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\StripeObject
     */
    protected static function _delete_nested_resource($id, $nested_path, $nested_id, $params = null, $options = null)
    {
        $url = static::_nested_resource_url($id, $nested_path, $nested_id);
        return self::_nested_resource_operation('delete', $url, $params, $options);
    }
    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\StripeObject
     */
    protected static function _all_nested_resources($id, $nested_path, $params = null, $options = null)
    {
        $url = static::_nested_resource_url($id, $nested_path);
        return self::_nested_resource_operation('get', $url, $params, $options);
    }
}
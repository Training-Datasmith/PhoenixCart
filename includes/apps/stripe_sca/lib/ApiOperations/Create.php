<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for creatable resources. Adds a `create()` static method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Create
{
    /**
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return static the created resource
     */
    public static function create($params = null, $options = null)
    {
        self::_validate_params($params);
        $url = static::class_url();
        [$response, $opts] = static::_static_request('post', $url, $params, $options);
        $obj = \Stripe\Util\Util::convert_to_stripe_object($response->json, $opts);
        $obj->set_last_response($response);
        return $obj;
    }
}
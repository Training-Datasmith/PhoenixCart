<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for listable resources. Adds a `all()` static method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait All
{
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection of ApiResources
     */
    public static function all($params = null, $opts = null)
    {
        self::_validate_params($params);
        $url = static::class_url();
        [$response, $opts] = static::_static_request('get', $url, $params, $opts);
        $obj = \Stripe\Util\Util::convert_to_stripe_object($response->json, $opts);
        if (!$obj instanceof \Stripe\Collection) {
            throw new \Stripe\Exception\UnexpectedValueException('Expected type ' . \Stripe\Collection::class . ', got "' . $obj::class . '" instead.');
        }
        $obj->set_last_response($response);
        $obj->set_filters($params);
        return $obj;
    }
}
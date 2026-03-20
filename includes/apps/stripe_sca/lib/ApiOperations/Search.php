<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for searchable resources.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Search
{
    /**
     * @param string $searchUrl
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\SearchResult of ApiResources
     */
    protected static function _search_resource($search_url, $params = null, $opts = null)
    {
        self::_validate_params($params);
        [$response, $opts] = static::_static_request('get', $search_url, $params, $opts);
        $obj = \Stripe\Util\Util::convert_to_stripe_object($response->json, $opts);
        if (!$obj instanceof \Stripe\Search_Result) {
            throw new \Stripe\Exception\UnexpectedValueException('Expected type ' . \Stripe\Search_Result::class . ', got "' . $obj::class . '" instead.');
        }
        $obj->set_last_response($response);
        $obj->set_filters($params);
        return $obj;
    }
}
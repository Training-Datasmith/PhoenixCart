<?php

declare (strict_types=1);
namespace Stripe\Api_Operations;

/**
 * Trait for retrievable resources. Adds a `retrieve()` static method to the
 * class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Retrieve
{
    /**
     * @param array|string $id the ID of the API resource to retrieve,
     *     or an options array containing an `id` key
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     */
    public static function retrieve($id, $opts = null): static
    {
        $opts = \Stripe\Util\Request_Options::parse($opts);
        $instance = new static($id, $opts);
        $instance->refresh();
        return $instance;
    }
}
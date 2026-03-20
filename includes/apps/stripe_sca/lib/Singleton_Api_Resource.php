<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class SingletonApiResource.
 */
abstract class Singleton_Api_Resource extends Api_Resource
{
    /**
     * @return string the endpoint associated with this singleton class
     */
    public static function class_url()
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/v1/foo/bar".
        /** @phpstan-ignore-next-line */
        $base = \str_replace('.', '/', static::OBJECT_NAME);
        return "/v1/{$base}";
    }
    /**
     * @return string the endpoint associated with this singleton API resource
     */
    public function instance_url()
    {
        return static::class_url();
    }
}
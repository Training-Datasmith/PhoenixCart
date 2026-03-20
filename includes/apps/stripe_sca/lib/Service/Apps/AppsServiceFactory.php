<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Apps;

/**
 * Service factory class for API resources in the Apps namespace.
 *
 * @property SecretService $secrets
 */
class Apps_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['secrets' => Secret_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
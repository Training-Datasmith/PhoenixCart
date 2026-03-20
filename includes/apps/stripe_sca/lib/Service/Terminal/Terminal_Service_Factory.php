<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Terminal;

/**
 * Service factory class for API resources in the Terminal namespace.
 *
 * @property ConfigurationService $configurations
 * @property ConnectionTokenService $connectionTokens
 * @property LocationService $locations
 * @property ReaderService $readers
 */
class Terminal_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['configurations' => Configuration_Service::class, 'connectionTokens' => Connection_Token_Service::class, 'locations' => Location_Service::class, 'readers' => Reader_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
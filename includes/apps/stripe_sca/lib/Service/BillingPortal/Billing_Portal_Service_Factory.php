<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Billing_Portal;

/**
 * Service factory class for API resources in the BillingPortal namespace.
 *
 * @property ConfigurationService $configurations
 * @property SessionService $sessions
 */
class Billing_Portal_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['configurations' => Configuration_Service::class, 'sessions' => Session_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Financial_Connections;

/**
 * Service factory class for API resources in the FinancialConnections namespace.
 *
 * @property AccountService $accounts
 * @property SessionService $sessions
 */
class Financial_Connections_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['accounts' => Account_Service::class, 'sessions' => Session_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
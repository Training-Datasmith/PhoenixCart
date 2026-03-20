<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers;

/**
 * Service factory class for API resources in the TestHelpers namespace.
 *
 * @property CustomerService $customers
 * @property Issuing\IssuingServiceFactory $issuing
 * @property RefundService $refunds
 * @property Terminal\TerminalServiceFactory $terminal
 * @property TestClockService $testClocks
 * @property Treasury\TreasuryServiceFactory $treasury
 */
class Test_Helpers_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['customers' => Customer_Service::class, 'issuing' => Issuing\Issuing_Service_Factory::class, 'refunds' => Refund_Service::class, 'terminal' => Terminal\Terminal_Service_Factory::class, 'testClocks' => Test_Clock_Service::class, 'treasury' => Treasury\Treasury_Service_Factory::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
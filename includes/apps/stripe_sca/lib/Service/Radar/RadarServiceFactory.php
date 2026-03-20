<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Radar;

/**
 * Service factory class for API resources in the Radar namespace.
 *
 * @property EarlyFraudWarningService $earlyFraudWarnings
 * @property ValueListItemService $valueListItems
 * @property ValueListService $valueLists
 */
class Radar_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['earlyFraudWarnings' => Early_Fraud_Warning_Service::class, 'valueListItems' => Value_List_Item_Service::class, 'valueLists' => Value_List_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
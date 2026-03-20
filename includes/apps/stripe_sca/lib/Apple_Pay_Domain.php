<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe;

/**
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $domain_name
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 */
class Apple_Pay_Domain extends Api_Resource
{
    use Api_Operations\All;
    use Api_Operations\Create;
    use Api_Operations\Delete;
    use Api_Operations\Retrieve;
    public const OBJECT_NAME = 'apple_pay_domain';
    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function class_url(): string
    {
        return '/v1/apple_pay/domains';
    }
}
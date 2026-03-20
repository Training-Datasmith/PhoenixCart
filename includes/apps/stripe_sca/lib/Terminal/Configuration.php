<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Terminal;

/**
 * A Configurations object represents how features should be configured for
 * terminal readers.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property \Stripe\StripeObject $bbpos_wisepos_e
 * @property null|bool $is_account_default Whether this Configuration is the default for your account
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \Stripe\StripeObject $tipping
 * @property \Stripe\StripeObject $verifone_p400
 */
class Configuration extends \Stripe\Api_Resource
{
    use \Stripe\Api_Operations\All;
    use \Stripe\Api_Operations\Create;
    use \Stripe\Api_Operations\Delete;
    use \Stripe\Api_Operations\Retrieve;
    use \Stripe\Api_Operations\Update;
    public const OBJECT_NAME = 'terminal.configuration';
}
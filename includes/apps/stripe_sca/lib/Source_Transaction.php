<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class SourceTransaction.
 *
 * @property string $id
 * @property string $object
 * @property \Stripe\StripeObject $ach_credit_transfer
 * @property int $amount
 * @property int $created
 * @property string $customer_data
 * @property string $currency
 * @property string $type
 */
class Source_Transaction extends Api_Resource
{
    public const OBJECT_NAME = 'source_transaction';
}
<?php

declare (strict_types=1);
namespace Stripe\Issuing;

/**
 * Class CardDetails.
 *
 * @property string $id
 * @property string $object
 * @property Card $card
 * @property string $cvc
 * @property int $exp_month
 * @property int $exp_year
 * @property string $number
 */
class Card_Details extends \Stripe\Api_Resource
{
    public const OBJECT_NAME = 'issuing.card_details';
}
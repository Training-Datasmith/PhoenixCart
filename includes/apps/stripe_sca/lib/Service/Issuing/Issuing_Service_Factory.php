<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Issuing;

/**
 * Service factory class for API resources in the Issuing namespace.
 *
 * @property AuthorizationService $authorizations
 * @property CardholderService $cardholders
 * @property CardService $cards
 * @property DisputeService $disputes
 * @property TransactionService $transactions
 */
class Issuing_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['authorizations' => Authorization_Service::class, 'cardholders' => Cardholder_Service::class, 'cards' => Card_Service::class, 'disputes' => Dispute_Service::class, 'transactions' => Transaction_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
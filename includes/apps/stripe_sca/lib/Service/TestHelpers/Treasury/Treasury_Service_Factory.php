<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Test_Helpers\Treasury;

/**
 * Service factory class for API resources in the Treasury namespace.
 *
 * @property InboundTransferService $inboundTransfers
 * @property OutboundPaymentService $outboundPayments
 * @property OutboundTransferService $outboundTransfers
 * @property ReceivedCreditService $receivedCredits
 * @property ReceivedDebitService $receivedDebits
 */
class Treasury_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['inboundTransfers' => Inbound_Transfer_Service::class, 'outboundPayments' => Outbound_Payment_Service::class, 'outboundTransfers' => Outbound_Transfer_Service::class, 'receivedCredits' => Received_Credit_Service::class, 'receivedDebits' => Received_Debit_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
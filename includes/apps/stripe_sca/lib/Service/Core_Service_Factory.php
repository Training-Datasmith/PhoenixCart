<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

/**
 * Service factory class for API resources in the root namespace.
 *
 * @property AccountLinkService $accountLinks
 * @property AccountService $accounts
 * @property ApplePayDomainService $applePayDomains
 * @property ApplicationFeeService $applicationFees
 * @property Apps\AppsServiceFactory $apps
 * @property BalanceService $balance
 * @property BalanceTransactionService $balanceTransactions
 * @property BillingPortal\BillingPortalServiceFactory $billingPortal
 * @property ChargeService $charges
 * @property Checkout\CheckoutServiceFactory $checkout
 * @property CountrySpecService $countrySpecs
 * @property CouponService $coupons
 * @property CreditNoteService $creditNotes
 * @property CustomerService $customers
 * @property DisputeService $disputes
 * @property EphemeralKeyService $ephemeralKeys
 * @property EventService $events
 * @property ExchangeRateService $exchangeRates
 * @property FileLinkService $fileLinks
 * @property FileService $files
 * @property FinancialConnections\FinancialConnectionsServiceFactory $financialConnections
 * @property Identity\IdentityServiceFactory $identity
 * @property InvoiceItemService $invoiceItems
 * @property InvoiceService $invoices
 * @property Issuing\IssuingServiceFactory $issuing
 * @property MandateService $mandates
 * @property OAuthService $oauth
 * @property PaymentIntentService $paymentIntents
 * @property PaymentLinkService $paymentLinks
 * @property PaymentMethodService $paymentMethods
 * @property PayoutService $payouts
 * @property PlanService $plans
 * @property PriceService $prices
 * @property ProductService $products
 * @property PromotionCodeService $promotionCodes
 * @property QuoteService $quotes
 * @property Radar\RadarServiceFactory $radar
 * @property RefundService $refunds
 * @property Reporting\ReportingServiceFactory $reporting
 * @property ReviewService $reviews
 * @property SetupAttemptService $setupAttempts
 * @property SetupIntentService $setupIntents
 * @property ShippingRateService $shippingRates
 * @property Sigma\SigmaServiceFactory $sigma
 * @property SourceService $sources
 * @property SubscriptionItemService $subscriptionItems
 * @property SubscriptionService $subscriptions
 * @property SubscriptionScheduleService $subscriptionSchedules
 * @property TaxCodeService $taxCodes
 * @property TaxRateService $taxRates
 * @property Terminal\TerminalServiceFactory $terminal
 * @property TestHelpers\TestHelpersServiceFactory $testHelpers
 * @property TokenService $tokens
 * @property TopupService $topups
 * @property TransferService $transfers
 * @property Treasury\TreasuryServiceFactory $treasury
 * @property WebhookEndpointService $webhookEndpoints
 */
class Core_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['accountLinks' => Account_Link_Service::class, 'accounts' => Account_Service::class, 'applePayDomains' => Apple_Pay_Domain_Service::class, 'applicationFees' => Application_Fee_Service::class, 'apps' => Apps\Apps_Service_Factory::class, 'balance' => Balance_Service::class, 'balanceTransactions' => Balance_Transaction_Service::class, 'billingPortal' => Billing_Portal\Billing_Portal_Service_Factory::class, 'charges' => Charge_Service::class, 'checkout' => Checkout\Checkout_Service_Factory::class, 'countrySpecs' => Country_Spec_Service::class, 'coupons' => Coupon_Service::class, 'creditNotes' => Credit_Note_Service::class, 'customers' => Customer_Service::class, 'disputes' => Dispute_Service::class, 'ephemeralKeys' => Ephemeral_Key_Service::class, 'events' => Event_Service::class, 'exchangeRates' => Exchange_Rate_Service::class, 'fileLinks' => File_Link_Service::class, 'files' => File_Service::class, 'financialConnections' => Financial_Connections\Financial_Connections_Service_Factory::class, 'identity' => Identity\Identity_Service_Factory::class, 'invoiceItems' => Invoice_Item_Service::class, 'invoices' => Invoice_Service::class, 'issuing' => Issuing\Issuing_Service_Factory::class, 'mandates' => Mandate_Service::class, 'oauth' => O_Auth_Service::class, 'paymentIntents' => Payment_Intent_Service::class, 'paymentLinks' => Payment_Link_Service::class, 'paymentMethods' => Payment_Method_Service::class, 'payouts' => Payout_Service::class, 'plans' => Plan_Service::class, 'prices' => Price_Service::class, 'products' => Product_Service::class, 'promotionCodes' => Promotion_Code_Service::class, 'quotes' => Quote_Service::class, 'radar' => Radar\Radar_Service_Factory::class, 'refunds' => Refund_Service::class, 'reporting' => Reporting\Reporting_Service_Factory::class, 'reviews' => Review_Service::class, 'setupAttempts' => Setup_Attempt_Service::class, 'setupIntents' => Setup_Intent_Service::class, 'shippingRates' => Shipping_Rate_Service::class, 'sigma' => Sigma\Sigma_Service_Factory::class, 'sources' => Source_Service::class, 'subscriptionItems' => Subscription_Item_Service::class, 'subscriptions' => Subscription_Service::class, 'subscriptionSchedules' => Subscription_Schedule_Service::class, 'taxCodes' => Tax_Code_Service::class, 'taxRates' => Tax_Rate_Service::class, 'terminal' => Terminal\Terminal_Service_Factory::class, 'testHelpers' => Test_Helpers\Test_Helpers_Service_Factory::class, 'tokens' => Token_Service::class, 'topups' => Topup_Service::class, 'transfers' => Transfer_Service::class, 'treasury' => Treasury\Treasury_Service_Factory::class, 'webhookEndpoints' => Webhook_Endpoint_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
<?php

declare(strict_types=1);

// File generated from our OpenAPI spec

namespace Stripe;

/**
 * Events are our way of letting you know when something interesting happens in
 * your account. When an interesting event occurs, we create a new
 * <code>Event</code> object. For example, when a charge succeeds, we create a
 * <code>charge.succeeded</code> event; and when an invoice payment attempt fails,
 * we create an <code>invoice.payment_failed</code> event. Note that many API
 * requests may cause multiple events to be created. For example, if you create a
 * new subscription for a customer, you will receive both a
 * <code>customer.subscription.created</code> event and a
 * <code>charge.succeeded</code> event.
 *
 * Events occur when the state of another API resource changes. The state of that
 * resource at the time of the change is embedded in the event's data field. For
 * example, a <code>charge.succeeded</code> event will contain a charge, and an
 * <code>invoice.payment_failed</code> event will contain an invoice.
 *
 * As with other API resources, you can use endpoints to retrieve an <a
 * href="https://stripe.com/docs/api#retrieve_event">individual event</a> or a <a
 * href="https://stripe.com/docs/api#list_events">list of events</a> from the API.
 * We also have a separate <a
 * href="http://en.wikipedia.org/wiki/Webhook">webhooks</a> system for sending the
 * <code>Event</code> objects directly to an endpoint on your server. Webhooks are
 * managed in your <a href="https://dashboard.stripe.com/account/webhooks">account
 * settings</a>, and our <a href="https://stripe.com/docs/webhooks">Using
 * Webhooks</a> guide will help you get set up.
 *
 * When using <a href="https://stripe.com/docs/connect">Connect</a>, you can also
 * receive notifications of events that occur in connected accounts. For these
 * events, there will be an additional <code>account</code> attribute in the
 * received <code>Event</code> object.
 *
 * <strong>NOTE:</strong> Right now, access to events through the <a
 * href="https://stripe.com/docs/api#retrieve_event">Retrieve Event API</a> is
 * guaranteed only for 30 days.
 *
 * This class includes constants for the possible string representations of
 * event types. See https://stripe.com/docs/api#event_types for more details.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property string $account The connected account that originated the event.
 * @property null|string $api_version The Stripe API version used to render <code>data</code>. <em>Note: This property is populated only for events on or after October 31, 2014</em>.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property \Stripe\StripeObject $data
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property int $pending_webhooks Number of webhooks that have yet to be successfully delivered (i.e., to return a 20x response) to the URLs you've specified.
 * @property null|\Stripe\StripeObject $request Information on the API request that instigated the event.
 * @property string $type Description of the event (e.g., <code>invoice.created</code> or <code>charge.refunded</code>).
 */
class Event extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    public const OBJECT_NAME = 'event';

    public const ACCOUNT_APPLICATION_AUTHORIZED = 'account.application.authorized';
    public const ACCOUNT_APPLICATION_DEAUTHORIZED = 'account.application.deauthorized';
    public const ACCOUNT_EXTERNAL_ACCOUNT_CREATED = 'account.external_account.created';
    public const ACCOUNT_EXTERNAL_ACCOUNT_DELETED = 'account.external_account.deleted';
    public const ACCOUNT_EXTERNAL_ACCOUNT_UPDATED = 'account.external_account.updated';
    public const ACCOUNT_UPDATED = 'account.updated';
    public const APPLICATION_FEE_CREATED = 'application_fee.created';
    public const APPLICATION_FEE_REFUND_UPDATED = 'application_fee.refund.updated';
    public const APPLICATION_FEE_REFUNDED = 'application_fee.refunded';
    public const BALANCE_AVAILABLE = 'balance.available';
    public const BILLING_PORTAL_CONFIGURATION_CREATED = 'billing_portal.configuration.created';
    public const BILLING_PORTAL_CONFIGURATION_UPDATED = 'billing_portal.configuration.updated';
    public const BILLING_PORTAL_SESSION_CREATED = 'billing_portal.session.created';
    public const CAPABILITY_UPDATED = 'capability.updated';
    public const CASH_BALANCE_FUNDS_AVAILABLE = 'cash_balance.funds_available';
    public const CHARGE_CAPTURED = 'charge.captured';
    public const CHARGE_DISPUTE_CLOSED = 'charge.dispute.closed';
    public const CHARGE_DISPUTE_CREATED = 'charge.dispute.created';
    public const CHARGE_DISPUTE_FUNDS_REINSTATED = 'charge.dispute.funds_reinstated';
    public const CHARGE_DISPUTE_FUNDS_WITHDRAWN = 'charge.dispute.funds_withdrawn';
    public const CHARGE_DISPUTE_UPDATED = 'charge.dispute.updated';
    public const CHARGE_EXPIRED = 'charge.expired';
    public const CHARGE_FAILED = 'charge.failed';
    public const CHARGE_PENDING = 'charge.pending';
    public const CHARGE_REFUND_UPDATED = 'charge.refund.updated';
    public const CHARGE_REFUNDED = 'charge.refunded';
    public const CHARGE_SUCCEEDED = 'charge.succeeded';
    public const CHARGE_UPDATED = 'charge.updated';
    public const CHECKOUT_SESSION_ASYNC_PAYMENT_FAILED = 'checkout.session.async_payment_failed';
    public const CHECKOUT_SESSION_ASYNC_PAYMENT_SUCCEEDED = 'checkout.session.async_payment_succeeded';
    public const CHECKOUT_SESSION_COMPLETED = 'checkout.session.completed';
    public const CHECKOUT_SESSION_EXPIRED = 'checkout.session.expired';
    public const COUPON_CREATED = 'coupon.created';
    public const COUPON_DELETED = 'coupon.deleted';
    public const COUPON_UPDATED = 'coupon.updated';
    public const CREDIT_NOTE_CREATED = 'credit_note.created';
    public const CREDIT_NOTE_UPDATED = 'credit_note.updated';
    public const CREDIT_NOTE_VOIDED = 'credit_note.voided';
    public const CUSTOMER_CREATED = 'customer.created';
    public const CUSTOMER_DELETED = 'customer.deleted';
    public const CUSTOMER_DISCOUNT_CREATED = 'customer.discount.created';
    public const CUSTOMER_DISCOUNT_DELETED = 'customer.discount.deleted';
    public const CUSTOMER_DISCOUNT_UPDATED = 'customer.discount.updated';
    public const CUSTOMER_SOURCE_CREATED = 'customer.source.created';
    public const CUSTOMER_SOURCE_DELETED = 'customer.source.deleted';
    public const CUSTOMER_SOURCE_EXPIRING = 'customer.source.expiring';
    public const CUSTOMER_SOURCE_UPDATED = 'customer.source.updated';
    public const CUSTOMER_SUBSCRIPTION_CREATED = 'customer.subscription.created';
    public const CUSTOMER_SUBSCRIPTION_DELETED = 'customer.subscription.deleted';
    public const CUSTOMER_SUBSCRIPTION_PAUSED = 'customer.subscription.paused';
    public const CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_APPLIED = 'customer.subscription.pending_update_applied';
    public const CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_EXPIRED = 'customer.subscription.pending_update_expired';
    public const CUSTOMER_SUBSCRIPTION_RESUMED = 'customer.subscription.resumed';
    public const CUSTOMER_SUBSCRIPTION_TRIAL_WILL_END = 'customer.subscription.trial_will_end';
    public const CUSTOMER_SUBSCRIPTION_UPDATED = 'customer.subscription.updated';
    public const CUSTOMER_TAX_ID_CREATED = 'customer.tax_id.created';
    public const CUSTOMER_TAX_ID_DELETED = 'customer.tax_id.deleted';
    public const CUSTOMER_TAX_ID_UPDATED = 'customer.tax_id.updated';
    public const CUSTOMER_UPDATED = 'customer.updated';
    public const CUSTOMER_CASH_BALANCE_TRANSACTION_CREATED = 'customer_cash_balance_transaction.created';
    public const FILE_CREATED = 'file.created';
    public const FINANCIAL_CONNECTIONS_ACCOUNT_CREATED = 'financial_connections.account.created';
    public const FINANCIAL_CONNECTIONS_ACCOUNT_DEACTIVATED = 'financial_connections.account.deactivated';
    public const FINANCIAL_CONNECTIONS_ACCOUNT_DISCONNECTED = 'financial_connections.account.disconnected';
    public const FINANCIAL_CONNECTIONS_ACCOUNT_REACTIVATED = 'financial_connections.account.reactivated';
    public const FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_BALANCE = 'financial_connections.account.refreshed_balance';
    public const IDENTITY_VERIFICATION_SESSION_CANCELED = 'identity.verification_session.canceled';
    public const IDENTITY_VERIFICATION_SESSION_CREATED = 'identity.verification_session.created';
    public const IDENTITY_VERIFICATION_SESSION_PROCESSING = 'identity.verification_session.processing';
    public const IDENTITY_VERIFICATION_SESSION_REDACTED = 'identity.verification_session.redacted';
    public const IDENTITY_VERIFICATION_SESSION_REQUIRES_INPUT = 'identity.verification_session.requires_input';
    public const IDENTITY_VERIFICATION_SESSION_VERIFIED = 'identity.verification_session.verified';
    public const INVOICE_CREATED = 'invoice.created';
    public const INVOICE_DELETED = 'invoice.deleted';
    public const INVOICE_FINALIZATION_FAILED = 'invoice.finalization_failed';
    public const INVOICE_FINALIZED = 'invoice.finalized';
    public const INVOICE_MARKED_UNCOLLECTIBLE = 'invoice.marked_uncollectible';
    public const INVOICE_PAID = 'invoice.paid';
    public const INVOICE_PAYMENT_ACTION_REQUIRED = 'invoice.payment_action_required';
    public const INVOICE_PAYMENT_FAILED = 'invoice.payment_failed';
    public const INVOICE_PAYMENT_SUCCEEDED = 'invoice.payment_succeeded';
    public const INVOICE_SENT = 'invoice.sent';
    public const INVOICE_UPCOMING = 'invoice.upcoming';
    public const INVOICE_UPDATED = 'invoice.updated';
    public const INVOICE_VOIDED = 'invoice.voided';
    public const INVOICEITEM_CREATED = 'invoiceitem.created';
    public const INVOICEITEM_DELETED = 'invoiceitem.deleted';
    public const INVOICEITEM_UPDATED = 'invoiceitem.updated';
    public const ISSUING_AUTHORIZATION_CREATED = 'issuing_authorization.created';
    public const ISSUING_AUTHORIZATION_REQUEST = 'issuing_authorization.request';
    public const ISSUING_AUTHORIZATION_UPDATED = 'issuing_authorization.updated';
    public const ISSUING_CARD_CREATED = 'issuing_card.created';
    public const ISSUING_CARD_UPDATED = 'issuing_card.updated';
    public const ISSUING_CARDHOLDER_CREATED = 'issuing_cardholder.created';
    public const ISSUING_CARDHOLDER_UPDATED = 'issuing_cardholder.updated';
    public const ISSUING_DISPUTE_CLOSED = 'issuing_dispute.closed';
    public const ISSUING_DISPUTE_CREATED = 'issuing_dispute.created';
    public const ISSUING_DISPUTE_FUNDS_REINSTATED = 'issuing_dispute.funds_reinstated';
    public const ISSUING_DISPUTE_SUBMITTED = 'issuing_dispute.submitted';
    public const ISSUING_DISPUTE_UPDATED = 'issuing_dispute.updated';
    public const ISSUING_TRANSACTION_CREATED = 'issuing_transaction.created';
    public const ISSUING_TRANSACTION_UPDATED = 'issuing_transaction.updated';
    public const MANDATE_UPDATED = 'mandate.updated';
    public const ORDER_CREATED = 'order.created';
    public const PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED = 'payment_intent.amount_capturable_updated';
    public const PAYMENT_INTENT_CANCELED = 'payment_intent.canceled';
    public const PAYMENT_INTENT_CREATED = 'payment_intent.created';
    public const PAYMENT_INTENT_PARTIALLY_FUNDED = 'payment_intent.partially_funded';
    public const PAYMENT_INTENT_PAYMENT_FAILED = 'payment_intent.payment_failed';
    public const PAYMENT_INTENT_PROCESSING = 'payment_intent.processing';
    public const PAYMENT_INTENT_REQUIRES_ACTION = 'payment_intent.requires_action';
    public const PAYMENT_INTENT_SUCCEEDED = 'payment_intent.succeeded';
    public const PAYMENT_LINK_CREATED = 'payment_link.created';
    public const PAYMENT_LINK_UPDATED = 'payment_link.updated';
    public const PAYMENT_METHOD_ATTACHED = 'payment_method.attached';
    public const PAYMENT_METHOD_AUTOMATICALLY_UPDATED = 'payment_method.automatically_updated';
    public const PAYMENT_METHOD_DETACHED = 'payment_method.detached';
    public const PAYMENT_METHOD_UPDATED = 'payment_method.updated';
    public const PAYOUT_CANCELED = 'payout.canceled';
    public const PAYOUT_CREATED = 'payout.created';
    public const PAYOUT_FAILED = 'payout.failed';
    public const PAYOUT_PAID = 'payout.paid';
    public const PAYOUT_UPDATED = 'payout.updated';
    public const PERSON_CREATED = 'person.created';
    public const PERSON_DELETED = 'person.deleted';
    public const PERSON_UPDATED = 'person.updated';
    public const PLAN_CREATED = 'plan.created';
    public const PLAN_DELETED = 'plan.deleted';
    public const PLAN_UPDATED = 'plan.updated';
    public const PRICE_CREATED = 'price.created';
    public const PRICE_DELETED = 'price.deleted';
    public const PRICE_UPDATED = 'price.updated';
    public const PRODUCT_CREATED = 'product.created';
    public const PRODUCT_DELETED = 'product.deleted';
    public const PRODUCT_UPDATED = 'product.updated';
    public const PROMOTION_CODE_CREATED = 'promotion_code.created';
    public const PROMOTION_CODE_UPDATED = 'promotion_code.updated';
    public const QUOTE_ACCEPTED = 'quote.accepted';
    public const QUOTE_CANCELED = 'quote.canceled';
    public const QUOTE_CREATED = 'quote.created';
    public const QUOTE_FINALIZED = 'quote.finalized';
    public const RADAR_EARLY_FRAUD_WARNING_CREATED = 'radar.early_fraud_warning.created';
    public const RADAR_EARLY_FRAUD_WARNING_UPDATED = 'radar.early_fraud_warning.updated';
    public const RECIPIENT_CREATED = 'recipient.created';
    public const RECIPIENT_DELETED = 'recipient.deleted';
    public const RECIPIENT_UPDATED = 'recipient.updated';
    public const REFUND_CREATED = 'refund.created';
    public const REFUND_UPDATED = 'refund.updated';
    public const REPORTING_REPORT_RUN_FAILED = 'reporting.report_run.failed';
    public const REPORTING_REPORT_RUN_SUCCEEDED = 'reporting.report_run.succeeded';
    public const REPORTING_REPORT_TYPE_UPDATED = 'reporting.report_type.updated';
    public const REVIEW_CLOSED = 'review.closed';
    public const REVIEW_OPENED = 'review.opened';
    public const SETUP_INTENT_CANCELED = 'setup_intent.canceled';
    public const SETUP_INTENT_CREATED = 'setup_intent.created';
    public const SETUP_INTENT_REQUIRES_ACTION = 'setup_intent.requires_action';
    public const SETUP_INTENT_SETUP_FAILED = 'setup_intent.setup_failed';
    public const SETUP_INTENT_SUCCEEDED = 'setup_intent.succeeded';
    public const SIGMA_SCHEDULED_QUERY_RUN_CREATED = 'sigma.scheduled_query_run.created';
    public const SKU_CREATED = 'sku.created';
    public const SKU_DELETED = 'sku.deleted';
    public const SKU_UPDATED = 'sku.updated';
    public const SOURCE_CANCELED = 'source.canceled';
    public const SOURCE_CHARGEABLE = 'source.chargeable';
    public const SOURCE_FAILED = 'source.failed';
    public const SOURCE_MANDATE_NOTIFICATION = 'source.mandate_notification';
    public const SOURCE_REFUND_ATTRIBUTES_REQUIRED = 'source.refund_attributes_required';
    public const SOURCE_TRANSACTION_CREATED = 'source.transaction.created';
    public const SOURCE_TRANSACTION_UPDATED = 'source.transaction.updated';
    public const SUBSCRIPTION_SCHEDULE_ABORTED = 'subscription_schedule.aborted';
    public const SUBSCRIPTION_SCHEDULE_CANCELED = 'subscription_schedule.canceled';
    public const SUBSCRIPTION_SCHEDULE_COMPLETED = 'subscription_schedule.completed';
    public const SUBSCRIPTION_SCHEDULE_CREATED = 'subscription_schedule.created';
    public const SUBSCRIPTION_SCHEDULE_EXPIRING = 'subscription_schedule.expiring';
    public const SUBSCRIPTION_SCHEDULE_RELEASED = 'subscription_schedule.released';
    public const SUBSCRIPTION_SCHEDULE_UPDATED = 'subscription_schedule.updated';
    public const TAX_RATE_CREATED = 'tax_rate.created';
    public const TAX_RATE_UPDATED = 'tax_rate.updated';
    public const TERMINAL_READER_ACTION_FAILED = 'terminal.reader.action_failed';
    public const TERMINAL_READER_ACTION_SUCCEEDED = 'terminal.reader.action_succeeded';
    public const TEST_HELPERS_TEST_CLOCK_ADVANCING = 'test_helpers.test_clock.advancing';
    public const TEST_HELPERS_TEST_CLOCK_CREATED = 'test_helpers.test_clock.created';
    public const TEST_HELPERS_TEST_CLOCK_DELETED = 'test_helpers.test_clock.deleted';
    public const TEST_HELPERS_TEST_CLOCK_INTERNAL_FAILURE = 'test_helpers.test_clock.internal_failure';
    public const TEST_HELPERS_TEST_CLOCK_READY = 'test_helpers.test_clock.ready';
    public const TOPUP_CANCELED = 'topup.canceled';
    public const TOPUP_CREATED = 'topup.created';
    public const TOPUP_FAILED = 'topup.failed';
    public const TOPUP_REVERSED = 'topup.reversed';
    public const TOPUP_SUCCEEDED = 'topup.succeeded';
    public const TRANSFER_CREATED = 'transfer.created';
    public const TRANSFER_REVERSED = 'transfer.reversed';
    public const TRANSFER_UPDATED = 'transfer.updated';
    public const TREASURY_CREDIT_REVERSAL_CREATED = 'treasury.credit_reversal.created';
    public const TREASURY_CREDIT_REVERSAL_POSTED = 'treasury.credit_reversal.posted';
    public const TREASURY_DEBIT_REVERSAL_COMPLETED = 'treasury.debit_reversal.completed';
    public const TREASURY_DEBIT_REVERSAL_CREATED = 'treasury.debit_reversal.created';
    public const TREASURY_DEBIT_REVERSAL_INITIAL_CREDIT_GRANTED = 'treasury.debit_reversal.initial_credit_granted';
    public const TREASURY_FINANCIAL_ACCOUNT_CLOSED = 'treasury.financial_account.closed';
    public const TREASURY_FINANCIAL_ACCOUNT_CREATED = 'treasury.financial_account.created';
    public const TREASURY_FINANCIAL_ACCOUNT_FEATURES_STATUS_UPDATED = 'treasury.financial_account.features_status_updated';
    public const TREASURY_INBOUND_TRANSFER_CANCELED = 'treasury.inbound_transfer.canceled';
    public const TREASURY_INBOUND_TRANSFER_CREATED = 'treasury.inbound_transfer.created';
    public const TREASURY_INBOUND_TRANSFER_FAILED = 'treasury.inbound_transfer.failed';
    public const TREASURY_INBOUND_TRANSFER_SUCCEEDED = 'treasury.inbound_transfer.succeeded';
    public const TREASURY_OUTBOUND_PAYMENT_CANCELED = 'treasury.outbound_payment.canceled';
    public const TREASURY_OUTBOUND_PAYMENT_CREATED = 'treasury.outbound_payment.created';
    public const TREASURY_OUTBOUND_PAYMENT_EXPECTED_ARRIVAL_DATE_UPDATED = 'treasury.outbound_payment.expected_arrival_date_updated';
    public const TREASURY_OUTBOUND_PAYMENT_FAILED = 'treasury.outbound_payment.failed';
    public const TREASURY_OUTBOUND_PAYMENT_POSTED = 'treasury.outbound_payment.posted';
    public const TREASURY_OUTBOUND_PAYMENT_RETURNED = 'treasury.outbound_payment.returned';
    public const TREASURY_OUTBOUND_TRANSFER_CANCELED = 'treasury.outbound_transfer.canceled';
    public const TREASURY_OUTBOUND_TRANSFER_CREATED = 'treasury.outbound_transfer.created';
    public const TREASURY_OUTBOUND_TRANSFER_EXPECTED_ARRIVAL_DATE_UPDATED = 'treasury.outbound_transfer.expected_arrival_date_updated';
    public const TREASURY_OUTBOUND_TRANSFER_FAILED = 'treasury.outbound_transfer.failed';
    public const TREASURY_OUTBOUND_TRANSFER_POSTED = 'treasury.outbound_transfer.posted';
    public const TREASURY_OUTBOUND_TRANSFER_RETURNED = 'treasury.outbound_transfer.returned';
    public const TREASURY_RECEIVED_CREDIT_CREATED = 'treasury.received_credit.created';
    public const TREASURY_RECEIVED_CREDIT_FAILED = 'treasury.received_credit.failed';
    public const TREASURY_RECEIVED_CREDIT_SUCCEEDED = 'treasury.received_credit.succeeded';
    public const TREASURY_RECEIVED_DEBIT_CREATED = 'treasury.received_debit.created';
}

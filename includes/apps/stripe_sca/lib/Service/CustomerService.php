<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Customer_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of your customers. The customers are returned sorted by creation
     * date, with the most recent customers appearing first.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Customer>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/customers', $params, $opts);
    }
    /**
     * Returns a list of transactions that updated the customer’s <a
     * href="/docs/billing/customer/balance">balances</a>.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\CustomerBalanceTransaction>
     */
    public function all_balance_transactions($parent_id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/customers/%s/balance_transactions', $parent_id), $params, $opts);
    }
    /**
     * Returns a list of transactions that modified the customer’s <a
     * href="/docs/payments/customer-balance">cash balance</a>.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\CustomerCashBalanceTransaction>
     */
    public function all_cash_balance_transactions($parent_id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/customers/%s/cash_balance_transactions', $parent_id), $params, $opts);
    }
    /**
     * Returns a list of PaymentMethods for a given Customer.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\PaymentMethod>
     */
    public function all_payment_methods($id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/customers/%s/payment_methods', $id), $params, $opts);
    }
    /**
     * List sources for a specified customer.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\BankAccount|\Stripe\Card|\Stripe\Source>
     */
    public function all_sources($parent_id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/customers/%s/sources', $parent_id), $params, $opts);
    }
    /**
     * Returns a list of tax IDs for a customer.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\TaxId>
     */
    public function all_tax_ids($parent_id, $params = null, $opts = null)
    {
        return $this->request_collection('get', $this->build_path('/v1/customers/%s/tax_ids', $parent_id), $params, $opts);
    }
    /**
     * Creates a new customer object.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/customers', $params, $opts);
    }
    /**
     * Creates an immutable transaction that updates the customer’s credit <a
     * href="/docs/billing/customer/balance">balance</a>.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CustomerBalanceTransaction
     */
    public function create_balance_transaction($parent_id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/balance_transactions', $parent_id), $params, $opts);
    }
    /**
     * Retrieve funding instructions for a customer cash balance. If funding
     * instructions do not yet exist for the customer, new funding instructions will be
     * created. If funding instructions have already been created for a given customer,
     * the same funding instructions will be retrieved. In other words, we will return
     * the same funding instructions each time.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function create_funding_instructions($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/funding_instructions', $id), $params, $opts);
    }
    /**
     * When you create a new credit card, you must specify a customer or recipient on
     * which to create it.
     *
     * If the card’s owner has no default card, then the new card will become the
     * default. However, if the owner already has a default, then it will not change.
     * To change the default, you should <a href="/docs/api#update_customer">update the
     * customer</a> to have a new <code>default_source</code>.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card|\Stripe\Source
     */
    public function create_source($parent_id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/sources', $parent_id), $params, $opts);
    }
    /**
     * Creates a new <code>TaxID</code> object for a customer.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\TaxId
     */
    public function create_tax_id($parent_id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/tax_ids', $parent_id), $params, $opts);
    }
    /**
     * Permanently deletes a customer. It cannot be undone. Also immediately cancels
     * any active subscriptions on the customer.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function delete($id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/customers/%s', $id), $params, $opts);
    }
    /**
     * Removes the currently applied discount on a customer.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function delete_discount($id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/customers/%s/discount', $id), $params, $opts);
    }
    /**
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card|\Stripe\Source
     */
    public function delete_source($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/customers/%s/sources/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Deletes an existing <code>TaxID</code> object.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\TaxId
     */
    public function delete_tax_id($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->build_path('/v1/customers/%s/tax_ids/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Retrieves a Customer object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s', $id), $params, $opts);
    }
    /**
     * Retrieves a specific customer balance transaction that updated the customer’s <a
     * href="/docs/billing/customer/balance">balances</a>.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CustomerBalanceTransaction
     */
    public function retrieve_balance_transaction($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s/balance_transactions/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Retrieves a customer’s cash balance.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CashBalance
     */
    public function retrieve_cash_balance($parent_id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s/cash_balance', $parent_id), $params, $opts);
    }
    /**
     * Retrieves a specific cash balance transaction, which updated the customer’s <a
     * href="/docs/payments/customer-balance">cash balance</a>.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CustomerCashBalanceTransaction
     */
    public function retrieve_cash_balance_transaction($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s/cash_balance_transactions/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Retrieves a PaymentMethod object for a given Customer.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function retrieve_payment_method($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s/payment_methods/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Retrieve a specified source for a given customer.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card|\Stripe\Source
     */
    public function retrieve_source($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s/sources/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Retrieves the <code>TaxID</code> object with the given identifier.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\TaxId
     */
    public function retrieve_tax_id($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/customers/%s/tax_ids/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Search for customers you’ve previously created using Stripe’s <a
     * href="/docs/search#search-query-language">Search Query Language</a>. Don’t use
     * search in read-after-write flows where strict consistency is necessary. Under
     * normal operating conditions, data is searchable in less than a minute.
     * Occasionally, propagation of new or updated data can be up to an hour behind
     * during outages. Search functionality is not available to merchants in India.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\SearchResult<\Stripe\Customer>
     */
    public function search($params = null, $opts = null)
    {
        return $this->request_search_result('get', '/v1/customers/search', $params, $opts);
    }
    /**
     * Updates the specified customer by setting the values of the parameters passed.
     * Any parameters not provided will be left unchanged. For example, if you pass the
     * <strong>source</strong> parameter, that becomes the customer’s active source
     * (e.g., a card) to be used for all charges in the future. When you update a
     * customer to a new valid card source by passing the <strong>source</strong>
     * parameter: for each of the customer’s current subscriptions, if the subscription
     * bills automatically and is in the <code>past_due</code> state, then the latest
     * open invoice for the subscription with automatic collection enabled will be
     * retried. This retry will not count as an automatic retry, and will not affect
     * the next regularly scheduled payment for the invoice. Changing the
     * <strong>default_source</strong> for a customer will not trigger this behavior.
     *
     * This request accepts mostly the same arguments as the customer creation call.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Customer
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s', $id), $params, $opts);
    }
    /**
     * Most credit balance transaction fields are immutable, but you may update its
     * <code>description</code> and <code>metadata</code>.
     *
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CustomerBalanceTransaction
     */
    public function update_balance_transaction($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/balance_transactions/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * Changes the settings on a customer’s cash balance.
     *
     * @param string $parentId
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CashBalance
     */
    public function update_cash_balance($parent_id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/cash_balance', $parent_id), $params, $opts);
    }
    /**
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card|\Stripe\Source
     */
    public function update_source($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/sources/%s', $parent_id, $id), $params, $opts);
    }
    /**
     * @param string $parentId
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card|\Stripe\Source
     */
    public function verify_source($parent_id, $id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/customers/%s/sources/%s/verify', $parent_id, $id), $params, $opts);
    }
}
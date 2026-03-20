<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe;

/**
 * This is an object representing a Stripe account. You can retrieve it to see
 * properties on the account like its current e-mail address or if the account is
 * enabled yet to make live charges.
 *
 * Some properties, marked below, are available only to platforms that want to <a
 * href="https://stripe.com/docs/connect/accounts">create and manage Express or
 * Custom accounts</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property null|\Stripe\StripeObject $business_profile Business information about the account.
 * @property null|string $business_type The business type.
 * @property \Stripe\StripeObject $capabilities
 * @property bool $charges_enabled Whether the account can create live charges.
 * @property \Stripe\StripeObject $company
 * @property \Stripe\StripeObject $controller
 * @property string $country The account's country.
 * @property int $created Time at which the account was connected. Measured in seconds since the Unix epoch.
 * @property string $default_currency Three-letter ISO currency code representing the default currency for the account. This must be a currency that <a href="https://stripe.com/docs/payouts">Stripe supports in the account's country</a>.
 * @property bool $details_submitted Whether account details have been submitted. Standard accounts cannot receive payouts before this is true.
 * @property null|string $email An email address associated with the account. You can treat this as metadata: it is not used for authentication or messaging account holders.
 * @property \Stripe\Collection<\Stripe\BankAccount|\Stripe\Card> $external_accounts External accounts (bank accounts and debit cards) currently attached to this account
 * @property \Stripe\StripeObject $future_requirements
 * @property \Stripe\Person $individual <p>This is an object representing a person associated with a Stripe account.</p><p>A platform cannot access a Standard or Express account's persons after the account starts onboarding, such as after generating an account link for the account. See the <a href="https://stripe.com/docs/connect/standard-accounts">Standard onboarding</a> or <a href="https://stripe.com/docs/connect/express-accounts">Express onboarding documentation</a> for information about platform pre-filling and account onboarding steps.</p><p>Related guide: <a href="https://stripe.com/docs/connect/identity-verification-api#person-information">Handling Identity Verification with the API</a>.</p>
 * @property \Stripe\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property bool $payouts_enabled Whether Stripe can send payouts to this account.
 * @property \Stripe\StripeObject $requirements
 * @property null|\Stripe\StripeObject $settings Options for customizing how the account functions within Stripe.
 * @property \Stripe\StripeObject $tos_acceptance
 * @property string $type The Stripe account type. Can be <code>standard</code>, <code>express</code>, or <code>custom</code>.
 */
class Account extends Api_Resource
{
    use Api_Operations\All;
    use Api_Operations\Create;
    use Api_Operations\Delete;
    use Api_Operations\Nested_Resource;
    use Api_Operations\Update;
    use Api_Operations\Retrieve {
        retrieve as protected _retrieve;
    }
    public const OBJECT_NAME = 'account';
    public const BUSINESS_TYPE_COMPANY = 'company';
    public const BUSINESS_TYPE_GOVERNMENT_ENTITY = 'government_entity';
    public const BUSINESS_TYPE_INDIVIDUAL = 'individual';
    public const BUSINESS_TYPE_NON_PROFIT = 'non_profit';
    public const TYPE_CUSTOM = 'custom';
    public const TYPE_EXPRESS = 'express';
    public const TYPE_STANDARD = 'standard';
    public static function get_saved_nested_resources()
    {
        static $saved_nested_resources = null;
        if (null === $saved_nested_resources) {
            $saved_nested_resources = new Util\Set(['external_account', 'bank_account']);
        }
        return $saved_nested_resources;
    }
    public function instance_url()
    {
        if (null === $this['id']) {
            return '/v1/account';
        }
        return parent::instance_url();
    }
    /**
     * @param null|array|string $id the ID of the account to retrieve, or an
     *     options array containing an `id` key
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Account
     */
    public static function retrieve($id = null, $opts = null)
    {
        if (!$opts && \is_string($id) && str_starts_with($id, 'sk_')) {
            $opts = $id;
            $id = null;
        }
        return self::_retrieve($id, $opts);
    }
    public function serialize_parameters($force = false)
    {
        $update = parent::serialize_parameters($force);
        if (isset($this->_values['legal_entity'])) {
            $entity = $this['legal_entity'];
            if (isset($entity->_values['additional_owners'])) {
                $owners = $entity['additional_owners'];
                $entity_update = $update['legal_entity'] ?? [];
                $entity_update['additional_owners'] = $this->serialize_additional_owners($entity, $owners);
                $update['legal_entity'] = $entity_update;
            }
        }
        if (isset($this->_values['individual'])) {
            $individual = $this['individual'];
            if ($individual instanceof Person && !isset($update['individual'])) {
                $update['individual'] = $individual->serialize_parameters($force);
            }
        }
        return $update;
    }
    /**
     * @return mixed[]
     */
    private function serialize_additional_owners(object $legal_entity, $additional_owners): array
    {
        if (isset($legal_entity->_original_values['additional_owners'])) {
            $original_value = $legal_entity->_original_values['additional_owners'];
        } else {
            $original_value = [];
        }
        if ($original_value && \count($original_value) > \count($additional_owners)) {
            throw new Exception\InvalidArgumentException('You cannot delete an item from an array, you must instead set a new array');
        }
        $update_arr = [];
        foreach ($additional_owners as $i => $v) {
            $update = $v instanceof Stripe_Object ? $v->serialize_parameters() : $v;
            if ([] !== $update) {
                if (!$original_value || !\array_key_exists($i, $original_value) || $update !== $legal_entity->serialize_params_value($original_value[$i], null, false, true)) {
                    $update_arr[$i] = $update;
                }
            }
        }
        return $update_arr;
    }
    /**
     * @param null|array $clientId
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\StripeObject object containing the response from the API
     */
    public function deauthorize($client_id = null, $opts = null)
    {
        $params = ['client_id' => $client_id, 'stripe_user_id' => $this->id];
        return O_Auth::deauthorize($params, $opts);
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Account the rejected account
     */
    public function reject($params = null, $opts = null): static
    {
        $url = $this->instance_url() . '/reject';
        [$response, $opts] = $this->_request('post', $url, $params, $opts);
        $this->refresh_from($response, $opts);
        return $this;
    }
    public const PATH_CAPABILITIES = '/capabilities';
    /**
     * @param string $id the ID of the account on which to retrieve the capabilities
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Capability> the list of capabilities
     */
    public static function all_capabilities($id, $params = null, $opts = null)
    {
        return self::_all_nested_resources($id, static::PATH_CAPABILITIES, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the capability belongs
     * @param string $capabilityId the ID of the capability to retrieve
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Capability
     */
    public static function retrieve_capability($id, $capability_id, $params = null, $opts = null)
    {
        return self::_retrieve_nested_resource($id, static::PATH_CAPABILITIES, $capability_id, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the capability belongs
     * @param string $capabilityId the ID of the capability to update
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Capability
     */
    public static function update_capability($id, $capability_id, $params = null, $opts = null)
    {
        return self::_update_nested_resource($id, static::PATH_CAPABILITIES, $capability_id, $params, $opts);
    }
    public const PATH_EXTERNAL_ACCOUNTS = '/external_accounts';
    /**
     * @param string $id the ID of the account on which to retrieve the external accounts
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\BankAccount|\Stripe\Card> the list of external accounts (BankAccount or Card)
     */
    public static function all_external_accounts($id, $params = null, $opts = null)
    {
        return self::_all_nested_resources($id, static::PATH_EXTERNAL_ACCOUNTS, $params, $opts);
    }
    /**
     * @param string $id the ID of the account on which to create the external account
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card
     */
    public static function create_external_account($id, $params = null, $opts = null)
    {
        return self::_create_nested_resource($id, static::PATH_EXTERNAL_ACCOUNTS, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the external account belongs
     * @param string $externalAccountId the ID of the external account to delete
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card
     */
    public static function delete_external_account($id, $external_account_id, $params = null, $opts = null)
    {
        return self::_delete_nested_resource($id, static::PATH_EXTERNAL_ACCOUNTS, $external_account_id, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the external account belongs
     * @param string $externalAccountId the ID of the external account to retrieve
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card
     */
    public static function retrieve_external_account($id, $external_account_id, $params = null, $opts = null)
    {
        return self::_retrieve_nested_resource($id, static::PATH_EXTERNAL_ACCOUNTS, $external_account_id, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the external account belongs
     * @param string $externalAccountId the ID of the external account to update
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\BankAccount|\Stripe\Card
     */
    public static function update_external_account($id, $external_account_id, $params = null, $opts = null)
    {
        return self::_update_nested_resource($id, static::PATH_EXTERNAL_ACCOUNTS, $external_account_id, $params, $opts);
    }
    public const PATH_LOGIN_LINKS = '/login_links';
    /**
     * @param string $id the ID of the account on which to create the login link
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\LoginLink
     */
    public static function create_login_link($id, $params = null, $opts = null)
    {
        return self::_create_nested_resource($id, static::PATH_LOGIN_LINKS, $params, $opts);
    }
    public const PATH_PERSONS = '/persons';
    /**
     * @param string $id the ID of the account on which to retrieve the persons
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Person> the list of persons
     */
    public static function all_persons($id, $params = null, $opts = null)
    {
        return self::_all_nested_resources($id, static::PATH_PERSONS, $params, $opts);
    }
    /**
     * @param string $id the ID of the account on which to create the person
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Person
     */
    public static function create_person($id, $params = null, $opts = null)
    {
        return self::_create_nested_resource($id, static::PATH_PERSONS, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the person belongs
     * @param string $personId the ID of the person to delete
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Person
     */
    public static function delete_person($id, $person_id, $params = null, $opts = null)
    {
        return self::_delete_nested_resource($id, static::PATH_PERSONS, $person_id, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the person belongs
     * @param string $personId the ID of the person to retrieve
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Person
     */
    public static function retrieve_person($id, $person_id, $params = null, $opts = null)
    {
        return self::_retrieve_nested_resource($id, static::PATH_PERSONS, $person_id, $params, $opts);
    }
    /**
     * @param string $id the ID of the account to which the person belongs
     * @param string $personId the ID of the person to update
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Person
     */
    public static function update_person($id, $person_id, $params = null, $opts = null)
    {
        return self::_update_nested_resource($id, static::PATH_PERSONS, $person_id, $params, $opts);
    }
}
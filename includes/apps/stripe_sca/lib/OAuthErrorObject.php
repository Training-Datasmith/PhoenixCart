<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class OAuthErrorObject.
 *
 * @property string $error
 * @property string $error_description
 */
class O_Auth_Error_Object extends Stripe_Object
{
    /**
     * Refreshes this object using the provided values.
     *
     * @param array $values
     * @param null|array|string|Util\RequestOptions $opts
     * @param bool $partial defaults to false
     */
    public function refresh_from($values, $opts, $partial = false): void
    {
        // Unlike most other API resources, the API will omit attributes in
        // error objects when they have a null value. We manually set default
        // values here to facilitate generic error handling.
        $values = \array_merge(['error' => null, 'error_description' => null], $values);
        parent::refresh_from($values, $opts, $partial);
    }
}
<?php

declare (strict_types=1);
namespace Stripe;

abstract class O_Auth
{
    /**
     * Generates a URL to Stripe's OAuth form.
     *
     * @param null|array $params
     * @param null|array $opts
     *
     * @return string the URL to Stripe's OAuth form
     */
    public static function authorize_url($params = null, $opts = null)
    {
        $params = $params ?: [];
        $base = $opts && \array_key_exists('connect_base', $opts) ? $opts['connect_base'] : Stripe::$connect_base;
        $params['client_id'] = self::_get_client_id($params);
        if (!\array_key_exists('response_type', $params)) {
            $params['response_type'] = 'code';
        }
        $query = Util\Util::encode_parameters($params);
        return $base . '/oauth/authorize?' . $query;
    }
    /**
     * Use an authoriztion code to connect an account to your platform and
     * fetch the user's credentials.
     *
     * @param null|array $params
     * @param null|array $opts
     *
     * @throws \Stripe\Exception\OAuth\OAuthErrorException if the request fails
     *
     * @return StripeObject object containing the response from the API
     */
    public static function token($params = null, $opts = null)
    {
        $base = $opts && \array_key_exists('connect_base', $opts) ? $opts['connect_base'] : Stripe::$connect_base;
        $requestor = new Api_Requestor(null, $base);
        [$response, $api_key] = $requestor->request('post', '/oauth/token', $params);
        return Util\Util::convert_to_stripe_object($response->json, $opts);
    }
    /**
     * Disconnects an account from your platform.
     *
     * @param null|array $params
     * @param null|array $opts
     *
     * @throws \Stripe\Exception\OAuth\OAuthErrorException if the request fails
     *
     * @return StripeObject object containing the response from the API
     */
    public static function deauthorize($params = null, $opts = null)
    {
        $params = $params ?: [];
        $base = $opts && \array_key_exists('connect_base', $opts) ? $opts['connect_base'] : Stripe::$connect_base;
        $requestor = new Api_Requestor(null, $base);
        $params['client_id'] = self::_get_client_id($params);
        [$response, $api_key] = $requestor->request('post', '/oauth/deauthorize', $params);
        return Util\Util::convert_to_stripe_object($response->json, $opts);
    }
    private static function _get_client_id($params = null)
    {
        $client_id = $params && \array_key_exists('client_id', $params) ? $params['client_id'] : null;
        if (null === $client_id) {
            $client_id = Stripe::get_client_id();
        }
        if (null === $client_id) {
            $msg = 'No client_id provided.  (HINT: set your client_id using ' . '"Stripe::setClientId(<CLIENT-ID>)".  You can find your client_ids ' . 'in your Stripe dashboard at ' . 'https://dashboard.stripe.com/account/applications/settings, ' . 'after registering your account as a platform. See ' . 'https://stripe.com/docs/connect/standard-accounts for details, ' . 'or email support@stripe.com if you have any questions.';
            throw new Exception\Authentication_Exception($msg);
        }
        return $client_id;
    }
}
<?php

declare (strict_types=1);
namespace Stripe\Service;

class O_Auth_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Sends a request to Stripe's Connect API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\Stripe\Util\RequestOptions $opts the special modifiers of the request
     *
     * @return \Stripe\StripeObject the object returned by Stripe's Connect API
     */
    protected function request_connect($method, $path, $params, $opts)
    {
        $opts = $this->_parse_opts($opts);
        $opts->api_base = $this->_get_base($opts);
        return $this->request($method, $path, $params, $opts);
    }
    /**
     * Generates a URL to Stripe's OAuth form.
     *
     * @param null|array $params
     * @param null|array $opts
     *
     * @return string the URL to Stripe's OAuth form
     */
    public function authorize_url($params = null, $opts = null): string
    {
        $params = $params ?: [];
        $opts = $this->_parse_opts($opts);
        $base = $this->_get_base($opts);
        $params['client_id'] = $this->_get_client_id($params);
        if (!\array_key_exists('response_type', $params)) {
            $params['response_type'] = 'code';
        }
        $query = \Stripe\Util\Util::encode_parameters($params);
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
     * @return \Stripe\StripeObject object containing the response from the API
     */
    public function token($params = null, $opts = null)
    {
        $params = $params ?: [];
        $params['client_secret'] = $this->_get_client_secret($params);
        return $this->request_connect('post', '/oauth/token', $params, $opts);
    }
    /**
     * Disconnects an account from your platform.
     *
     * @param null|array $params
     * @param null|array $opts
     *
     * @throws \Stripe\Exception\OAuth\OAuthErrorException if the request fails
     *
     * @return \Stripe\StripeObject object containing the response from the API
     */
    public function deauthorize($params = null, $opts = null)
    {
        $params = $params ?: [];
        $params['client_id'] = $this->_get_client_id($params);
        return $this->request_connect('post', '/oauth/deauthorize', $params, $opts);
    }
    private function _get_client_id($params = null)
    {
        $client_id = $params && \array_key_exists('client_id', $params) ? $params['client_id'] : null;
        if (null === $client_id) {
            $client_id = $this->client->get_client_id();
        }
        if (null === $client_id) {
            $msg = 'No client_id provided. (HINT: set your client_id using ' . '`new \Stripe\StripeClient([clientId => <CLIENT-ID>
                ])`)".  You can find your client_ids ' . 'in your Stripe dashboard at ' . 'https://dashboard.stripe.com/account/applications/settings, ' . 'after registering your account as a platform. See ' . 'https://stripe.com/docs/connect/standard-accounts for details, ' . 'or email support@stripe.com if you have any questions.';
            throw new \Stripe\Exception\Authentication_Exception($msg);
        }
        return $client_id;
    }
    private function _get_client_secret($params = null)
    {
        if (\array_key_exists('client_secret', $params)) {
            return $params['client_secret'];
        }
        return $this->client->get_api_key();
    }
    /**
     * @param array|\Stripe\Util\RequestOptions $opts the special modifiers of the request
     *
     * @throws \Stripe\Exception\InvalidArgumentException
     *
     * @return \Stripe\Util\RequestOptions
     */
    private function _parse_opts($opts)
    {
        if (\is_array($opts)) {
            if (\array_key_exists('connect_base', $opts)) {
                // Throw an exception for the convenience of anybody migrating to
                // \Stripe\Service\OAuthService from \Stripe\OAuth, where `connect_base`
                // was the name of the parameter that behaves as `api_base` does here.
                throw new \Stripe\Exception\InvalidArgumentException('Use `api_base`, not `connect_base`');
            }
        }
        return \Stripe\Util\Request_Options::parse($opts);
    }
    /**
     * @param \Stripe\Util\RequestOptions $opts
     *
     * @return string
     */
    private function _get_base($opts)
    {
        return $opts->api_base ?? $this->client->get_connect_base();
    }
}
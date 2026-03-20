<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class Stripe.
 */
class Stripe
{
    /** @var string The Stripe API key to be used for requests. */
    public static $api_key;
    /** @var string The Stripe client_id to be used for Connect requests. */
    public static $client_id;
    /** @var string The base URL for the Stripe API. */
    public static $api_base = 'https://api.stripe.com';
    /** @var string The base URL for the OAuth API. */
    public static $connect_base = 'https://connect.stripe.com';
    /** @var string The base URL for the Stripe API uploads endpoint. */
    public static $api_upload_base = 'https://files.stripe.com';
    /** @var null|string The version of the Stripe API to use for requests. */
    public static $api_version;
    /** @var null|string The account ID for connected accounts requests. */
    public static $account_id;
    /** @var string Path to the CA bundle used to verify SSL certificates */
    public static $ca_bundle_path;
    /** @var bool Defaults to true. */
    public static $verify_ssl_certs = true;
    /** @var array The application's information (name, version, URL) */
    public static $app_info;
    /**
     * @var null|Util\LoggerInterface the logger to which the library will
     *   produce messages
     */
    public static $logger;
    /** @var int Maximum number of request retries */
    public static $max_network_retries = 0;
    /** @var bool Whether client telemetry is enabled. Defaults to true. */
    public static $enable_telemetry = true;
    /** @var float Maximum delay between retries, in seconds */
    private static float $max_network_retry_delay = 2.0;
    /** @var float Maximum delay between retries, in seconds, that will be respected from the Stripe API */
    private static float $max_retry_after = 60.0;
    /** @var float Initial delay between retries, in seconds */
    private static float $initial_network_retry_delay = 0.5;
    public const VERSION = '10.5.0';
    /**
     * @return string the API key used for requests
     */
    public static function get_api_key()
    {
        return self::$api_key;
    }
    /**
     * @return string the client_id used for Connect requests
     */
    public static function get_client_id()
    {
        return self::$client_id;
    }
    /**
     * @return Util\LoggerInterface the logger to which the library will
     *   produce messages
     */
    public static function get_logger()
    {
        if (null === self::$logger) {
            return new Util\Default_Logger();
        }
        return self::$logger;
    }
    /**
     * @param \Psr\Log\LoggerInterface|Util\LoggerInterface $logger the logger to which the library
     *   will produce messages
     */
    public static function set_logger($logger): void
    {
        self::$logger = $logger;
    }
    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function set_api_key($api_key): void
    {
        self::$api_key = $api_key;
    }
    /**
     * Sets the client_id to be used for Connect requests.
     *
     * @param string $clientId
     */
    public static function set_client_id($client_id): void
    {
        self::$client_id = $client_id;
    }
    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function get_api_version()
    {
        return self::$api_version;
    }
    /**
     * @param string $apiVersion the API version to use for requests
     */
    public static function set_api_version($api_version): void
    {
        self::$api_version = $api_version;
    }
    /**
     * @return string
     */
    private static function get_default_ca_bundle_path()
    {
        return \realpath(__DIR__ . '/../data/ca-certificates.crt');
    }
    /**
     * @return string
     */
    public static function get_ca_bundle_path()
    {
        return self::$ca_bundle_path ?: self::get_default_ca_bundle_path();
    }
    /**
     * @param string $caBundlePath
     */
    public static function set_ca_bundle_path($ca_bundle_path): void
    {
        self::$ca_bundle_path = $ca_bundle_path;
    }
    /**
     * @return bool
     */
    public static function get_verify_ssl_certs()
    {
        return self::$verify_ssl_certs;
    }
    /**
     * @param bool $verify
     */
    public static function set_verify_ssl_certs($verify): void
    {
        self::$verify_ssl_certs = $verify;
    }
    /**
     * @return null|string The Stripe account ID for connected account
     *   requests
     */
    public static function get_account_id()
    {
        return self::$account_id;
    }
    /**
     * @param null|string $accountId the Stripe account ID to set for connected
     *   account requests
     */
    public static function set_account_id($account_id): void
    {
        self::$account_id = $account_id;
    }
    /**
     * @return null|array The application's information
     */
    public static function get_app_info()
    {
        return self::$app_info;
    }
    /**
     * @param string $appName The application's name
     * @param null|string $appVersion The application's version
     * @param null|string $appUrl The application's URL
     * @param null|string $appPartnerId The application's partner ID
     */
    public static function set_app_info($app_name, $app_version = null, $app_url = null, $app_partner_id = null): void
    {
        self::$app_info = self::$app_info ?: [];
        self::$app_info['name'] = $app_name;
        self::$app_info['partner_id'] = $app_partner_id;
        self::$app_info['url'] = $app_url;
        self::$app_info['version'] = $app_version;
    }
    /**
     * @return int Maximum number of request retries
     */
    public static function get_max_network_retries()
    {
        return self::$max_network_retries;
    }
    /**
     * @param int $maxNetworkRetries Maximum number of request retries
     */
    public static function set_max_network_retries($max_network_retries): void
    {
        self::$max_network_retries = $max_network_retries;
    }
    /**
     * @return float Maximum delay between retries, in seconds
     */
    public static function get_max_network_retry_delay()
    {
        return self::$max_network_retry_delay;
    }
    /**
     * @return float Maximum delay between retries, in seconds, that will be respected from the Stripe API
     */
    public static function get_max_retry_after()
    {
        return self::$max_retry_after;
    }
    /**
     * @return float Initial delay between retries, in seconds
     */
    public static function get_initial_network_retry_delay()
    {
        return self::$initial_network_retry_delay;
    }
    /**
     * @return bool Whether client telemetry is enabled
     */
    public static function get_enable_telemetry()
    {
        return self::$enable_telemetry;
    }
    /**
     * @param bool $enableTelemetry Enables client telemetry.
     *
     * Client telemetry enables timing and request metrics to be sent back to Stripe as an HTTP Header
     * with the current request. This enables Stripe to do latency and metrics analysis without adding extra
     * overhead (such as extra network calls) on the client.
     */
    public static function set_enable_telemetry($enable_telemetry): void
    {
        self::$enable_telemetry = $enable_telemetry;
    }
}
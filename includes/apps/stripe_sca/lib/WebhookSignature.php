<?php

declare (strict_types=1);
namespace Stripe;

abstract class Webhook_Signature
{
    public const EXPECTED_SCHEME = 'v1';
    /**
     * Verifies the signature header sent by Stripe. Throws an
     * Exception\SignatureVerificationException exception if the verification fails for
     * any reason.
     *
     * @param string $payload the payload sent by Stripe
     * @param string $header the contents of the signature header sent by
     *  Stripe
     * @param string $secret secret used to generate the signature
     * @param int $tolerance maximum difference allowed between the header's
     *  timestamp and the current time
     *
     * @throws Exception\SignatureVerificationException if the verification fails
     *
     * @return bool
     */
    public static function verify_header($payload, $header, $secret, $tolerance = null)
    {
        // Extract timestamp and signatures from header
        $timestamp = self::get_timestamp($header);
        $signatures = self::get_signatures($header, self::EXPECTED_SCHEME);
        if (-1 === $timestamp) {
            throw Exception\Signature_Verification_Exception::factory('Unable to extract timestamp and signatures from header', $payload, $header);
        }
        if (empty($signatures)) {
            throw Exception\Signature_Verification_Exception::factory('No signatures found with expected scheme', $payload, $header);
        }
        // Check if expected signature is found in list of signatures from
        // header
        $signed_payload = "{$timestamp}.{$payload}";
        $expected_signature = self::compute_signature($signed_payload, $secret);
        $signature_found = false;
        foreach ($signatures as $signature) {
            if (Util\Util::secure_compare($expected_signature, $signature)) {
                $signature_found = true;
                break;
            }
        }
        if (!$signature_found) {
            throw Exception\Signature_Verification_Exception::factory('No signatures found matching the expected signature for payload', $payload, $header);
        }
        // Check if timestamp is within tolerance
        if ($tolerance > 0 && \abs(\time() - $timestamp) > $tolerance) {
            throw Exception\Signature_Verification_Exception::factory('Timestamp outside the tolerance zone', $payload, $header);
        }
        return true;
    }
    /**
     * Extracts the timestamp in a signature header.
     *
     * @param string $header the signature header
     *
     * @return int the timestamp contained in the header, or -1 if no valid
     *  timestamp is found
     */
    private static function get_timestamp($header): int
    {
        $items = \explode(',', $header);
        foreach ($items as $item) {
            $item_parts = \explode('=', $item, 2);
            if ('t' === $item_parts[0]) {
                if (!\is_numeric($item_parts[1])) {
                    return -1;
                }
                return (int) $item_parts[1];
            }
        }
        return -1;
    }
    /**
     * Extracts the signatures matching a given scheme in a signature header.
     *
     * @param string $header the signature header
     * @param string $scheme the signature scheme to look for
     *
     * @return array the list of signatures matching the provided scheme
     */
    private static function get_signatures($header, string $scheme): array
    {
        $signatures = [];
        $items = \explode(',', $header);
        foreach ($items as $item) {
            $item_parts = \explode('=', $item, 2);
            if (\trim($item_parts[0]) === $scheme) {
                $signatures[] = $item_parts[1];
            }
        }
        return $signatures;
    }
    /**
     * Computes the signature for a given payload and secret.
     *
     * The current scheme used by Stripe ("v1") is HMAC/SHA-256.
     *
     * @param string $payload the payload to sign
     * @param string $secret the secret used to generate the signature
     *
     * @return string the signature as a string
     */
    private static function compute_signature(string $payload, $secret): string
    {
        return \hash_hmac('sha256', $payload, $secret);
    }
}
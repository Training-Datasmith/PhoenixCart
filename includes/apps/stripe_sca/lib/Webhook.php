<?php

declare (strict_types=1);
namespace Stripe;

abstract class Webhook
{
    public const DEFAULT_TOLERANCE = 300;
    /**
     * Returns an Event instance using the provided JSON payload. Throws an
     * Exception\UnexpectedValueException if the payload is not valid JSON, and
     * an Exception\SignatureVerificationException if the signature
     * verification fails for any reason.
     *
     * @param string $payload the payload sent by Stripe
     * @param string $sigHeader the contents of the signature header sent by
     *  Stripe
     * @param string $secret secret used to generate the signature
     * @param int $tolerance maximum difference allowed between the header's
     *  timestamp and the current time
     *
     * @throws Exception\UnexpectedValueException if the payload is not valid JSON,
     * @throws Exception\SignatureVerificationException if the verification fails
     *
     * @return Event the Event instance
     */
    public static function construct_event($payload, $sig_header, $secret, $tolerance = self::DEFAULT_TOLERANCE)
    {
        Webhook_Signature::verify_header($payload, $sig_header, $secret, $tolerance);
        $data = \json_decode($payload, true);
        $json_error = \json_last_error();
        if (null === $data && \JSON_ERROR_NONE !== $json_error) {
            $msg = "Invalid payload: {$payload} " . "(json_last_error() was {$json_error})";
            throw new Exception\UnexpectedValueException($msg);
        }
        return Event::construct_from($data);
    }
}
<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Interface for a Stripe client.
 */
interface Stripe_Streaming_Client_Interface extends Base_Stripe_Client_Interface
{
    public function request_stream($method, $path, $read_body_chunk_callable, $params, $opts);
}
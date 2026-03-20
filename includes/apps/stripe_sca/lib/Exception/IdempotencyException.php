<?php

declare (strict_types=1);
namespace Stripe\Exception;

/**
 * IdempotencyException is thrown in cases where an idempotency key was used
 * improperly.
 */
class Idempotency_Exception extends Api_Error_Exception
{
}
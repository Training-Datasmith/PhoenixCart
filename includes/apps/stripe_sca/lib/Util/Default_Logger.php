<?php

declare (strict_types=1);
namespace Stripe\Util;

/**
 * A very basic implementation of LoggerInterface that has just enough
 * functionality that it can be the default for this library.
 */
class Default_Logger implements Logger_Interface
{
    /** @var int */
    public $message_type = 0;
    /** @var null|string */
    public $destination;
    public function error($message, array $context = []): void
    {
        if (\count($context) > 0) {
            throw new \Stripe\Exception\BadMethodCallException('DefaultLogger does not currently implement context. Please implement if you need it.');
        }
        if (null === $this->destination) {
            \error_log($message, $this->message_type);
        } else {
            \error_log($message, $this->message_type, $this->destination);
        }
    }
}
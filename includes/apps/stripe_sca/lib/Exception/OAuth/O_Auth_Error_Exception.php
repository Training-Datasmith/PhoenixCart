<?php

declare (strict_types=1);
namespace Stripe\Exception\O_Auth;

/**
 * Implements properties and methods common to all (non-SPL) Stripe OAuth
 * exceptions.
 */
abstract class O_Auth_Error_Exception extends \Stripe\Exception\Api_Error_Exception
{
    protected function construct_error_object()
    {
        if (null === $this->json_body) {
            return null;
        }
        return \Stripe\O_Auth_Error_Object::construct_from($this->json_body);
    }
}
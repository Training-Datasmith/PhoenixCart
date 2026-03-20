<?php

declare (strict_types=1);
namespace Stripe\Exception\O_Auth;

/**
 * UnsupportedGrantTypeException is thrown when an unuspported grant type
 * parameter is specified.
 */
class Unsupported_Grant_Type_Exception extends O_Auth_Error_Exception
{
}
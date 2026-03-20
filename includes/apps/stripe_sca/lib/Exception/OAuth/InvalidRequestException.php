<?php

declare (strict_types=1);
namespace Stripe\Exception\O_Auth;

/**
 * InvalidRequestException is thrown when a code, refresh token, or grant
 * type parameter is not provided, but was required.
 */
class Invalid_Request_Exception extends O_Auth_Error_Exception
{
}
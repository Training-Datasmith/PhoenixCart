<?php

declare (strict_types=1);
namespace Stripe\Exception\O_Auth;

/**
 * InvalidGrantException is thrown when a specified code doesn't exist, is
 * expired, has been used, or doesn't belong to you; a refresh token doesn't
 * exist, or doesn't belong to you; or if an API key's mode (live or test)
 * doesn't match the mode of a code or refresh token.
 */
class Invalid_Grant_Exception extends O_Auth_Error_Exception
{
}
<?php

declare (strict_types=1);
namespace Stripe\Exception\O_Auth;

/**
 * UnknownApiErrorException is thrown when the client library receives an
 * error from the OAuth API it doesn't know about. Receiving this error usually
 * means that your client library is outdated and should be upgraded.
 */
class Unknown_O_Auth_Error_Exception extends O_Auth_Error_Exception
{
}
<?php

declare (strict_types=1);
/*
* This file is part of the Symfony package.
*
* (c) Fabien Potencier <fabien@symfony.com>
*
* For the full copyright and license information, please read:
*
* Copyright (c) 2004-present Fabien Potencier

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
/**
 * Provides fake static versions of the global functions in the intl extension.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @internal
 */
abstract class Intl_Globals
{
    /**
     * Indicates that no error occurred.
     */
    public const U_ZERO_ERROR = 0;
    /**
     * Indicates that an invalid argument was passed.
     */
    public const U_ILLEGAL_ARGUMENT_ERROR = 1;
    /**
     * Indicates that the parse() operation failed.
     */
    public const U_PARSE_ERROR = 9;
    /**
     * All known error codes.
     */
    private const ERROR_CODES = [self::U_ZERO_ERROR => 'U_ZERO_ERROR', self::U_ILLEGAL_ARGUMENT_ERROR => 'U_ILLEGAL_ARGUMENT_ERROR', self::U_PARSE_ERROR => 'U_PARSE_ERROR'];
    /**
     * The error code of the last operation.
     */
    private static int $error_code = self::U_ZERO_ERROR;
    /**
     * The error code of the last operation.
     */
    private static string $error_message = 'U_ZERO_ERROR';
    /**
     * Returns whether the error code indicates a failure.
     *
     * @param int $errorCode The error code returned by IntlGlobals::getErrorCode()
     */
    public static function is_failure(int $error_code): bool
    {
        return isset(self::ERROR_CODES[$error_code]) && $error_code > self::U_ZERO_ERROR;
    }
    /**
     * Returns the error code of the last operation.
     *
     * Returns IntlGlobals::U_ZERO_ERROR if no error occurred.
     *
     * @return int
     */
    public static function get_error_code()
    {
        return self::$error_code;
    }
    /**
     * Returns the error message of the last operation.
     *
     * Returns "U_ZERO_ERROR" if no error occurred.
     */
    public static function get_error_message(): string
    {
        return self::$error_message;
    }
    /**
     * Returns the symbolic name for a given error code.
     *
     * @param int $code The error code returned by IntlGlobals::getErrorCode()
     */
    public static function get_error_name(int $code): string
    {
        return self::ERROR_CODES[$code] ?? '[BOGUS UErrorCode]';
    }
    /**
     * Sets the current error.
     *
     * @param int    $code    One of the error constants in this class
     * @param string $message The ICU class error message
     *
     * @throws \InvalidArgumentException If the code is not one of the error constants in this class
     */
    public static function set_error(int $code, string $message = ''): void
    {
        if (!isset(self::ERROR_CODES[$code])) {
            throw new \InvalidArgumentException(sprintf('No such error code: "%s".', $code));
        }
        self::$error_message = $message ? sprintf('%s: %s', $message, self::ERROR_CODES[$code]) : self::ERROR_CODES[$code];
        self::$error_code = $code;
    }
}
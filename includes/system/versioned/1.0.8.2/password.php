<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Password
{
    public static function validate($plain, $hashed)
    {
        if ('' === $plain || '' === $hashed) {
            return false;
        }
        switch (static::type($hashed)) {
            case 'salt':
                return old_password::validate($plain, $hashed);
            case 'phpass':
                $hasher = new Password_Hash(10, true);
                return $hasher->check_password($plain, $hashed);
        }
        return password_verify((string) $plain, (string) $hashed);
    }
    public static function get_algorithm()
    {
        return defined('PHOENIX_ENCRYPTION') ? PHOENIX_ENCRYPTION : PASSWORD_DEFAULT;
    }
    public static function hash($plain): string
    {
        return defined('PHOENIX_PASSWORD_OPTIONS') ? password_hash((string) $plain, static::get_algorithm(), PHOENIX_PASSWORD_OPTIONS) : password_hash((string) $plain, static::get_algorithm());
    }
    protected static function _needs_rehash($hashed): bool
    {
        return defined('PHOENIX_PASSWORD_OPTIONS') ? password_needs_rehash($hashed, static::get_algorithm(), PHOENIX_PASSWORD_OPTIONS) : password_needs_rehash($hashed, static::get_algorithm());
    }
    public static function needs_rehash($hashed): bool
    {
        if (static::type($hashed) !== 'native') {
            return true;
        }
        return (bool) static::_needs_rehash($hashed);
    }
    public static function type($hashed): string
    {
        if (preg_match('{^[A-Za-z0-9]{32}:[A-Za-z0-9]{2}$}', (string) $hashed) === 1) {
            return 'salt';
        }
        if (Text::is_prefixed_by($hashed, '$P$')) {
            return 'phpass';
        }
        return 'native';
    }
    public static function create_random($length, $type = 'mixed'): string
    {
        if (!in_array($type, ['mixed', 'letters', 'digits'])) {
            $type = 'mixed';
        }
        $base = '';
        if ($type === 'mixed' || $type === 'letters') {
            $base .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($type === 'mixed' || $type === 'digits') {
            $base .= '0123456789';
        }
        $value = '';
        do {
            foreach (str_split(base64_encode(random_bytes($length))) as $random) {
                if (str_contains($base, $random)) {
                    $value .= $random;
                }
            }
        } while (strlen($value) < $length);
        if (strlen($value) > $length) {
            return substr($value, 0, $length);
        }
        return $value;
    }
}
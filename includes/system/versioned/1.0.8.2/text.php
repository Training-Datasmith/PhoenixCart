<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Text
{
    /**
     * Break words longer than maximum.
     */
    public static function break(string $s, int $maximum, string $break_marker = '-'): string
    {
        return array_reduce(
            explode(' ', $s),
            fn ($carry, $word) => $carry . Text::rtrim_once(chunk_split((string) $word, $maximum, $break_marker), $break_marker) . ' ',
            ''
        );
    }

    /**
     * Sanitize and normalize HTTP input.
     */
    public static function input(string $s): string
    {
        return trim((string) static::sanitize($s));
    }

    public static function is_empty(string $s = null): bool
    {
        return is_null($s) || ('' === trim($s));
    }

    public static function is_prefixed_by(string $s, string $prefix): bool
    {
        return (str_starts_with($s, $prefix));
    }

    public static function is_suffixed_by(string $s, string $suffix): bool
    {
        return (str_ends_with($s, $suffix));
    }

    public static function ltrim_once(string $s, string $prefix): string
    {
        $length = strlen($prefix);
        if (substr($s, 0, $length) === $prefix) {
            return substr($s, $length);
        }

        return $s;
    }

    public static function output(string $s, $translate = false): string
    {
        return strtr(trim($s), $translate ?: ['"' => '&quot;']);
    }

    public static function prepare(string $s): string
    {
        return trim($s);
    }

    public static function rtrim_once(string $s, string $suffix): string
    {
        $displacement = -strlen($suffix);
        if (substr($s, $displacement) === $suffix) {
            return substr($s, 0, $displacement);
        }

        return $s;
    }

    public static function sanitize(string $s): ?string
    {
        return preg_replace(
            ['{ +}', '{[<>]}'],
            [' ', '_'],
            trim($s)
        );
    }

}

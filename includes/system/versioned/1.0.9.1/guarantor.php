<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Guarantor
{
    public static function &ensure_global($class, ...$parameters)
    {
        if (!(($GLOBALS[$class] ?? null) instanceof $class)) {
            $GLOBALS[$class] = new $class(...$parameters);
        }

        return $GLOBALS[$class];
    }

    public static function &guarantee_subarray(array &$data, $key)
    {
        if (!isset($data[$key]) || !is_array($data[$key])) {
            $data[$key] = [];
        }

        return $data[$key];
    }

    public static function &guarantee_all(&$data, ...$keys)
    {
        $current = &$data;
        foreach ($keys as $key) {
            $current = &Guarantor::guarantee_subarray($current, $key);
        }

        return $current;
    }

}

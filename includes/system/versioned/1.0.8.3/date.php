<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Date
{
    protected $timestamp;

    /**
     * Construct a Date object.
     * Strings need to be in this format: YYYY-MM-DD HH:MM:SS
     * @param mixed $date
     */
    public function __construct($date)
    {
        if (is_int($date)) {
            $this->timestamp = $date;
        } elseif (($date === '0000-00-00 00:00:00') || !$date) {
            $this->timestamp = false;
        } else {
            $this->timestamp = mktime(
                (int)substr((string) $date, 11, 2),
                (int)substr((string) $date, 14, 2),
                (int)substr((string) $date, 17, 2),
                (int)substr((string) $date, 5, 2),
                (int)substr((string) $date, 8, 2),
                (int)substr((string) $date, 0, 4)
            );
        }
    }

    /**
     * Format this date with strftime.
     * @param string $format A strftime format string.
     */
    public function format($format): string|false
    {
        return $this->timestamp
             ? strftime($format, $this->timestamp)
             : false;
    }

    // Output in the selected locale date format, long version
    // $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
    public static function expound($raw_date)
    {
        return (new Date($raw_date))->format(DATE_FORMAT_LONG);
    }

    ////
    // Output in the selected locale date format, shorter version
    // $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
    public static function abridge($raw_date)
    {
        return (new Date($raw_date))->format(DATE_FORMAT_SHORT);
    }

    /**
     * Create with the current date.
     */
    public static function now(): \Date
    {
        return new Date(time());
    }

}

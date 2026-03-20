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
 * Replacement for PHP's native {@link IntlDateFormatter} class.
 *
 * The only methods currently supported in this class are:
 *
 *  - {@link __construct}
 *  - {@link create}
 *  - {@link format}
 *  - {@link getCalendar}
 *  - {@link getDateType}
 *  - {@link getErrorCode}
 *  - {@link getErrorMessage}
 *  - {@link getLocale}
 *  - {@link getPattern}
 *  - {@link getTimeType}
 *  - {@link getTimeZoneId}
 *  - {@link isLenient}
 *  - {@link parse}
 *  - {@link setLenient}
 *  - {@link setPattern}
 *  - {@link setTimeZoneId}
 *  - {@link setTimeZone}
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @internal
 */
class Intl_Date_Formatter
{
    /**
     * The error code from the last operation.
     *
     * @var int
     */
    protected $error_code = Intl_Globals::U_ZERO_ERROR;
    /**
     * The error message from the last operation.
     *
     * @var string
     */
    protected $error_message = 'U_ZERO_ERROR';
    /* date/time format types */
    public const NONE = -1;
    public const FULL = 0;
    public const LONG = 1;
    public const MEDIUM = 2;
    public const SHORT = 3;
    /* calendar formats */
    public const TRADITIONAL = 0;
    public const GREGORIAN = 1;
    /**
     * Patterns used to format the date when no pattern is provided.
     */
    private $default_date_formats = [self::NONE => '', self::FULL => 'EEEE, MMMM d, y', self::LONG => 'MMMM d, y', self::MEDIUM => 'MMM d, y', self::SHORT => 'M/d/yy'];
    /**
     * Patterns used to format the time when no pattern is provided.
     */
    private $default_time_formats = [self::FULL => 'h:mm:ss a zzzz', self::LONG => 'h:mm:ss a z', self::MEDIUM => 'h:mm:ss a', self::SHORT => 'h:mm a'];
    private readonly int $datetype;
    private readonly int $timetype;
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var DateTimeZone
     */
    private $date_time_zone;
    /**
     * @var bool
     */
    private $uninitialized_time_zone_id = false;
    /**
     * @var string
     */
    private $time_zone_id;
    /**
     * @param string|null                             $locale   The locale code. The only currently supported locale is "en" (or null using the default locale, i.e. "en")
     * @param int|null                                $datetype Type of date formatting, one of the format type constants
     * @param int|null                                $timetype Type of time formatting, one of the format type constants
     * @param IntlTimeZone|DateTimeZone|string|null $timezone Timezone identifier
     * @param int|null                                $calendar Calendar to use for formatting or parsing. The only currently
     *                                                          supported value is IntlDateFormatter::GREGORIAN (or null using the default calendar, i.e. "GREGORIAN")
     * @param string|null                             $pattern  Optional pattern to use when formatting
     *
     * @see https://php.net/intldateformatter.create
     * @see http://userguide.icu-project.org/formatparse/datetime
     */
    public function __construct(string $locale = null, int $datetype = null, int $timetype = null, $timezone = null, int $calendar = null, string $pattern = null)
    {
        if ('en' !== $locale && null !== $locale) {
            trigger_error("The [{$locale}] locale will be treated as en", E_USER_WARNING);
        }
        if (self::GREGORIAN !== $calendar && null !== $calendar) {
            trigger_error("The [{$calendar}] calendar will be treated as Gregorian", E_USER_WARNING);
        }
        $this->datetype = $datetype ?? self::FULL;
        $this->timetype = $timetype ?? self::FULL;
        if ('' === ($pattern ?? '')) {
            $pattern = $this->get_default_pattern();
        }
        $this->set_pattern($pattern);
        $this->set_time_zone($timezone);
    }
    /**
     * Static constructor.
     *
     * @param string|null                             $locale   The locale code. The only currently supported locale is "en" (or null using the default locale, i.e. "en")
     * @param int|null                                $datetype Type of date formatting, one of the format type constants
     * @param int|null                                $timetype Type of time formatting, one of the format type constants
     * @param IntlTimeZone|DateTimeZone|string|null $timezone Timezone identifier
     * @param int                                     $calendar Calendar to use for formatting or parsing; default is Gregorian
     *                                                          One of the calendar constants
     * @param string|null                             $pattern  Optional pattern to use when formatting
     *
     *
     * @see https://php.net/intldateformatter.create
     * @see http://userguide.icu-project.org/formatparse/datetime
     */
    public static function create(string $locale = null, int $datetype = null, int $timetype = null, $timezone = null, int $calendar = self::GREGORIAN, string $pattern = null): static
    {
        return new static($locale, $datetype, $timetype, $timezone, $calendar, $pattern);
    }
    /**
     * Format the date/time value (timestamp) as a string.
     *
     * @param int|string|DateTimeInterface $timestamp The timestamp to format
     *
     * @return string|bool The formatted value or false if formatting failed
     *
     * @see https://php.net/intldateformatter.format
     *
     * @throws InvalidArgumentException If one of the formatting characters is not implemented
     */
    public function format($timestamp): false|string
    {
        // intl allows timestamps to be passed as arrays - we don't
        if (is_array($timestamp)) {
            $message = ' Only Unix timestamps and DateTime objects are supported';
            throw new InvalidArgumentException(__METHOD__ . $message);
        }
        if (is_string($timestamp) && $dt = DateTime::create_from_format('U', $timestamp)) {
            $timestamp = $dt;
        }
        // behave like the intl extension
        $argument_error = null;
        if (!is_int($timestamp) && !$timestamp instanceof DateTimeInterface) {
            $argument_error = sprintf("datefmt_format: string '%s' is not numeric, which would be required for it to be a valid date", $timestamp);
        }
        if (null !== $argument_error) {
            Intl_Globals::set_error(Intl_Globals::U_ILLEGAL_ARGUMENT_ERROR, $argument_error);
            $this->error_code = Intl_Globals::get_error_code();
            $this->error_message = Intl_Globals::get_error_message();
            return false;
        }
        if ($timestamp instanceof DateTimeInterface) {
            $timestamp = $timestamp->format('U');
        }
        $transformer = new Full_Transformer($this->get_pattern(), $this->get_time_zone_id());
        $formatted = $transformer->format($this->create_date_time($timestamp));
        // behave like the intl extension
        Intl_Globals::set_error(Intl_Globals::U_ZERO_ERROR);
        $this->error_code = Intl_Globals::get_error_code();
        $this->error_message = Intl_Globals::get_error_message();
        return $formatted;
    }
    /**
     * Returns the formatter's calendar.
     *
     * @return int The calendar being used by the formatter. Currently always returns
     *             IntlDateFormatter::GREGORIAN.
     *
     * @see https://php.net/intldateformatter.getcalendar
     */
    public function get_calendar(): int
    {
        return self::GREGORIAN;
    }
    /**
     * Returns the formatter's datetype.
     *
     * @return int The current value of the formatter
     *
     * @see https://php.net/intldateformatter.getdatetype
     */
    public function get_date_type()
    {
        return $this->datetype;
    }
    /**
     * Returns formatter's last error code. Always returns the U_ZERO_ERROR class constant value.
     *
     * @return int The error code from last formatter call
     *
     * @see https://php.net/intldateformatter.geterrorcode
     */
    public function get_error_code()
    {
        return $this->error_code;
    }
    /**
     * Returns formatter's last error message. Always returns the U_ZERO_ERROR_MESSAGE class constant value.
     *
     * @return string The error message from last formatter call
     *
     * @see https://php.net/intldateformatter.geterrormessage
     */
    public function get_error_message()
    {
        return $this->error_message;
    }
    /**
     * Returns the formatter's locale.
     *
     * @param int $type Not supported. The locale name type to return (Locale::VALID_LOCALE or Locale::ACTUAL_LOCALE)
     *
     * @return string The locale used to create the formatter. Currently always
     *                returns "en".
     *
     * @see https://php.net/intldateformatter.getlocale
     */
    public function get_locale(int $ignored = null): string
    {
        return 'en';
    }
    /**
     * Returns the formatter's pattern.
     *
     * @return string The pattern string used by the formatter
     *
     * @see https://php.net/intldateformatter.getpattern
     */
    public function get_pattern()
    {
        return $this->pattern;
    }
    /**
     * Returns the formatter's time type.
     *
     * @return int The time type used by the formatter
     *
     * @see https://php.net/intldateformatter.gettimetype
     */
    public function get_time_type()
    {
        return $this->timetype;
    }
    /**
     * Returns the formatter's timezone identifier.
     *
     * @return string The timezone identifier used by the formatter
     *
     * @see https://php.net/intldateformatter.gettimezoneid
     */
    public function get_time_zone_id()
    {
        return $this->uninitialized_time_zone_id ? date_default_timezone_get() : $this->time_zone_id;
    }
    /**
     * Returns whether the formatter is lenient.
     *
     * @return bool Currently always returns false
     *
     * @see https://php.net/intldateformatter.islenient
     */
    public function is_lenient(): bool
    {
        return false;
    }
    /**
     * Parse string to a timestamp value.
     *
     * @param string   $value    String to convert to a time value
     * @param int|null $position Not supported. Position at which to start the parsing in $value (zero-based)
     *                           If no error occurs before $value is consumed, $parse_pos will
     *                           contain -1 otherwise it will contain the position at which parsing
     *                           ended. If $parse_pos > strlen($value), the parse fails immediately.
     *
     * @return int|false Parsed value as a timestamp
     *
     * @see https://php.net/intldateformatter.parse
     *
     * @throws InvalidArgumentException When $position different than null, behavior not implemented
     */
    public function parse(string $value, int &$position = null)
    {
        // We don't calculate the position when parsing the value
        if (null !== $position) {
            throw new InvalidArgumentException(__METHOD__ . ' position');
        }
        $date_time = $this->create_date_time(0);
        $transformer = new Full_Transformer($this->get_pattern(), $this->get_time_zone_id());
        $timestamp = $transformer->parse($date_time, $value);
        // behave like the intl extension. FullTransformer::parse() set the proper error
        $this->error_code = Intl_Globals::get_error_code();
        $this->error_message = Intl_Globals::get_error_message();
        return $timestamp;
    }
    /**
     * Set the leniency of the parser.
     *
     * Define if the parser is strict or lenient in interpreting inputs that do not match the pattern
     * exactly. Enabling lenient parsing allows the parser to accept otherwise flawed date or time
     * patterns, parsing as much as possible to obtain a value. Extra space, unrecognized tokens, or
     * invalid values ("February 30th") are not accepted.
     *
     * @param bool $lenient Sets whether the parser is lenient or not. Currently
     *                      only false (strict) is supported.
     *
     * @return bool true on success or false on failure
     *
     * @see https://php.net/intldateformatter.setlenient
     *
     * @throws InvalidArgumentException When $lenient is true
     */
    public function set_lenient(bool $lenient): bool
    {
        if ($lenient) {
            throw new InvalidArgumentException('Only the strict parser is supported');
        }
        return true;
    }
    /**
     * Set the formatter's pattern.
     *
     * @param string|null $pattern A pattern string in conformance with the ICU IntlDateFormatter documentation
     *
     * @return bool true on success or false on failure
     *
     * @see https://php.net/intldateformatter.setpattern
     * @see http://userguide.icu-project.org/formatparse/datetime
     */
    public function set_pattern(string $pattern = null): bool
    {
        $this->pattern = (string) $pattern;
        return true;
    }
    /**
     * Set the formatter's timezone identifier.
     *
     * @param string|null $timeZoneId The time zone ID string of the time zone to use.
     *                                If NULL or the empty string, the default time zone for the
     *                                runtime is used.
     *
     * @return bool true on success or false on failure
     *
     * @see https://php.net/intldateformatter.settimezoneid
     */
    public function set_time_zone_id(string $time_zone_id = null): bool
    {
        if (null === $time_zone_id) {
            $time_zone_id = date_default_timezone_get();
            $this->uninitialized_time_zone_id = true;
        }
        // Backup original passed time zone
        $time_zone = $time_zone_id;
        // Get an Etc/GMT time zone that is accepted for DateTimeZone
        if ('GMT' !== $time_zone_id && Text::is_prefixed_by($time_zone_id, 'GMT')) {
            try {
                $time_zone_id = Date_Format\Timezone_Transformer::get_etc_time_zone_id($time_zone_id);
            } catch (InvalidArgumentException) {
                // Does nothing, will fallback to UTC
            }
        }
        try {
            $this->date_time_zone = new DateTimeZone($time_zone_id);
            if ('GMT' !== $time_zone_id && $this->date_time_zone->get_name() !== $time_zone_id) {
                $time_zone = $this->get_time_zone_id();
            }
        } catch (Exception) {
            $time_zone_id = $time_zone = $this->get_time_zone_id();
            $this->date_time_zone = new DateTimeZone($time_zone_id);
        }
        $this->time_zone_id = $time_zone;
        return true;
    }
    /**
     * This method was added in PHP 5.5 as replacement for `setTimeZoneId()`.
     *
     * @param IntlTimeZone|DateTimeZone|string|null $timeZone
     *
     * @return bool true on success or false on failure
     *
     * @see https://php.net/intldateformatter.settimezone
     */
    public function set_time_zone($time_zone)
    {
        if ($time_zone instanceof Intl_Time_Zone) {
            $time_zone = $time_zone->get_id();
        }
        if ($time_zone instanceof DateTimeZone) {
            $time_zone = $time_zone->get_name();
            // DateTimeZone returns the GMT offset timezones without the leading GMT, while our parsing requires it.
            if (!empty($time_zone) && ('+' === $time_zone[0] || '-' === $time_zone[0])) {
                $time_zone = 'GMT' . $time_zone;
            }
        }
        return $this->set_time_zone_id($time_zone);
    }
    /**
     * Create and returns a DateTime object with the specified timestamp and with the
     * current time zone.
     *
     * @return DateTime
     */
    protected function create_date_time(string $timestamp)
    {
        $date_time = DateTime::create_from_format('U', $timestamp);
        $date_time->set_timezone($this->date_time_zone);
        return $date_time;
    }
    /**
     * Returns a pattern string based in the datetype and timetype values.
     *
     * @return string
     */
    protected function get_default_pattern()
    {
        $pattern = '';
        if (self::NONE !== $this->datetype) {
            $pattern = $this->default_date_formats[$this->datetype];
        }
        if (self::NONE !== $this->timetype) {
            if (self::FULL === $this->datetype || self::LONG === $this->datetype) {
                $pattern .= " 'at' ";
            } elseif (self::NONE !== $this->datetype) {
                $pattern .= ', ';
            }
            $pattern .= $this->default_time_formats[$this->timetype];
        }
        return $pattern;
    }
}
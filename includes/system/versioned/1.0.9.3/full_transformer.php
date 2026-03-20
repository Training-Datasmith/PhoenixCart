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
 * Parser and formatter for date formats.
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 *
 * @internal
 */
class Full_Transformer
{
    private string $quote_match = "'(?:[^']+|'')*'";
    private string $implemented_chars = 'MLydQqhDEaHkKmsz';
    private string $not_implemented_chars = 'GYuwWFgecSAZvVW';
    private readonly string $reg_exp;
    /**
     * @var Transformer[]
     */
    private array $transformers;
    /**
     * @param string $pattern  The pattern to be used to format and/or parse values
     * @param string $timezone The timezone to perform the date/time calculations
     */
    public function __construct(private readonly string $pattern, private readonly string $timezone)
    {
        $implemented_chars_match = $this->build_chars_match($this->implemented_chars);
        $not_implemented_chars_match = $this->build_chars_match($this->not_implemented_chars);
        $this->reg_exp = "/({$this->quote_match}|{$implemented_chars_match}|{$not_implemented_chars_match})/";
        $this->transformers = ['M' => new Month_Transformer(), 'L' => new Month_Transformer(), 'y' => new Year_Transformer(), 'd' => new Day_Transformer(), 'q' => new Quarter_Transformer(), 'Q' => new Quarter_Transformer(), 'h' => new Hour1201Transformer(), 'D' => new Day_Of_Year_Transformer(), 'E' => new Day_Of_Week_Transformer(), 'a' => new Am_Pm_Transformer(), 'H' => new Hour2400Transformer(), 'K' => new Hour1200Transformer(), 'k' => new Hour2401Transformer(), 'm' => new Minute_Transformer(), 's' => new Second_Transformer(), 'z' => new Timezone_Transformer()];
    }
    /**
     * Format a DateTime using ICU dateformat pattern.
     *
     * @return string The formatted value
     */
    public function format(DateTime $date_time): string
    {
        return preg_replace_callback($this->reg_exp, fn($matches) => $this->format_replace($matches[0], $date_time), $this->pattern);
    }
    /**
     * Return the formatted ICU value for the matched date characters.
     *
     * @throws InvalidArgumentException When it encounters a not implemented date character
     */
    private function format_replace(string $date_chars, DateTime $date_time): string
    {
        $length = strlen($date_chars);
        if ($this->is_quote_match($date_chars)) {
            return $this->replace_quote_match($date_chars);
        }
        if (isset($this->transformers[$date_chars[0]])) {
            $transformer = $this->transformers[$date_chars[0]];
            return $transformer->format($date_time, $length);
        }
        // handle unimplemented characters
        if (str_contains((string) $this->not_implemented_chars, $date_chars[0])) {
            throw new InvalidArgumentException(sprintf('Unimplemented date character "%s" in format "%s".', $date_chars[0], $this->pattern));
        }
        return '';
    }
    /**
     * Parse a pattern based string to a timestamp value.
     *
     * @param DateTime $dateTime A configured DateTime object to use to perform the date calculation
     * @param string    $value    String to convert to a time value
     *
     * @return int|false The corresponding Unix timestamp
     *
     * @throws InvalidArgumentException When the value cannot be matched with pattern
     */
    public function parse(DateTime $date_time, string $value)
    {
        $reverse_matching_reg_exp = $this->get_reverse_matching_reg_exp($this->pattern);
        $reverse_matching_reg_exp = '/^' . $reverse_matching_reg_exp . '$/';
        $options = [];
        if (preg_match($reverse_matching_reg_exp, $value, $matches)) {
            $matches = $this->normalize_array($matches);
            foreach ($this->transformers as $char => $transformer) {
                if (isset($matches[$char])) {
                    $length = strlen((string) $matches[$char]['pattern']);
                    $options = array_merge($options, $transformer->extract_date_options($matches[$char]['value'], $length));
                }
            }
            // reset error code and message
            Intl_Globals::set_error(Intl_Globals::U_ZERO_ERROR);
            return $this->calculate_unix_timestamp($date_time, $options);
        }
        // behave like the intl extension
        Intl_Globals::set_error(Intl_Globals::U_PARSE_ERROR, 'Date parsing failed');
        return false;
    }
    /**
     * Retrieve a regular expression to match with a formatted value.
     *
     * @return string The reverse matching regular expression with named captures being formed by the
     *                transformer index in the $transformer array
     */
    private function get_reverse_matching_reg_exp(string $pattern): string
    {
        $escaped_pattern = preg_quote($pattern, '/');
        // ICU 4.8 recognizes slash ("/") in a value to be parsed as a dash ("-") and vice-versa
        // when parsing a date/time value
        $escaped_pattern = preg_replace('/\\\\[\-|\/]/', '[\/\-]', $escaped_pattern);
        return preg_replace_callback($this->reg_exp, function (array $matches): ?string {
            $length = strlen((string) $matches[0]);
            $transformer_index = $matches[0][0];
            $date_chars = $matches[0];
            if ($this->is_quote_match($date_chars)) {
                return $this->replace_quote_match($date_chars);
            }
            if (isset($this->transformers[$transformer_index])) {
                $transformer = $this->transformers[$transformer_index];
                $capture_name = str_repeat($transformer_index, $length);
                return "(?P<{$capture_name}>" . $transformer->get_reverse_matching_reg_exp($length) . ')';
            }
            return null;
        }, (string) $escaped_pattern);
    }
    /**
     * Check if the first char of a string is a single quote.
     */
    private function is_quote_match(string $quote_match): bool
    {
        return "'" === $quote_match[0];
    }
    /**
     * Replaces single quotes at the start or end of a string with two single quotes.
     */
    private function replace_quote_match(string $quote_match): string
    {
        if (preg_match("/^'+\$/", $quote_match)) {
            return str_replace("''", "'", $quote_match);
        }
        return str_replace("''", "'", substr($quote_match, 1, -1));
    }
    /**
     * Builds a chars match regular expression.
     */
    private function build_chars_match(string $special_chars): string
    {
        $special_chars_array = str_split($special_chars);
        return implode('|', array_map(fn($char) => $char . '+', $special_chars_array));
    }
    /**
     * Normalize a preg_replace match array, removing the numeric keys and returning an associative array
     * with the value and pattern values for the matched Transformer.
     */
    private function normalize_array(array $data): array
    {
        $ret = [];
        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            $ret[$key[0]] = ['value' => $value, 'pattern' => $key];
        }
        return $ret;
    }
    /**
     * Calculates the Unix timestamp based on the matched values by the reverse matching regular
     * expression of parse().
     *
     * @return bool|int The calculated timestamp or false if matched date is invalid
     */
    private function calculate_unix_timestamp(DateTime $date_time, array $options): false|int
    {
        $options = $this->get_default_value_for_options($options);
        $year = $options['year'];
        $month = $options['month'];
        $day = $options['day'];
        $hour = $options['hour'];
        $hour_instance = $options['hourInstance'];
        $minute = $options['minute'];
        $second = $options['second'];
        $marker = $options['marker'];
        $timezone = $options['timezone'];
        // If month is false, return immediately (intl behavior)
        if (false === $month) {
            Intl_Globals::set_error(Intl_Globals::U_PARSE_ERROR, 'Date parsing failed');
            return false;
        }
        // Normalize hour
        if ($hour_instance instanceof Hour_Transformer) {
            $hour = $hour_instance->normalize_hour($hour, $marker);
        }
        // Set the timezone if different from the default one
        if (null !== $timezone && $timezone !== $this->timezone) {
            $date_time->set_timezone(new DateTimeZone($timezone));
        }
        // Normalize yy year
        preg_match_all($this->reg_exp, $this->pattern, $matches);
        if (in_array('yy', $matches[0])) {
            $date_time->set_timestamp(time());
            $year = $year > (int) $date_time->format('y') + 20 ? 1900 + $year : 2000 + $year;
        }
        $date_time->set_date($year, $month, $day);
        $date_time->set_time($hour, $minute, $second);
        return $date_time->get_timestamp();
    }
    /**
     * Add sensible default values for missing items in the extracted date/time options array. The values
     * are base in the beginning of the Unix era.
     */
    private function get_default_value_for_options(array $options): array
    {
        return ['year' => $options['year'] ?? 1970, 'month' => $options['month'] ?? 1, 'day' => $options['day'] ?? 1, 'hour' => $options['hour'] ?? 0, 'hourInstance' => $options['hourInstance'] ?? null, 'minute' => $options['minute'] ?? 0, 'second' => $options['second'] ?? 0, 'marker' => $options['marker'] ?? null, 'timezone' => $options['timezone'] ?? null];
    }
}
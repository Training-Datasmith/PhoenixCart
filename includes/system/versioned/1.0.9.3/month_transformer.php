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
 * Parser and formatter for month format.
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 *
 * @internal
 */
class Month_Transformer extends Transformer
{
    protected static $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    /**
     * Short months names (first 3 letters).
     */
    protected static array $short_months = [];
    /**
     * Flipped $months array, $name => $index.
     */
    protected static array $flipped_months = [];
    /**
     * Flipped $shortMonths array, $name => $index.
     */
    protected static array $flipped_short_months = [];
    public function __construct()
    {
        if (0 === \count(self::$short_months)) {
            self::$short_months = array_map(fn($month) => substr((string) $month, 0, 3), self::$months);
            self::$flipped_months = array_flip(self::$months);
            self::$flipped_short_months = array_flip(self::$short_months);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function format(\DateTime $date_time, int $length): string
    {
        $match_length_map = [1 => 'n', 2 => 'm', 3 => 'M', 4 => 'F'];
        if (isset($match_length_map[$length])) {
            return $date_time->format($match_length_map[$length]);
        }
        if (5 === $length) {
            return substr($date_time->format('M'), 0, 1);
        }
        return $this->pad_left($date_time->format('m'), $length);
    }
    /**
     * {@inheritdoc}
     */
    public function get_reverse_matching_reg_exp(int $length): string
    {
        return match ($length) {
            1 => '\d{1,2}',
            3 => implode('|', self::$short_months),
            4 => implode('|', self::$months),
            5 => '[JFMASOND]',
            default => '\d{1,' . $length . '}',
        };
    }
    /**
     * {@inheritdoc}
     */
    public function extract_date_options(string $matched, int $length): array
    {
        if (is_numeric($matched)) {
            $matched = (int) $matched;
        } elseif (3 === $length) {
            $matched = self::$flipped_short_months[$matched] + 1;
        } elseif (4 === $length) {
            $matched = self::$flipped_months[$matched] + 1;
        } elseif (5 === $length) {
            // IntlDateFormatter::parse() always returns false for MMMMM or LLLLL
            $matched = false;
        }
        return ['month' => $matched];
    }
}
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
 * Parser and formatter for 12 hour format (1-12).
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 *
 * @internal
 */
class Hour1201Transformer extends Hour_Transformer
{
    /**
     * {@inheritdoc}
     */
    public function format(\DateTime $date_time, int $length): string
    {
        return $this->pad_left($date_time->format('g'), $length);
    }
    /**
     * {@inheritdoc}
     */
    public function normalize_hour(int $hour, ?string $marker = null): int
    {
        if ('PM' !== $marker && 12 === $hour) {
            $hour = 0;
        } elseif ('PM' === $marker && 12 !== $hour) {
            // If PM and hour is not 12 (1-12), sum 12 hour
            $hour += 12;
        }
        return $hour;
    }
    /**
     * {@inheritdoc}
     */
    public function get_reverse_matching_reg_exp(int $length): string
    {
        return '\d{1,2}';
    }
}
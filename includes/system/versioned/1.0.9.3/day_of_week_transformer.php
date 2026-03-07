<?php

declare(strict_types=1);

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
 * Parser and formatter for day of week format.
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 *
 * @internal
 */
class DayOfWeekTransformer extends Transformer
{
    /**
      * {@inheritdoc}
      */
    public function format(DateTime $dateTime, int $length): string
    {
        $dayOfWeek = $dateTime->format('l');
        return match ($length) {
            4 => $dayOfWeek,
            5 => $dayOfWeek[0],
            6 => substr($dayOfWeek, 0, 2),
            default => substr($dayOfWeek, 0, 3),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function getReverseMatchingRegExp(int $length): string
    {
        return match ($length) {
            4 => 'Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday',
            5 => '[MTWFS]',
            6 => 'Mo|Tu|We|Th|Fr|Sa|Su',
            default => 'Mon|Tue|Wed|Thu|Fri|Sat|Sun',
        };
    }

}

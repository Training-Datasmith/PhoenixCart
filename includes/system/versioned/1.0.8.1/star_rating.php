<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class star_rating implements \Stringable
{
    public function __construct(protected float $rating = 0.0)
    {
    }

    public function __toString(): string
    {
        $star_rating = round(min($this->rating, 5), 0, PHP_ROUND_HALF_UP);
        return '<span class="text-warning" title="' . sprintf(STAR_RATING, $this->rating) . '">'
             . str_repeat('<i class="fas fa-star"></i>', $star_rating)
             . str_repeat('<i class="far fa-star"></i>', 5 - $star_rating)
             . '</span>';
    }

}

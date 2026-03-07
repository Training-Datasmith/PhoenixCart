<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2023 Phoenix Cart

  Released under the GNU General Public License
*/

class global_eraser
{
    public function __call(string $name, array $arguments)
    {
        unset($GLOBALS[$name]);
    }

}

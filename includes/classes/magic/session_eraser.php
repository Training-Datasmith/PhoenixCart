<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class session_eraser
{
    public function __call(string $name, array $arguments)
    {
        unset($_SESSION[$name]);
    }

}

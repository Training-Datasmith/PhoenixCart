<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2022 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_default_currency
{
    public $type = 'error';

    public function pass(): bool
    {
        return defined('DEFAULT_CURRENCY');
    }

    public function get_message(): string
    {
        return ERROR_NO_DEFAULT_CURRENCY_DEFINED;
    }

}

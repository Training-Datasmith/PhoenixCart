<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2022 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_session_auto_start
{
    public $type = 'warning';

    public function pass(): bool
    {
        return ((bool)ini_get('session.auto_start') == false);
    }

    public function get_message(): string
    {
        return WARNING_SESSION_AUTO_START;
    }

}

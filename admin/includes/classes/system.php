<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class System
{
    /**
     * Sets the timeout for the current script.
     * Can't be used in safe mode, so override on such servers.
     * @param numeric $limit
     */
    public static function set_time_limit($limit): void
    {
        set_time_limit($limit);
    }

}

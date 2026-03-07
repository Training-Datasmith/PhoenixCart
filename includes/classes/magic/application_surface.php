<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class application_surface
{
    public function __call(string $name, array $arguments)
    {
        return DIR_FS_CATALOG . "includes/system/segments/application/$name.php";
    }

}

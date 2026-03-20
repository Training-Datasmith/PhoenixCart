<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_admin_site_Wide_style_Sheet_Dropdown
{
    public function listen_inject_site_start(): string
    {
        return '<style>#navbarAdmin ul.navbar-nav li.dropdown:hover > ul.dropdown-menu { max-height:500px; overflow-y:auto; }</style>' . PHP_EOL;
    }
}
<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class hook_admin_siteWide_styleSheetDropdown
{
    public function listen_injectSiteStart(): string
    {
        return '<style>#navbarAdmin ul.navbar-nav li.dropdown:hover > ul.dropdown-menu { max-height:500px; overflow-y:auto; }</style>' . PHP_EOL;
    }

}

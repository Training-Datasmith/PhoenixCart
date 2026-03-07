<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cfgm_shipping
{
    public const CODE = 'shipping';
    public const DIRECTORY = DIR_FS_CATALOG . 'includes/modules/shipping/';
    public const LANGUAGE_DIRECTORY = DIR_FS_CATALOG . 'includes/languages/';
    public const KEY = 'MODULE_SHIPPING_INSTALLED';
    public const TITLE = MODULE_CFG_MODULE_SHIPPING_TITLE;
    public const TEMPLATE_INTEGRATION = false;

    public const GET_HELP_LINK = 'https://phoenixcart.org/phoenixcartwiki/index.php?title=Shipping';
    public const GET_ADDONS_LINKS = [ADDONS_FREE => 'https://phoenixcart.org/forum/app.php/addons/free/shipping-18',
                              ADDONS_COMMERCIAL => 'https://phoenixcart.org/forum/app.php/addons/commercial/shipping-24',];

}

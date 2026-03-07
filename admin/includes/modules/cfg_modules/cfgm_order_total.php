<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cfgm_order_total
{
    public const CODE = 'order_total';
    public const DIRECTORY = DIR_FS_CATALOG . 'includes/modules/order_total/';
    public const LANGUAGE_DIRECTORY = DIR_FS_CATALOG . 'includes/languages/';
    public const KEY = 'MODULE_ORDER_TOTAL_INSTALLED';
    public const TITLE = MODULE_CFG_MODULE_ORDER_TOTAL_TITLE;
    public const TEMPLATE_INTEGRATION = false;

    public const GET_HELP_LINK = 'https://phoenixcart.org/phoenixcartwiki/index.php?title=Order_Total';
    public const GET_ADDONS_LINKS = [ADDONS_FREE => 'https://phoenixcart.org/forum/app.php/addons/free/orderTotal-22',
                              ADDONS_COMMERCIAL => 'https://phoenixcart.org/forum/app.php/addons/commercial/orderTotal-34',
                              ADDONS_PRO => 'https://phoenixcart.org/forum/app.php/addons/supporters/other-45',];

}

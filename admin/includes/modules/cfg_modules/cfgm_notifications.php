<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cfgm_notifications
{
    public const CODE = 'notifications';
    public const DIRECTORY = DIR_FS_CATALOG . 'includes/modules/notifications/';
    public const LANGUAGE_DIRECTORY = DIR_FS_CATALOG . 'includes/languages/';
    public const KEY = 'MODULE_NOTIFICATIONS_INSTALLED';
    public const TITLE = MODULE_CFG_MODULE_NOTIFICATIONS_TITLE;
    public const TEMPLATE_INTEGRATION = false;

    public const GET_HELP_LINK = 'https://phoenixcart.org/phoenixcartwiki/index.php?title=Notifications';
    public const GET_ADDONS_LINKS = [ADDONS_FREE => 'https://phoenixcart.org/forum/app.php/addons/free/other-29',
                              ADDONS_COMMERCIAL => 'https://phoenixcart.org/forum/app.php/addons/commercial/other-36',
                              ADDONS_PRO => 'https://phoenixcart.org/forum/app.php/addons/supporters/other-45',];

}

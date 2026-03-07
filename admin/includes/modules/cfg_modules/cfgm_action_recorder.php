<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cfgm_action_recorder
{
    public const CODE = 'action_recorder';
    public const DIRECTORY = DIR_FS_CATALOG . 'includes/modules/action_recorder/';
    public const LANGUAGE_DIRECTORY = DIR_FS_CATALOG . 'includes/languages/';
    public const KEY = 'MODULE_ACTION_RECORDER_INSTALLED';
    public const TITLE = MODULE_CFG_MODULE_ACTION_RECORDER_TITLE;
    public const TEMPLATE_INTEGRATION = false;

    public const GET_HELP_LINK = 'https://phoenixcart.org/phoenixcartwiki/index.php?title=Action_Recorder_(modules)';
    public const GET_ADDONS_LINKS = [];

}

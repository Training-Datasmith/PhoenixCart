<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2022 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_config_file_catalog
{
    public $type = 'warning';

    public function pass(): bool
    {
        return (file_exists(DIR_FS_CATALOG . 'includes/configure.php') && !File::is_writable(DIR_FS_CATALOG . 'includes/configure.php'));
    }

    public function get_message(): string
    {
        return WARNING_CONFIG_FILE_WRITEABLE;
    }

}

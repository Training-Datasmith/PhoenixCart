<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_download_directory
{
    public const FS_DOWNLOAD_DIRECTORY = DIR_FS_CATALOG . 'download/';

    public $type = 'warning';

    public function pass(): bool
    {
        return ('true' !== DOWNLOAD_ENABLED) || is_dir(static::FS_DOWNLOAD_DIRECTORY);
    }

    public function get_message(): string
    {
        return sprintf(WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT, static::FS_DOWNLOAD_DIRECTORY);
    }

}

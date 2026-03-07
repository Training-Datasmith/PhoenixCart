<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2022 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_file_uploads
{
    public $type = 'warning';

    public function pass(): bool
    {
        return (bool)ini_get('file_uploads');
    }

    public function get_message(): string
    {
        return WARNING_FILE_UPLOADS_DISABLED;
    }

}

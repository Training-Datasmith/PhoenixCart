<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_github_directory
{
    /**
     * @var 'Github Directory'
     */
    public $title;
    public $type = 'warning';

    public function __construct()
    {
        $this->title = MODULE_SECURITY_CHECK_GITHUB_TITLE;
    }

    public function pass(): bool
    {
        return !file_exists(DIR_FS_CATALOG . '.github');
    }

    public function get_message(): string
    {
        return MODULE_SECURITY_CHECK_GITHUB_DIRECTORY_EXISTS;
    }

}

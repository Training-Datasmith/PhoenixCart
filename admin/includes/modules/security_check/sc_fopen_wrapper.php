<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class sc_fopen_wrapper
{
    /**
     * @var 'allow_url_fopen'
     */
    public $title;
    public $type = 'warning';
    public $has_doc = false;

    public function __construct()
    {
        $this->title = MODULE_SECURITY_CHECK_FOPEN_WRAPPER_TITLE;
    }

    public function pass(): bool
    {
        return ((int)ini_get('allow_url_fopen') != 0);
    }

    public function get_message(): string
    {
        return MODULE_SECURITY_CHECK_FOPEN_WRAPPER_ERROR;
    }

}

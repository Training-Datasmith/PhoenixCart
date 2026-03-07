<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Linker
{
    public function __construct(protected $prefix = HTTP_SERVER . DIR_WS_CATALOG)
    {
    }

    public function get_prefix()
    {
        return $this->prefix;
    }

    public function set_prefix($prefix): void
    {
        $this->prefix = $prefix;
    }

    public function build($page = null, $parameters = [], $add_session_id = true): \Href
    {
        return new Href($this->prefix, $page, $parameters, $add_session_id);
    }

}

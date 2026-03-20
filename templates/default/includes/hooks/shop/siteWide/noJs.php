<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_shop_site_Wide_no_Js
{
    public $bodywrapperstart;
    public function listen_inject_body_wrapper_start(): string
    {
        $msg = TEXT_NOSCRIPT;
        $this->bodywrapperstart .= <<<eod
        <!-- noJs hooked -->
        <noscript>
          <div class="alert alert-danger text-center">{$msg}</div>
          <div class="w-100"></div>
        </noscript>
        eod;
        return $this->bodywrapperstart;
    }
}
<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_admin_site_Wide_style_Sheets
{
    public function listen_inject_site_start(): string
    {
        $admin_css = '<!-- stylesheets hooked -->' . PHP_EOL;
        $admin_css .= '<style>* {min-height: 0.01px;} .form-control-feedback { position: absolute; width: auto; top: 7px; right: 45px; margin-top: 0; }</style>' . PHP_EOL;
        return $admin_css . ('<link href="includes/stylesheet.css" rel="stylesheet">' . PHP_EOL);
    }
}
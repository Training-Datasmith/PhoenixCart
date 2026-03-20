<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_shop_site_Wide_style_Sheets
{
    public $sitestart;
    public function listen_inject_site_start(): string
    {
        $this->sitestart .= '<style>* {min-height: 0.01px;} input:-webkit-autofill, select:-webkit-autofill { animation-name: onAutoFillStart; transition: background-color 50000s ease-in-out 0s; } input:not(:-webkit-autofill) { animation-name: onAutoFillCancel; } .carousel-control-prev:hover, .carousel-control-next:hover { background-color: rgba(255, 255, 255, 0.2); }@view-transition { navigation: auto; }</style>';
        $css_file = 'templates/' . TEMPLATE_SELECTION . '/static/user.css';
        if (file_exists($css_file)) {
            $this->sitestart .= '<link href="' . $css_file . '" rel="stylesheet">' . PHP_EOL;
        }
        return $this->sitestart;
    }
}
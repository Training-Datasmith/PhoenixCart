<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_admin_site_Wide_chart_Js
{
    public $version = '2.9.3';
    public $sitestart;
    public function listen_inject_site_start()
    {
        if (basename(Request::get_page() === 'index.php')) {
            return '<!-- chartJs Hooked -->' . PHP_EOL . '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>' . PHP_EOL;
        }
    }
}
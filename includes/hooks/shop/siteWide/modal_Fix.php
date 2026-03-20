<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2025 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_shop_site_Wide_modal_Fix
{
    public function listen_inject_body_end(): string
    {
        return <<<EOD
        <script>
        document.addEventListener('show.bs.modal', e => e.target.inert = false);
        document.addEventListener('hide.bs.modal', e => e.target.inert = true);
        </script>
        EOD;
    }
}
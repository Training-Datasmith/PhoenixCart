<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2025 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_shop_site_Wide_pulse_Base
{
    public function listen_inject_body_end(): string
    {
        $pulse = <<<HTML
        <script src="./ext/modules/pulse/pulse.js" defer></script>
        <script>
          window.pulse = window.pulse || [];
        </script>
        HTML;
        return PHP_EOL . $pulse;
    }
}
<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
class Alert_Block
{
    public function __construct($alerts, $alert_output = false): string
    {
        $alert_box_string = '';
        foreach ($alerts as $alert) {
            $alert_box_string .= '<div';
            if (isset($alert['params']) && !Text::is_empty($alert['params'])) {
                $alert_box_string .= ' ' . $alert['params'];
            }
            $alert_box_string .= '>' . PHP_EOL;
            $alert_box_string .= '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' . PHP_EOL;
            $alert_box_string .= $alert['text'];
            $alert_box_string .= '</div>' . PHP_EOL;
        }
        if ($alert_output) {
            echo $alert_box_string;
        }
        return $alert_box_string;
    }
}
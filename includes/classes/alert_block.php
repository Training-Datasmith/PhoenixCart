<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Alert_Block
{
    public function __construct($alerts, $alert_output = false): string
    {
        $alert_box_string = '';
        foreach ($alerts as $alert) {
            $alert_box_string .= '  <div';
            if (isset($alert['params']) && !Text::is_empty($alert['params'])) {
                $alert_box_string .= ' ' . $alert['params'];
            }
            $alert_box_string .= '>' . "\n";
            $alert_box_string .= '	<button type="button" class="close" data-dismiss="alert">&times;</button>' . "\n";
            $alert_box_string .= $alert['text'];
            $alert_box_string .= '  </div>' . "\n";
        }
        if ($alert_output) {
            echo $alert_box_string;
        }
        return $alert_box_string;
    }
}
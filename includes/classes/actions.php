<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Actions
{
    public static function parse($action): void
    {
        $action = basename((string) $action);

        if ($action && class_exists($class = "\\Phoenix\\Actions\\$action")) {
            $hook_action = lcfirst(implode('', array_map(ucfirst(...), explode('_', $action))))  . 'Action';
            $GLOBALS['hooks']->cat($hook_action);

            call_user_func([$class, 'execute']);
        }
    }

}

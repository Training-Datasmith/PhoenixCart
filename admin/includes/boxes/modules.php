<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

$cl_box_groups[] = [
  'sort' => 25,
  'heading' => BOX_HEADING_MODULES,
  'apps' => array_map(fn (array $m) => [
    'code' => 'modules.php',
    'title' => $m['title'],
    'link' => $GLOBALS['Admin']->link('modules.php', ['set' => $m['code']]),
  ], Guarantor::ensure_global('cfg_modules')->getAll()),
];

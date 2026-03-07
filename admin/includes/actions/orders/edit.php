<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

if (!isset($_GET['oID'])) {
    $action = '';
    return;
}

$oID = (int)$_GET['oID'];

if (mysqli_num_rows($db->query('SELECT orders_id FROM orders WHERE orders_id = ' . $oID))) {
    return;
}

$messageStack->add_session(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
return $Admin->link('orders.php');

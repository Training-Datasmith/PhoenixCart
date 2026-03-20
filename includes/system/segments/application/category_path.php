<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
if (isset($_GET['products_id'])) {
    $product = product_by_id::build((int) $_GET['products_id']);
}
// calculate category path
if (isset($_GET['cPath'])) {
    $c_path_array = Guarantor::ensure_global('category_tree')->parse_path($_GET['cPath']);
    $current_category_id = end($c_path_array);
} elseif (isset($_GET['manufacturers_id'])) {
    $brand = new manufacturer((int) $_GET['manufacturers_id']);
} elseif (isset($product) && $product->get('status')) {
    $current_category_id = $product->get('categories')[0] ?? 0;
    $c_path_array = array_reverse(Guarantor::ensure_global('category_tree')->get_ancestors($current_category_id));
    $c_path_array[] = $current_category_id;
}
if (!isset($current_category_id)) {
    $current_category_id = 0;
}
$c_path = isset($c_path_array) ? implode('_', $c_path_array) : '';
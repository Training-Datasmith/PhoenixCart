<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
$page_content = $Template->get_content('shopping_cart');
$breadcrumb->add(NAVBAR_TITLE, $Linker->build('shopping_cart.php'));
require $Template->map('template_top.php', 'component');
if ($message_stack->size('product_action') > 0) {
    echo $message_stack->output('product_action');
}
?>

<div class="row">
  <?php 
echo $page_content;
?>
</div>

<?php 
require $Template->map('template_bottom.php', 'component');
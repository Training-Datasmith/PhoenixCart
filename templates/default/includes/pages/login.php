<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
$breadcrumb->add(NAVBAR_TITLE, $Linker->build('login.php'));
require $Template->map('template_top.php', 'component');
if ($message_stack->size('login') > 0) {
    echo $message_stack->output('login');
}
?>

  <div class="row">
    <?php 
echo $page_content;
?>
  </div>

<?php 
require $Template->map('template_bottom.php', 'component');
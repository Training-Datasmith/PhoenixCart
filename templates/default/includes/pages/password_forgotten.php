<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
$breadcrumb->add(NAVBAR_TITLE_1, $Linker->build('login.php'));
$breadcrumb->add(NAVBAR_TITLE_2, $Linker->build('password_forgotten.php'));
require $Template->map('template_top.php', 'component');
?>

<div class="row">

  <div class="col-sm-6 offset-sm-3">

<?php 
if ($message_stack->size('password_forgotten') > 0) {
    echo $message_stack->output('password_forgotten');
}
if ($password_reset_initiated == true) {
    ?>

  <div class="alert alert-success" role="alert"><?php 
    echo TEXT_PASSWORD_RESET_INITIATED;
    ?></div>

<?php 
} else {
    ?>

<?php 
    echo new Form('password_forgotten', $Linker->build('password_forgotten.php', ['action' => 'process']), 'post', ['class' => 'was-validated'], true);
    ?>

  <div class="alert alert-warning" role="alert"><?php 
    echo TEXT_MAIN;
    ?></div>

  <?php 
    $customer_data->display_input(['email_address']);
    ?>

  <div class="d-grid">
    <?php 
    echo new Button(IMAGE_BUTTON_RESET_PASSWORD, 'fas fa-user-cog', 'btn-warning');
    ?>
  </div>
  
  <div class="my-2">
    <?php 
    echo new Button(IMAGE_BUTTON_BACK, 'fas fa-angle-left', 'btn-light', [], $Linker->build('login.php'));
    ?>
  </div>
  
</form>

<?php 
}
?>
  
  </div>
  
</div>

<?php 
require $Template->map('template_bottom.php', 'component');
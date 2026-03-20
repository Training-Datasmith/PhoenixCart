<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
$breadcrumb->add(NAVBAR_TITLE_1, $Linker->build('login.php'));
$breadcrumb->add(NAVBAR_TITLE_2);
require $Template->map('template_top.php', 'component');
?>

<h1 class="display-4 mb-4"><?php 
echo HEADING_TITLE;
?></h1>
<?php 
if ($message_stack->size('password_reset') > 0) {
    echo $message_stack->output('password_reset');
}
echo new Form('password_reset', $Linker->build('password_reset.php', ['account' => $email_address, 'key' => $password_key, 'action' => 'process']), 'post', ['class' => 'was-validated'], true);
?>

  <div class="alert alert-info" role="alert"><?php 
echo TEXT_MAIN;
?></div>

  <?php 
$customer_data->display_input($page_fields);
echo $hooks->cat('injectFormDisplay');
?>

  <div class="d-grid">
    <?php 
echo new Button(IMAGE_BUTTON_CONTINUE, 'fas fa-angle-right', 'btn-success btn-lg');
?>
  </div>

</form>

<?php 
require $Template->map('template_bottom.php', 'component');
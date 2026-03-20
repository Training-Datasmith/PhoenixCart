<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
$Template->build_blocks();
$hooks->cat('injectRedirects');
$tpl_template = $Template->get_template();
if (!$Template->has_blocks('boxes_column_left')) {
    $tpl_template->set_grid_content_width($tpl_template->get_grid_content_width() + $tpl_template->get_grid_column_width());
}
if (!$Template->has_blocks('boxes_column_right')) {
    $tpl_template->set_grid_content_width($tpl_template->get_grid_content_width() + $tpl_template->get_grid_column_width());
}
?>
<!DOCTYPE html>
<html<?php 
echo HTML_PARAMS;
?>>
<head>
<meta charset="<?php 
echo CHARSET;
?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="generator" content="CE Phoenix Cart">
<title><?php 
echo htmlspecialchars((string) $Template->get_title());
?></title>
<base href="<?php 
echo HTTP_SERVER . DIR_WS_CATALOG;
?>">

<?php 
echo $hooks->cat('injectSiteStart'), $Template->get_blocks('header_tags');
?>
</head>
<body>

  <?php 
echo $hooks->cat('injectBodyStart'), $Template->get_content('navigation'), $hooks->cat('injectBeforeHeader');
?>
    
  <div class="header bg-body-tertiary border-bottom">
    <div class="<?php 
echo BOOTSTRAP_CONTAINER;
?>">
      <?php 
require $Template->map('header.php', 'component');
?>
    </div>
  </div>
    
  <?php 
echo $hooks->cat('injectAfterHeader');
?>

  <div id="bodyWrapper" class="<?php 
echo BOOTSTRAP_CONTAINER;
?>">

    <?php 
echo $hooks->cat('injectBodyWrapperStart');
?>

    <div class="row">
      <div id="bodyContent" class="col order-1 order-md-2 mb-2 mb-md-0">

        <?php 
echo $hooks->cat('injectBodyContentStart');
?>
        
        <main>

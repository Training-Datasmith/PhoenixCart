<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
?>

        </main>
      
      <?php 
echo $hooks->cat('injectBodyContentEnd');
?>

      </div> <!-- bodyContent //-->

<?php 
if ($Template->has_blocks('boxes_column_left') && $tpl_template->get_grid_column_width() > 0) {
    ?>

      <div id="columnLeft" class="col-md-<?php 
    echo $tpl_template->get_grid_column_width();
    ?> order-2 order-md-1">
        <?php 
    echo $Template->get_blocks('boxes_column_left');
    ?>
      </div>

<?php 
}
if ($Template->has_blocks('boxes_column_right') && $tpl_template->get_grid_column_width() > 0) {
    ?>

      <div id="columnRight" class="col-md-<?php 
    echo $tpl_template->get_grid_column_width();
    ?> order-last">
        <?php 
    echo $Template->get_blocks('boxes_column_right');
    ?>
      </div>

<?php 
}
?>

    </div> <!-- row -->

    <?php 
echo $hooks->cat('injectBodyWrapperEnd');
?>

  </div> <!-- bodyWrapper //-->

  <?php 
echo $hooks->cat('injectBeforeFooter');
require $Template->map('footer.php', 'component');
echo $hooks->cat('injectAfterFooter');
echo $hooks->cat('injectSiteEnd');
echo $Template->get_blocks('footer_scripts');
echo $hooks->cat('injectBodyEnd');
?>

</body>
</html>

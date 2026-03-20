<?php

/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
$breadcrumb->add(NAVBAR_TITLE_1, $Linker->build('advanced_search.php'));
require $Template->map('template_top.php', 'component');
?>

<h1 class="display-4 mb-4"><?php 
echo HEADING_TITLE_1;
?></h1>

<?php 
if ($message_stack->size('search') > 0) {
    echo $message_stack->output('search');
}
?>

<?php 
echo (new Form('advanced_search', $Linker->build('advanced_search_result.php', [], false), 'get', ['class' => 'was-validated']))->hide_session_id()->hide('search_in_description', '1');
?>

  <div class="form-floating mb-2">
    <?php 
echo (new Input('keywords', ['id' => 'inputKeywords', 'placeholder' => TEXT_SEARCH_PLACEHOLDER], 'search'))->require(), FORM_REQUIRED_INPUT;
?>
    <label for="inputKeywords"><?php 
echo HEADING_SEARCH_CRITERIA;
?></label>
  </div>

  <div class="d-grid">
    <?php 
echo new Button(IMAGE_BUTTON_SEARCH, 'fas fa-search', 'btn-success btn-lg');
?>
  </div>
  
  <p class="mt-1"><a data-bs-toggle="modal" href="#helpSearch" class="btn btn-light"><?php 
echo TEXT_SEARCH_HELP_LINK;
?></a></p>

  <?php 
$modal = ['name' => 'helpSearch', 'title' => HEADING_SEARCH_HELP, 'text' => TEXT_SEARCH_HELP, 'close_button' => IMAGE_BUTTON_CLOSE, 'size' => 'modal-md', 'show_footer' => false];
ob_start();
include Guarantor::ensure_global('Template')->map('modal.php', 'component');
?>

  <hr>

  <div class="row mb-2">
    <div class="col">
      <div class="form-floating">
        <?php 
echo new Select('categories_id', Guarantor::ensure_global('category_tree')->get_selections([['id' => '', 'text' => TEXT_ALL_CATEGORIES]]), ['id' => 'entryCategories']);
?>
        <label for="entryCategories"><?php 
echo ENTRY_CATEGORIES;
?></label>
      </div>

      <div class="form-check-inline mt-2">
        <?php 
echo (new Tickable('inc_subcat', ['value' => '1', 'id' => 'entryIncludeSubs', 'class' => 'form-check-input'], 'checkbox'))->tick();
?>
        <label for="entryIncludeSubs" class="form-check-label"><?php 
echo ENTRY_INCLUDE_SUBCATEGORIES;
?></label>
      </div>
    </div>
    <div class="col">
      <div class="form-floating">
        <?php 
echo new Select('manufacturers_id', array_merge([['id' => '', 'text' => TEXT_ALL_MANUFACTURERS]], $db->fetch_all('SELECT manufacturers_id AS id, manufacturers_name AS text FROM manufacturers ORDER BY manufacturers_name')), ['id' => 'entryManufacturers']);
?>
        <label for="entryManufacturers"><?php 
echo ENTRY_MANUFACTURERS;
?></label>
      </div>
    </div>
  </div>
  
  <hr>
  
  <div class="row mb-2">
    <div class="col">
      <div class="form-floating">
        <?php 
echo new Input('pfrom', ['id' => 'PriceFrom', 'placeholder' => ENTRY_PRICE_FROM_TEXT]);
?>
        <label for="PriceTo"><?php 
echo ENTRY_PRICE_FROM_TEXT;
?></label>
      </div>
    </div>
    <div class="col">
      <div class="form-floating">
         <?php 
echo new Input('pto', ['id' => 'PriceTo', 'placeholder' => ENTRY_PRICE_TO_TEXT]);
?>
        <label for="PriceTo"><?php 
echo ENTRY_PRICE_TO_TEXT;
?></label>
      </div>
    </div>
  </div>

</form>

<?php 
require $Template->map('template_bottom.php', 'component');
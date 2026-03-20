<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class page_selection
{
    public static function _get_pages($p = ''): array
    {
        return array_filter(array_map(trim(...), explode(';', (string) $p)));
    }
    public static function _show_pages($text)
    {
        return abstract_module::list_exploded($text);
    }
    public static function _edit_pages($values, $key): string
    {
        $files = [];
        // main files
        foreach (new Directory_Iterator(DIR_FS_CATALOG) as $file) {
            if ($file->is_file() && $file->get_extension() === 'php') {
                $files[] = $file->get_filename();
            }
        }
        // ext files
        $dir = new Recursive_Directory_Iterator(DIR_FS_CATALOG . 'ext/modules/content/');
        $iterator = new Recursive_Iterator_Iterator($dir);
        foreach ($iterator as $file) {
            if ($file->is_file() && $file->get_extension() === 'php') {
                $files[] = $file->get_filename();
            }
        }
        $files = array_unique($files);
        sort($files);
        $output = Config::select_multiple($files, $values, $key);
        $checkbox = new Tickable('p_all', ['id' => 'p_all', 'class' => 'form-check-input'], 'checkbox');
        $text_all = TEXT_ALL;
        $output .= <<<EOT
        <hr>
        <div class="form-check">
          {$checkbox}
          <label class="form-check-label" for="p_all">
            {$text_all}
          </label>
        </div>
        EOT;
        $key_name = Config::name($key) . '[]';
        return $output . <<<EOSCRIPT
        <script>
        document.querySelector('input[name="p_all"]').addEventListener('click', function() {
          const isChecked = this.checked;
          const checkboxes = document.querySelectorAll('input[name="{$key_name}"]');
        
          checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
          });
        });
        document.querySelectorAll('input[name="{$key_name}"]').forEach(function(checkbox) {
          checkbox.addEventListener('click', function() {
            if (!this.checked) {
              document.querySelector('input[name="p_all"]').checked = false;
            }
          });
        });
        </script>
        EOSCRIPT;
    }
}
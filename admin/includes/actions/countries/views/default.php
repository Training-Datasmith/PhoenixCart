<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/

$keywords = null;
$search_sql = '';
if (!Text::is_empty($_GET['search'] ?? '')) {
    $keywords = Text::input($_GET['search']);

    $search_sql = "WHERE countries_iso_code_2 = '" . $keywords . "' OR countries_iso_code_3 = '" . $keywords . "' OR countries_name LIKE '%" . $keywords. "%'";

    $admin_hooks->set('countriesListButtons', 'reset_keywords', fn () => $GLOBALS['Admin']->button(IMAGE_RESET, 'fas fa-angle-left', 'btn-light', $GLOBALS['Admin']->link('countries.php')));
}

$countries_sql = "SELECT * FROM countries $search_sql ORDER BY countries_name";

$table_definition = [
  'columns' => [
    [
      'name' => TABLE_HEADING_COUNTRY_NAME,
      'is_heading' => true,
      'function' => fn ($row) => $row['countries_name'],
    ],
    [
      'name' => TABLE_HEADING_COUNTRY_CODES,
      'function' => fn ($row) => implode(', ', [$row['countries_iso_code_2'], $row['countries_iso_code_3']]),
    ],
    [
      'name' => TABLE_HEADING_STATUS,
      'class' => 'text-end',
      'function' => function (array &$row): string {
          $href = (clone $row['onclick'])->set_parameter('action', 'set_flag');
          return ($row['status'] == '1')
               ? '<i class="fas fa-check-circle text-success"></i> <a href="' . $href->set_parameter('flag', '0')  . '"><i class="fas fa-times-circle text-muted"></i></a>'
               : '<a href="' . $href->set_parameter('flag', '1') . '"><i class="fas fa-check-circle text-muted"></i></a> <i class="fas fa-times-circle text-danger"></i>';
      },
    ],
    [
      'name' => TABLE_HEADING_ACTION,
      'class' => 'text-end',
      'function' => fn ($row) => (isset($row['info']->countries_id))
            ? '<i class="fas fa-chevron-circle-right text-info"></i>'
            : '<a href="' . $row['onclick'] . '"><i class="fas fa-info-circle text-muted"></i></a>',
      ],
  ],
  'count_text' => TEXT_DISPLAY_NUMBER_OF_COUNTRIES,
  'hooks' => [
      'button' => 'countriesListButtons',
    ],
  'page' => $_GET['page'] ?? null,
  'web_id' => 'cID',
  'sql' => $countries_sql,
];

$table_definition['split'] = new Paginator($table_definition);
$link = $Admin->link()->retain_query_except(['action']);
$table_definition['function'] = function (array &$row) use ($link, $action, &$table_definition): void {
    $link->set_parameter('cID', $row['countries_id']);
    if (!isset($table_definition['info']) && (!isset($_GET['cID']) || ($_GET['cID'] == $row['countries_id'])) && (!str_starts_with((string) $action, 'new'))) {
        $table_definition['info'] = new objectInfo($row);
        $row['info'] = &$table_definition['info'];

        $row['onclick'] = (clone $link)->set_parameter('action', 'edit');
        $row['css'] = ' class="table-active"';
        $row['info']->link = $link;
    } else {
        $row['onclick'] = $link;
        $row['css'] = '';
    }
};

$table_definition['split']->display_table();

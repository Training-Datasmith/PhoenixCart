<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/

class ht_outgoing extends abstract_executable_module
{
    public const CONFIG_KEY_BASE = 'MODULE_HEADER_TAGS_O_';

    public function __construct()
    {
        parent::__construct(__FILE__);

        $display_pages = Outgoing::show_pages();
        Outgoing::merge_tags();

        $display_page_msg = MODULE_HEADER_TAGS_O_PAGES;
        foreach ($display_pages as $p) {
            $display_page_msg .= sprintf(MODULE_HEADER_TAGS_O_PAGES_LIVE, $p);
        }

        $this->description .= '<div class="alert alert-danger">' . $display_page_msg . '</div>';
    }

    public function execute(): void
    {
        global $display_pages, $merge_tags;

        // clean queue
        if (in_array(basename((string) Request::get_page()), $display_pages)) {
            Outgoing::delete();
            Outgoing::parse();
        }
    }

    protected function get_parameters(): array
    {
        return [
          $this->config_key_base . 'STATUS' => [
            'title' => 'Enable Queued E-mail Module',
            'value' => 'True',
            'desc' => 'Do you want to enable the this module?',
            'set_func' => "Config::select_one(['True', 'False'], ",
          ],
          $this->config_key_base . 'SORT_ORDER' => [
            'title' => 'Sort Order',
            'value' => '0',
            'desc' => 'Sort order of display. Lowest is displayed first.',
          ],
        ];
    }

}

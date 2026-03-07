<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class order_total
{
    public $modules;

    // class constructor
    public function __construct()
    {
        if (defined('MODULE_ORDER_TOTAL_INSTALLED') && !Text::is_empty(MODULE_ORDER_TOTAL_INSTALLED)) {
            $this->modules = explode(';', (string) MODULE_ORDER_TOTAL_INSTALLED);

            foreach ($this->modules as $value) {
                $class = pathinfo($value, PATHINFO_FILENAME);
                $GLOBALS[$class] = new $class();
            }
        }
    }

    public function process(): array
    {
        $order_total_array = [];
        if (is_array($this->modules)) {
            foreach ($this->modules as $value) {
                $class = pathinfo((string) $value, PATHINFO_FILENAME);
                if ($GLOBALS[$class]->enabled) {
                    $GLOBALS[$class]->output = [];
                    $GLOBALS[$class]->process();

                    foreach ($GLOBALS[$class]->output as $output) {
                        if (!Text::is_empty($output['title']) && !Text::is_empty($output['text'])) {
                            $order_total_array[] = [
                              'code' => $GLOBALS[$class]->code,
                              'title' => $output['title'],
                              'text' => $output['text'],
                              'value' => $output['value'],
                              'sort_order' => $GLOBALS[$class]->sort_order,
                            ];
                        }
                    }
                }
            }
        }

        return $order_total_array;
    }

    public function output(): string
    {
        $output_string = '';
        if (is_array($this->modules)) {
            foreach ($this->modules as $value) {
                $class = pathinfo((string) $value, PATHINFO_FILENAME);
                if ($GLOBALS[$class]->enabled) {
                    foreach ($GLOBALS[$class]->output as $output) {
                        include Guarantor::ensure_global('Template')->map('order_total.php', 'component');
                    }
                }
            }
        }

        return $output_string;
    }
}

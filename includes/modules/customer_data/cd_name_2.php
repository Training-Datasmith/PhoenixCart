<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cd_name_2 extends abstract_module
{
    public const CONFIG_KEY_BASE = 'MODULE_CUSTOMER_DATA_NAME_2_';

    public const PROVIDES = [ 'name' ];
    public const REQUIRES = [ 'firstname', 'lastname' ];

    protected function get_parameters(): array
    {
        return [
          static::CONFIG_KEY_BASE . 'STATUS' => [
            'title' => 'Enable Two Part Name module',
            'value' => 'True',
            'desc' => 'Do you want to add the module to your shop?',
            'set_func' => "Config::select_one(['True', 'False'], ",
          ],
        ];
    }

    public function get($field, array &$customer_details)
    {
        switch ($field) {
            case 'name':
                if (!isset($customer_details[$field])) {
                    global $customer_data;
                    $customer_details[$field] = $customer_data->get('firstname', $customer_details)
                                              . ' ' . $customer_data->get('lastname', $customer_details);
                }

                return $customer_details[$field];
        }
    }

    public function build_db_values(&$db_tables, $customer_details, $table = 'both'): void
    {
        global $customer_data;

        foreach ([$customer_data->get_module('firstname'), $customer_data->get_module('lastname')] as $purveyor) {
            $purveyor->build_db_values($db_tables, $customer_details, $table);
        }
    }

    public function build_db_aliases(&$db_tables, $table = 'both'): void
    {
        global $customer_data;

        foreach ([$customer_data->get_module('firstname'), $customer_data->get_module('lastname')] as $purveyor) {
            $purveyor->build_db_aliases($db_tables, $table);
        }
    }

}

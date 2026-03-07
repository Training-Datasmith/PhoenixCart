<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cd_id extends abstract_module
{
    public const CONFIG_KEY_BASE = 'MODULE_CUSTOMER_DATA_ID_';

    public const PROVIDES = [ 'id' ];
    public const REQUIRES = [  ];
    public const OFFERS = [  ];

    protected function get_parameters(): array
    {
        return [
          static::CONFIG_KEY_BASE . 'STATUS' => [
            'title' => 'Enable Identifier module',
            'value' => 'True',
            'desc' => 'Do you want to add the module to your shop?',
            'set_func' => "Config::select_one(['True', 'False'], ",
          ],
        ];
    }

    public function get($field, array &$customer_details)
    {
        switch ($field) {
            case 'id':
                if (!isset($customer_details[$field])) {
                    $customer_details[$field] = $customer_details['id']
                      ?? $customer_details['customers_id']
                      ?? $customer_details['customers_info_id']
                      ?? $customer_details['customer_id'] ?? null;
                }

                return $customer_details[$field];
        }
    }

    public function build_db_values(array &$db_tables, $customer_details, $table = 'both'): void
    {
        if ('both' === $table) {
            $table = 'customers';
        }

        Guarantor::guarantee_subarray($db_tables, $table);
        $db_tables[$table]['customers_id'] = $this->get('id', $customer_details);
    }

    public function build_db_aliases(array &$db_tables, $table = 'both'): void
    {
        if ('both' === $table) {
            $table = 'customers';
        }

        Guarantor::guarantee_subarray($db_tables, $table);
        $db_tables[$table]['customers_id'] = 'id';
    }

    public function add_order_by(array &$columns, $criterion, $direction): void
    {
        Guarantor::guarantee_subarray($columns, 'customers');
        $columns['customers']['customers_id'] = $direction;
    }

}

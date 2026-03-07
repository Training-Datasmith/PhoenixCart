<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class cd_address_book_id extends abstract_module
{
    public const CONFIG_KEY_BASE = 'MODULE_CUSTOMER_DATA_ADDRESS_BOOK_ID_';

    public const PROVIDES = [ 'address_book_id' ];
    public const REQUIRES = [  ];

    protected function get_parameters(): array
    {
        return [
          static::CONFIG_KEY_BASE . 'STATUS' => [
            'title' => 'Enable Address Book ID module',
            'value' => 'True',
            'desc' => 'Do you want to add the module to your shop?',
            'set_func' => "Config::select_one(['True', 'False'], ",
          ],
        ];
    }

    public function get($field, array &$customer_details)
    {
        switch ($field) {
            case 'address_book_id':
                return ($customer_details[$field] ?? null);
        }
    }

    public function build_db_values(array &$db_tables, array $customer_details, $table = 'both'): void
    {
        Guarantor::guarantee_subarray($db_tables, 'address_book');
        $db_tables['address_book']['address_book_id'] = $customer_details['address_book_id'];
    }

    public function build_db_aliases(array &$db_tables, $table = 'both'): void
    {
        Guarantor::guarantee_subarray($db_tables, 'address_book');
        $db_tables['address_book']['address_book_id'] = null;
    }

}

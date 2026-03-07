<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2025 Phoenix Cart

  Released under the GNU General Public License
*/

abstract class searcher
{
    public function __construct(protected $db_tables, protected $criteria)
    {
    }

    public function add_db_table($table, $columns): void
    {
        $this->db_tables[$table] = $columns;
    }

    public function add_column($table, $column): void
    {
        $this->db_tables[$table][] = $column;
    }

    public function add_criterion($column, $value): void
    {
        $this->criteria[$column] = $value;
    }

}

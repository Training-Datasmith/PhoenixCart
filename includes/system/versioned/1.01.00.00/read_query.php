<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2025 Phoenix Cart

  Released under the GNU General Public License
*/

abstract class read_query extends query
{
    abstract public static function build_joins($db_tables, $criteria);

    public static function build_read($db_tables, $criteria, array $chain = [])
    {
        foreach ($db_tables as $db_table => &$columns) {
            $primary_key = static::determine_id($db_table);
            if (($primary_key === "{$db_table}_id") && !array_key_exists($primary_key, $columns)) {
                $columns[$primary_key] = null;
            }
        }
        unset($columns);

        $sql = 'SELECT ' . static::_build_columns($db_tables, $chain) . ($chain['custom']['select'] ?? '');
        $sql .= ' FROM' . static::build_joins($db_tables, $criteria) . ($chain['custom']['from'] ?? '');

        return $sql . (static::build_where($criteria) . ($chain['custom']['where'] ?? '') . ($chain['custom']['group'] ?? ''));
    }

    public static function count_by_criteria($criteria, array $chain = [])
    {
        $sql = 'SELECT COUNT(*) AS total FROM';
        $sql .= static::build_joins($criteria, $criteria) . ($chain['custom']['from'] ?? '');
        $sql .= static::build_where($criteria) . ($chain['custom']['where'] ?? '') . ($chain['custom']['group'] ?? '');

        $query = $GLOBALS['db']->query($sql);
        $result = $query->fetch_assoc();

        return $result['total'] ?? null;
    }

}

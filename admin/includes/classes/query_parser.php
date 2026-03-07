<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class query_parser
{
    protected $to;
    protected $from;
    protected int $where_position;

    public function __construct(protected $sql_query)
    {
        $this->to = strlen((string) $this->sql_query);
        $this->from = stripos((string) $this->sql_query, ' FROM');
        $this->where_position = strripos(substr((string) $this->sql_query, $this->from), ' WHERE') ?: 0;
        $this->where_position += $this->from;

        foreach ([' GROUP BY', ' HAVING', ' ORDER BY'] as $needle) {
            $this->lower_end($needle);
        }
    }

    protected function lower_end($needle)
    {
        $position = strripos((string) $this->sql_query, (string) $needle);
        if ($position && ($position > $this->where_position) && ($position < $this->to)) {
            $this->to = $position;
        }
    }

    public function count()
    {
        $count_query = $GLOBALS['db']->query('SELECT COUNT(*) AS total '
          . substr((string) $this->sql_query, $this->from, ($this->to - $this->from)));
        return $count_query->fetch_assoc()['total'];
    }

}

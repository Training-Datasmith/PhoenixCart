<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2025 Phoenix Cart

  Released under the GNU General Public License
*/
class importer
{
    public $_data = [];
    public function __construct($i_id)
    {
        $this->build_importer($i_id);
    }
    public function build_importer($i_id): void
    {
        $importer_query = $GLOBALS['db']->query('select i.*, ii.* from importers i, importers_info ii where i.importers_id = ' . (int) $i_id . ' and i.importers_id = ii.importers_id and ii.languages_id = ' . (int) $_SESSION['languages_id']);
        if (mysqli_num_rows($importer_query) === 1) {
            $this->_data = $importer_query->fetch_assoc();
        } else {
            error_log("No unique importer for [{$i_id}:{$_SESSION['languages_id']}]");
        }
    }
    public function get_data($key)
    {
        return $this->_data[$key];
    }
    public function show_image(): \Image
    {
        return new Image('images/' . $this->_data['importers_image'], [], $this->_data['importers_name']);
    }
    public function build_importer_array()
    {
        return $this->_data;
    }
}
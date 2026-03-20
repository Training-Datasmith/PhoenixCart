<?php

declare (strict_types=1);
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2018 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class manufacturer
{
    public $_data = [];
    public function __construct($m_id)
    {
        $this->build_manufacturer($m_id);
    }
    public function build_manufacturer($m_id): void
    {
        $manufacturer_query = $GLOBALS['db']->query('select m.*, mi.* from manufacturers m, manufacturers_info mi where m.manufacturers_id = ' . (int) $m_id . ' and m.manufacturers_id = mi.manufacturers_id and mi.languages_id = ' . (int) $_SESSION['languages_id']);
        if (mysqli_num_rows($manufacturer_query) === 1) {
            $this->_data = $manufacturer_query->fetch_assoc();
        } else {
            error_log("No unique manufacturer for [{$m_id}:{$_SESSION['languages_id']}]");
        }
    }
    public function get_data($key)
    {
        return $this->_data[$key];
    }
    public function show_image(): \Image
    {
        return new Image('images/' . $this->_data['manufacturers_image'], [], $this->_data['manufacturers_name']);
    }
    public function build_manufacturer_array()
    {
        return $this->_data;
    }
}
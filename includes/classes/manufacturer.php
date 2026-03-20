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
    /** @var array<string, mixed>  All columns from manufacturers + manufacturers_info for the loaded manufacturer. */
    public $_data = [];

    /**
     * Loads manufacturer data for the given ID in the current session language.
     *
     * @param  int  $m_id  The manufacturers_id to load.
     * @since  1.0.0
     */
    public function __construct(int $m_id)
    {
        $this->build_manufacturer($m_id);
    }

    /**
     * Queries manufacturers and manufacturers_info and populates $_data.
     *
     * Logs an error if the manufacturer ID does not exist or is not unique for
     * the current session language.
     *
     * @param  int  $m_id  The manufacturers_id to query.
     * @return void
     * @since  1.0.0
     */
    public function build_manufacturer(int $m_id): void
    {
        $manufacturer_query = $GLOBALS['db']->query('select m.*, mi.* from manufacturers m, manufacturers_info mi where m.manufacturers_id = ' . (int) $m_id . ' and m.manufacturers_id = mi.manufacturers_id and mi.languages_id = ' . (int) $_SESSION['languages_id']);
        if (mysqli_num_rows($manufacturer_query) === 1) {
            $this->_data = $manufacturer_query->fetch_assoc();
        } else {
            error_log("No unique manufacturer for [{$m_id}:{$_SESSION['languages_id']}]");
        }
    }

    /**
     * Returns a single field value from the loaded manufacturer data.
     *
     * @param  string  $key  Column name (e.g. 'manufacturers_name', 'manufacturers_image').
     * @return mixed         The column value, or null if the key does not exist.
     * @since  1.0.0
     */
    public function get_data(string $key): mixed
    {
        return $this->_data[$key] ?? null;
    }

    /**
     * Builds and returns an Image object for the manufacturer's logo.
     *
     * @return \Image  An Image instance pointing to the manufacturer's image file.
     * @since  1.0.0
     */
    public function show_image(): \Image
    {
        return new Image('images/' . $this->_data['manufacturers_image'], [], $this->_data['manufacturers_name']);
    }

    /**
     * Returns the full manufacturer data array.
     *
     * @return array<string, mixed>  All manufacturer and manufacturer_info columns.
     * @since  1.0.0
     */
    public function build_manufacturer_array(): array
    {
        return $this->_data;
    }
}
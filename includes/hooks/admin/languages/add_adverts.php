<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class hook_admin_languages_add_adverts
{
    public function listen_insert_action(): void
    {
        global $l_id;
        $GLOBALS['db']->query('INSERT INTO advert_info (advert_id, languages_id) SELECT advert_id, ' . (int) $l_id . ' FROM advert_info WHERE languages_id = ' . (int) $_SESSION['languages_id']);
    }
    public function listen_delete_confirm_action(): void
    {
        global $l_id;
        $GLOBALS['db']->query('DELETE FROM advert_info WHERE languages_id = ' . (int) $l_id);
    }
}
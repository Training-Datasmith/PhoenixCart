<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_shop_site_Wide_gdpr_Data
{
    public function listen_post_registration(): void
    {
        self::store_matc('create_account.php');
    }
    public function listen_inject_form_verify(): void
    {
        if ('create_account.php' !== Request::get_page()) {
            self::store_matc(Request::get_page());
        }
    }
    public function listen_insert_order(): void
    {
        self::store_matc('checkout_confirmation.php');
    }
    private function store_matc(string $page): void
    {
        $agreed = isset($_POST['matc']) ? Text::input($_POST['matc']) : false;
        if ('1' === $agreed) {
            $agreed_pages = ['privacy', 'conditions'];
            foreach ($agreed_pages as $v) {
                $info_page = info_pages::get_page(['pd.languages_id' => $_SESSION['languages_id'], 'p.slug' => $v]);
                $info_page = array_filter($info_page);
                $sql_data = ['customers_id' => (int) $_SESSION['customer_id'], 'slug' => Text::input($v), 'page' => Text::prepare($page), 'pages_text' => Text::prepare($info_page['pages_text']), 'pages_title' => Text::prepare($info_page['pages_title']), 'timestamp' => Text::input($info_page['last_modified'] ?? $info_page['date_added']), 'language' => Text::input($_SESSION['language']), 'date_added' => 'NOW()'];
                $GLOBALS['db']->perform('customers_gdpr', $sql_data);
            }
        }
    }
}
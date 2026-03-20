<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Application
{
    /**
     * Verifies that the SSL session ID matches, if the feature is enabled.
     *
     * Delegates to Request::check_ssl_session_id() which terminates the session
     * on mismatch. Controlled by SESSION_CHECK_SSL_SESSION_ID constant.
     *
     * @return void
     * @since  1.0.0
     */
    public function check_ssl_session_id(): void
    {
        // verify the ssl_session_id if the feature is enabled
        if (SESSION_CHECK_SSL_SESSION_ID === 'True') {
            Request::check_ssl_session_id();
        }
    }

    /**
     * Verifies that the browser user agent matches the one recorded at session start.
     *
     * Delegates to Request::check_user_agent() which terminates the session on
     * mismatch. Controlled by SESSION_CHECK_USER_AGENT constant.
     *
     * @return void
     * @since  1.0.0
     */
    public function check_user_agent(): void
    {
        // verify the browser user agent if the feature is enabled
        if (SESSION_CHECK_USER_AGENT === 'True') {
            Request::check_user_agent();
        }
    }

    /**
     * Verifies that the client IP address matches the one recorded at session start.
     *
     * Delegates to Request::check_ip() which terminates the session on mismatch.
     * Controlled by SESSION_CHECK_IP_ADDRESS constant.
     *
     * @return void
     * @since  1.0.0
     */
    public function check_ip(): void
    {
        // verify the IP address if the feature is enabled
        if (SESSION_CHECK_IP_ADDRESS === 'True') {
            Request::check_ip();
        }
    }

    /**
     * Ensures a valid Shopping_Cart instance exists in the session.
     *
     * Creates a new Shopping_Cart if none is present or if the stored value is
     * no longer a Shopping_Cart instance (e.g. after session deserialization errors).
     *
     * @return void
     * @since  1.0.0
     */
    public function ensure_session_cart(): void
    {
        if (!isset($_SESSION['cart']) || !$_SESSION['cart'] instanceof Shopping_Cart) {
            $_SESSION['cart'] = new Shopping_Cart();
        }
    }

    /**
     * Resets LC_NUMERIC to the system locale to prevent decimal separator issues.
     *
     * PHP's LC_ALL can set LC_NUMERIC to a locale that uses a comma as the decimal
     * separator (e.g. de_DE), which breaks float arithmetic. This method pins
     * LC_NUMERIC back to the system default on every call.
     *
     * @return void
     * @see    https://bugs.php.net/bug.php?id=634
     * @since  1.0.0
     */
    public function fix_numeric_locale(): void
    {
        static $_system_locale_numeric = 0;
        // Prevent LC_ALL from setting LC_NUMERIC to a locale with 1,0 float/decimal values instead of 1.0 (see bug #634)
        $_system_locale_numeric = setlocale(LC_NUMERIC, $_system_locale_numeric);
    }

    /**
     * Initialises the session language and returns the translation file suffix.
     *
     * Builds the language object if no language is set in the session or if the
     * visitor is switching language via the `language` query parameter. Also
     * ensures the Template global is available and registers the class translator.
     *
     * @return string  The translation file extension (e.g. '.php').
     * @since  1.0.0
     */
    public function set_session_language(): string
    {
        if (empty($_SESSION['language']) || isset($_GET['language'])) {
            $GLOBALS['lng'] = language::build();
            $GLOBALS['languages_id'] =& $_SESSION['languages_id'];
            $GLOBALS['language'] =& $_SESSION['language'];
        }
        class_exists('Text');
        Guarantor::ensure_global('Template');
        $GLOBALS['class_index']->set_translator('language::map_to_translation');
        $this->fix_numeric_locale();
        return language::map_to_translation('.php');
    }

    /**
     * Sets the page title on the Template global to the site TITLE constant.
     *
     * @return void
     * @since  1.0.0
     */
    public function set_template_title(): void
    {
        Guarantor::ensure_global('Template')->set_title(TITLE);
    }

    /**
     * Ensures a Navigation_History instance exists in the session and records the current page.
     *
     * Creates a new Navigation_History if none is present, then calls
     * add_current_page() to append the current URL to the back-navigation stack.
     *
     * @return void
     * @since  1.0.0
     */
    public function ensure_navigation_history(): void
    {
        if (!isset($_SESSION['navigation']) || !$_SESSION['navigation'] instanceof Navigation_History) {
            $_SESSION['navigation'] = new Navigation_History();
            $GLOBALS['navigation'] =& $_SESSION['navigation'];
        }
        $_SESSION['navigation']->add_current_page();
    }

    /**
     * Creates a customer object in globals if a customer session is active.
     *
     * If $_SESSION['customer_id'] is set (i.e. the visitor is logged in), a new
     * customer instance is loaded from the database and stored as $GLOBALS['customer'].
     *
     * @return void
     * @since  1.0.0
     */
    public function set_customer_if_identified(): void
    {
        if (isset($_SESSION['customer_id'])) {
            $GLOBALS['customer'] = new customer($_SESSION['customer_id']);
        }
    }
}
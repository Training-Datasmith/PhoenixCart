<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Session
{
    protected static $started = false;

    public static function clear_cookie($name): void
    {
        $session_data = session_get_cookie_params();

        setcookie($name, '', ['expires' => time() - 42000, 'path' => $session_data['path'], 'domain' => $session_data['domain']]);
        unset($_COOKIE[$name]);
    }

    public static function start()
    {
        $sane_session_id = true;

        if (isset($_GET[session_name()])) {
            if ((SESSION_FORCE_COOKIE_USE === 'True') || (!preg_match('{^[a-zA-Z0-9,-]+$}', (string) $_GET[session_name()]))) {
                unset($_GET[session_name()]);

                $sane_session_id = false;
            }
        }

        if (isset($_POST[session_name()])) {
            if ((SESSION_FORCE_COOKIE_USE === 'True') || (!preg_match('{^[a-zA-Z0-9,-]+$}', (string) $_POST[session_name()]))) {
                unset($_POST[session_name()]);

                $sane_session_id = false;
            }
        }

        if (isset($_COOKIE[session_name()])) {
            if (!preg_match('{^[a-zA-Z0-9,-]+$}', (string) $_COOKIE[session_name()])) {
                static::clear_cookie(session_name());

                $sane_session_id = false;
            }
        }

        if (!$sane_session_id) {
            Href::redirect(Guarantor::ensure_global('Linker')->build('index.php')->set_include_session(false));
        }

        static::$started = session_start();
        return static::$started;
    }

    public static function destroy(): bool
    {
        if (isset($_COOKIE[session_name()])) {
            static::clear_cookie(session_name());
        }

        static::$started = false;

        return session_destroy();
    }

    public static function is_started()
    {
        return static::$started;
    }

    public static function recreate(): void
    {
        $old_id = session_id();

        session_regenerate_id(true);

        if (!empty($GLOBALS['SID'])) {
            $GLOBALS['SID'] = session_name() . '=' . session_id();
        }

        whos_online::update_session_id($old_id, session_id());
    }

    public static function request_id(): void
    {
        $session_name = session_name();
        $cookie_id = $_COOKIE[$session_name] ?? null;
        if (isset($_GET[$session_name]) && !Text::is_empty($_GET[$session_name]) && ($cookie_id !== $_GET[$session_name])) {
            session_id($_GET[$session_name]);
        } elseif (isset($_POST[$session_name]) && !Text::is_empty($_POST[$session_name]) && ($cookie_id !== $_POST[$session_name])) {
            session_id($_POST[$session_name]);
        }
    }

    public static function set_save_location(): void
    {
        if (defined('DIR_FS_SESSION') && DIR_FS_SESSION && is_dir(DIR_FS_SESSION) && is_writable(DIR_FS_SESSION)) {
            session_save_path(DIR_FS_SESSION);
        } else {
            // if we don't have a usable session directory defined, use MySQL sessions
            // Note:  this is the default configuration in the normal install process.
            session_set_save_handler(new mysql_session());
        }
    }

}

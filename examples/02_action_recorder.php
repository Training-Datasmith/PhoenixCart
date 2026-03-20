<?php

declare(strict_types=1);

/**
 * Example: Using Action_Recorder to throttle login attempts in CE Phoenix.
 *
 * Action_Recorder wraps pluggable "action recorder" modules that track user
 * actions (typically login attempts) and can deny further attempts after a
 * configurable threshold.
 *
 * In production this is invoked from the login page controller. The snippet
 * below shows the typical pattern.
 *
 * Prerequisites:
 *   - MODULE_ACTION_RECORDER_INSTALLED constant must be set (e.g. 'ar_login.php')
 *   - The ar_login class must exist and be loadable
 *   - $GLOBALS['db'] must be a live database connection
 */

// --- Setup (normally done by the Phoenix bootstrap) ---
// define('MODULE_ACTION_RECORDER_INSTALLED', 'ar_login.php');
// require_once __DIR__ . '/../includes/classes/action_recorder.php';

// 1. Create a recorder for the 'ar_login' module, passing the user's
//    email as the identifier and their customer ID if already known.
$recorder = new Action_Recorder(
    module:    'ar_login',
    user_id:   null,           // not yet authenticated
    user_name: 'user@example.com',
);

// 2. Check whether this user/IP is still allowed to attempt login
if (!$recorder->can_perform()) {
    // Too many failed attempts — block the login and show an error
    echo 'Too many failed login attempts. Please try again later.';
    exit;
}

// 3. ... perform authentication logic here ...
$loginSucceeded = false; // replace with real auth check

// 4. Record the outcome
$recorder->record($loginSucceeded);

// 5. Optionally clean up old records (usually called on a schedule)
$recorder->expire_entries();

<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Action_Recorder
{
    /** @var string|null  Name of the active action recorder module class. */
    public $_module;

    /** @var int|null  ID of the user performing the action. */
    public $_user_id;

    /** @var string|null  Display name of the user performing the action. */
    public $_user_name;

    /**
     * Initialises the action recorder for a specific module and user.
     *
     * Sanitises and validates the module name against the list of installed
     * action recorder modules. If the module is not installed or the class does
     * not exist, the recorder is silently disabled (all subsequent calls become
     * no-ops).
     *
     * @param  string      $module     Name of the action recorder module (e.g. 'ar_login').
     * @param  int|null    $user_id    Numeric ID of the user performing the action.
     * @param  string|null $user_name  Display name of the user performing the action.
     * @since  1.0.0
     */
    public function __construct(string $module, ?int $user_id = null, ?string $user_name = null)
    {
        $module = Text::sanitize(str_replace(' ', '', $module));
        if (!defined('MODULE_ACTION_RECORDER_INSTALLED') || Text::is_empty(MODULE_ACTION_RECORDER_INSTALLED) || Text::is_empty($module) || !in_array("{$module}.php", explode(';', (string) MODULE_ACTION_RECORDER_INSTALLED)) || !class_exists($module)) {
            return;
        }
        $this->_module = $module;
        if (!empty($user_id) && is_numeric($user_id)) {
            $this->_user_id = $user_id;
        }
        if (!empty($user_name)) {
            $this->_user_name = $user_name;
        }
        $GLOBALS[$this->_module] = new $module();
        $GLOBALS[$this->_module]->set_identifier();
    }

    /**
     * Determines whether the current user is permitted to perform the recorded action.
     *
     * Returns false if no module is active (i.e. the recorder was not initialised
     * with a valid, installed module).
     *
     * @return bool  True if the action is allowed, false otherwise.
     * @since  1.0.0
     */
    public function can_perform(): bool
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->can_perform($this->_user_id, $this->_user_name);
        }
        return false;
    }

    /**
     * Returns the human-readable title of the active recorder module.
     *
     * @return string|null  Module title, or null if no module is active.
     * @since  1.0.0
     */
    public function get_title(): ?string
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->title;
        }
        return null;
    }

    /**
     * Returns the identifier string used to de-duplicate action records.
     *
     * The identifier is typically derived from the user's IP address or login
     * attempt key, depending on the module implementation.
     *
     * @return string|null  Identifier string, or null if no module is active.
     * @since  1.0.0
     */
    public function get_identifier(): ?string
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->identifier;
        }
        return null;
    }

    /**
     * Writes an action record to the action_recorder database table.
     *
     * Records whether the action succeeded or failed, along with the user
     * identity and module-specific identifier. Does nothing if no module is active.
     *
     * @param  bool  $success  True for a successful action, false for a failed attempt.
     * @return void
     * @since  1.0.0
     */
    public function record(bool $success = true): void
    {
        if (!Text::is_empty($this->_module)) {
            $GLOBALS['db']->perform('action_recorder', ['module' => $this->_module, 'user_id' => (int) $this->_user_id, 'user_name' => $this->_user_name, 'identifier' => $this->get_identifier(), 'success' => $success ? 1 : 0, 'date_added' => 'NOW()']);
        }
    }

    /**
     * Triggers the module's cleanup logic to delete expired action records.
     *
     * Delegates to the module's own expire_entries() method. The expiry window
     * is defined by the module. Does nothing and returns null if no module is active.
     *
     * @return mixed  Whatever the module's expire_entries() returns, or null.
     * @since  1.0.0
     */
    public function expire_entries(): mixed
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->expire_entries();
        }
        return null;
    }
}
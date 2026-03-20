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
    public $_module;
    public $_user_id;
    public $_user_name;
    public function __construct($module, $user_id = null, $user_name = null)
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
    public function can_perform()
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->can_perform($this->_user_id, $this->_user_name);
        }
        return false;
    }
    public function get_title()
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->title;
        }
    }
    public function get_identifier()
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->identifier;
        }
    }
    public function record($success = true): void
    {
        if (!Text::is_empty($this->_module)) {
            $GLOBALS['db']->perform('action_recorder', ['module' => $this->_module, 'user_id' => (int) $this->_user_id, 'user_name' => $this->_user_name, 'identifier' => $this->get_identifier(), 'success' => $success ? 1 : 0, 'date_added' => 'NOW()']);
        }
    }
    public function expire_entries()
    {
        if (!Text::is_empty($this->_module)) {
            return $GLOBALS[$this->_module]->expire_entries();
        }
    }
}
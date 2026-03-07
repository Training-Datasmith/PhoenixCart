<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class payment
{
    public $modules;
    public $selected_module;

    // class constructor
    public function __construct(string $module = '')
    {
        if (defined('MODULE_PAYMENT_INSTALLED') && !Text::is_empty(MODULE_PAYMENT_INSTALLED)) {
            $this->modules = explode(';', (string) MODULE_PAYMENT_INSTALLED);

            $include_modules = [];

            if ((!Text::is_empty($module)) && (in_array($module . '.php', $this->modules))) {
                $this->selected_module = $module;

                $include_modules[] = ['class' => $module, 'file' => "$module.php"];
            } else {
                foreach ($this->modules as $value) {
                    $include_modules[] = [
                      'class' => pathinfo($value, PATHINFO_FILENAME),
                      'file' => $value,
                    ];
                }
            }

            foreach ($include_modules as $include_module) {
                $GLOBALS[$include_module['class']] = new $include_module['class']();
            }

            // if there is only one payment method, select it as default because in
            // checkout_confirmation.php the $payment variable is being assigned the
            // $_POST['payment'] value which will be empty (no radio button selection possible)
            if (($this->count() == 1) && (!isset($_SESSION['payment']) || !is_object($GLOBALS[$_SESSION['payment']] ?? null))) {
                $_SESSION['payment'] = $include_modules[0]['class'];
            }

            if ((!Text::is_empty($module)) && (in_array($module, $this->modules)) && (isset($GLOBALS[$module]->form_action_url))) {
                $this->form_action_url = $GLOBALS[$module]->form_action_url;
            }
        }
    }

    // class methods
    /* The following method is needed in the checkout_confirmation.php page
       due to a chicken and egg problem with the payment class and order class.
       The payment modules needs the order destination data for the dynamic status
       feature, and the order class needs the payment module title.
       The following method is a work-around to implementing the method in all
       payment modules available which would break the modules in the contributions
       section. This should be looked into again post 2.2.
    */
    public function update_status(): void
    {
        if (is_array($this->modules)
          && is_object($GLOBALS[$this->selected_module])
          && method_exists($GLOBALS[$this->selected_module], 'update_status')) {
            $GLOBALS[$this->selected_module]->update_status();
        }
    }

    public function javascript_validation(): string
    {
        $js = '';
        if (is_array($this->modules)) {
            $js = '<script><!-- ' . "\n";

            foreach ($this->modules as $value) {
                $class = pathinfo((string) $value, PATHINFO_FILENAME);
                if ($GLOBALS[$class]->enabled) {
                    $js .= $GLOBALS[$class]->javascript_validation();
                }
            }

            $js .= "\n" .
                   '//--></script>' . "\n";
        }

        return $js;
    }

    /**
     * @return mixed[]
     */
    public function checkout_initialization_method(): array
    {
        $initialize_array = [];

        if (is_array($this->modules)) {
            foreach ($this->modules as $value) {
                $class = pathinfo((string) $value, PATHINFO_FILENAME);

                if ($GLOBALS[$class]->enabled && method_exists($GLOBALS[$class], 'checkout_initialization_method')) {
                    $initialize_array[] = $GLOBALS[$class]->checkout_initialization_method();
                }
            }
        }

        return $initialize_array;
    }

    /**
     * @return mixed[][]
     */
    public function selection(): array
    {
        $selection_array = [];

        if (is_array($this->modules)) {
            foreach ($this->modules as $value) {
                $class = pathinfo((string) $value, PATHINFO_FILENAME);

                if ($GLOBALS[$class]->enabled) {
                    $selection = $GLOBALS[$class]->selection();

                    if (is_array($selection)) {
                        $selection_array[] = $selection;
                    }
                }
            }
        }

        return $selection_array;
    }

    protected function is_selected_enabled(): bool
    {
        return (is_array($this->modules)
          && is_object($GLOBALS[$this->selected_module])
          && ($GLOBALS[$this->selected_module]->enabled));
    }

    public function pre_confirmation_check(): void
    {
        if ($this->is_selected_enabled()) {
            $GLOBALS[$this->selected_module]->pre_confirmation_check();
        }
    }

    public function confirmation()
    {
        if ($this->is_selected_enabled()) {
            return $GLOBALS[$this->selected_module]->confirmation();
        }
    }

    public function process_button()
    {
        if ($this->is_selected_enabled()) {
            return $GLOBALS[$this->selected_module]->process_button();
        }
    }

    public function before_process()
    {
        if ($this->is_selected_enabled()) {
            return $GLOBALS[$this->selected_module]->before_process();
        }
    }

    public function after_process()
    {
        if ($this->is_selected_enabled()) {
            return $GLOBALS[$this->selected_module]->after_process();
        }
    }

    public function get_error()
    {
        if ($this->is_selected_enabled()) {
            return $GLOBALS[$this->selected_module]->get_error();
        }
    }

    public function count(): int
    {
        return count(array_filter($this->modules, fn ($m) => $GLOBALS[pathinfo((string) $m, PATHINFO_FILENAME)]->enabled ?? false));
    }

}

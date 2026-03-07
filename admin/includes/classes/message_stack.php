<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License

  Example usage:

  $messageStack = new messageStack();
  $messageStack->add('<strong>Error:</strong> Error 1', 'error');
  $messageStack->add('<strong>Error:</strong> Error 2', 'warning');
  if ($messageStack->size > 0) echo $messageStack->output();
*/

class messageStack
{
    public $size = 0;
    public $errors = [];

    public function __construct()
    {
        foreach (($_SESSION['messageToStack'] ?? []) as $message) {
            $this->add($message['text'], $message['type']);
        }

        unset($_SESSION['messageToStack']);
    }

    public function add($message, $type = 'error'): void
    {
        $this->errors[] = match ($type) {
            'primary' => ['params' => 'alert alert-primary', 'text' => $message],
            'secondary' => ['params' => 'alert alert-secondary', 'text' => $message],
            'light' => ['params' => 'alert alert-light', 'text' => $message],
            'dark' => ['params' => 'alert alert-dark', 'text' => $message],
            'warning' => ['params' => 'alert alert-warning', 'text' => $message],
            'success' => ['params' => 'alert alert-success', 'text' => $message],
            // error & danger
            default => ['params' => 'alert alert-danger', 'text' => $message],
        };

        $this->size++;
    }

    public function add_classed($class, $message, $type = 'error'): void
    {
        $this->add($message, $type);
    }

    public function add_session($message, $type = 'error'): void
    {
        if (!isset($_SESSION['messageToStack'])) {
            $_SESSION['messageToStack'] = [];
        }

        $_SESSION['messageToStack'][] = ['text' => $message, 'type' => $type];
    }

    public function reset(): void
    {
        $this->errors = [];
        $this->size = 0;
    }

    public function output()
    {
        $alert = null;
        foreach ($this->errors as $e) {
            $alert .= '<div class="' . $e['params'] . ' my-2 alert-dismissible fade show" role="alert">';
            $alert .= $e['text'];
            $alert .= '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            $alert .= '</div>';
        }

        return $alert;
    }

}

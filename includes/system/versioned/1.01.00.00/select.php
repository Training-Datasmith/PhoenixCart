<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2024 Phoenix Cart

  Released under the GNU General Public License
*/

class Select extends Input
{
    public const ESCAPES = [
      '"' => '&quot;',
      "'" => '&#039;',
      '<' => '&lt;',
      '>' => '&gt;',
    ];

    protected $options;
    protected $required = false;
    protected string $selection;

    public function __construct(string $name, array $options = [], array $parameters = [])
    {
        parent::__construct($name, $parameters);
        $this->options = $options;

        if (!isset($this->parameters['value']) && is_string($request = Request::value($this->get('name')))) {
            $this->selection = $request;
        }
    }

    public function add_option(array $option): static
    {
        $this->options[] = $option;
        return $this;
    }

    protected function build_options(): string
    {
        $field = '';

        $selector = ' selected="selected"';
        foreach ($this->options as $option) {
            $field .= '<option value="' . Text::output($option['id']) . '"';
            if ($selector && ($this->selection == $option['id'])) {
                $field .= $selector;
                $selector = '';
            }

            $field .= '>' . Text::output($option['text'], static::ESCAPES) . '</option>';
        }

        return $field;
    }

    public function draw(): string
    {
        // default if not already set
        $this->parameters += [
          'class' => 'form-select',
        ];

        if (isset($this->parameters['value'])) {
            // select menus do not have values per se; instead an option can be selected
            if (!isset($this->selection)) {
                $this->selection = $this->parameters['value'];
            }

            unset($this->parameters['value']);
        }

        $select = '<select' . $this->stringify_parameters() . '>' . $this->build_options() . '</select>';

        if ($this->required) {
            $select .= TEXT_FIELD_REQUIRED;
        }

        return $select;
    }

    /**
     *
     * @return array
     */
    public function get_options()
    {
        return $this->options;
    }

    public function set_options(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    /**
     *
     * @return boolean|bool
     */
    public function get_required()
    {
        return $this->required;
    }

    public function set_required(bool $required): static
    {
        $this->required = $required;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function get_selection()
    {
        return $this->selection;
    }

    public function set_selection(string $selection = null): static
    {
        $this->selection = $selection;
        return $this;
    }

    public function set_default_selection(string $default = null): static
    {
        if (!isset($this->selection)) {
            $this->selection = $default;
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->draw();
    }

}

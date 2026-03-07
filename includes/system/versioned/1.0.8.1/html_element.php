<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class html_element
{
    protected $parameters;

    /**
     * @param string $name
     * @param string $css A space-separated list of CSS classes.
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Append to any existing CSS.  Will create if not already there.
     * @param string $css A space-separated list of CSS classes.
     */
    public function append_css(string $css): static
    {
        if (isset($this->parameters['class']) && !Text::is_empty($this->parameters['class'])) {
            $this->parameters['class'] .= " $css";
        } else {
            $this->set('class', $css);
        }

        return $this;
    }

    /**
     * Unset a parameter.
     */
    public function delete(string $name): static
    {
        unset($this->parameters[$name]);
        return $this;
    }

    /**
     * Get the current parameter value.
     * @return number
     */
    public function get(string $name)
    {
        return $this->parameters[$name];
    }

    /**
     * Set an element parameter.
     */
    public function set(string $name, string $value = null): static
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * Convert the parameters array into a query string.
     */
    public function stringify_parameters(): string
    {
        return implode('', array_map(function (int|string $parameter, int $value): string {
            $parameter .= '="' . Text::output("$value") . '"';

            return " $parameter";
        }, array_keys($this->parameters), $this->parameters));
    }

}

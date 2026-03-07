<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class Textarea extends Input
{
    protected $text = '';

    public function retain_text(): static
    {
        if (is_string($text = Request::value($this->get('name'))) && !Text::is_empty($text)) {
            $this->set_text($text);
        }

        return $this;
    }

    /**
     *
     * @param string $text
     */
    public function set_text($text): static
    {
        $this->text = $text;
        return $this;
    }

    public function __toString(): string
    {
        // default if not already set
        $this->parameters += [
          'class' => 'form-control',
        ];

        return '<textarea' . $this->stringify_parameters() . ' >' . htmlspecialchars((string) $this->text). '</textarea>';
    }

}

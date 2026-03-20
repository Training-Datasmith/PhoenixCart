<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class breadcrumb
{
    /** @var array<int, array{title: string, link: string}> Ordered list of breadcrumb entries. */
    public $_trail;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears all breadcrumb entries.
     *
     * @return void
     * @since  1.0.0
     */
    public function reset(): void
    {
        $this->_trail = [];
    }

    /**
     * Appends an entry to the end of the breadcrumb trail.
     *
     * @param  string  $title  Human-readable label for the breadcrumb item.
     * @param  string  $link   URL for the breadcrumb link; empty string for non-linked items.
     * @return void
     * @since  1.0.0
     */
    public function add(string $title, string $link = ''): void
    {
        $this->_trail[] = ['title' => $title, 'link' => $link];
    }

    /**
     * Prepends an entry to the beginning of the breadcrumb trail.
     *
     * Useful for inserting a "Home" entry before page-specific crumbs.
     *
     * @param  string  $title  Human-readable label for the breadcrumb item.
     * @param  string  $link   URL for the breadcrumb link; empty string for non-linked items.
     * @return void
     * @since  1.0.0
     */
    public function prepend(string $title, string $link = ''): void
    {
        array_unshift($this->_trail, ['title' => $title, 'link' => $link]);
    }

    /**
     * Returns the raw breadcrumb trail array.
     *
     * The $separator parameter is accepted for API compatibility but not used;
     * rendering is left to the caller or template.
     *
     * @param  string|null  $separator  Unused; retained for API compatibility.
     * @return array<int, array{title: string, link: string}>
     * @since  1.0.0
     */
    public function trail(?string $separator = null): array
    {
        return $this->_trail;
    }

}

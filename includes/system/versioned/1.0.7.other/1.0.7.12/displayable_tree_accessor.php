<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
abstract class displayable_tree_accessor
{
    protected $max_level = 0;
    protected $root_start_string = '';
    protected $root_end_string = '';
    protected $parent_start_string = '';
    protected $parent_end_string = '';
    protected $parent_group_start_string = '<ul>';
    protected $parent_group_end_string = '</ul>';
    protected $parent_group_apply_to_root = false;
    protected $child_start_string = '<li>';
    protected $child_end_string = '</li>';
    protected $breadcrumb_separator = '_';
    protected $breadcrumb_usage = true;
    protected $spacer_string = '';
    protected $spacer_multiplier = 1;
    protected $follow_path = false;
    protected $path_array = [];
    protected $path_start_string = '';
    protected $path_end_string = '';
    public function __construct(protected $tree)
    {
    }
    public function set_maximum_level($max_level): void
    {
        $this->max_level = $max_level;
    }
    public function set_root_string($root_start_string, $root_end_string): void
    {
        $this->root_start_string = $root_start_string;
        $this->root_end_string = $root_end_string;
    }
    public function set_parent_string($parent_start_string, $parent_end_string): void
    {
        $this->parent_start_string = $parent_start_string;
        $this->parent_end_string = $parent_end_string;
    }
    public function set_parent_group_string($parent_group_start_string, $parent_group_end_string, $apply_to_root = false): void
    {
        $this->parent_group_start_string = $parent_group_start_string;
        $this->parent_group_end_string = $parent_group_end_string;
        $this->parent_group_apply_to_root = $apply_to_root;
    }
    public function set_child_string($child_start_string, $child_end_string): void
    {
        $this->child_start_string = $child_start_string;
        $this->child_end_string = $child_end_string;
    }
    public function set_breadcrumb_separator($breadcrumb_separator): void
    {
        $this->breadcrumb_separator = $breadcrumb_separator;
    }
    public function set_breadcrumb_usage($breadcrumb_usage): void
    {
        $this->breadcrumb_usage = $breadcrumb_usage === true;
    }
    public function set_spacer_string($spacer_string, $spacer_multiplier = 2): void
    {
        $this->spacer_string = $spacer_string;
        $this->spacer_multiplier = $spacer_multiplier;
    }
    public function set_path($path_string, $path_start_string = '', $path_end_string = ''): void
    {
        $this->follow_path = true;
        $this->path_array = explode($this->breadcrumb_separator, (string) $path_string);
        $this->path_start_string = $path_start_string;
        $this->path_end_string = $path_end_string;
    }
    public function set_follow_path($follow_path): void
    {
        $this->follow_path = $follow_path === true;
    }
    public function set_path_string($path_start_string, $path_end_string): void
    {
        $this->path_start_string = $path_start_string;
        $this->path_end_string = $path_end_string;
    }
}
<?php

declare(strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

class navigationHistory
{
    public $path;
    public $snapshot;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->path = [];
        $this->snapshot = [];
    }

    public function add_current_page(): void
    {
        global $cPath;

        for ($i = 0, $n = count($this->path); $i < $n; $i++) {
            if ($this->path[$i]['page'] == Request::get_page()) {
                if (!isset($cPath)) {
                    array_splice($this->path, ($i));
                    break;
                }

                if (!isset($this->path[$i]['get']['cPath'])) {
                    continue;
                }

                if ($this->path[$i]['get']['cPath'] == $cPath) {
                    array_splice($this->path, ($i + 1));
                    return;
                }

                $old_cPath = explode('_', $this->path[$i]['get']['cPath']);
                $new_cPath = explode('_', $cPath);

                for ($j = 0, $n2 = count($old_cPath); $j < $n2; $j++) {
                    if ($old_cPath[$j] != $new_cPath[$j]) {
                        array_splice($this->path, ($i));
                        break 2;
                    }
                }
            }
        }

        $this->path[] = [
          'page' => Request::get_page(),
          'get' => $this->filter_parameters($_GET),
          'post' => $this->filter_parameters($_POST),
        ];
    }

    public function remove_current_page(): void
    {
        $last_entry_position = count($this->path) - 1;
        if ($this->path[$last_entry_position]['page'] == Request::get_page()) {
            unset($this->path[$last_entry_position]);
        }
    }

    public function set_snapshot($page = null): void
    {
        if (isset($page['page'])) {
            $this->snapshot = [
              'page' => $page['page'],
              'get' => $this->filter_parameters($page['get'] ?? []),
              'post' => $this->filter_parameters($page['post'] ?? []),
            ];
        } else {
            $this->snapshot = [
              'page' => Request::get_page(),
              'get' => $this->filter_parameters($_GET),
              'post' => $this->filter_parameters($_POST),
            ];
        }
    }

    public function clear_snapshot(): void
    {
        $this->snapshot = [];
    }

    public function set_path_as_snapshot($history = 0): void
    {
        $pos = (count($this->path) - 1 - $history);
        $this->snapshot = [
          'page' => $this->path[$pos]['page'],
          'get' => $this->path[$pos]['get'],
          'post' => $this->path[$pos]['post'],
        ];
    }

    public function link_snapshot($default = null)
    {
        if (empty($this->snapshot)) {
            return $GLOBALS['Linker']->build($default ?? 'index.php');
        }

        return $GLOBALS['Linker']->build(
            $this->snapshot['page'],
            array_diff_key($this->snapshot['get'], array_flip([session_name()]))
        );
    }

    public function pop_snapshot_as_link()
    {
        if (empty($this->snapshot)) {
            return $GLOBALS['Linker']->build('index.php');
        }

        $origin_href = $this->link_snapshot();

        $this->clear_snapshot();
        return $origin_href;
    }

    public function debug(): void
    {
        foreach ($this->path as $step) {
            echo $step['page'] . '?';
            foreach ($step['get'] as $key => $value) {
                echo $key . '=' . $value . '&';
            }

            if (count($step['post']) > 0) {
                echo '<br>';
                foreach ($step['post'] as $key => $value) {
                    echo '&nbsp;&nbsp;<strong>' . $key . '=' . $value . '</strong><br>';
                }
            }
            echo '<br>';
        }

        if (count($this->snapshot) > 0) {
            echo '<br><br>';

            echo $GLOBALS['Linker']->build(
                $this->snapshot['page'],
                array_diff_key($this->snapshot['get'], array_flip([session_name()]))
            ) . '<br>';
        }
    }

    /**
     * @return mixed[]
     */
    protected function filter_parameters($parameters): array
    {
        $clean = [];

        foreach (($parameters ?? []) as $key => $value) {
            if (!strpos((string) $key, '_nh-dns')) {
                $clean[$key] = $value;
            }
        }

        return $clean;
    }

}

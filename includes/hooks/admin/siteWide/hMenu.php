<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_admin_site_Wide_h_Menu
{
    public $version = '1.0.0';
    public static function sort_box_links(array $a, array $b): int
    {
        return strcasecmp((string) $a['title'], (string) $b['title']);
    }
    public function listen_inject_body_start()
    {
        if (basename((string) Request::get_page()) !== 'login.php') {
            $cl_box_groups = [];
            if ($dir = @dir(DIR_FS_ADMIN . 'includes/boxes')) {
                $files = [];
                while ($file = $dir->read()) {
                    if (!is_dir("{$dir->path}/{$file}") && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                        $files[] = $file;
                    }
                }
                $dir->close();
                natcasesort($files);
                foreach ($files as $file) {
                    $path = DIR_FS_ADMIN . "includes/languages/{$_SESSION['language']}/modules/boxes/{$file}";
                    if (file_exists($path)) {
                        include_once $path;
                    }
                    include_once "{$dir->path}/{$file}";
                }
            }
            usort($cl_box_groups, function (array $a, array $b): int {
                $has_sort_a = isset($a['sort']);
                $has_sort_b = isset($b['sort']);
                if ($has_sort_a && $has_sort_b) {
                    return $a['sort'] <=> $b['sort'];
                }
                if ($has_sort_a) {
                    return -1;
                }
                if ($has_sort_b) {
                    return 1;
                }
                return strcasecmp(strip_tags((string) $a['heading']), strip_tags((string) $b['heading']));
            });
            foreach ($cl_box_groups as &$group) {
                usort($group['apps'], Hook_admin_site_Wide_h_Menu::sort_box_links(...));
            }
            $n = 1;
            $mr = '';
            foreach ($cl_box_groups as $groups) {
                $mr .= '<li class="nav-item dropdown">';
                $mr .= '<a class="nav-link dropdown-toggle" href="#" id="navbar_' . $n . '" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $groups['heading'] . '</a>';
                $al = $n > 6 ? ' dropdown-menu-end' : '';
                $mr .= '<ul class="dropdown-menu' . $al . '" aria-labelledby="navbar_' . $n . '">';
                foreach ($groups['apps'] as $app) {
                    $mr .= '<li><a class="dropdown-item" href="' . $app['link'] . '">' . $app['title'] . '</a></li>';
                }
                $mr .= '</ul>';
                $mr .= '</li>' . PHP_EOL;
                $n++;
            }
            $icon = $GLOBALS['Admin']->image('images/CE-Phoenix-30-30.png', [], 'CE Phoenix v' . Versions::get('Phoenix'), 30, 30);
            $output = '';
            $output .= '<nav class="navbar navbar-expand-xl navbar-dark bg-dark d-print-none sticky-top" aria-label="Main Menu">';
            $output .= '<div class="container-fluid">';
            $output .= '<a class="navbar-brand" href="' . $GLOBALS['Admin']->link('index.php') . '">' . $icon->set_responsive(false) . '</a>';
            $output .= '<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
            $output .= '<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="navbarAdmin" aria-labelledby="navbarAdminLabel">';
            $output .= '<div class="offcanvas-header">';
            $output .= '<h5 class="offcanvas-title" id="navbarAdminLabel">Main Menu</h5>';
            $output .= '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>';
            $output .= '</div>';
            $output .= '<div class="offcanvas-body">';
            $output .= '<ul class="navbar-nav justify-content-start flex-grow-1 pe-3">';
            $output .= $mr;
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</nav>';
            $output .= '<div class="col bg-light mb-1 border-bottom d-print-none">';
            $output .= '<ul class="nav justify-content-end">';
            $output .= '<li class="nav-item"><a class="nav-link" target="_blank" rel="noreferrer" href="https://phoenixcart.org/forum/">' . HEADER_TITLE_PHOENIX_CLUB . '</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" target="_blank" rel="noreferrer" href="https://phoenixcart.org/phoenixcartwiki/index.php">' . HEADER_TITLE_PHOENIX_WIKI . '</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" target="_blank" rel="noreferrer" href="https://phoenixcart.org/forum/addons/">' . HEADER_TITLE_CERTIFIED_ADDONS . '</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" target="_blank" rel="noreferrer" href="https://phoenixcart.org/forum/viewforum.php?f=22">' . HEADER_TITLE_CERTIFIED_DEVELOPERS . '</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" href="' . $GLOBALS['Admin']->catalog('') . '">' . HEADER_TITLE_ONLINE_CATALOG . '</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link text-danger" href="' . $GLOBALS['Admin']->link('login.php', ['action' => 'logoff']) . '">' . sprintf(HEADER_TITLE_LOGOFF, $_SESSION['admin']['username']) . '</a></li>';
            $output .= '</ul>';
            return $output . '</div>';
        }
    }
}
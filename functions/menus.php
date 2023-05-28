<?php

/**
 * Register navigation menus
 *
 * @link https://codex.wordpress.org/register_nav_menus
 */
register_nav_menus(
    array(
        'header' => 'Header Menu',
        'footer' => 'Footer Menu'
    )
);

function header_menu()
{
    $header = array(
        'theme_location'  => 'header',
        'container'       => false,
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => false,
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 5,
        'walker'          => new custom_walker()
    );

    wp_nav_menu($header);
}

function mobile_menu()
{
    $mobile = array(
        'theme_location' => 'header',
        'container'       => false,
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => false,
        'before'          => '<span><i class="fa-sharp fa-solid fa-triangle"></i></span>',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'          => 0,
        'walker'          => new custom_walker()
    );

    wp_nav_menu($mobile);
}

function footer_menu()
{
    $footer = array(
        'theme_location' => 'footer',
        'container'       => false,
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => false,
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'          => 0,
        'walker'          => new custom_walker()
    );

    wp_nav_menu($footer);
}

class custom_walker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        /**
         * Debugging parameters
         */
        // echo '<pre>';
        // print_r($args);
        // echo '</pre>';

        /**
         * Search through the Wordpress classes applied to each menu item and reassign them
         */
        $current = array_search('current-menu-item', $item->classes);
        $parent = array_search('menu-item-has-children', $item->classes);
        $ancestor = array_search('current-menu-ancestor', $item->classes);
        $custom = ($item->classes[0]) ? $item->classes[0] : '';
        $target = ($item->target) ? $item->target : '_self';

        // Undefined variables
        $li_classes = '';
        $before = '';

        if ($current) {
            $li_classes .= 'current ';
        }

        if ($parent) {
            $li_classes .= 'parent ';
        }

        if ($ancestor) {
            $li_classes .= 'ancestor ';
        }

        /**
         * Check if the before arg for mobile is set
         */
        if ($parent || $ancestor) {
            $before = $args->before;
        }

        if ($custom) {
            $li_classes .= $item->classes[0] . ' ';
            $start_span = '<span>';
            $end_span = '</span>';
        }

        $li_class = substr($li_classes, 0, -1);
        $li_class = $li_class ? ' class="' . esc_attr($li_class) . '"' : '';

        $output .= sprintf("\n <li%s>%s<a href='%s' target='%s'>%s</a>\n", $li_class, $before, $item->url, $target, $item->title);
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);

        $output .= "\n$indent<ul class=\"dropdown\">\n";
    }
}

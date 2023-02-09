<?php

/**
 * Loads any fields.json file saved in fields/ for syncing
 */
// add_filter('acf/settings/load_json', 'preload_fields');
function preload_fields( $paths ) {
    unset($paths[0]);

    $paths[] = get_stylesheet_directory() . '/functions/fields';

    return $paths;
}

if ( function_exists('acf_add_options_page') ) {
    /**
     * Adds an options page to the admin menu.
     *
     * @link https://www.advancedcustomfields.com/resources/options-page/
     */
    acf_add_options_page(
        array(
            'page_title'  => 'Global Fields',
            'menu_title'  => 'Global Fields',
            'menu_slug'   => 'acf-settings',
            'capability'  => 'edit_posts',
            'position'    => '80.01',
            // 'parent_slug' => 'options-general.php',
            'icon_url'    => 'dashicons-admin-site',
            'redirect'    => false
        )
    );

    /**
     * Adds a new options sub page to the admin menu.
     *
     * @link https://www.advancedcustomfields.com/resources/acf_add_options_sub_page/
     */
    acf_add_options_sub_page(
        array(
            'page_title'  => 'Mobile Menu Settings',
            'menu_title'  => 'Mobile Menu',
            'parent_slug' => 'themes.php',
        )
    );
}

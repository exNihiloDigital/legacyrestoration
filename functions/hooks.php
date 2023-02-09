<?php
/**
 * Custom hooks
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if ( ! function_exists('site_info') ) {
    /**
     * Add site info hook to WP hook library.
     */
    function site_info() {
        do_action('site_info');
    }
}


if ( ! function_exists('add_site_info') ) {
    /**
     * Add site info content.
     */
    function add_site_info() {
        $site_info = sprintf(
            '<p>%1$s %2$s %3$s %4$s %5$s %6$s</p>',
            esc_html('&copy;'),
            esc_html(date('Y')),
            esc_html(get_bloginfo('name') . "."),
            sprintf(
                '<a href="%1$s" target="_blank">%2$s</a>',
                esc_url('https://phoscreative.com/expertise/web-design/'),
                esc_html('Web Design')
            ),
            esc_html('by'),
            sprintf(
                '<a href="%1$s" target="_blank">%2$s</a>',
                esc_url('https://phoscreative.com'),
                esc_html('PHOS Creative')
            )
        );

        echo apply_filters('site_info_content', $site_info);
    }
}
add_action('site_info', 'add_site_info');

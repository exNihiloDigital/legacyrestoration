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



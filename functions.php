<?php

/**
 * @package Framework
 *
 * Foreach glob & require each file in the functions/ directory
 */

$framework_includes = array(
    '/dashboard.php',
    '/enqueue.php',
    '/featured.php',
    '/menus.php',
    '/hooks.php',
    '/post-types.php',
    '/shortcodes.php',
    '/theme.php',
);

// Functions directory.
$theme_fn_dir = '/functions';

// Load ACF functions only if ACF is activated.
if (class_exists('ACF') ) {
    $framework_includes[] = '/acf.php';
}

// Load WooCommerce functions only if WooCommerce is activated.
if (class_exists('WooCommerce') ) {
    $framework_includes[] = '/woocommerce.php';
}

foreach ( $framework_includes as $file) {
    include_once get_theme_file_path($theme_fn_dir . $file);
}

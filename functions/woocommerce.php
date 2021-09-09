<?php

/**
 * Declare WooCommerce support
 */
if (! function_exists('woocommerce_support') ) {
    // Declares WooCommerce theme support.
    function woocommerce_support() {
        add_theme_support('woocommerce');

        // Add Product Gallery support.
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-slider');
    }
}
add_action('after_setup_theme', 'woocommerce_support');

/**
 * Remove HTML before/after output when calling woocommerce_content()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Remove default styling
 */
// add_filter('woocommerce_enqueue_styles', '__return_false');

// ================================================================
// Shop, is_shop()
// ================================================================

/**
 * Removes title
 */
add_filter('woocommerce_show_page_title', '__return_false');

/**
 * Removes ratings
 */
remove_filter('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

// ================================================================
// Single Product, is_product()
// ================================================================

/**
 * Changes title from an h1 to an h2
 */
function woocommerce_template_single_title() {
    echo '<h2>'.get_the_title().'</h2>';
}
remove_filter('woocommerce_single_product_summary', 'woocommerce_template_single_title');
add_filter('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

/**
 * Removes ratings
 */
remove_filter('woocommerce_single_product_summary', 'woocommerce_template_single_rating');

/**
 * Removes summary
 */
// remove_filter('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
// remove_filter('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
// remove_filter('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

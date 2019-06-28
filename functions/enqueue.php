<?php

/**
 * Enqueue fonts
 *
 * https://fonts.google.com/
 */
add_action('wp_enqueue_scripts', 'enqueue_fonts');
function enqueue_fonts()
{
    /**
     * font-family: 'Montserrat', sans-serif;
     * font-family: 'Roboto', sans-serif;
     *
    */
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i');
}

/**
 * Enqueue ACF & Dashboard styles
 */
add_action('admin_enqueue_scripts', 'enqueue_acf');
function enqueue_acf()
{
    wp_enqueue_style('theme-acf', get_template_directory_uri() . '/assets/acf.min.css');
    wp_enqueue_style('theme-dashboard', get_template_directory_uri() . '/assets/dashboard.min.css');
}

/**
 * Enqueue Gutenberg styles
 */
add_action('admin_enqueue_scripts', 'enqueue_gutenberg');
add_action('enqueue_block_editor_assets', 'enqueue_gutenberg');
function enqueue_gutenberg()
{
    wp_enqueue_style('theme-gutenberg', get_template_directory_uri() . '/assets/gutenberg.min.css');
}

/**
 * Enqueue login styles
 */
add_action('login_enqueue_scripts', 'enqueue_login');
function enqueue_login()
{
    wp_enqueue_style('theme-login', get_template_directory_uri() . '/assets/login.min.css');
}

/**
 * Enqueue theme scripts & styles
 */
add_action('wp_enqueue_scripts', 'enqueue_theme');
function enqueue_theme()
{
    if (! is_admin()) {
        wp_deregister_script('jquery'); // Takes out the possibly outdated version included in WP
        wp_enqueue_script('jquery', 'https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js');
        wp_enqueue_script('scripts', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js');
        wp_enqueue_script('theme', get_template_directory_uri() . '/assets/theme.min.js');

        wp_enqueue_style('normalize', 'https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.min.css');
        wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css');
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('theme', get_template_directory_uri() . '/assets/theme.min.css');
    }
}

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
        wp_enqueue_script('jquery');
        wp_enqueue_script('matchheight', 'https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js');
        wp_enqueue_script('theme', get_template_directory_uri() . '/assets/theme.min.js');

        wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('fontawesome', 'https://cdn.jsdelivr.net/fontawesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('theme', get_template_directory_uri() . '/assets/theme.min.css');

        /**
         * Cross-browser
         */
        wp_script_add_data('html5shiv', 'conditional', 'gte IE 9');
        wp_enqueue_script('html5shiv', 'https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js');

        wp_script_add_data('html5shiv-printshiv', 'conditional', 'lte IE 8');
        wp_enqueue_script('html5shiv-printshiv', 'https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv-printshiv.min.js');
    }
}

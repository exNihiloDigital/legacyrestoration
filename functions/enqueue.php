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
    wp_enqueue_style('theme-acf', get_template_directory_uri() . '/assets/css/acf.min.css');
    wp_enqueue_style('theme-dashboard', get_template_directory_uri() . '/assets/css/dashboard.min.css');
}

/**
 * Enqueue Gutenberg styles
 */
add_action('admin_enqueue_scripts', 'enqueue_gutenberg');
add_action('enqueue_block_editor_assets', 'enqueue_gutenberg');
function enqueue_gutenberg()
{
    wp_enqueue_style('theme-gutenberg', get_template_directory_uri() . '/assets/css/gutenberg.min.css');
}

/**
 * Enqueue login styles
 */
add_action('login_enqueue_scripts', 'enqueue_login');
function enqueue_login()
{
    wp_enqueue_style('theme-login', get_template_directory_uri() . '/assets/css/login.min.css');
}

/**
 * Enqueue theme scripts & styles
 */
add_action('wp_enqueue_scripts', 'enqueue_theme');
function enqueue_theme()
{
    if (! is_admin()) {
        // Get the theme data.
        $the_theme     = wp_get_theme();
        // Will take the version from root folder /style.css
        $theme_version = $the_theme->get( 'Version' );
        // Will append the modified-time to static assets.
        // theme.min.css becomes theme.min.css?ver=1.0.0195867.
        // Prevents caching issues as the cache renews with changed file names.
        // https://www.keycdn.com/support/what-is-cache-busting
        $css = file_exists( get_template_directory() . '/assets/css/theme.min.css' ) ? '/assets/css/theme.min.css' : '/style.css';
        $js = file_exists( get_template_directory() . '/assets/js/theme.min.js' ) ? '/assets/js/theme.min.js' : '/style.css';
        $css_v = $theme_version . '.' . filemtime( get_template_directory() . $css );
        $js_v = $theme_version . '.' . filemtime( get_template_directory() . $js );

        wp_enqueue_script('jquery');
        wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper@6.5.8/swiper-bundle.min.js');
        wp_enqueue_script('theme', get_template_directory_uri() . '/assets/js/theme.min.js', array('jquery'), $js_v);

        wp_enqueue_style('normalize', 'https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.min.css');
        wp_enqueue_style('fontawesome', 'https://pro.fontawesome.com/releases/v5.12.0/css/all.css');
        wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@6.5.8/swiper-bundle.min.css');
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('theme', get_template_directory_uri() . '/assets/css/theme.min.css', array(), $css_v);
    }
}
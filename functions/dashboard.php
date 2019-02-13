<?php

/**
 * Foreach removal of default Wordpress core functions for security
 *
 * @return void
 */
add_action('wp_head', 'remove_wordpress_defaults');
function remove_wordpress_defaults()
{
    $defaults = array(
        'rsd_link',
        'wlwmanifest_link',
        'feed_links',
        'rsd_link',
        'wlwmanifest_link',
        'feed_links',
        'feed_links_extra',
        'index_rel_link',
        'parent_post_rel_link',
        'start_post_rel_link',
        'adjacent_posts_rel_l',
        'rest_output_link_wp_head',
        'wp_generator'
    );

    foreach ($defaults as $default) {
        remove_action('wp_head', $default);
    }
}

/**
 * Change 'Howdy' to 'Welcome' in $wp_admin_bar
 *
 * @param [type] $wp_admin_bar
 * @return void
 */
add_filter('admin_bar_menu', 'howdy_to_welcome');
function howdy_to_welcome($wp_admin_bar)
{
    $account = $wp_admin_bar->get_node('my-account');
    $welcome = str_replace('Howdy', 'Welcome', $account->title);

    $wp_admin_bar->add_node(
        array(
            'id'    => 'my-account',
            'title' => $welcome
        )
    );
}

/**
 * Replaces 'Thank you for creating with WordPress' with 'Website developed by PHOS Creative'
 */
add_filter('admin_footer_text', 'replace_thank_you_in_dashboard');
function replace_thank_you_in_dashboard() {
    echo '<span id="footer-thankyou">Website developed by <a href="https://phoscreative.com" target="_blank">PHOS Creative</a>.</span>';
}

/**
 * Hide dashboard widgets for a cleaner interface
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_meta_box/
 * @return void
 */
add_action('wp_dashboard_setup', 'hide_dashboard_widgets', 999);
function hide_dashboard_widgets()
{
    global $wp_meta_boxes;

    $wp_meta_boxes['dashboard']['normal']['core'] = array();
    $wp_meta_boxes['dashboard']['side']['core'] = array();

    // foreach ($wp_meta_boxes as $meta => $value) {
    //     unset($wp_meta_boxes[$meta]);
    // }
}

/**
 * Remove adminbar menu items for a cleaner interface
 *
 * @link https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_menu/
 * @param [type] $dashboard
 * @return void
 */
add_action('admin_bar_menu', 'remove_adminbar_items', 999);
function remove_adminbar_items($dashboard)
{
    global $wp_admin_bar;

    /**
     * Get the specific ID of every $wp_admin_bar item
     */
    foreach ($wp_admin_bar->get_nodes() as $menu) {
        $menus[] = $menu->id;
    }

    /**
     * Manually list all the menu items we wish to keep
     */
    $menu_keep = array(
        'user-actions',
        'user-info',
        'edit-profile',
        'logout',
        'menu-toggle',
        'my-account',
        'site-name',
        'my-sites',
        'my-sites-super-admin',
        'network-admin',
        'my-sites-list',
        // ----------------
        'dashboard',
        'appearance',
        'menus',
        'view-site',
        'edit',
        'new-content',
        'new-post',
        'new-media',
        'new-page',
        'new-example',
        'new-user',
        'top-secondary',
    );

    /**
     * Add network-admin items to $menu_keep
     */
    foreach (array('d', 's', 'u','t', 'p', 'o') as $letter) {
        $menu_keep[] = 'network-admin-' . $letter;
    }

    /**
     * Add blog sites and their submenu items to $menu_keep
     */
    foreach (range(1, 10) as $number) {
        $menu_keep[] = 'blog-' . $number;

        foreach (array('d', 'n', 'c','v') as $letter) {
            $menu_keep[] = 'blog-' . $number . '-' . $letter;
        }
    }

    /**
     * Get the differences between $menus and $menu_keep
     */
    $menus = array_diff($menus, $menu_keep);

    /**
     * Eliminate the differences, leaving only what we want in wp_admin_bar
     */
    foreach ($menus as $menu) {
        $dashboard->remove_menu($menu);
    }
}

/**
 * Debug & var_dump the dashboard menu
 *
 * @return void
 */
// add_action('admin_notices', debug_dashboard_menu);
function debug_dashboard_menu()
{
    global $pagenow, $menu, $submenu;

    $phos_developers = array(
        'admin@localhost.dev',
        'alex@phoscreative.com',
        'miker@phoscreative.com'
    );

    foreach ($phos_developers as $developer) {
        if (wp_get_current_user()->user_email == $developer) {
            echo '<pre style="padding: 15px">';
            echo '<h1>Menu Debugging</h1>';
            echo '<h2>$pagenow</h2>';
            var_dump($pagenow);
            echo '<h2>$menu</h2>';
            var_dump($menu);
            echo '<h2>$submenu</h2>';
            var_dump($submenu);
            echo '</pre>';
        }
    }
}

/**
 * Remove dashboard menu items
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_menu_page
 * @return void
 */
add_action('admin_menu', 'remove_adminmenu_items');
function remove_adminmenu_items()
{
    $menus = array(
        'link-manager.php',
        'edit-comments.php'
    );

    foreach ($menus as $menu) {
        remove_menu_page($menu);
    }
}

/**
 * Filter default posts label in the dashboard menu
 *
 * @return void
 */
add_action('admin_menu', 'edit_posts');
function edit_posts()
{
    global $menu, $submenu;

    $menu[5][0]                 = 'Blog';
    $submenu['edit.php'][5][0]  = 'Blog';
    $submenu['edit.php'][10][0] = 'Add Blog';
    $submenu['edit.php'][16][0] = 'Blog Tags';
}

/**
 * Filter default posts label globally
 *
 * @return void
 */
add_action('init', 'edit_posts_labels');
function edit_posts_labels()
{
    global $wp_post_types;

    $labels                     = &$wp_post_types['post']->labels;
    $labels->name               = 'Blog';
    $labels->singular_name      = 'Blog';
    $labels->add_new            = 'Add Blog';
    $labels->add_new_item       = 'Add Blog';
    $labels->edit_item          = 'Edit Blog';
    $labels->new_item           = 'Blog';
    $labels->view_item          = 'View Blog';
    $labels->search_items       = 'Search Blog';
    $labels->not_found          = 'No Blog found';
    $labels->not_found_in_trash = 'No Blog found in Trash';
    $labels->all_items          = 'All Blog';
    $labels->menu_name          = 'Blog';
    $labels->name_admin_bar     = 'Blog';
}

/**
 * Create dashboard menu separators
 *
 * @param [type] $position
 * @return void
 */
add_action('admin_init', 'create_separator');
function create_separator($position)
{
    global $menu;

    $menu[$position] = array(
        0 => '',
        1 => 'read',
        2 => 'separator' . $position,
        3 => '',
        4 => 'wp-menu-separator'
    );
}

/**
 * Set $position range for dashboard menu separators
 *
 * @return void
 */
add_action('admin_menu', 'assign_separator');
function assign_separator()
{
    foreach (range(1000, 1040) as $position) {
        create_separator($position);
    }
}

/**
 * Reprioritize the adminmenu
 *
 * @param [type] $order
 * @return void
 */
add_filter('custom_menu_order', 'organize_dashboard_menu');
add_filter('menu_order', 'organize_dashboard_menu');
function organize_dashboard_menu($order)
{
    if (! $order) {
        return true;
    }

    $i = 1000;

    $order = array(
        'index.php',
        'separator'.  $i++,
        'edit.php',
        'edit.php?post_type=page',
        'upload.php',
        'separator'.  $i++,
        'edit.php?post_type=example',
        'separator'.  $i++,
        'gf_edit_forms',
        'separator'.  $i++,
        'woocommerce',
        'edit.php?post_type=product',
        'separator'.  $i++,
        'themes.php',
        'plugins.php',
        'users.php',
        'tools.php',
        'separator'.  $i++,
        'wpseo_dashboard',
        'separator'.  $i++,
        'edit.php?post_type=acf-field-group',
        'separator'.  $i++,
        'acf-settings',
        'options-general.php',
    );

    return $order;
}

/**
 * Hides specific meta boxes automatically from posts and pages
 *
 * @param [type] $hidden
 * @param [type] $screen
 * @return void
 */
add_action('default_hidden_meta_boxes', 'hide_meta_boxes', 10, 2);
function hide_meta_boxes($hidden, $screen)
{
    $hidden = array(
        'categorydiv',
        'revisionsdiv',
        // 'pageparentdiv',
        // 'postimagediv',
        // 'submitdiv',
        // 'tagsdiv-post_tag',
        // 'tagsdiv-{$tax-name}',
        // '{$tax-name}div',
        'authordiv',
        'slugdiv',
        'commentstatusdiv',
        'commentsdiv',
        'formatdiv',
        'postcustom',
        'postexcerpt',
        'trackbacksdiv'
    );

    return $hidden;
}

/**
 * Moves Yoast meta boxes to the bottom of posts and pages
 *
 * @return void
 */
add_filter('wpseo_metabox_prio', 'yoast_to_bottom');
function yoast_to_bottom()
{
    return 'low';
}

/**
 * Remove indexing on archive pages
 */
add_filter('wpseo_robots', 'no_index_paginated_pages');
function no_index_paginated_pages($robots) {
    if (is_paged()) {
        return false;
    } else {
        return $robots;
    }
}

/**
 * Remove emoji support
 *
 * @link https://codex.wordpress.org/Emoji
 * @return void
 */
add_action('init', 'remove_emojis');
function remove_emojis()
{
    add_filter('emoji_svg_url', '__return_false');

    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        }

        return array();
    });

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

/**
 * Modifies TinyMCE's setting and button ordering
 *
 * @link https://codex.wordpress.org/TinyMCE
 * @param [type] $settings
 * @return void
 */
add_filter('tiny_mce_before_init', 'clean_tinymce');
function clean_tinymce($settings)
{
    $settings['remove_linebreaks'] = true;
    $settings['gecko_spellcheck'] = true;
    $settings['keep_styles'] = true;
    $settings['accessibility_focus'] = true;
    $settings['paste_remove_styles'] = true;
    $settings['paste_remove_spans'] = true;
    $settings['paste_strip_class_attributes'] = 'all';

    // formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link unlink wp_more spellchecker fullscreen wp_adv strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help

    /**
     * This is where you will add specific button shortcodes into the toolbar
     */
    $settings['toolbar1'] = 'formatselect,forecolor,bold,italic,underline,strikethrough,hr,blockquote,numlist,bullist,button,link,unlink,alignleft,aligncenter,alignright,outdent,indent,undo,redo,charmap,removeformat,pastetext,wp_help';

    $settings['toolbar2'] = '';

    // $settings['block_formats'] = "base=p; Heading 1=h1; Heading 2=h2; Heading 3=h3;";

    return $settings;
}

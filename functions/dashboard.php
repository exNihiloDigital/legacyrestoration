<?php

/**
 * Foreach removal of default Wordpress core functions for security
 *
 * @return void
 */
add_action('wp_head', 'remove_wordpress_defaults');
function remove_wordpress_defaults() {
    $defaults = array(
        'adjacent_posts_rel_link_wp_head',
        'feed_links_extra',
        'feed_links',
        'rsd_link',
        'wlwmanifest_link',
        'wp_generator',
        'print_emoji_detection_script'
    );

    foreach ($defaults as $default) {
        remove_action('wp_head', $default);
    }
}

/**
 * Change 'Howdy' to 'Welcome' in $wp_admin_bar
 *
 * @param  [type] $wp_admin_bar
 * @return void
 */
add_filter('admin_bar_menu', 'howdy_to_welcome');
function howdy_to_welcome($wp_admin_bar) {
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
    echo sprintf(
        '<span id="footer-thankyou">%1$s %2$s</span>',
        esc_html('Website developed by'),
        sprintf(
            '<a href="%1$s" target="_blank">%2$s</a>',
            esc_url('https://phoscreative.com'),
            esc_html('PHOS Creative')
        )
    );
}

/**
 * Hide dashboard widgets for a cleaner interface
 *
 * @return void
 */
add_action('wp_dashboard_setup', 'hide_dashboard_widgets', 999);
function hide_dashboard_widgets() {
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal'); // Gravity Forms
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal'); // Yoast
}

/**
 * Remove adminbar menu items for a cleaner interface
 *
 * @link   https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_menu/
 * @param  [type] $dashboard
 * @return void
 */
add_action('admin_bar_menu', 'remove_adminbar_items', 999);
function remove_adminbar_items($dashboard) {
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
 * Remove admin panel comment entry
 *
 * @link   https://codex.wordpress.org/Function_Reference/remove_menu_page
 * @return void
 */
add_action('admin_menu', 'remove_adminmenu_items');
function remove_adminmenu_items() {
    $menus = array('edit-comments.php');

    foreach ($menus as $menu) {
        remove_menu_page($menu);
    }
}

/**
 * Filter default posts label globally
 *
 * @return void
 */
add_action('init', 'edit_posts_labels');
function edit_posts_labels() {
    global $wp_post_types;

    $labels                     = &$wp_post_types['post']->labels;
    $labels->name               = 'Blogs';
    $labels->singular_name      = 'Blog';
    $labels->add_new            = 'Add Blog Post';
    $labels->add_new_item       = 'Add Blog';
    $labels->edit_item          = 'Edit Blog';
    $labels->new_item           = 'Blog';
    $labels->view_item          = 'View Blog';
    $labels->search_items       = 'Search Blog';
    $labels->not_found          = 'No Blog found';
    $labels->not_found_in_trash = 'No Blog found in Trash';
    $labels->all_items          = 'All Blog Posts';
    $labels->menu_name          = 'Blog';
    $labels->name_admin_bar     = 'Blog';
}

/**
 * Create dashboard menu separators
 *
 * @param  [type] $position
 * @return void
 */
function create_separator($position) {
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
 * Control admin panel entry grouping - deactivated until needed
 *
 * @return void
 */
// add_action('admin_menu', 'assign_separator');
function assign_separator() {
    foreach (range(1000, 1040) as $position) {
        create_separator($position);
    }
}

/**
 * Control admin panel entry sorting - deactivated until needed
 *
 * @param  [type] $order
 * @return void
 */
// add_filter('custom_menu_order', 'organize_dashboard_menu');
// add_filter('menu_order', 'organize_dashboard_menu');
function organize_dashboard_menu($order) {
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
 * Moves Yoast meta boxes to the bottom of posts and pages
 *
 * @return void
 */
add_filter('wpseo_metabox_prio', 'yoast_to_bottom');
function yoast_to_bottom() {
    return 'low';
}

/**
 * Remove emoji support
 *
 * @link   https://codex.wordpress.org/Emoji
 * @return void
 */
add_action('init', 'remove_emojis');
function remove_emojis() {
    // Filters the URL where emoji SVG images are hosted.
    add_filter('emoji_svg_url', '__return_false');

    add_filter(
        'tiny_mce_plugins', function ($plugins) {
            if (is_array($plugins)) {
                return array_diff($plugins, array('wpemoji'));
            }

            return array();
        }
    );

    // Print the inline Emoji detection script if it is not already printed.
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    // Print the important emoji-related styles.
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    // Convert emoji to a static img element.
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    // Convert emoji in emails into static images.
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

// Add Insert Button
add_action('init', 'tiny_mce_new_buttons');
function tiny_mce_new_buttons() {
    add_filter('mce_external_plugins', 'tiny_mce_add_buttons');
    add_filter('mce_buttons', 'tiny_mce_register_buttons');
}

function tiny_mce_add_buttons( $plugins ) {
    $plugins['mytinymceplugin'] = get_template_directory_uri() . '/assets/tinymce-plugin.js';
    return $plugins;
}

function tiny_mce_register_buttons( $buttons ) {
    $newBtns = array('myblockquotebtn');
    $buttons = array_merge($buttons, $newBtns);
    return $buttons;
}

/**
 * Modifies TinyMCE's setting and button ordering
 *
 * @link   https://codex.wordpress.org/TinyMCE
 * @param  [type] $settings
 * @return void
 */
// add_filter('tiny_mce_before_init', 'clean_tinymce');
function clean_tinymce($settings) {
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
    $settings['toolbar1'] = 'formatselect,forecolor,bold,italic,underline,strikethrough,hr,blockquote,numlist,bullist,button,link,unlink,alignleft,aligncenter,alignright,outdent,indent,undo,redo,charmap,removeformat,pastetext,wp_help,myblockquotebtn';

    $settings['toolbar2'] = '';

    // $settings['block_formats'] = "base=p; Heading 1=h1; Heading 2=h2; Heading 3=h3;";

    return $settings;
}

//====================================================================
//  Add Button to TinyMCE
//====================================================================
add_action('admin_head', 'phos_add_tinymce_button');
function phos_add_tinymce_button() {
    global $typenow;
    // check user permissions
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }
    // verify the post type
    if(! in_array($typenow, array( 'post', 'page' )) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if (get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "phos_add_tinymce_plugin");
        add_filter('mce_buttons', 'phos_register_tc_button');
    }
}

function phos_add_tinymce_plugin($plugin_array) {
    $plugin_array['phos_tc_button'] = get_template_directory_uri() . '/assets/tinymce-plugin.js';
    return $plugin_array;
}

function phos_register_tc_button($buttons) {
    array_push($buttons, "phos_tc_button");
    return $buttons;
}

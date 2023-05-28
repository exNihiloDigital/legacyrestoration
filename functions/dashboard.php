<?php

/**
 * Removes default Wordpress hooks for security
 *
 * @link https://core.trac.wordpress.org/browser/tags/5.2.3/src/wp-includes/default-filters.php#L280
 * @link https://developer.wordpress.org/reference/hooks/wp_head/#more-information
 * @return void
 */
function remove_wordpress_defaults() {
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // removes all extra rss feed links
    remove_action( 'wp_head', 'feed_links', 2 ); // remove rss feed links
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_head', 'rsd_link' ); // remove really simple discovery link
    remove_action( 'wp_head', 'wlwmanifest_link' ); // remove wlwmanifest.xml (windows live writer)
    remove_action( 'wp_head', 'wp_generator' ); // remove wordpress version
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); // Remove shortlink
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action('wp_head', 'remove_wordpress_defaults');

/**
 * Changes 'Howdy' to 'Welcome' in the WordPress Admin Bar
 *
 * @param  object $wp_admin_bar
 * @return void
 */
function howdy_to_welcome( $wp_admin_bar ) {
    $account = $wp_admin_bar -> get_node('my-account');
    $welcome = str_replace('Howdy', 'Welcome', $account->title);

    $wp_admin_bar->add_node(
        array(
            'id'    => 'my-account',
            'title' => $welcome
        )
    );
}
add_filter('admin_bar_menu', 'howdy_to_welcome');


/**
 * Hide dashboard widgets for a cleaner interface
 *
 * @return void
 */
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
add_action('wp_dashboard_setup', 'hide_dashboard_widgets', 999);

/**
 * Remove adminbar menu items for a cleaner interface
 *
 * @link   https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_menu/
 * @param  object $dashboard
 * @return void
 */
function remove_adminbar_items( $dashboard ) {
    global $wp_admin_bar;

    $menu_bar_entries = (array) $wp_admin_bar->get_nodes();

    /**
     * Get the specific ID of every $wp_admin_bar item
     */
    $menu_full = [];

    foreach ( $menu_bar_entries as $menu ) {
        $menu_full[] = $menu->id;
    }

    /**
     * Manually list all the menu items we wish to keep
     */
    $menu_keep = array(
        'appearance',
        'dashboard',
        'edit-profile',
        'edit',
        'logout',
        'menu-toggle',
        'menus',
        'my-account',
        'my-sites-list',
        'my-sites-super-admin',
        'my-sites',
        'network-admin',
        'new-content',
        'new-example',
        'new-media',
        'new-page',
        'new-post',
        'new-user',
        'site-name',
        'top-secondary',
        'user-actions',
        'user-info',
        'view-site',
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
    $menus = array_diff($menu_full, $menu_keep);

    /**
     * Eliminate the differences, leaving only what we want in wp_admin_bar
     */
    foreach ($menus as $menu) {
        $dashboard->remove_menu( $menu );
    }
}
add_action('admin_bar_menu', 'remove_adminbar_items', 999);

/**
 * Remove admin panel comment entry
 *
 * @link   https://codex.wordpress.org/Function_Reference/remove_menu_page
 * @return void
 */
function remove_adminmenu_items() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_adminmenu_items');

/**
 * Filter default post labels globally
 *
 * @return void
 */
function edit_posts_labels() {
    global $wp_post_types;

    $labels                     = &$wp_post_types['post']->labels;
    $labels->add_new            = 'Add Blog Post';
    $labels->add_new_item       = 'Add Blog';
    $labels->all_items          = 'All Blog Posts';
    $labels->edit_item          = 'Edit Blog';
    $labels->menu_name          = 'Blog';
    $labels->name               = 'Blogs';
    $labels->name_admin_bar     = 'Blog';
    $labels->new_item           = 'Blog';
    $labels->not_found          = 'No Blog found';
    $labels->not_found_in_trash = 'No Blog found in Trash';
    $labels->search_items       = 'Search Blog';
    $labels->singular_name      = 'Blog';
    $labels->view_item          = 'View Blog';
}
add_action('init', 'edit_posts_labels');

/**
 * Create dashboard menu separators
 *
 * @param  int $position
 * @return void
 */
function create_separator( $position ) {
    /**
     * @var array
     */
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
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @return void
 */
function assign_separator() {
    foreach ( range(1000, 1040) as $position ) {
        create_separator($position);
    }
}
add_action('admin_menu', 'assign_separator');

/**
 * Control admin panel sorting - deactivated until needed
 *
 * @link https://developer.wordpress.org/reference/hooks/custom_menu_order/
 * @link https://developer.wordpress.org/reference/hooks/menu_order/
 * @param  array $order
 * @return void
 */
function organize_dashboard_menu( $order ) {
    if ( ! $order ) {
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
// add_filter('custom_menu_order', '__return_true');
// add_filter('menu_order', 'organize_dashboard_menu');

/**
 * Moves Yoast meta boxes to the bottom of posts and pages
 *
 * @return void
 */
function yoast_to_bottom() {
    return 'low';
}
add_filter('wpseo_metabox_prio', 'yoast_to_bottom');

/**
 * Remove emoji support
 *
 * @link   https://codex.wordpress.org/Emoji
 * @return void
 */
function remove_emojis() {
    // Remove the DNS prefetch by returning false
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
add_action('init', 'remove_emojis');

/**
 * Add Insert Button
 *
 * @return void
 */
function tiny_mce_new_buttons() {
    add_filter('mce_external_plugins', 'tiny_mce_add_buttons');
    add_filter('mce_buttons', 'tiny_mce_register_buttons');
}
// add_action('init', 'tiny_mce_new_buttons');

/**
 * Help by inserting a proper description of the function
 *
 * @param array $plugins
 * @return array
 */
function tiny_mce_add_buttons( $plugins ) {
    $plugins['mytinymceplugin'] = get_template_directory_uri() . '/assets/tinymce-plugin.js';

    return $plugins;
}

/**
 * Help by inserting a proper description of the function
 *
 * @param array
 * @return array
 */
function tiny_mce_register_buttons( $buttons ) {
    $newBtns = array('myblockquotebtn');
    $buttons = array_merge($buttons, $newBtns);
    return $buttons;
}

/**
 * Modifies TinyMCE's setting and button ordering
 *
 * @link   https://codex.wordpress.org/TinyMCE
 * @param  array $settings
 * @return array
 */
function clean_tinymce( $settings ) {
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
// add_filter('tiny_mce_before_init', 'clean_tinymce');

/**
 * Add Button to TinyMCE
 *
 * @link   https://codex.wordpress.org/TinyMCE
 * @return void
 */
function custom_add_tinymce_button() {
    global $typenow;

    $can_edit       = current_user_can('edit_pages') && current_user_can('edit_posts');
    $is_activated   = 'true' === get_user_option('rich_editing');
    $is_verified    = in_array($typenow, array( 'post', 'page' ) );

    if ( $is_activated && $is_verified && $can_edit) {
        add_filter('mce_external_plugins', 'custom_add_tinymce_plugin');
        add_filter('mce_buttons', 'custom_register_tc_button');
    }
}
// add_action('admin_head', 'custom_add_tinymce_button');

/**
 * Add Button to TinyMCE
 *
 * @link   https://codex.wordpress.org/TinyMCE
 * @param  array $settings
 * @return array
 */
function custom_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['custom_tc_button'] = get_template_directory_uri() . '/assets/tinymce-plugin.js';

    return $plugin_array;
}

/**
 * Add Button to TinyMCE
 *
 * @link   https://codex.wordpress.org/TinyMCE
 * @param  array $buttons
 * @return array
 */
function custom_register_tc_button( $buttons ) {
    $buttons[] = 'custom_tc_button';

    return $buttons;
}

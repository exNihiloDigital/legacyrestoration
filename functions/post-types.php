<?php

/**
 * Foreach post type & taxonomy registration
 *
 * @link https://codex.wordpress.org/Post_Types#Custom_Post_Types
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function post_types()
{
    global $wp_post_types;
    global $wp_taxonomies;

    $post_types = array(
        array(
            'slug'        => 'locations',
            'single_name' => 'Location',
            'plural_name' => 'Locations',
            'menu_name'   => 'Locations',
            'description' => '',
            // https://developer.wordpress.org/resource/dashicons/#microphone
            'dashicon'    => 'dashicons-location-alt'
        )
    );

    foreach ($post_types as $post_type) {
        $post_type_labels = array(
            'name'                  => _x($post_type["plural_name"], 'Post Type General Name', 'custom'),
            'singular_name'         => _x($post_type["single_name"], 'Post Type Singular Name', 'custom'),
            'menu_name'             => __($post_type["menu_name"], 'custom'),
            'name_admin_bar'        => __($post_type["plural_name"], 'custom'),
            'archives'              => __($post_type["single_name"] . ' Archives', 'custom'),
            'attributes'            => __($post_type["single_name"] . ' Attributes', 'custom'),
            'parent_item_colon'     => __('Parent ' . $post_type["single_name"], 'custom'),
            'all_items'             => __('All ' . $post_type["plural_name"], 'custom'),
            'add_new_item'          => __('Add New ' . $post_type["single_name"], 'custom'),
            'add_new'               => __('Add New ' . $post_type["single_name"], 'custom'),
            'new_item'              => __('New ' . $post_type["single_name"], 'custom'),
            'edit_item'             => __('Edit ' . $post_type["single_name"], 'custom'),
            'update_item'           => __('Update ' . $post_type["single_name"], 'custom'),
            'view_item'             => __('View ' . $post_type["single_name"], 'custom'),
            'view_items'            => __('View ' . $post_type["single_name"], 'custom'),
            'search_items'          => __('Search ' . $post_type["single_name"], 'custom'),
            'not_found'             => __('Not found', 'custom'),
            'not_found_in_trash'    => __('Not found in Trash', 'custom'),
            'featured_image'        => __($post_type["single_name"] . ' Image', 'custom'),
            'set_featured_image'    => __('Set ' . $post_type["single_name"] . ' image', 'custom'),
            'remove_featured_image' => __('Remove ' . $post_type["single_name"] . ' image', 'custom'),
            'use_featured_image'    => __('Use as ' . $post_type["single_name"] . ' image', 'custom'),
            'insert_into_item'      => __('Insert into ' . $post_type["single_name"], 'custom'),
            'uploaded_to_this_item' => __('Uploaded to this ' . $post_type["single_name"], 'custom'),
            'items_list'            => __($post_type["single_name"] . ' list', 'custom'),
            'items_list_navigation' => __($post_type["single_name"] . ' list navigation', 'custom'),
            'filter_items_list'     => __('Filter ' . $post_type["single_name"] . ' list', 'custom')
        );

        $post_types_args = array(
            'label'                 => __($post_type["single_name"], 'custom'),
            'description'           => __($post_type["description"], 'custom'),
            'labels'                => $post_type_labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            // 'taxonomies'            => array('example', 'post_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => $post_type["dashicon"],
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page'
        );

        $slug = $post_type['slug'];

        /**
         * Gutenberg & Rest API Support
         */
        if (isset($wp_post_types[$slug])) {
            $wp_post_types[$slug]->show_in_rest = true;
            $wp_post_types[$slug]->rest_base = $slug;
            $wp_post_types[$slug]->rest_controller_class = 'WP_REST_Posts_Controller';
        }

        register_post_type($post_type['slug'], $post_types_args);
    }

    $taxonomies = array(
        array(
            'slug'        => 'example',
            'single_name' => 'Example',
            'plural_name' => 'Examples',
            'menu_name'   => '→ Examples',
            // This is where you sync the taxonomy to the post types above
            'post_type'   => 'example'
        )
    );

    foreach ($taxonomies as $taxonomy) {
        $taxonomy_labels = array(
            'name'              => $taxonomy["plural_name"],
            'singular_name'     => $taxonomy["single_name"],
            'search_items'      => 'Search ' . $taxonomy["plural_name"],
            'all_items'         => 'All ' . $taxonomy["plural_name"],
            'parent_item'       => 'Parent ' . $taxonomy["single_name"],
            'parent_item_colon' => 'Parent ' . $taxonomy["single_name"] . ':',
            'edit_item'         => 'Edit ' . $taxonomy["single_name"],
            'update_item'       => 'Update ' . $taxonomy["single_name"],
            'add_new_item'      => 'Add New ' . $taxonomy["single_name"],
            'new_item_name'     => 'New ' . $taxonomy["single_name"] . ' Name',
            'menu_name'         => $taxonomy["menu_name"]
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true
        );

        $slug = $taxonomy['slug'];

        /**
         * Gutenberg & Rest API Support
         */
        // if (isset($wp_post_types[$slug])) {
        //     $wp_post_types[$slug]->show_in_rest = true;
        //     $wp_post_types[$slug]->rest_base = $slug;
        //     $wp_post_types[$slug]->rest_controller_class = 'WP_REST_Posts_Controller';
        // }

        register_taxonomy($taxonomy["slug"], $taxonomy["post_type"], $taxonomy_args);
    }
}
add_action('init', 'post_types');

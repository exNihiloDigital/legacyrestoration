<?php

/**
 * Foreach post type & taxonomy registration
 *
 * @link https://codex.wordpress.org/Post_Types#Custom_Post_Types
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
add_action('init', 'post_types');
function post_types()
{
    global $wp_post_types;
    global $wp_taxonomies;

    $post_types = array(
        array(
            'slug'        => 'example',
            'single_name' => 'Example',
            'plural_name' => 'Examples',
            'menu_name'	  => 'Example',
            'description' => '',
            // https://developer.wordpress.org/resource/dashicons/#microphone
            'dashicon'    => 'dashicons-menu'
        )
    );

    foreach ($post_types as $post_type) {
        $post_type_labels = array(
            'name'                  => _x($post_type["plural_name"], 'Post Type General Name', 'phos'),
            'singular_name'         => _x($post_type["single_name"], 'Post Type Singular Name', 'phos'),
            'menu_name'             => __($post_type["menu_name"], 'phos'),
            'name_admin_bar'        => __($post_type["plural_name"], 'phos'),
            'archives'              => __($post_type["single_name"] . ' Archives', 'phos'),
            'attributes'            => __($post_type["single_name"] . ' Attributes', 'phos'),
            'parent_item_colon'     => __('Parent ' . $post_type["single_name"], 'phos'),
            'all_items'             => __('All ' . $post_type["plural_name"], 'phos'),
            'add_new_item'          => __('Add New ' . $post_type["single_name"], 'phos'),
            'add_new'               => __('Add New ' . $post_type["single_name"], 'phos'),
            'new_item'              => __('New ' . $post_type["single_name"], 'phos'),
            'edit_item'             => __('Edit ' . $post_type["single_name"], 'phos'),
            'update_item'           => __('Update ' . $post_type["single_name"], 'phos'),
            'view_item'             => __('View ' . $post_type["single_name"], 'phos'),
            'view_items'            => __('View ' . $post_type["single_name"], 'phos'),
            'search_items'          => __('Search ' . $post_type["single_name"], 'phos'),
            'not_found'             => __('Not found', 'phos'),
            'not_found_in_trash'    => __('Not found in Trash', 'phos'),
            'featured_image'        => __($post_type["single_name"] . ' Image', 'phos'),
            'set_featured_image'    => __('Set ' . $post_type["single_name"] . ' image', 'phos'),
            'remove_featured_image' => __('Remove ' . $post_type["single_name"] . ' image', 'phos'),
            'use_featured_image'    => __('Use as ' . $post_type["single_name"] . ' image', 'phos'),
            'insert_into_item'      => __('Insert into ' . $post_type["single_name"], 'phos'),
            'uploaded_to_this_item' => __('Uploaded to this ' . $post_type["single_name"], 'phos'),
            'items_list'            => __($post_type["single_name"] . ' list', 'phos'),
            'items_list_navigation' => __($post_type["single_name"] . ' list navigation', 'phos'),
            'filter_items_list'     => __('Filter ' . $post_type["single_name"] . ' list', 'phos')
        );

        $post_types_args = array(
            'label'                 => __($post_type["single_name"], 'phos'),
            'description'           => __($post_type["description"], 'phos'),
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
        if (isset($wp_post_types[$slug])) {
            $wp_post_types[$slug]->show_in_rest = true;
            $wp_post_types[$slug]->rest_base = $slug;
            $wp_post_types[$slug]->rest_controller_class = 'WP_REST_Posts_Controller';
        }

        register_taxonomy($taxonomy["slug"], $taxonomy["post_type"], $taxonomy_args);
    }
}

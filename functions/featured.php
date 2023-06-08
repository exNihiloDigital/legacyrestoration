<?php

/**
 * Featured titles, images, and styles
 */
function featured( $key )
{
    /**
     * Set the empty arrays
     */
    $title = [];
    $image = [];
    $alt = [];

    /**
     * Set alt to false
     */
    array_push($alt, false);

    /**
     * This is where we can set titles, images, and whether the featured element has an alt class for alternative styling.
     *
     * We use array_push() for a cleaner method of putting each value into an array to be processed automatically for us later.
     *
     * array_push($title, '');
     * array_push($image, '');
     * array_push($alt, '');
     */
    if (is_paged() ) {
        array_push($title, get_the_archive_title());
        array_push($alt, true);
    }

    if (is_home() || is_home() && is_paged() ) {
        array_push($title, 'Blog');

        if (get_queried_object() && get_queried_object() -> ID ) {
            $id = get_queried_object() -> ID;
            $thumb = get_post_thumbnail_id($id);
            $att = wp_get_attachment_image_src($thumb, 'full')[0];

            array_push($image, $att);
        } else {
            array_push($image, get_theme_file_uri() . '/images/featured.jpg');
        }
    }

    if (is_page() ) {
        array_push($title, get_the_title());
    }

    if (is_single() ) {
        array_push($title, get_the_title());
        array_push($image, get_theme_file_uri() . '/images/featured.jpg');
    }

    if (is_date() ) {
        array_push($title, get_the_archive_title());
    }

    if (is_author() ) {
        array_push($title, get_the_author());
        array_push($alt, true);
    }

    if (is_attachment() ) {
        array_push($title, get_the_title());
        array_push($alt, true);
    }

    if  (is_category() ) {
        array_push($title, single_cat_title('', false));
        array_push($image, esc_url(get_theme_file_uri()) . '/images/featured.jpg');
    }

    if (is_archive() ) {
        array_push($title, single_cat_title('', false));
        array_push($image, esc_url(get_theme_file_uri()) . '/images/featured.jpg');
    }

    if (is_post_type_archive('locations') ) {
        array_push($title, 'Locations');
        array_push($alt, false);
    }

    if (is_post_type_archive('example') && is_paged() ) {
        array_push($title, 'Examples');
        array_push($alt, true);
    }

    if (is_search() ) {
        array_push($title, 'Search: ' . get_search_query());
        array_push($alt, true);
    }

    if (! $image) {
        if (has_post_thumbnail() ) {
            array_push($image, wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0]);
        } else {
            array_push($image, esc_url(get_theme_file_uri()) . '/images/featured.jpg');
        }
    }

    /**
     * We need to check if there are more than 1 entries to each array and either get the last or the only value.
     */
    $title = count($title) > 1 ? end($title) : $title[0];
    $image = count($image) > 1 ? end($image) : $image[0];
    $alt = count($alt) > 1 ? end($alt) : $alt[0];

    /**
     * Because a boolean in an array returns 1 or null we'd like $alt to echo 'alt' if true for styling purposes.
     */
    $alt = $alt === '1' ? 'alt' : '';

    /**
     * Store processed arguments into an array.
     */
    $data = array(
        'alt'   => $alt,
        'image' => $image,
        'title' => $title
    );

    /**
     * When featured() is called we can access the array's values directly.
     */
    echo $data[$key];
}

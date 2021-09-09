<?php

/**
 * Sets theme defaults and registers support for various WordPress features
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support
 */
function phos_supports()
{
    $content_width = 800;

    add_theme_support('html5');
    add_theme_support('post-thumbnails');

    /**
     * Yoast support
     */
    add_theme_support('title-tag');
    add_theme_support('yoast-seo-breadcrumbs');

    /**
     * Gutenberg
     *
     * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
     */
    $editor_colors = array(
        array(
            'name' => __('PHOS Yellow'),
            'slug' => 'phos-yellow',
            'color' => '#f5c71f',
        ),
        array(
            'name' => __('PHOS Blue'),
            'slug' => 'phos-blue',
            'color' => '#113751',
        ),
        array(
            'name' => __('PHOS Dark Blue'),
            'slug' => 'phos-dark-blue',
            'color' => '#0a192c',
        )
    );

    add_theme_support('align-wide');
    add_theme_support('editor-color-palette', $editor_colors);
    add_theme_support('disable-custom-colors');
}
add_action('after_setup_theme', 'phos_supports');

/**
 * Join posts and postsmeta tables so we can search custom fields
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function search_join($join)
{
    global $wpdb;

    if (is_search()) {
        $join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'search_join');

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function search_where($where)
{
    global $pagenow, $wpdb;

    if (is_search()) {
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)",
            $where
        );
    }

    return $where;
}
add_filter('posts_where', 'search_where');

/**
 * Prevent duplicates in search
 */
function search_distinct($where)
{
    global $wpdb;

    if (is_search()) {
        return "DISTINCT";
    }

    return $where;
}
add_filter('posts_distinct', 'search_distinct');

/**
 * Gets post ID as a conditional for it's children
 *
 * @link https://css-tricks.com/snippets/wordpress/if-page-is-parent-or-child
 */
function is_tree($page_id)
{
    global $post;

    if (is_page() && ($post->post_parent==$page_id || is_page($page_id))) {
        return true;
    } else {
        return false;
    }
};

/**
* Limits the_excerpt() to a three sentences rather than a word limit
*/
function filter_excerpt($excerpt)
{
    $allowed_ends = array('.', '!', '?', '...');
    $number_sentences = 1;
    $excerpt_chunk = $excerpt;

    for ($i = 0; $i < $number_sentences; $i++) {
        $lowest_sentence_end[$i] = 100000000000000000;

        foreach ($allowed_ends as $allowed_end) {
            $sentence_end = strpos($excerpt_chunk, $allowed_end);

            if ($sentence_end !== false && $sentence_end < $lowest_sentence_end[$i]) {
                $lowest_sentence_end[$i] = $sentence_end + strlen($allowed_end);
            }

            $sentence_end = false;
        }

        $sentences[$i] = substr($excerpt_chunk, 0, $lowest_sentence_end[$i]);
        $excerpt_chunk = substr($excerpt_chunk, $lowest_sentence_end[$i]);
    }

    return implode('', $sentences);
}
add_filter('get_the_excerpt', 'filter_excerpt');

/**
 * Replaces [...] with a "Read More" button in the_excerpt() & the_content()
 */
function filter_read_more($more)
{
    return '<a href="' . get_permalink() . '" class="button">Read More</a>';
}
add_filter('excerpt_more', 'filter_read_more');

/**
 * Paginates a numeric list in archive, index, and search templates
 */
function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;

    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }

    if ($pages == '') {
        global $wp_query;

        $pages = $wp_query->max_num_pages;

        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
        if ($paged > 2 && $paged > $range+1 && $showitems < $pages) {
            echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        }
        if ($paged > 1 && $showitems < $pages) {
            echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
        }

        for ($i=1; $i <= $pages; $i++) {
            if (1 != $pages &&(!($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems)) {
                echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
            }
        }

        if ($paged < $pages && $showitems < $pages) {
            echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        }
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
            echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        }
        echo "</div>\n";
    }
}

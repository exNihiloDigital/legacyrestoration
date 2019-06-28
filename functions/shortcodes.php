<?php

/**
 * [accordion name="$name"] shortcode
 * .h2+.accordion>.block>.title>span^+.content
 */
add_shortcode('accordion', 'shortcode_accordion');
function shortcode_accordion($atts)
{
    $atts = shortcode_atts(
        array(
            'name' => get_field('accordions')['name']
        ),
        $atts,
        'accordion'
    );

    if (have_rows('accordions')) {
        while (have_rows('accordions')) {
            the_row();

            $compare = false;

            foreach ($atts as $att) {
                if ($att == get_sub_field('name')) {
                    $compare = true;
                }
            }

            if ($compare) {
                $output .= '<h2>' . get_sub_field('header') . '</h2>';

                if (have_rows('fields')) {
                    $output .= '<div class="accordion">';

                    while (have_rows('fields')) {
                        the_row();


                        $output .= '<div class="block">';

                        $output .= '<div class="title">';
                        $output .= '<span>' . get_sub_field('title') . '</span><i class="fas fa-plus"></i>';
                        $output .= '</div>';

                        $output .= '<div class="content">';
                        $output .= get_sub_field('content');
                        $output .= '</div>';

                        $output .= '</div>';
                    }

                    $output .= '</div>';
                }
            }
        }
    }

    return $output;
}

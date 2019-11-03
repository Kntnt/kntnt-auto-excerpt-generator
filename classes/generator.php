<?php

namespace Kntnt\Auto_Excerpt_Generator;

class Generator {

    public function __construct() {
        $this->ns = Plugin::ns();
    }

    public function run() {
        remove_filter( 'get_the_excerpt', 'wp_trim_excerpt', 10 );
        add_filter( 'get_the_excerpt', [ $this, 'get_the_excerpt' ], 10, 2 );
    }

    public function get_the_excerpt( $excerpt, $post ) {

        if ( '' == $excerpt && ( $field = Plugin::option( 'field', '' ) ) ) {
            $excerpt = Plugin::get_field( $field, $post );
        }

        if ( '' == $excerpt ) {
            // Similar to wp_trim_excerpt().
            $excerpt = get_the_content( '', false, $post );
            $excerpt = strip_shortcodes( $excerpt );
            $excerpt = excerpt_remove_blocks( $excerpt );
            $excerpt = apply_filters( 'the_content', $excerpt );
            $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
            $excerpt = substr( $excerpt, 0, strpos( $excerpt, '</p>' ) + 4 );
            $excerpt = wp_strip_all_tags( $excerpt, true );
            $excerpt = apply_filters( 'wp_trim_excerpt', $excerpt, '' );
        }

        return $excerpt;
    }

}

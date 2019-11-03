<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Auto Excerpt Generator
 * Plugin URI:        https://github.com/Kntnt/kntnt-auto-excerpt-generator
 * GitHub Plugin URI: https://github.com/Kntnt/kntnt-auto-excerpt-generator
 * Description:       Generates a better auto excerpt than WordPress builtin.
 * Version:           1.0.2
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Kntnt\Auto_Excerpt_Generator;

defined( 'WPINC' ) && new Plugin();

final class Plugin {

    // If an ACF field with following slug exists, the field's value is used as
    // auto excerpt. Otherwise the first paragraph of the body text is used.
    private $acf_field_slug = 'lead';

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'run' ] );
    }

    public function run() {
        remove_filter( 'get_the_excerpt', 'wp_trim_excerpt', 10 );
        add_filter( 'get_the_excerpt', [ $this, 'get_the_excerpt' ], 10, 2 );
    }

    public function get_the_excerpt( $excerpt, $post ) {

        if ( '' == $excerpt ) {
            if ( function_exists( '\get_field' ) && ( $lead = \get_field( $this->acf_field_slug, $post ) ) ) {
                $excerpt = $lead;
            }
            else {
                // See wp_trim_excerpt().
                $raw_excerpt = $excerpt;
                $excerpt = get_the_content( '', false, $post );
                $excerpt = strip_shortcodes( $excerpt );
                $excerpt = excerpt_remove_blocks( $excerpt );
                $excerpt = apply_filters( 'the_content', $excerpt );
                $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
                $excerpt = substr( $excerpt, 0, strpos( $excerpt, '</p>' ) + 4 );
                $excerpt = apply_filters( 'wp_trim_excerpt', $excerpt, $raw_excerpt );
            }
        }
        return $excerpt;
    }

}

<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt's auto excerpt generator.
 * Plugin URI:        https://github.com/TBarregren/kntnt-auto-excerpt-from-acf-field
 * Description:       Generates a better auto excerpt than WordPress builtin.
 * Version:           1.0.1
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
        add_filter( 'get_the_excerpt', [ $this, 'get_the_excerpt' ], 10, 2 );
        add_filter( 'get_post_metadata', [ $this, 'get_post_metadata' ], 10, 4 );
    }

    public function get_the_excerpt( $excerpt, $post ) {
        if ( '' == $excerpt ) {
            if ( function_exists( '\get_field' ) && ( $lead = \get_field( $this->acf_field_slug, $post ) ) ) {
                $excerpt = $lead;
            }
            else {
                $excerpt = get_the_content();
                $excerpt = strip_shortcodes( $excerpt );
                $excerpt = apply_filters( 'the_content', $excerpt );
                $excerpt = substr( $excerpt, 0, strpos( $excerpt, '</p>' ) + 4 );
            }
        }
        return $excerpt;
    }

    public function get_post_metadata( $meta_value, $post_id, $meta_key, $single ) {

        static $enabled = true;

        if ( $enabled && '_genesis_description' == $meta_key ) {

            $enabled = false;
            $meta_value = get_metadata( 'post', $post_id, $meta_key, $single );
            $enabled = true;

            if ( ! $meta_value ) {
                $meta_value = trim( strip_tags( get_the_excerpt( $post_id ) ) );
            }

        }

        return $meta_value;

    }

}

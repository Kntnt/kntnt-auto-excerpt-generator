<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt's auto excerpt generator.
 * Plugin URI:        https://github.com/TBarregren/kntnt-auto-excerpt-from-acf-field
 * Description:       Generates a better auto excerpt than WordPress builtin.
 * Version:           1.0.0
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
    add_filter( 'wp_trim_excerpt', [ $this, 'wp_trim_excerpt' ], 10, 2 );
    add_filter( 'get_post_metadata', [ $this, 'get_post_metadata' ], 10, 4 );
  }
  
  public function wp_trim_excerpt( $text, $raw_excerpt ) {
    if( ! $raw_excerpt ) {
      if ( function_exists( 'get_field' ) && ( $lead = get_field( $this->acf_field_slug ) ) ) {
        $text = strip_tags( $lead );
      }
      else {
        $text = get_the_content();
        $text = strip_shortcodes( $text );
        $text = apply_filters( 'the_content', $text );
        $text = substr( $text, 0, strpos( $text, '</p>' ) + 4 );
      }
    }
    return $text;
  }

  public function get_post_metadata( $meta_value, $object_id, $meta_key, $single ) {
    if ( "_genesis_description" == $meta_key ) {
      return get_the_excerpt( $object_id );
    }
  }

}

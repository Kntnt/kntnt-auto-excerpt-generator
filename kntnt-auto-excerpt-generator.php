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

add_filter('wp_trim_excerpt', function ($text, $raw_excerpt) {

  // If an ACF field with following slug exists, the field's value is used as
  // auto excerpt. Otherwise the first paragraph of the body text is used.
  $acf_field_slug = 'lead';

  if(!$raw_excerpt) {

    if (function_exists('get_field') && ($lead=get_field($acf_field_slug))) {
      $text = $lead;
    }
    else {
      $text = get_the_content();
      $text = strip_shortcodes($text);
      $text = apply_filters('the_content', $text);
      $text = substr($text, 0, strpos( $text, '</p>') + 4);
    }

  }

  return $text;

}, 10, 2);


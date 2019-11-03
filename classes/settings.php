<?php

namespace Kntnt\Auto_Excerpt_Generator;

require_once Plugin::plugin_dir( 'classes/abstract-settings.php' );

class Settings extends Abstract_Settings {

    /**
     * Returns the settings menu title.
     */
    protected function menu_title() {
        return __( 'Auto Excerpt', 'kntnt-auto-excerpt-generator' );
    }

    /**
     * Returns the settings page title.
     */
    protected function page_title() {
        return __( "Kntnt Auto Excerpt Generator", 'kntnt-auto-excerpt-generator' );
    }

    /**
     * Returns all fields used on the settings page.
     */
    protected function fields() {

        $fields['field'] = [
            'type' => 'text',
            'label' => __( 'Field', 'kntnt-auto-excerpt-generator' ),
            'size' => 80,
            'description' => __( 'If a post is missing an excerpt, the text in the <a href="https://wordpress.org/support/article/custom-fields/">custom filed</a> or <a href="https://wordpress.org/plugins/advanced-custom-fields/">ACF Field</a> named above is used instead. If the named field is empty, or no valid name is provided, the first paragraph of the body is used instead.', 'kntnt-auto-excerpt-generator' ),
        ];

        $fields['submit'] = [
            'type' => 'submit',
        ];

        return $fields;

    }

}

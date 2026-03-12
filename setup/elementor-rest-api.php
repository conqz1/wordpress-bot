<?php
/**
 * Plugin Name: Elementor REST API Meta Access
 * Description: Exposes _elementor_data and related meta fields via the WordPress REST API.
 *              Required by the Elementor Bot to create pages programmatically.
 * Version:     1.0.0
 *
 * INSTALLATION:
 *   Copy this file to:  wp-content/mu-plugins/elementor-rest-api.php
 *   (Create the mu-plugins folder if it does not exist.)
 *   Must-use plugins load automatically — no activation needed.
 */

add_action( 'init', function () {
    $fields = [
        '_elementor_data'          => 'string',
        '_elementor_edit_mode'     => 'string',
        '_elementor_template_type' => 'string',
        '_elementor_version'       => 'string',
    ];

    foreach ( $fields as $key => $type ) {
        register_post_meta( '', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can( 'edit_posts' );
            },
        ] );
    }
} );

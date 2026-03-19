<?php
/**
 * gardenhouse-plumbing-theme functions and definitions
 */

function gardenhouse_plumbing_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script'
    ) );
}
add_action( 'after_setup_theme', 'gardenhouse_plumbing_theme_setup' );

function gardenhouse_plumbing_theme_scripts() {
    wp_enqueue_style(
        'gardenhouse-plumbing-theme-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'gardenhouse_plumbing_theme_scripts' );

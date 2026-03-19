<?php
/**
 * jordana-raiskin-therapy functions and definitions
 */

function jordana_raiskin_therapy_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script'
    ) );
}
add_action( 'after_setup_theme', 'jordana_raiskin_therapy_setup' );

function jordana_raiskin_therapy_scripts() {
    wp_enqueue_style(
        'jordana-raiskin-therapy-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'jordana_raiskin_therapy_scripts' );

function jordana_raiskin_therapy_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'jordana_raiskin_therapy_content', array(
        'title'    => 'Site Content',
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'hero_label', array(
        'default'           => 'Austin, Texas Psychotherapist',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_label', array(
        'label'   => 'Hero Label',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_headline', array(
        'default'           => 'Life should be more than just coping',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_headline', array(
        'label'   => 'Hero Headline',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_subtext', array(
        'default'           => 'You want to feel comfortable in your own skin. You want to feel confident of yourself and your decisions. You want to laugh spontaneously, and feel connected to the people around you.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_subtext', array(
        'label'   => 'Hero Subtext',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_cta', array(
        'default'           => 'Begin Your Journey',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_cta', array(
        'label'   => 'Hero Cta',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_cta_secondary', array(
        'default'           => 'Learn About Therapy',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_cta_secondary', array(
        'label'   => 'Hero Cta Secondary',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'about_label', array(
        'default'           => 'My Approach',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'about_label', array(
        'label'   => 'About Label',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'about_headline', array(
        'default'           => 'Meeting you where you are',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'about_headline', array(
        'label'   => 'About Headline',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'quote_text', array(
        'default'           => 'A dream you dream alone is only a dream. A dream you dream together is reality.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'quote_text', array(
        'label'   => 'Quote Text',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'quote_author', array(
        'default'           => 'John Lennon',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'quote_author', array(
        'label'   => 'Quote Author',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'specialties_label', array(
        'default'           => 'Areas of Focus',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'specialties_label', array(
        'label'   => 'Specialties Label',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'specialties_headline', array(
        'default'           => 'What I can help with',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'specialties_headline', array(
        'label'   => 'Specialties Headline',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'why_label', array(
        'default'           => 'Why Therapy',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'why_label', array(
        'label'   => 'Why Label',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'why_headline', array(
        'default'           => 'A safe space to explore and grow',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'why_headline', array(
        'label'   => 'Why Headline',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'cta_headline', array(
        'default'           => 'Ready to take the first step?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'cta_headline', array(
        'label'   => 'Cta Headline',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'cta_subtext', array(
        'default'           => 'Reaching out is the hardest part. I\'m here to make the rest of the journey easier.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'cta_subtext', array(
        'label'   => 'Cta Subtext',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'cta_button', array(
        'default'           => 'Contact Me Today',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'cta_button', array(
        'label'   => 'Cta Button',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_description', array(
        'default'           => 'Helping individuals in Austin, Texas navigate life\'s challenges and discover a more vibrant, connected, purposeful way of living.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_description', array(
        'label'   => 'Footer Description',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_location', array(
        'default'           => 'Austin, Texas',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_location', array(
        'label'   => 'Footer Location',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_credentials', array(
        'default'           => 'Licensed Clinical Social Worker',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_credentials', array(
        'label'   => 'Footer Credentials',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_contact_link', array(
        'default'           => 'Send a Message →',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_contact_link', array(
        'label'   => 'Footer Contact Link',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_copyright', array(
        'default'           => 'Jordana Raiskin LCSW',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_copyright', array(
        'label'   => 'Footer Copyright',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_tagline', array(
        'default'           => 'Life should be more than just coping.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_tagline', array(
        'label'   => 'Footer Tagline',
        'section' => 'jordana_raiskin_therapy_content',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'jordana_raiskin_therapy_customize_register' );

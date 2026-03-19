<?php
/**
 * menuboard-manager-theme functions and definitions
 */

function menuboard_manager_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script'
    ) );
}
add_action( 'after_setup_theme', 'menuboard_manager_theme_setup' );

function menuboard_manager_theme_scripts() {
    wp_enqueue_style(
        'menuboard-manager-theme-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'menuboard_manager_theme_scripts' );

function menuboard_manager_theme_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'menuboard_manager_theme_content', array(
        'title'    => 'Site Content',
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'topbar_rating', array(
        'default'           => '4.9 Stars',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_rating', array(
        'label'   => 'Topbar Rating',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'topbar_reviews', array(
        'default'           => 'on Google Reviews',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_reviews', array(
        'label'   => 'Topbar Reviews',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'topbar_badge', array(
        'default'           => 'Veteran-Owned Business',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_badge', array(
        'label'   => 'Topbar Badge',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'topbar_integration', array(
        'default'           => 'Official Toast® Integration Partner',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_integration', array(
        'label'   => 'Topbar Integration',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'topbar_cta', array(
        'default'           => 'Get Started Free',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_cta', array(
        'label'   => 'Topbar Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'nav_cta', array(
        'default'           => 'Book a Demo',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'nav_cta', array(
        'label'   => 'Nav Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_label', array(
        'default'           => '#1 Digital Menu Board Software for Restaurants',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_label', array(
        'label'   => 'Hero Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_headline', array(
        'default'           => 'Sell More Food, Faster',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_headline', array(
        'label'   => 'Hero Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'hero_subtext', array(
        'default'           => 'Elevate your restaurant with stunning digital menu boards. Easy to update, fully customizable, and integrated with your POS system.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hero_subtext', array(
        'label'   => 'Hero Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'features_label', array(
        'default'           => 'Top Features',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'features_label', array(
        'label'   => 'Features Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'features_headline', array(
        'default'           => 'Everything You Need to Sell More',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'features_headline', array(
        'label'   => 'Features Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'features_subtext', array(
        'default'           => 'Our digital menu board software is built specifically for restaurants. Here\'s what sets us apart.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'features_subtext', array(
        'label'   => 'Features Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'amazon_label', array(
        'default'           => 'Hardware Made Simple',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'amazon_label', array(
        'label'   => 'Amazon Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'amazon_headline', array(
        'default'           => 'Amazon Signage',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'amazon_headline', array(
        'label'   => 'Amazon Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'amazon_desc', array(
        'default'           => 'Run your digital menu boards on affordable Amazon Fire TV Stick hardware. Plug in, connect to your account, and your menus are live in minutes.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'amazon_desc', array(
        'label'   => 'Amazon Desc',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'amazon_cta', array(
        'default'           => 'Learn More',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'amazon_cta', array(
        'label'   => 'Amazon Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'command_label', array(
        'default'           => 'Powerful & Intuitive',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'command_label', array(
        'label'   => 'Command Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'command_headline', array(
        'default'           => 'Your Menu Command Center',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'command_headline', array(
        'label'   => 'Command Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'command_subtext', array(
        'default'           => 'See how easy it is to manage your digital menus from our cloud-based dashboard. Control every screen, every location.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'command_subtext', array(
        'label'   => 'Command Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'command_cta', array(
        'default'           => 'Start Managing Your Menus',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'command_cta', array(
        'label'   => 'Command Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pricing_label', array(
        'default'           => 'Transparent Pricing',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pricing_label', array(
        'label'   => 'Pricing Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pricing_headline', array(
        'default'           => 'Simple, Per-Screen Pricing',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pricing_headline', array(
        'label'   => 'Pricing Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pricing_subtext', array(
        'default'           => 'No hidden fees. No long-term contracts. Scale as you grow.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pricing_subtext', array(
        'label'   => 'Pricing Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'comparison_headline', array(
        'default'           => 'Compare the cost of digital menus to printing and manually updating static menus!',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'comparison_headline', array(
        'label'   => 'Comparison Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'comparison_subtext', array(
        'default'           => 'See how much time and money you can save with Menuboard Manager.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'comparison_subtext', array(
        'label'   => 'Comparison Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'comparison_cta', array(
        'default'           => 'See the Comparison',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'comparison_cta', array(
        'label'   => 'Comparison Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'reviews_label', array(
        'default'           => 'What People Say',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'reviews_label', array(
        'label'   => 'Reviews Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'reviews_headline', array(
        'default'           => 'Google Reviews',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'reviews_headline', array(
        'label'   => 'Reviews Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pos_label', array(
        'default'           => 'Seamless Integration',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pos_label', array(
        'label'   => 'Pos Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pos_headline', array(
        'default'           => 'Order Confirmation with Your POS',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pos_headline', array(
        'label'   => 'Pos Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pos_desc', array(
        'default'           => 'Connect your digital menu boards directly to your POS system. When you update items, prices, or availability in Toast® — your boards update in real-time.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pos_desc', array(
        'label'   => 'Pos Desc',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'pos_cta', array(
        'default'           => 'See It In Action',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'pos_cta', array(
        'label'   => 'Pos Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'tech_headline', array(
        'default'           => 'Where Menus Meet Your Tech Stack',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'tech_headline', array(
        'label'   => 'Tech Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'tech_subtext', array(
        'default'           => 'Menuboard Manager integrates with the tools you already use to run your restaurant.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'tech_subtext', array(
        'label'   => 'Tech Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'financing_label', array(
        'default'           => 'Flexible Options',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'financing_label', array(
        'label'   => 'Financing Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'financing_headline', array(
        'default'           => 'Financing Available',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'financing_headline', array(
        'label'   => 'Financing Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'financing_subtext', array(
        'default'           => 'Get started with affordable monthly payments. No large upfront costs.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'financing_subtext', array(
        'label'   => 'Financing Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'case_studies_label', array(
        'default'           => 'Real Results',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'case_studies_label', array(
        'label'   => 'Case Studies Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'case_studies_headline', array(
        'default'           => 'Case Studies',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'case_studies_headline', array(
        'label'   => 'Case Studies Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'case_studies_subtext', array(
        'default'           => 'For nearly a decade, we\'ve been transforming how restaurants display and sell their food.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'case_studies_subtext', array(
        'label'   => 'Case Studies Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'why_label', array(
        'default'           => 'The Menuboard Manager Difference',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'why_label', array(
        'label'   => 'Why Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'why_headline', array(
        'default'           => 'Why Choose Us?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'why_headline', array(
        'label'   => 'Why Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'whoweare_label', array(
        'default'           => 'Our Story',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'whoweare_label', array(
        'label'   => 'Whoweare Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'whoweare_headline', array(
        'default'           => 'Who We Are',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'whoweare_headline', array(
        'label'   => 'Whoweare Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'whoweare_cta', array(
        'default'           => 'Learn Our Story',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'whoweare_cta', array(
        'label'   => 'Whoweare Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'testimonials_label', array(
        'default'           => 'Trusted by Restaurants',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'testimonials_label', array(
        'label'   => 'Testimonials Label',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'testimonials_headline', array(
        'default'           => 'Client Testimonials',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'testimonials_headline', array(
        'label'   => 'Testimonials Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'cta_headline', array(
        'default'           => 'Stunning Menus That Drive More Sales',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'cta_headline', array(
        'label'   => 'Cta Headline',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'cta_subtext', array(
        'default'           => 'Join hundreds of restaurants already using Menuboard Manager to boost revenue and simplify operations.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'cta_subtext', array(
        'label'   => 'Cta Subtext',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_desc', array(
        'default'           => 'Elevate your restaurant with stunning digital menu boards. Easy to update, fully customizable, and integrated with POS systems like Toast®.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_desc', array(
        'label'   => 'Footer Desc',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_email', array(
        'default'           => 'hello@menuboardmanager.com',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_email', array(
        'label'   => 'Footer Email',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_phone', array(
        'default'           => '(800) 555-MENU',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_phone', array(
        'label'   => 'Footer Phone',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_cta', array(
        'default'           => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_cta', array(
        'label'   => 'Footer Cta',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'footer_company', array(
        'default'           => 'Menuboard Manager',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_company', array(
        'label'   => 'Footer Company',
        'section' => 'menuboard_manager_theme_content',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'menuboard_manager_theme_customize_register' );

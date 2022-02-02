<?php
/**
 * Core Blog Theme Options Panel
 */
$wp_customize->add_panel('core_blog_theme_options', array(
    'title' => __('Core Blog Settings', 'core-blog') ,
    'priority' => 1,
));

//Header Search Icon And Menu Sidebar Section
$wp_customize->add_section('core_blog_header_search_icon_section', array(
    'title' => __('Core Blog Header Search Display Setting', 'core-blog') ,
    'panel' => 'core_blog_theme_options',
    'priority' => 10
));
// Top Header Menu Social Icon Display Control
$wp_customize->add_setting('core_blog_header_search_icon_display', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_header_search_icon_display', array(
    'label' => esc_html__('Display Search Icon', 'core-blog') ,
    'section' => 'core_blog_header_search_icon_section',
    'priority' => 4,
    'type' => 'checkbox'
));

// Top Header Menu Social Icon Display Control
$wp_customize->add_setting('core_blog_header_menu_sidebar_display', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_header_menu_sidebar_display', array(
    'label' => esc_html__('Display Menu Sidebar', 'core-blog') ,
    'section' => 'core_blog_header_search_icon_section',
    'priority' => 4,
    'type' => 'checkbox'
));

/*Blog Post Options Section*/
$wp_customize->add_section('core_blog_general_options', array(
    'title' => __('Core Blog Read More Options', 'core-blog') ,
    'panel' => 'core_blog_theme_options',
    'priority' => 10,
    'description' => esc_html__('Personalize the settings of your theme.', 'core-blog') ,
));

// Read More Label
$wp_customize->add_setting('core_blog_read_more_label', array(
    'default' => esc_html__('continue reading', 'core-blog') ,
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('core_blog_read_more_label', array(
    'label' => esc_html__('Read More Label', 'core-blog') ,
    'section' => 'core_blog_general_options',
    'priority' => 1,
    'type' => 'text',
));


/*Blog Post Options*/
$wp_customize->add_section('core_blog_archive_content_options', array(
    'title' => __('Core Blog Blog Post Options', 'core-blog') ,
    'panel' => 'core_blog_theme_options',
    'priority' => 10,
    'description' => esc_html__('Setting will also apply on archieve and search page.', 'core-blog') ,
));

/*======================*/

// Post Author Display Control
$wp_customize->add_setting('core_blog_archive_co_post_author', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_archive_co_post_author', array(
    'label' => esc_html__('Display Author', 'core-blog') ,
    'section' => 'core_blog_archive_content_options',
    'priority' => 2,
    'type' => 'checkbox',
));

// Post Date Display Control
$wp_customize->add_setting('core_blog_archive_co_post_date', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_archive_co_post_date', array(
    'label' => esc_html__('Display Date', 'core-blog') ,
    'section' => 'core_blog_archive_content_options',
    'priority' => 3,
    'type' => 'checkbox',
));

// Featured Image Archive Control
$wp_customize->add_setting('core_blog_archive_co_featured_image', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_archive_co_featured_image', array(
    'label' => esc_html__('Display Featured Image', 'core-blog') ,
    'section' => 'core_blog_archive_content_options',
    'priority' => 5,
    'type' => 'checkbox',
));

// Categories Archive Control
$wp_customize->add_setting('core_blog_archive_co_categories', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_archive_co_categories', array(
    'label' => esc_html__('Display Categories', 'core-blog') ,
    'section' => 'core_blog_archive_content_options',
    'priority' => 5,
    'type' => 'checkbox',
));

// Comment Archive Control
$wp_customize->add_setting('core_blog_archive_co_comment', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_archive_co_comment', array(
    'label' => esc_html__('Display Comments ', 'core-blog') ,
    'section' => 'core_blog_archive_content_options',
    'priority' => 5,
    'type' => 'checkbox',
));

// Post View Archive Control
$wp_customize->add_setting('core_blog_archive_co_view', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_archive_co_view', array(
    'label' => esc_html__('Display Views ', 'core-blog') ,
    'section' => 'core_blog_archive_content_options',
    'priority' => 5,
    'type' => 'checkbox',
));

/*Single Post Options*/
$wp_customize->add_section('core_blog_single_content_options', array(
    'title' => __('Core Blog Single Post Options', 'core-blog') ,
    'panel' => 'core_blog_theme_options',
    'priority' => 10,
    'description' => esc_html__('Setting will apply on the content of single posts.', 'core-blog') ,
));

// Post Author Display Control
$wp_customize->add_setting('core_blog_single_co_post_author', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_single_co_post_author', array(
    'label' => esc_html__('Display Author', 'core-blog') ,
    'section' => 'core_blog_single_content_options',
    'priority' => 2,
    'type' => 'checkbox',
));

// Post Date Display Control
$wp_customize->add_setting('core_blog_single_co_post_date', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_single_co_post_date', array(
    'label' => esc_html__('Display Date', 'core-blog') ,
    'section' => 'core_blog_single_content_options',
    'priority' => 3,
    'type' => 'checkbox',
));

// Single Post Category Display Control
$wp_customize->add_setting('core_blog_single_co_post_category', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_single_co_post_category', array(
    'label' => esc_html__('Display Category', 'core-blog') ,
    'section' => 'core_blog_single_content_options',
    'priority' => 5,
    'type' => 'checkbox',
));

// Post View Archive Control
$wp_customize->add_setting('core_blog_single_co_view', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_single_co_view', array(
    'label' => esc_html__('Display Views ', 'core-blog') ,
    'section' => 'core_blog_single_content_options',
    'priority' => 5,
    'type' => 'checkbox',
));

// Featured Image Post Display Control
$wp_customize->add_setting('core_blog_single_co_featured_image_post', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_single_co_featured_image_post', array(
    'label' => esc_html__('Display Featured Image', 'core-blog') ,
    'section' => 'core_blog_single_content_options',
    'priority' => 7,
    'type' => 'checkbox',
));

//Sidebar Section
$wp_customize->add_section('core_blog_sidebar_section', array(
    'title' => __('Core Blog Sidebar Setting', 'core-blog') ,
    'panel' => 'core_blog_theme_options',
    'priority' => 10
));

// Main Sidebar Position
$wp_customize->add_setting('core_blog_sidebar_position', array(
    'default' => esc_html__('right', 'core-blog') ,
    'sanitize_callback' => 'core_blog_sanitize_select',
));

$wp_customize->add_control('core_blog_sidebar_position', array(
    'label' => esc_html__('Sidebar Position', 'core-blog') ,
    'section' => 'core_blog_sidebar_section',
    'priority' => 2,
    'type' => 'select',
    'choices' => array(
        'right' => esc_html__('Right Sidebar', 'core-blog') ,
        'left' => esc_html__('Left Sidebar', 'core-blog') ,
        'no' => esc_html__('No Sidebar', 'core-blog')
    ) ,
));

//Footer Section
$wp_customize->add_section('core_blog_footer_section', array(
    'title' => __('Core Blog Footer Setting', 'core-blog') ,
    'panel' => 'core_blog_theme_options',
    'priority' => 10
));

//Footer bottom Copyright Display Control
$wp_customize->add_setting('core_blog_footer_copyright_display', array(
    'default' => true,
    'sanitize_callback' => 'core_blog_sanitize_checkbox',
));

$wp_customize->add_control('core_blog_footer_copyright_display', array(
    'label' => esc_html__('Display Copyright Footer', 'core-blog') ,
    'section' => 'core_blog_footer_section',
    'priority' => 1,
    'type' => 'checkbox',
));

// Copyright Control
$wp_customize->add_setting('core_blog_copyright', array(
    'default' => esc_html__('Proudly Powered By WordPress', 'core-blog') ,
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control('core_blog_copyright', array(
    'label' => esc_html__('Copyright', 'core-blog') ,
    'section' => 'core_blog_footer_section',
    'priority' => 2,
    'type' => 'textarea',
    'active_callback' => 'core_blog_footer_copyright_callback'
));
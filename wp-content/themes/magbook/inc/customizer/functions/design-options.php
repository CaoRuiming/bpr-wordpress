<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
$magbook_settings = magbook_get_theme_options();

$wp_customize->add_section('magbook_layout_options', array(
	'title' => __('Layout Options', 'magbook'),
	'priority' => 102,
	'panel' => 'magbook_options_panel'
));

$wp_customize->add_setting('magbook_theme_options[magbook_responsive]', array(
	'default' => $magbook_settings['magbook_responsive'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('magbook_theme_options[magbook_responsive]', array(
	'priority' =>20,
	'label' => __('Responsive Layout', 'magbook'),
	'section' => 'magbook_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'on' => __('ON ','magbook'),
		'off' => __('OFF','magbook'),
	),
));

$wp_customize->add_setting('magbook_theme_options[magbook_blog_layout]', array(
	'default' => $magbook_settings['magbook_blog_layout'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('magbook_theme_options[magbook_blog_layout]', array(
	'priority' =>30,
	'label' => __('Blog Layout', 'magbook'),
	'section'    => 'magbook_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'default_blog_display' => __('Blog with Large Image','magbook'),
		'medium_image_display' => __('Blog with Small Image','magbook'),
		'two_column_image_display' => __('Blog with Two Column/ Default','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_entry_meta_single]', array(
	'default' => $magbook_settings['magbook_entry_meta_single'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_entry_meta_single]', array(
	'priority'=>40,
	'label' => __('Disable Entry Meta from Single Page', 'magbook'),
	'section' => 'magbook_layout_options',
	'type' => 'select',
	'choices' => array(
		'show' => __('Display Entry Format','magbook'),
		'hide' => __('Hide Entry Format','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_entry_meta_blog]', array(
	'default' => $magbook_settings['magbook_entry_meta_blog'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_entry_meta_blog]', array(
	'priority'=>50,
	'label' => __('Disable Entry Meta from Slider/ Blog/ Widgets Page', 'magbook'),
	'section' => 'magbook_layout_options',
	'type'	=> 'select',
	'choices' => array(
		'show-meta' => __('Display Entry Meta','magbook'),
		'hide-meta' => __('Hide Entry Meta','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_post_category]', array(
	'default' => $magbook_settings['magbook_post_category'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_post_category]', array(
	'priority'=>55,
	'label' => __('Disable Category', 'magbook'),
	'section' => 'magbook_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_post_author]', array(
	'default' => $magbook_settings['magbook_post_author'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_post_author]', array(
	'priority'=>60,
	'label' => __('Disable Author', 'magbook'),
	'section' => 'magbook_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_post_date]', array(
	'default' => $magbook_settings['magbook_post_date'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_post_date]', array(
	'priority'=>65,
	'label' => __('Disable Date', 'magbook'),
	'section' => 'magbook_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_post_comments]', array(
	'default' => $magbook_settings['magbook_post_comments'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_post_comments]', array(
	'priority'=>68,
	'label' => __('Disable Comments', 'magbook'),
	'section' => 'magbook_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting('magbook_theme_options[magbook_blog_content_layout]', array(
   'default'        => $magbook_settings['magbook_blog_content_layout'],
   'sanitize_callback' => 'magbook_sanitize_select',
   'type'                  => 'option',
   'capability'            => 'manage_options'
));
$wp_customize->add_control('magbook_theme_options[magbook_blog_content_layout]', array(
   'priority'  =>75,
   'label'      => __('Blog Content Display', 'magbook'),
   'section'    => 'magbook_layout_options',
   'type'       => 'select',
   'checked'   => 'checked',
   'choices'    => array(
       'fullcontent_display' => __('Blog Full Content Display','magbook'),
       'excerptblog_display' => __(' Excerpt  Display','magbook'),
   ),
));

$wp_customize->add_setting('magbook_theme_options[magbook_design_layout]', array(
	'default'        => $magbook_settings['magbook_design_layout'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type'                  => 'option',
));
$wp_customize->add_control('magbook_theme_options[magbook_design_layout]', array(
	'priority'  =>80,
	'label'      => __('Design Layout', 'magbook'),
	'section'    => 'magbook_layout_options',
	'type'       => 'select',
	'checked'   => 'checked',
	'choices'    => array(
		'full-width-layout' => __('Full Width Layout','magbook'),
		'boxed-layout' => __('Boxed Layout','magbook'),
		'small-boxed-layout' => __('Small Boxed Layout','magbook'),
	),
));
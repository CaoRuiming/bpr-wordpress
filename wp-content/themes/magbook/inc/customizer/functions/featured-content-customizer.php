<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

/******************** MAGBOOK SLIDER SETTINGS ******************************************/
$magbook_settings = magbook_get_theme_options();
$magbook_categories_lists = magbook_categories_lists();
$wp_customize->add_section( 'featured_content', array(
	'title' => __( 'Slider Settings', 'magbook' ),
	'priority' => 140,
	'panel' => 'magbook_featuredcontent_panel'
));

$wp_customize->add_section( 'small_slider_posts', array(
	'title' => __( 'Select Category Posts for Small Slider', 'magbook' ),
	'priority' => 145,
	'panel' => 'magbook_featuredcontent_panel'
));

$wp_customize->add_section( 'slider_category_content', array(
	'title' => __( 'Select Category Slider', 'magbook' ),
	'priority' => 150,
	'panel' => 'magbook_featuredcontent_panel'
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_slider_design_layout]', array(
	'default' => $magbook_settings['magbook_slider_design_layout'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_slider_design_layout]', array(
	'priority'=>10,
	'label' => __('Slider Design Layout', 'magbook'),
	'description' => __('Slider Image Size(600x455px for default, 2000x800px for Layer Slider and 360x400px for Multi Slider)', 'magbook'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'no-slider' => __('Default/ No Slider','magbook'),
		'layer-slider' => __('Layer/ Single Slider','magbook'),
		'multi-slider' => __('Multi/ Four slider','magbook'),
		'small-slider' => __('Small Slider','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_enable_slider]', array(
	'default' => $magbook_settings['magbook_enable_slider'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_enable_slider]', array(
	'priority'=>20,
	'label' => __('Enable Slider', 'magbook'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'frontpage' => __('Front Page','magbook'),
		'enitresite' => __('Entire Site','magbook'),
		'disable' => __('Disable Slider','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_animation_effect]', array(
	'default' => $magbook_settings['magbook_animation_effect'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_animation_effect]', array(
	'priority'=>60,
	'label' => __('Animation Effect', 'magbook'),
	'description' => __('This feature will not work on Multi Slider','magbook'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'slide' => __('Slide','magbook'),
		'fade' => __('Fade','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_slideshowSpeed]', array(
	'default' => $magbook_settings['magbook_slideshowSpeed'],
	'sanitize_callback' => 'magbook_numeric_value',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_slideshowSpeed]', array(
	'priority'=>70,
	'label' => __('Set the speed of the slideshow cycling', 'magbook'),
	'section' => 'featured_content',
	'type' => 'text',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_animationSpeed]', array(
	'default' => $magbook_settings['magbook_animationSpeed'],
	'sanitize_callback' => 'magbook_numeric_value',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_animationSpeed]', array(
	'priority'=>80,
	'label' => __(' Set the speed of animations', 'magbook'),
	'description' => __('This feature will not work on Animation Effect set to fade','magbook'),
	'section' => 'featured_content',
	'type' => 'text',
));


/* Slider Category Section */

$wp_customize->add_setting('magbook_theme_options[magbook_slider_content_bg_color]', array(
	'default' =>$magbook_settings['magbook_slider_content_bg_color'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('magbook_theme_options[magbook_slider_content_bg_color]', array(
	'priority' =>8,
	'label' => __('Slider Content With background color', 'magbook'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
	'on' => __('Show Background Color','magbook'),
	'off' => __('Hide Background Color','magbook'),
	),
));

/* Select your category to display Slider */

$wp_customize->add_setting( 'magbook_theme_options[magbook_default_category_slider]', array(
		'default'				=>$magbook_settings['magbook_default_category_slider'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'magbook_sanitize_category_select',
		'type'				=> 'option'
	));
$wp_customize->add_control(
	
	'magbook_theme_options[magbook_default_category_slider]',
		array(
			'priority' 				=> 10,
			'label'					=> __('Select Category Slider ( By default it will display all post )','magbook'),
			'description'					=> __('By default it will display all post','magbook'),
			'section'				=> 'slider_category_content',
			'settings'				=> 'magbook_theme_options[magbook_default_category_slider]',
			'type'					=>'select',
			'choices'	=>  $magbook_categories_lists 
	)
);


/* Select your category to display posts in slider section */
$wp_customize->add_setting( 'magbook_theme_options[magbook_small_slider_post_category]', array(
		'default'				=>$magbook_settings['magbook_small_slider_post_category'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'magbook_sanitize_category_select',
		'type'				=> 'option'
	));
$wp_customize->add_control('magbook_theme_options[magbook_small_slider_post_category]',
		array(
			'priority' 				=> 10,
			'label'					=> __('Display 4 Posts in Small Slider','magbook'),
			'description'					=> __('Selecting this category will only be displayed in Small Slider which is selected from Slider Design Layout','magbook'),
			'section'				=> 'small_slider_posts',
			'settings'				=> 'magbook_theme_options[magbook_small_slider_post_category]',
			'type'					=>'select',
			'choices'	=>  $magbook_categories_lists 
		)
);

	
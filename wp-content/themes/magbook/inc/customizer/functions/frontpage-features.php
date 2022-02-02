<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

/******************** MAGBOOK FRONTPAGE  *********************************************/
/* Frontpage Magbook */
$magbook_settings = magbook_get_theme_options();
$magbook_categories_lists = magbook_categories_lists();
$wp_customize->add_section( 'magbook_breaking_news', array(
	'title' => __('Breaking News','magbook'),
	'priority' => 10,
	'panel' =>'magbook_frontpage_panel'
));
$wp_customize->add_section( 'magbook_frontpage_features', array(
	'title' => __('Feature News','magbook'),
	'priority' => 20,
	'panel' =>'magbook_frontpage_panel'
));


/* Frontpage Breaking News */

$wp_customize->add_setting( 'magbook_theme_options[magbook_disable_breaking_news]', array(
	'default' => $magbook_settings['magbook_disable_breaking_news'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_disable_breaking_news]', array(
	'priority' => 5,
	'label' => __('Disable Breaking News Section', 'magbook'),
	'section' => 'magbook_breaking_news',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_breaking_news_title]', array(
	'default' => $magbook_settings['magbook_breaking_news_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'magbook_theme_options[magbook_breaking_news_title]', array(
	'priority' => 10,
	'label' => __( 'Title', 'magbook' ),
	'section' => 'magbook_breaking_news',
	'type' => 'text',
	)
);

$wp_customize->add_setting(
	'magbook_theme_options[magbook_breaking_news_category]', array(
		'default'				=>$magbook_settings['magbook_breaking_news_category'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'magbook_sanitize_category_select',
		'type'				=> 'option'
	)
);
$wp_customize->add_control( 'magbook_theme_options[magbook_breaking_news_category]',
		array(
			'priority' => 20,
			'label'       => __( 'Breaking News Category', 'magbook' ),
			'section'     => 'magbook_breaking_news',
			'settings'	  => 'magbook_theme_options[magbook_breaking_news_category]',
			'type'        => 'select',
			'choices'	=>  $magbook_categories_lists 
		)
);


/* Frontpage Feature News */
$wp_customize->add_setting( 'magbook_theme_options[magbook_disable_feature_news]', array(
	'default' => $magbook_settings['magbook_disable_feature_news'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_disable_feature_news]', array(
	'priority' => 5,
	'label' => __('Disable Feature News Section', 'magbook'),
	'section' => 'magbook_frontpage_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_feature_news_title]', array(
	'default' => $magbook_settings['magbook_feature_news_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'magbook_theme_options[magbook_feature_news_title]', array(
	'priority' => 10,
	'label' => __( 'Title', 'magbook' ),
	'section' => 'magbook_frontpage_features',
	'type' => 'text',
	)
);

$wp_customize->add_setting(
	'magbook_theme_options[magbook_featured_news_category]', array(
		'default'				=>$magbook_settings['magbook_featured_news_category'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'magbook_sanitize_category_select',
		'type'				=> 'option'
	)
);
$wp_customize->add_control( 'magbook_theme_options[magbook_featured_news_category]',
		array(
			'priority' => 20,
			'label'       => __( 'Feature News Category', 'magbook' ),
			'section'     => 'magbook_frontpage_features',
			'settings'	  => 'magbook_theme_options[magbook_featured_news_category]',
			'type'        => 'select',
			'choices'	=>  $magbook_categories_lists 
		)
);
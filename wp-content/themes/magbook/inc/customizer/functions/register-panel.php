<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
/******************** MAGBOOK CUSTOMIZE REGISTER *********************************************/
add_action( 'customize_register', 'magbook_customize_register_wordpress_default' );
function magbook_customize_register_wordpress_default( $wp_customize ) {
	$wp_customize->add_panel( 'magbook_wordpress_default_panel', array(
		'priority' => 5,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'WordPress Settings', 'magbook' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'magbook_customize_register_options');
function magbook_customize_register_options( $wp_customize ) {
	$wp_customize->add_panel( 'magbook_options_panel', array(
		'priority' => 6,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Options', 'magbook' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'magbook_customize_register_featuredcontent' );
function magbook_customize_register_featuredcontent( $wp_customize ) {
	$wp_customize->add_panel( 'magbook_featuredcontent_panel', array(
		'priority' => 8,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Slider Options', 'magbook' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'magbook_customize_register_frontpage_options');
function magbook_customize_register_frontpage_options( $wp_customize ) {
	$wp_customize->add_panel( 'magbook_frontpage_panel', array(
		'priority' => 7,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Frontpage', 'magbook' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'magbook_customize_register_colors' );
function magbook_customize_register_colors( $wp_customize ) {
	$wp_customize->add_panel( 'colors', array(
		'priority' => 9,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Colors Section', 'magbook' ),
		'description' => '',
	) );
}
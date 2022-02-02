<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'magpaper_layout', array(
	'title'               => esc_html__('Layout','magpaper'),
	'description'         => esc_html__( 'Layout section options.', 'magpaper' ),
	'panel'               => 'magpaper_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[site_layout]', array(
	'sanitize_callback'   => 'magpaper_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new Magpaper_Custom_Radio_Image_Control ( $wp_customize, 'magpaper_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'magpaper' ),
	'section'             => 'magpaper_layout',
	'choices'			  => magpaper_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'magpaper_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Magpaper_Custom_Radio_Image_Control ( $wp_customize, 'magpaper_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Blog/Archive Sidebar Position', 'magpaper' ),
	'section'             => 'magpaper_layout',
	'choices'			  => magpaper_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'magpaper_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Magpaper_Custom_Radio_Image_Control ( $wp_customize, 'magpaper_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'magpaper' ),
	'section'             => 'magpaper_layout',
	'choices'			  => magpaper_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'magpaper_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Magpaper_Custom_Radio_Image_Control( $wp_customize, 'magpaper_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'magpaper' ),
	'section'             => 'magpaper_layout',
	'choices'			  => magpaper_sidebar_position(),
) ) );
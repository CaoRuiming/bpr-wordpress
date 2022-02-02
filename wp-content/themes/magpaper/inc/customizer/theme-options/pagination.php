<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'magpaper_pagination', array(
	'title'               => esc_html__('Pagination','magpaper'),
	'description'         => esc_html__( 'Blog/Archive Pagination options.', 'magpaper' ),
	'panel'               => 'magpaper_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'magpaper' ),
	'section'             => 'magpaper_pagination',
	'on_off_label' 		=> magpaper_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'magpaper_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'magpaper_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'magpaper' ),
	'section'             => 'magpaper_pagination',
	'type'                => 'select',
	'choices'			  => magpaper_pagination_options(),
	'active_callback'	  => 'magpaper_is_pagination_enable',
) );

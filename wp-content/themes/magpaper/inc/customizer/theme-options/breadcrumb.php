<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

$wp_customize->add_section( 'magpaper_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','magpaper' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'magpaper' ),
	'panel'             => 'magpaper_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'magpaper' ),
	'section'          	=> 'magpaper_breadcrumb',
	'on_off_label' 		=> magpaper_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'magpaper_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'magpaper' ),
	'active_callback' 	=> 'magpaper_is_breadcrumb_enable',
	'section'          	=> 'magpaper_breadcrumb',
) );

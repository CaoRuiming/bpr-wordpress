<?php
/**
 * Hero Section options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add Hero section
$wp_customize->add_section( 'magpaper_hero_section', array(
	'title'             => esc_html__( 'Hero','magpaper' ),
	'description'       => esc_html__( 'Hero Section options.', 'magpaper' ),
	'panel'             => 'magpaper_front_page_panel',
) );

// Hero content enable control and setting
$wp_customize->add_setting( 'magpaper_theme_options[hero_section_enable]', array(
	'default'			=> 	$options['hero_section_enable'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[hero_section_enable]', array(
	'label'             => esc_html__( 'Hero Section Enable', 'magpaper' ),
	'section'           => 'magpaper_hero_section',
	'on_off_label' 		=> magpaper_switch_options(),
) ) );

// featured pages drop down chooser control and setting
$wp_customize->add_setting( 'magpaper_theme_options[hero_content_page]', array(
	'sanitize_callback' => 'magpaper_sanitize_page',
) );

$wp_customize->add_control( new Magpaper_Dropdown_Chooser( $wp_customize, 'magpaper_theme_options[hero_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'magpaper' ),
	'section'           => 'magpaper_hero_section',
	'choices'			=> magpaper_page_choices(),
	'active_callback'	=> 'magpaper_is_hero_section_enable',
) ) );


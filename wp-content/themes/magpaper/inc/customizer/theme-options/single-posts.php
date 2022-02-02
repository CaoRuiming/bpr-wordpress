<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'magpaper_single_post_section', array(
	'title'             => esc_html__( 'Single Post','magpaper' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'magpaper' ),
	'panel'             => 'magpaper_theme_options_panel',
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'magpaper' ),
	'section'           => 'magpaper_single_post_section',
	'on_off_label' 		=> magpaper_hide_options(),
) ) );

// Archive author meta setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'magpaper' ),
	'section'           => 'magpaper_single_post_section',
	'on_off_label' 		=> magpaper_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'magpaper' ),
	'section'           => 'magpaper_single_post_section',
	'on_off_label' 		=> magpaper_hide_options(),
) ) );

// Archive tag category setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'magpaper' ),
	'section'           => 'magpaper_single_post_section',
	'on_off_label' 		=> magpaper_hide_options(),
) ) );

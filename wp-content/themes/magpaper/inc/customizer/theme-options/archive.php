<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'magpaper_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','magpaper' ),
	'description'       => esc_html__( 'Archive section options.', 'magpaper' ),
	'panel'             => 'magpaper_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'magpaper_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'magpaper' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'magpaper' ),
	'section'           => 'magpaper_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'magpaper_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'magpaper' ),
	'section'           => 'magpaper_archive_section',
	'on_off_label' 		=> magpaper_hide_options(),
) ) );

// Archive comment category setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[hide_author]', array(
	'default'           => $options['hide_author'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'magpaper' ),
	'section'           => 'magpaper_archive_section',
	'on_off_label' 		=> magpaper_hide_options(),
) ) );
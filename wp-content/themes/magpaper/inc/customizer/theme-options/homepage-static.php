<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Magpaper
* @since Magpaper 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'magpaper_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'magpaper_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'magpaper' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'magpaper' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );
<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'magpaper_reset_section', array(
	'title'             => esc_html__('Reset all settings','magpaper'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'magpaper' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'magpaper_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'magpaper_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'magpaper' ),
	'section'           => 'magpaper_reset_section',
	'type'              => 'checkbox',
) );

<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'magpaper_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'magpaper' ),
		'priority'   			=> 900,
		'panel'      			=> 'magpaper_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'magpaper_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'magpaper_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'magpaper_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'magpaper' ),
		'section'    			=> 'magpaper_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magpaper_theme_options[copyright_text]', array(
		'selector'            => '.site-info .copyright p',
		'settings'            => 'magpaper_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magpaper_copyright_text_partial',
    ) );
}

// scroll top visible
$wp_customize->add_setting( 'magpaper_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'magpaper_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'magpaper' ),
		'section'    			=> 'magpaper_section_footer',
		'on_off_label' 		=> magpaper_switch_options(),
    )
) );
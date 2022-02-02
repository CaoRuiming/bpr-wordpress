<?php
/**
 * Popular post Section options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add Popular post section
$wp_customize->add_section( 'magpaper_popular_post_section', array(
	'title'             => esc_html__( 'Popular Posts','magpaper' ),
	'description'       => esc_html__( 'Popular Posts Section options.', 'magpaper' ),
	'panel'             => 'magpaper_front_page_panel',
) );

// Popular post content enable control and setting
$wp_customize->add_setting( 'magpaper_theme_options[popular_post_section_enable]', array(
	'default'			=> 	$options['popular_post_section_enable'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[popular_post_section_enable]', array(
	'label'             => esc_html__( 'Popular posts Section Enable', 'magpaper' ),
	'section'           => 'magpaper_popular_post_section',
	'on_off_label' 		=> magpaper_switch_options(),
) ) );

// Popular post content 
$wp_customize->add_setting( 'magpaper_theme_options[popular_post_title]',
	array(
		'default'       	=> $options['popular_post_title'],
		'sanitize_callback'	=> 'sanitize_text_field',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( 'magpaper_theme_options[popular_post_title]',
    array(
		'label'      		=> esc_html__( 'Popular Posts Title', 'magpaper' ),
		'section'    		=> 'magpaper_popular_post_section',
		'type'		 		=> 'text',
		'active_callback'   => 'magpaper_is_popular_post_section_enable',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magpaper_theme_options[popular_post_title]', array(
		'selector'            => '#popular-posts .section-header h2.section-title',
		'settings'            => 'magpaper_theme_options[popular_post_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magpaper_popular_post_title_partial',
    ) );
}

// Popular post right control and setting
$wp_customize->add_setting( 'magpaper_theme_options[popular_post_right_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Magpaper_Note_Control( $wp_customize, 'magpaper_theme_options[popular_post_right_label]', array(
	'label'             => esc_html__( 'Highlighted Post', 'magpaper' ),
	'section'           => 'magpaper_popular_post_section',
	'active_callback'	=> 'magpaper_is_popular_post_section_enable',
) ) );


// popular_post pages drop down chooser control and setting
$wp_customize->add_setting( 'magpaper_theme_options[popular_post_right_content_page]', array(
	'sanitize_callback' => 'magpaper_sanitize_page',
) );

$wp_customize->add_control( new Magpaper_Dropdown_Chooser( $wp_customize, 'magpaper_theme_options[popular_post_right_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'magpaper' ),
	'section'           => 'magpaper_popular_post_section',
	'choices'			=> magpaper_page_choices(),
	'active_callback'	=> 'magpaper_is_popular_post_section_enable',
) ) );



// Popular post left control and setting
$wp_customize->add_setting( 'magpaper_theme_options[popular_post_left_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Magpaper_Note_Control( $wp_customize, 'magpaper_theme_options[popular_post_left_label]', array(
	'label'             => esc_html__( 'Popular Posts', 'magpaper' ),
	'section'           => 'magpaper_popular_post_section',
	'active_callback'	=> 'magpaper_is_popular_post_section_enable',
) ) );


// Add dropdown category setting and control.
$wp_customize->add_setting(  'magpaper_theme_options[popular_post_left_content_category]', array(
	'sanitize_callback' => 'magpaper_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Magpaper_Dropdown_Taxonomies_Control( $wp_customize,'magpaper_theme_options[popular_post_left_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'magpaper' ),
	'description'      	=> esc_html__( 'Note: Latest selected no. of posts will be shown from selected category', 'magpaper' ),
	'section'           => 'magpaper_popular_post_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'magpaper_is_popular_post_section_enable'
) ) );



<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'magpaper_blog_section', array(
	'title'             => esc_html__( 'Latest Posts','magpaper' ),
	'description'       => esc_html__( 'Latest Posts Section options.', 'magpaper' ),
	'panel'             => 'magpaper_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'magpaper_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'magpaper_sanitize_switch_control',
) );

$wp_customize->add_control( new Magpaper_Switch_Control( $wp_customize, 'magpaper_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'magpaper' ),
	'section'           => 'magpaper_blog_section',
	'on_off_label' 		=> magpaper_switch_options(),
) ) );

// Blog content title 
$wp_customize->add_setting( 'magpaper_theme_options[blog_section_title]',
	array(
		'default'       	=> $options['blog_section_title'],
		'sanitize_callback'	=> 'sanitize_text_field',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( 'magpaper_theme_options[blog_section_title]',
    array(
		'label'      		=> esc_html__( 'Latest Posts Title', 'magpaper' ),
		'section'    		=> 'magpaper_blog_section',
		'type'		 		=> 'text',
		'active_callback'   => 'magpaper_is_blog_section_enable',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magpaper_theme_options[blog_section_title]', array(
		'selector'            => '#latest-posts .section-header h2.section-title',
		'settings'            => 'magpaper_theme_options[blog_section_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magpaper_blog_section_title_partial',
    ) );
}

// Blog content type control and setting
$wp_customize->add_setting( 'magpaper_theme_options[blog_content_type]', array(
	'default'          	=> $options['blog_content_type'],
	'sanitize_callback' => 'magpaper_sanitize_select',
) );

$wp_customize->add_control( 'magpaper_theme_options[blog_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'magpaper' ),
	'section'           => 'magpaper_blog_section',
	'type'				=> 'select',
	'active_callback' 	=> 'magpaper_is_blog_section_enable',
	'choices'			=> array( 
		'category' 	=> esc_html__( 'Category', 'magpaper' ),
		'recent' 	=> esc_html__( 'Recent', 'magpaper' ),
	),
) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'magpaper_theme_options[blog_content_category]', array(
	'sanitize_callback' => 'magpaper_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Magpaper_Dropdown_Taxonomies_Control( $wp_customize,'magpaper_theme_options[blog_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'magpaper' ),
	'description'      	=> esc_html__( 'Note: Latest selected no of posts will be shown from selected category', 'magpaper' ),
	'section'           => 'magpaper_blog_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'magpaper_is_blog_section_content_category_enable'
) ) );

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'magpaper_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'magpaper_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Magpaper_Dropdown_Category_Control( $wp_customize,'magpaper_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'magpaper' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press Shift key select multilple categories.', 'magpaper' ),
	'section'           => 'magpaper_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'magpaper_is_blog_section_content_recent_enable'
) ) );

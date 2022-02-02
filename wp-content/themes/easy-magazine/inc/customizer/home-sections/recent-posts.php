<?php
/**
 * Recent Posts options.
 *
 * @package Easy Magazine
 */

$default = easy_magazine_get_default_theme_options();

// Recent Posts Section
$wp_customize->add_section( 'section_recent_posts',
	array(
	'title'      => __( 'Recent Posts', 'easy-magazine' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Recent Posts Section
$wp_customize->add_setting('theme_options[enable_recent_posts_section]', 
	array(
	'default' 			=> $default['enable_recent_posts_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'easy_magazine_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_recent_posts_section]', 
	array(		
	'label' 	=> __('Enable Recent Posts Section', 'easy-magazine'),
	'section' 	=> 'section_recent_posts',
	'settings'  => 'theme_options[enable_recent_posts_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[recent_posts_section_title]', 
	array(
	'default'           => $default['recent_posts_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[recent_posts_section_title]', 
	array(
	'label'       => __('Section Title', 'easy-magazine'),
	'section'     => 'section_recent_posts',   
	'settings'    => 'theme_options[recent_posts_section_title]',	
	'active_callback' => 'easy_magazine_recent_posts_active',		
	'type'        => 'text'
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_recent_posts_items]', 
	array(
	'default' 			=> $default['number_of_recent_posts_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_magazine_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_recent_posts_items]', 
	array(
	'label'       => __('Number Of Items', 'easy-magazine'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 10.', 'easy-magazine'),
	'section'     => 'section_recent_posts',   
	'settings'    => 'theme_options[number_of_recent_posts_items]',		
	'type'        => 'number',
	'active_callback' => 'easy_magazine_recent_posts_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 10,
			'step'	=> 1,
		),
	)
);

$wp_customize->add_setting('theme_options[recent_posts_content_type]', 
	array(
	'default' 			=> $default['recent_posts_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_magazine_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[recent_posts_content_type]', 
	array(
	'label'       => __('Content Type', 'easy-magazine'),
	'section'     => 'section_recent_posts',   
	'settings'    => 'theme_options[recent_posts_content_type]',		
	'type'        => 'select',
	'active_callback' => 'easy_magazine_recent_posts_active',
	'choices'	  => array(
			'recent_posts_page'	  => __('Page','easy-magazine'),
			'recent_posts_post'	  => __('Post','easy-magazine'),
		),
	)
);

$number_of_recent_posts_items = easy_magazine_get_option( 'number_of_recent_posts_items' );

for( $i=1; $i<=$number_of_recent_posts_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[recent_posts_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_magazine_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[recent_posts_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'easy-magazine'), $i),
		'section'     => 'section_recent_posts',   
		'settings'    => 'theme_options[recent_posts_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'easy_magazine_recent_posts_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[recent_posts_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_magazine_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[recent_posts_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'easy-magazine'), $i),
		'section'     => 'section_recent_posts',   
		'settings'    => 'theme_options[recent_posts_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => easy_magazine_dropdown_posts(),
		'active_callback' => 'easy_magazine_recent_posts_post',
		)
	);
}
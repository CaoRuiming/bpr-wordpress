<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
/********************* Color Option **********************************************/
	$wp_customize->add_section( 'color_styles', array(
		'title' 						=> __('Color Options','magbook'),
		'priority'					=> 10,
		'panel'					=>'colors'
	));

	$wp_customize->add_section( 'category_colors', array(
		'title' 						=> __('Category Color Options','magbook'),
		'priority'					=> 20,
		'panel'					=>'colors'
	));

	$wp_customize->add_section( 'colors', array(
		'title' 						=> __('Background Color Options','magbook'),
		'priority'					=> 100,
		'panel'					=>'colors'
	));

	$color_scheme = magbook_get_color_scheme();
	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default_color',
		'sanitize_callback' => 'magbook_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Select Color Style', 'magbook' ),
		'description'    => __( 'Please select any other color from dropdown to work with custom color. Changing an individual color settings will not work if default color is choosen.', 'magbook' ),
		'section'  => 'color_styles',
		'type'     => 'select',
		'choices'  => magbook_get_color_scheme_choices(),
		'priority' => 1,
	) );

	$wp_customize->add_setting( 'magbook_site_page_nav_link_title_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_site_page_nav_link_title_color', array(
		'description'       => __( 'Nav, links and Hover', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_button_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_button_color', array(
		'description'       => __( 'Default Buttons and Submit', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_top_bar_bg_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_top_bar_bg_color', array(
		'description'       => __( 'Top Bar Background', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_breaking_news_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_breaking_news_color', array(
		'description'       => __( 'Breaking News', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_feature_news_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_feature_news_color', array(
		'description'       => __( 'Feature News', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_tag_widget_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_tag_widget_color', array(
		'description'       => __( 'Tab Widget', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_category_box_widget_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_category_box_widget_color', array(
		'description'       => __( 'Category Box Widgets', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_category_box_widget_2_color', array(
		'default'				=> $color_scheme[3],
		'sanitize_callback'	=> 'sanitize_hex_color',
		'transport'				=> 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_category_box_widget_2_color', array(
		'description'       => __( 'Category Box Widgets 2', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_bbpress_woocommerce_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_bbpress_woocommerce_color', array(
		'description'       => __( 'WooCommerce/ bbPress', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_category_slider_widget_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_category_slider_widget_color', array(
		'description'       => __( 'Category Slider Widget', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

	$wp_customize->add_setting( 'magbook_category_grid_widget_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_category_grid_widget_color', array(
		'description'       => __( 'Category Grid Widget', 'magbook' ),
		'section'     => 'color_styles',
	) ) );

/********************* Category Color**********************************************/
	$magbook_categories = get_terms( 'category' );
	foreach ( $magbook_categories as $magbook_category_list ) {
		$wp_customize->add_setting( 'magbook_category_color_'.esc_html( strtolower( $magbook_category_list->name ) ), array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magbook_category_color_'.esc_html( strtolower( $magbook_category_list->name ) ), array(
			'label'       => sprintf( esc_html__( ' %s', 'magbook' ), esc_html( $magbook_category_list->name ) ),
			'section'     => 'category_colors',
		) ) );
	}
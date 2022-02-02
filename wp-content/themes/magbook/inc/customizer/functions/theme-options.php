<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
$magbook_settings = magbook_get_theme_options();
/********************** MAGBOOK WORDPRESS DEFAULT PANEL ***********************************/
$wp_customize->add_section('header_image', array(
'title' => __('Header Media', 'magbook'),
'priority' => 20,
'panel' => 'magbook_wordpress_default_panel'
));
$wp_customize->add_section('colors', array(
'title' => __('Colors', 'magbook'),
'priority' => 30,
'panel' => 'magbook_wordpress_default_panel'
));
$wp_customize->add_section('background_image', array(
'title' => __('Background Image', 'magbook'),
'priority' => 40,
'panel' => 'magbook_wordpress_default_panel'
));
$wp_customize->add_section('nav', array(
'title' => __('Navigation', 'magbook'),
'priority' => 50,
'panel' => 'magbook_wordpress_default_panel'
));
$wp_customize->add_section('static_front_page', array(
'title' => __('Static Front Page', 'magbook'),
'priority' => 60,
'panel' => 'magbook_wordpress_default_panel'
));
$wp_customize->add_section('title_tagline', array(
	'title' => __('Site Title & Logo Options', 'magbook'),
	'priority' => 10,
	'panel' => 'magbook_wordpress_default_panel'
));

$wp_customize->add_section('magbook_custom_header', array(
	'title' => __('Magbook Options', 'magbook'),
	'priority' => 503,
	'panel' => 'magbook_options_panel'
));

$wp_customize->add_section( 'search_text', array(
   'title'    => __('Search Text', 'magbook'),
   'priority'       => 508,
   'panel' => 'magbook_options_panel'
));

$wp_customize->add_section( 'excerpt_tag_setting', array(
   'title'    => __('Excert Text/ Excerpt Length', 'magbook'),
   'priority'       => 509,
   'panel' => 'magbook_options_panel'
));

$wp_customize->add_section('magbook_footer_image', array(
	'title' => __('Footer Background Image', 'magbook'),
	'priority' => 510,
	'panel' => 'magbook_options_panel'
));

/********************  MAGBOOK THEME OPTIONS ******************************************/
$wp_customize->add_setting('magbook_theme_options[magbook_logo_sitetitle_display]', array(
	'capability' => 'edit_theme_options',
	'default' => $magbook_settings['magbook_logo_sitetitle_display'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('magbook_theme_options[magbook_logo_sitetitle_display]', array(
	'label' => __('Display Logo/ Site title Position', 'magbook'),
	'priority' => 101,
	'section' => 'title_tagline',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'above_menubar' => __('Above Menubar (Default)','magbook'),
		'above_topbar' => __('Above Top Bar','magbook'),
		'below_menubar' => __('Below Menubar','magbook'),
	),
));

$wp_customize->add_setting('magbook_theme_options[magbook_header_display]', array(
	'capability' => 'edit_theme_options',
	'default' => $magbook_settings['magbook_header_display'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('magbook_theme_options[magbook_header_display]', array(
	'label' => __('Site Logo/ Text Options', 'magbook'),
	'priority' => 105,
	'section' => 'title_tagline',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'header_text' => __('Display Site Title Only','magbook'),
		'header_logo' => __('Display Site Logo Only','magbook'),
		'show_both' => __('Show Both','magbook'),
		'disable_both' => __('Disable Both','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_logo_high_resolution]', array(
	'default' => $magbook_settings['magbook_logo_high_resolution'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_logo_high_resolution]', array(
	'priority'=>110,
	'label' => __('Logo for high resolution screen(Use 2X size image)', 'magbook'),
	'section' => 'title_tagline',
	'type' => 'checkbox',
));

$wp_customize->add_setting('magbook_theme_options[magbook_header_design_layout]', array(
	'default' => $magbook_settings['magbook_header_design_layout'],
	'sanitize_callback' => 'magbook_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('magbook_theme_options[magbook_header_design_layout]', array(
	'priority' =>120,
	'label' => __('Header Design Layout', 'magbook'),
	'section' => 'title_tagline',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'' => __('Default','magbook'),
		'top-logo-title' => __('Top/center logo & site title','magbook'),
	),
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_slider_button]', array(
	'default' => $magbook_settings['magbook_slider_button'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_slider_button]', array(
	'priority'=>10,
	'label' => __('Disable Slider Button', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_search_custom_header]', array(
	'default' => $magbook_settings['magbook_search_custom_header'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_search_custom_header]', array(
	'priority'=>20,
	'label' => __('Disable Search Form', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_side_menu]', array(
	'default' => $magbook_settings['magbook_side_menu'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_side_menu]', array(
	'priority'=>25,
	'label' => __('Disable Side Menu', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_stick_menu]', array(
	'default' => $magbook_settings['magbook_stick_menu'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_stick_menu]', array(
	'priority'=>30,
	'label' => __('Disable Stick Menu', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_scroll]', array(
	'default' => $magbook_settings['magbook_scroll'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_scroll]', array(
	'priority'=>40,
	'label' => __('Disable Goto Top', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_top_social_icons]', array(
	'default' => $magbook_settings['magbook_top_social_icons'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_top_social_icons]', array(
	'priority'=>50,
	'label' => __('Disable Top Social Icons', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_side_menu_social_icons]', array(
	'default' => $magbook_settings['magbook_side_menu_social_icons'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_side_menu_social_icons]', array(
	'priority'=>60,
	'label' => __('Disable Side Menu Social Icons', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_buttom_social_icons]', array(
	'default' => $magbook_settings['magbook_buttom_social_icons'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_buttom_social_icons]', array(
	'priority'=>70,
	'label' => __('Disable Bottom Social Icons', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_display_page_single_featured_image]', array(
	'default' => $magbook_settings['magbook_display_page_single_featured_image'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_display_page_single_featured_image]', array(
	'priority'=>100,
	'label' => __('Disable Page/Single Featured Image', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_disable_main_menu]', array(
	'default' => $magbook_settings['magbook_disable_main_menu'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_disable_main_menu]', array(
	'priority'=>120,
	'label' => __('Disable Main Menu', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_current_date]', array(
	'default' => $magbook_settings['magbook_current_date'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_current_date]', array(
	'priority'=>130,
	'label' => __('Disable Header Current Date', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_disable_cat_color_menu]', array(
	'default' => $magbook_settings['magbook_disable_cat_color_menu'],
	'sanitize_callback' => 'magbook_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_disable_cat_color_menu]', array(
	'priority'=>140,
	'label' => __('Disable Category Color from Menu', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'magbook_theme_options[magbook_reset_all]', array(
	'default' => $magbook_settings['magbook_reset_all'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'magbook_reset_alls',
	'transport' => 'postMessage',
));
$wp_customize->add_control( 'magbook_theme_options[magbook_reset_all]', array(
	'priority'=>150,
	'label' => __('Reset all default settings. (Refresh it to view the effect)', 'magbook'),
	'section' => 'magbook_custom_header',
	'type' => 'checkbox',
));

/********************Search Text ******************************************/

$wp_customize->add_setting( 'magbook_theme_options[magbook_search_text]', array(
   'default'           => $magbook_settings['magbook_search_text'],
   'sanitize_callback' => 'sanitize_text_field',
   'type'                  => 'option',
   'capability'            => 'manage_options'
   )
);
$wp_customize->add_control( 'magbook_theme_options[magbook_search_text]', array(
   'label' => __('Search Text','magbook'),
   'section' => 'search_text',
   'type'     => 'text'
   )
);
/********************Excert Text/ Excerpt Length ******************************************/
$wp_customize->add_setting( 'magbook_theme_options[magbook_tag_text]', array(
   'default'           => $magbook_settings['magbook_tag_text'],
   'sanitize_callback' => 'sanitize_text_field',
   'type'                  => 'option',
   'capability'            => 'manage_options'
   )
);
$wp_customize->add_control( 'magbook_theme_options[magbook_tag_text]', array(
   'label' => __('Excerpt Text','magbook'),
   'section' => 'excerpt_tag_setting',
   'type'     => 'text'
   )
);
$wp_customize->add_setting( 'magbook_theme_options[magbook_excerpt_length]', array(
   'default'           => $magbook_settings['magbook_excerpt_length'],
   'sanitize_callback' => 'magbook_numeric_value',
   'type'                  => 'option',
   'capability'            => 'manage_options'
   )
);
$wp_customize->add_control( 'magbook_theme_options[magbook_excerpt_length]', array(
   'label' => __('Excerpt length','magbook'),
   'section' => 'excerpt_tag_setting',
   'type'     => 'text'
   )
);

/********************** Footer Background Image ***********************************/
$wp_customize->add_setting( 'magbook_theme_options[magbook_img-upload-footer-image]',array(
	'default'	=> $magbook_settings['magbook_img-upload-footer-image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magbook_theme_options[magbook_img-upload-footer-image]', array(
	'label' => __('Footer Background Image','magbook'),
	'description' => __('Image will be displayed on footer','magbook'),
	'priority'	=> 50,
	'section' => 'magbook_footer_image',
	)
));
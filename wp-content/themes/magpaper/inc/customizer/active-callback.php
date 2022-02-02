<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */


if ( ! function_exists( 'magpaper_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Magpaper 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function magpaper_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'magpaper_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'magpaper_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Magpaper 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function magpaper_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'magpaper_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if header section is enabled.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_header_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magpaper_theme_options[header_section_enable]' )->value() );
}


/**
 * Check if header right section is enabled.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_header_right_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magpaper_theme_options[header_right_section_enable]' )->value() );
}


/**
 * Check if hero section is enabled.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_hero_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magpaper_theme_options[hero_section_enable]' )->value() );
}

/**
 * Check if popular_post section is enabled.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_popular_post_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magpaper_theme_options[popular_post_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magpaper_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if blog section content type is category.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_blog_section_content_category_enable( $control ) {
	$content_type = $control->manager->get_setting( 'magpaper_theme_options[blog_content_type]' )->value();
	return magpaper_is_blog_section_enable( $control ) && ( 'category' == $content_type );
}

/**
 * Check if blog section content type is recent.
 *
 * @since Magpaper 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magpaper_is_blog_section_content_recent_enable( $control ) {
	$content_type = $control->manager->get_setting( 'magpaper_theme_options[blog_content_type]' )->value();
	return magpaper_is_blog_section_enable( $control ) && ( 'recent' == $content_type );
}

<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 * @return array An array of default values
 */

function magpaper_get_default_theme_options() {
	$theme_data = wp_get_theme();
	$magpaper_default_options = array(
		// Color Options
		'header_title_color'			=> '#2a2e43',
		'header_tagline_color'			=> '#2a2e43',
		'header_txt_logo_extra'			=> 'show-all',

		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',


		// excerpt options
		'long_excerpt_length'           => 25,
		'read_more_text'           		=> esc_html__( 'Continue Reading', 'magpaper' ),
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'magpaper' ), '[the-year]', '[site-link]' ),
		'powered_by_text'           	=> esc_html__( 'All Rights Reserved | ', 'magpaper' ) . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'magpaper' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>',
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'magpaper' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,
		'hide_author'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// Header
		'header_section_enable'		=> false,

		// Header right
		'header_right_section_enable'		=> false,

		// Header
		'hero_section_enable'		=> false,

		// Popular post
		'popular_post_section_enable'	=> false,
		'popular_post_title'			=> esc_html__( 'The Highlights', 'magpaper' ),

		// blog
		'blog_section_enable'			=> false,
		'blog_section_title'			=> esc_html__( 'Latest Posts', 'magpaper' ),
		'blog_content_type'				=> 'recent',

	);

	$output = apply_filters( 'magpaper_default_theme_options', $magpaper_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}
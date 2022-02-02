<?php
/**
 * Default theme options.
 *
 * @package Easy Magazine
 */

if ( ! function_exists( 'easy_magazine_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function easy_magazine_get_default_theme_options() {

	$defaults = array();

	// Top Bar
	$defaults['show_header_contact_info'] 		= false;
    $defaults['show_header_social_links'] 		= false;
    $defaults['header_social_links']			= array();

    // Homepage Options
	$defaults['enable_frontpage_content'] 		= false;

	// Breaking News Section	
	$defaults['enable_breaking_news_section']		= false;
	$defaults['breaking_news_section_title']		= esc_html__( 'Breaking News', 'easy-magazine' );
	$defaults['number_of_breaking_news_items']		= 3;
	$defaults['breaking_news_content_type']			= 'breaking_news_page';

	// Highlighted Posts Section	
	$defaults['enable_highlighted_posts_section']		= false;
	$defaults['number_of_highlighted_posts_items']		= 5;
	$defaults['highlighted_posts_content_type']			= 'highlighted_posts_page';

	// Featured Posts Section	
	$defaults['enable_featured_posts_section']		= false;
	$defaults['featured_posts_section_title']		= esc_html__( 'Featured Posts', 'easy-magazine' );
	$defaults['number_of_featured_posts_items']		= 3;
	$defaults['featured_posts_content_type']		= 'featured_posts_page';

	// Recent Posts Section	
	$defaults['enable_recent_posts_section']		= false;
	$defaults['recent_posts_section_title']			= esc_html__( 'Recent Posts', 'easy-magazine' );
	$defaults['number_of_recent_posts_items']		= 4;
	$defaults['recent_posts_content_type']			= 'recent_posts_page';

	// Popular Posts Section	
	$defaults['enable_popular_posts_section']		= false;
	$defaults['popular_posts_section_title']		= esc_html__( 'Popular Posts', 'easy-magazine' );
	$defaults['number_of_popular_posts_items']		= 2;
	$defaults['popular_posts_content_type']			= 'popular_posts_page';

	// Trending Posts Section	
	$defaults['enable_trending_posts_section']		= false;
	$defaults['trending_posts_section_title']		= esc_html__( 'Trending Posts', 'easy-magazine' );
	$defaults['number_of_trending_posts_items']		= 4;
	$defaults['trending_posts_content_type']		= 'trending_posts_page';

	// Latest Posts Section
	$defaults['enable_blog_section']		= false;
	$defaults['blog_section_title']			= esc_html__( 'Latest Posts', 'easy-magazine' );
	$defaults['blog_category']	   			= 0; 
	$defaults['blog_number']				= 4;	

	//General Section
	$defaults['your_latest_posts_title']		= esc_html__('Blog','easy-magazine');
	$defaults['excerpt_length']					= 15;
	$defaults['layout_options_blog']			= 'no-sidebar';
	$defaults['layout_options_archive']			= 'no-sidebar';
	$defaults['layout_options_page']			= 'no-sidebar';	
	$defaults['layout_options_single']			= 'right-sidebar';	

	//Footer section 		
	$defaults['copyright_text']					= esc_html__( 'Copyright &copy; All rights reserved.', 'easy-magazine' );

	// Pass through filter.
	$defaults = apply_filters( 'easy_magazine_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'easy_magazine_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function easy_magazine_get_option( $key ) {

		$default_options = easy_magazine_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;
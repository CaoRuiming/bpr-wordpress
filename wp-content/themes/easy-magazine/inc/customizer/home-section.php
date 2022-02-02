<?php
/**
 * Home Page Options.
 *
 * @package Easy Magazine
 */

$default = easy_magazine_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'home_page_panel',
	array(
	'title'      => __( 'Front Page Sections', 'easy-magazine' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

/**
* Section Customizer Options.
*/
require get_template_directory() . '/inc/customizer/home-sections/breaking-news.php';
require get_template_directory() . '/inc/customizer/home-sections/highlighted-posts.php';
require get_template_directory() . '/inc/customizer/home-sections/featured-posts.php';
require get_template_directory() . '/inc/customizer/home-sections/recent-posts.php';
require get_template_directory() . '/inc/customizer/home-sections/popular-posts.php';
require get_template_directory() . '/inc/customizer/home-sections/trending-posts.php';
require get_template_directory() . '/inc/customizer/home-sections/blog.php';


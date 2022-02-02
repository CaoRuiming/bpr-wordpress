<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Magpaper
	 * @since Magpaper 1.0.0
	 */

	/**
	 * magpaper_doctype hook
	 *
	 * @hooked magpaper_doctype -  10
	 *
	 */
	do_action( 'magpaper_doctype' );

?>
<head>
<?php
	/**
	 * magpaper_before_wp_head hook
	 *
	 * @hooked magpaper_head -  10
	 *
	 */
	do_action( 'magpaper_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * magpaper_page_start_action hook
	 *
	 * @hooked magpaper_page_start -  10
	 *
	 */
	do_action( 'magpaper_page_start_action' ); 

	/**
	 * magpaper_loader_action hook
	 *
	 * @hooked magpaper_loader -  10
	 * @hooked magpaper_top_bar -  20
	 *
	 */
	do_action( 'magpaper_before_header' );

	/**
	 * magpaper_header_action hook
	 *
	 * @hooked magpaper_header_start -  10
	 * @hooked magpaper_left_side_post -  15
	 * @hooked magpaper_site_branding -  20
	 * @hooked magpaper_right_side_post -  25
	 * @hooked magpaper_site_navigation -  30
	 * @hooked magpaper_header_end -  40
	 * @hooked magpaper_content_start -  50
	 *
	 */
	do_action( 'magpaper_header_action' );

    if ( magpaper_is_frontpage() ) {
    	/**
		 * magpaper_primary_content hook
		 *
		 * @hooked magpaper_add_hero_section -  10
		 * @hooked magpaper_add_popular_post_section -  20
		 * @hooked magpaper_social_menu -  55
		 *
		 */
		do_action( 'magpaper_primary_content' );
	}
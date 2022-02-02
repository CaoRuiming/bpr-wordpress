<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package News Block
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php 
		wp_body_open();

		/**
		 * hook - news_block_site_preloader_hook
		 * 
		 * @hooked - news_block_site_preloader - 10
		 * 
		 */
		if( has_action( 'news_block_site_preloader_hook' ) ) {
			do_action( 'news_block_site_preloader_hook' );
		}
	?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'news-block' ); ?></a>
	<?php
		/**
		 * hook - news_block_top_header_hook
		 * 
		 * @hooked - news_block_top_header_date
		 * 
		 */
		if( has_action( 'news_block_top_header_hook' ) ) {
			do_action( 'news_block_top_header_hook' );
		}
		
		/**
		 * hook - news_block_header_hook
		 * 
		 * @hooked - news_block_header_start - 
		 * @hooked - news_block_header_site_sec_wrap_open
		 * @hooked - news_block_header_site_branding
		 * @hooked - news_block_header_ad_banner
		 * @hooked - news_block_header_site_sec_wrap_close
		 * @hooked - news_block_header_main_menu_sec_wrap_open
		 * @hooked - news_block_header_main_menu
		 * @hooked - news_block_header_search_bar
		 * @hooked - news_block_header_main_menu_sec_wrap_close
		 * @hooked - news_block_header_close
		 * 
		 */
		if( has_action( 'news_block_header_hook' ) ) {
			do_action( 'news_block_header_hook' );
		}

		/**
		 * hook - news_block_before_content_hook
		 * 
		 * @hooked - 
		 * 
		 */
		if( has_action( 'news_block_before_content_hook' ) ) {
			do_action( 'news_block_before_content_hook' );
		}
	?>
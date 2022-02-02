<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Easy Magazine
 */
/**
* Hook - easy_magazine_action_doctype.
*
* @hooked easy_magazine_doctype -  10
*/
do_action( 'easy_magazine_action_doctype' );
?>
<head>
<?php
/**
* Hook - easy_magazine_action_head.
*
* @hooked easy_magazine_head -  10
*/
do_action( 'easy_magazine_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php

/**
* Hook - easy_magazine_action_before.
*
* @hooked easy_magazine_page_start - 10
*/
do_action( 'easy_magazine_action_before' );

/**
*
* @hooked easy_magazine_header_start - 10
*/
do_action( 'easy_magazine_action_before_header' );

/**
*
*@hooked easy_magazine_site_branding - 10
*@hooked easy_magazine_header_end - 15 
*/
do_action('easy_magazine_action_header');

/**
*
* @hooked easy_magazine_content_start - 10
*/
do_action( 'easy_magazine_action_before_content' );

/**
 * Banner start
 * 
 * @hooked easy_magazine_banner_header - 10
*/
do_action( 'easy_magazine_banner_header' );  

<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Easy Magazine
 */

/**
 *
 * @hooked easy_magazine_footer_start
 */
do_action( 'easy_magazine_action_before_footer' );

/**
 * Hooked - easy_magazine_footer_top_section -10
 * Hooked - easy_magazine_footer_section -20
 */
do_action( 'easy_magazine_action_footer' );

/**
 * Hooked - easy_magazine_footer_end. 
 */
do_action( 'easy_magazine_action_after_footer' );

wp_footer(); ?>

</body>  
</html>
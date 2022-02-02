<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

/**
 * magpaper_footer_primary_content hook
 *
 * @hooked magpaper_add_contact_section -  10
 *
 */
do_action( 'magpaper_footer_primary_content' );

/**
 * magpaper_content_end_action hook
 *
 * @hooked magpaper_content_end -  10
 *
 */
do_action( 'magpaper_content_end_action' );

/**
 * magpaper_content_end_action hook
 *
 * @hooked magpaper_footer_start -  10
 * @hooked Magpaper_Footer_Widgets->add_footer_widgets -  20
 * @hooked magpaper_footer_site_info -  40
 * @hooked magpaper_footer_end -  100
 *
 */
do_action( 'magpaper_footer' );

/**
 * magpaper_page_end_action hook
 *
 * @hooked magpaper_page_end -  10
 *
 */
do_action( 'magpaper_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>

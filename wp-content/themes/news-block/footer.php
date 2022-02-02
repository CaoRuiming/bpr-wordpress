<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package News Block
 */

 /**
  * hook - news_block_footer_hook
  *
  * @hooked - news_block_footer_start
  * @hooked - news_block_footer_close
  *
  */
  	if( has_action( 'news_block_footer_hook' ) ) {
		do_action( 'news_block_footer_hook' );
	}

  /**
  * hook - news_block_bottom_footer_hook
  *
  * @hooked - news_block_bottom_footer_start
  * @hooked - news_block_bottom_footer_site_logo
  * @hooked - news_block_bottom_footer_menu
  * @hooked - news_block_bottom_footer_site_info
  * @hooked - news_block_bottom_footer_close
  *
  */
  	if( has_action( 'news_block_bottom_footer_hook' ) ) {
	  	do_action( 'news_block_bottom_footer_hook' );
  	}

    /**
    * hook - news_block_after_footer_hook
    *
    * @hooked - news_block_scroll_to_top
    *
    */
  	if( has_action( 'news_block_after_footer_hook' ) ) {
	  	do_action( 'news_block_after_footer_hook' );
  	}
?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

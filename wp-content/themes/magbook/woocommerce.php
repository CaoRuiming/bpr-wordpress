<?php
/**
 * This template to displays woocommerce page
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

get_header();
	$magbook_settings = magbook_get_theme_options();
	global $magbook_content_layout;
	if( $post ) {
		$layout = get_post_meta( get_queried_object_id(), 'magbook_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	} ?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php woocommerce_content(); ?>
		</main><!-- end #main -->
	</div> <!-- #primary -->
<?php 
if( 'default' == $layout ) { //Settings from customizer
	if(($magbook_settings['magbook_sidebar_layout_options'] != 'nosidebar') && ($magbook_settings['magbook_sidebar_layout_options'] != 'fullwidth')){ ?>
<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Side Sidebar','magbook');?>">
	<?php }
} 
	if( 'default' == $layout ) { //Settings from customizer
		if(($magbook_settings['magbook_sidebar_layout_options'] != 'nosidebar') && ($magbook_settings['magbook_sidebar_layout_options'] != 'fullwidth')): ?>
		<?php dynamic_sidebar( 'magbook_woocommerce_sidebar' ); ?>
</aside><!-- end #secondary -->
<?php endif;
	}
?>
</div><!-- end .wrap -->
<?php
get_footer();
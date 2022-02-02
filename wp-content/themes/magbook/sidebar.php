<?php
/**
 * The sidebar containing the main Sidebar area.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
	$magbook_settings = magbook_get_theme_options();
	global $magbook_content_layout;
	if( $post ) {
		$layout = get_post_meta( get_queried_object_id(), 'magbook_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}

if( 'default' == $layout ) { //Settings from customizer
	if(($magbook_settings['magbook_sidebar_layout_options'] != 'nosidebar') && ($magbook_settings['magbook_sidebar_layout_options'] != 'fullwidth')){ ?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Side Sidebar','magbook');?>">
<?php }
}else{ // for page/ post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){ ?>
<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Side Sidebar','magbook');?>">
  <?php }
	}?>
  <?php 
	if( 'default' == $layout ) { //Settings from customizer
		if(($magbook_settings['magbook_sidebar_layout_options'] != 'nosidebar') && ($magbook_settings['magbook_sidebar_layout_options'] != 'fullwidth')): ?>
  <?php dynamic_sidebar( 'magbook_main_sidebar' ); ?>
</aside><!-- end #secondary -->
<?php endif;
	}else{ // for page/post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){
			dynamic_sidebar( 'magbook_main_sidebar' );
			echo '</aside><!-- end #secondary -->';
		}
	}
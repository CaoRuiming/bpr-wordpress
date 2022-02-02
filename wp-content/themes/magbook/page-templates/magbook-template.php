<?php
/**
 * Template Name: Magbook Template
 *
 * Displays Magazine template.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
get_header(); ?>
<div class="wrap">
	<?php 	if( is_active_sidebar( 'magbook_primary_fullwidth' ) && class_exists('Magbook_Plus_Features') ){
		echo '<div class="primary-full-width clearfix">';
			dynamic_sidebar ('magbook_primary_fullwidth');
		echo '</div>';
	} ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php 
			if( is_active_sidebar( 'magbook_template_section' )){
				dynamic_sidebar( 'magbook_template_section' );
			}

		the_content(); ?>
		</main><!-- end #main -->
	</div> <!-- end #primary -->
	
		<?php if( is_active_sidebar( 'magbook_template_sidebar_section' )){ ?>
		<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Side Sidebar','magbook');?>">
			<?php dynamic_sidebar( 'magbook_template_sidebar_section' ); ?>
		</aside> <!-- end #secondary -->
	<?php	}
	if( is_active_sidebar( 'magbook_seondary_fullwidth' ) && class_exists('Magbook_Plus_Features') ){
		echo '<div class="secondary-full-width clearfix">';
			dynamic_sidebar ('magbook_seondary_fullwidth');
		echo '</div>';
	} ?>
	
</div><!-- end .wrap -->


<?php get_footer();
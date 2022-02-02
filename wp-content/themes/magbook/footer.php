<?php
/**
 * The template for displaying the footer.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

$magbook_settings = magbook_get_theme_options(); ?>
</div><!-- end #content -->
<!-- Footer Start ============================================= -->
<footer id="colophon" class="site-footer" role="contentinfo">
<?php
 
$footer_column = $magbook_settings['magbook_footer_column_section'];
	if( is_active_sidebar( 'magbook_footer_1' ) || is_active_sidebar( 'magbook_footer_2' ) || is_active_sidebar( 'magbook_footer_3' ) || is_active_sidebar( 'magbook_footer_4' )) { ?>
	<div class="widget-wrap" <?php if($magbook_settings['magbook_img-upload-footer-image'] !=''){?>style="background-image:url('<?php echo esc_url($magbook_settings['magbook_img-upload-footer-image']); ?>');" <?php } ?>>
		<div class="wrap">
			<div class="widget-area">
			<?php
				if($footer_column == '1' || $footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_1' ) ) :
						dynamic_sidebar( 'magbook_footer_1' );
					endif;
				echo '</div><!-- end .column'.absint($footer_column). '  -->';
				}
				if($footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_2' ) ) :
						dynamic_sidebar( 'magbook_footer_2' );
					endif;
				echo '</div><!--end .column'.absint($footer_column).'  -->';
				}
				if($footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_3' ) ) :
						dynamic_sidebar( 'magbook_footer_3' );
					endif;
				echo '</div><!--end .column'.absint($footer_column).'  -->';
				}
				if($footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_4' ) ) :
						dynamic_sidebar( 'magbook_footer_4' );
					endif;
				echo '</div><!--end .column'.absint($footer_column).  '-->';
				}
				?>
			</div> <!-- end .widget-area -->
		</div><!-- end .wrap -->
	</div> <!-- end .widget-wrap -->
	<?php } ?>
	<div class="site-info">
		<div class="wrap">
			<?php
			if($magbook_settings['magbook_buttom_social_icons'] == 0):
				do_action('magbook_social_links');
			endif; ?>
			<div class="copyright-wrap clearfix">
				<?php 
				 do_action('magbook_footer_menu');
				 
				 if ( is_active_sidebar( 'magbook_footer_options' ) ) :
					dynamic_sidebar( 'magbook_footer_options' );
				else:
					echo '<div class="copyright">'; ?>
					<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name', 'display' ); ?></a> | 
									<?php esc_html_e('Designed by:','magbook'); ?> <a title="<?php echo esc_attr__( 'Theme Freesia', 'magbook' ); ?>" target="_blank" href="<?php echo esc_url( 'https://themefreesia.com' ); ?>"><?php esc_html_e('Theme Freesia','magbook');?></a> |
									<?php date_i18n(__('Y','magbook')) ; ?> <a title="<?php echo esc_attr__( 'WordPress', 'magbook' );?>" target="_blank" href="<?php echo esc_url( 'https://wordpress.org' );?>"><?php esc_html_e('WordPress','magbook'); ?></a>  | <?php echo '&copy; ' . esc_html__('Copyright All right reserved ','magbook'); ?>
								</div>
				<?php endif; ?>
			</div> <!-- end .copyright-wrap -->
			<div style="clear:both;"></div>
		</div> <!-- end .wrap -->
	</div> <!-- end .site-info -->
	<?php
		$disable_scroll = $magbook_settings['magbook_scroll'];
		if($disable_scroll == 0):?>
			<button class="go-to-top" type="button">
				<span class="icon-bg"></span>
				<span class="back-to-top-text"><?php esc_html_e('Top','magbook'); ?></span>
				<i class="fa fa-angle-up back-to-top-icon"></i>
			</button>
	<?php endif; ?>
	<div class="page-overlay"></div>
</footer> <!-- end #colophon -->
</div><!-- end .site-content-contain -->
</div><!-- end #page -->
<?php wp_footer(); ?>
</body>
</html>
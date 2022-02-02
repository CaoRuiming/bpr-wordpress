<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('hentry'); ?>>
	<div class="entry-container">
		<div class="entry-meta">
            <?php magpaper_single_author(); ?>
        </div><!-- .entry-meta -->
		<div class="entry-container">
			<div class="entry-content">
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'magpaper' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'magpaper' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		</div><!-- .entry-container -->

		<div class="entry-meta entry-footer-meta">
			<?php magpaper_entry_footer(); ?>
		</div>

	</div><!-- .entry-container -->
</article><!-- #post-## -->

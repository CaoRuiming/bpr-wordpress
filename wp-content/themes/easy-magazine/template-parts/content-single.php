<?php 
 /*
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Easy Magazine
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'easy-magazine' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php easy_magazine_posts_tags(); ?>
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'easy-magazine' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>	

	<div class="entry-meta">
		<?php easy_magazine_posted_on();
		easy_magazine_entry_meta(); ?>
	</div><!-- .entry-meta -->	
</article><!-- #post-## -->
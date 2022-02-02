<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Block
 * @since 1.0.0
 * 
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bmm-post'); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="bmm-post-thumb">
			<?php news_block_post_thumbnail(); ?>
		</div>
	<?php endif; ?>
	
	<div class="post-elements-wrapper">
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="bmm-post-title">', '</h1>' );
			else :
				the_title( '<h2 class="bmm-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="bmm-post-meta">
				
					<?php news_block_entry_footer(); ?>
					
					<?php news_block_posted_on(); ?>
				</div>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			news_block_get_content_type();
				$content_type = news_block_get_content_type();
				switch( $content_type ) {
					case 'excerpt': the_excerpt();
								break;
					default : the_content(
										sprintf(
											wp_kses(
												/* translators: %s: Name of current post. Only visible to screen readers */
												__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'news-block' ),
												array(
													'span' => array(
														'class' => array(),
													),
												)
											),
											wp_kses_post( get_the_title() )
										)
									);
								break;
				}

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'news-block' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->

		<?php
		
		news_block_posted_by();
		
		/**
		 * hook - news_block_archive_single_post_before_article_hook
		 * 
		 * @hooked - news_block_archive_read_more_button - 10
		 * 
		 */
			if( has_action( 'news_block_archive_single_post_before_article_hook' ) ) {
				do_action( 'news_block_archive_single_post_before_article_hook' );
			}
        ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
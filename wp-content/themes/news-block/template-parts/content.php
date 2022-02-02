<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Block
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bmm-post .bmm-block-post-list--layout-one'); ?>>
	<div class="post-elements-wrapper">
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="bmm-post-title">', '</h1>' );
			else :
				the_title( '<h2 class="bmm-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

				if (has_post_thumbnail()):
			?>
					<div class="bmm-post-thumb">
						<?php news_block_post_thumbnail(); ?>
					</div>	
			<?php
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
        ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

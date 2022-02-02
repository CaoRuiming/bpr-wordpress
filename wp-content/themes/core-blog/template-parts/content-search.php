<?php
	$readmore=get_theme_mod('core_blog_read_more_label', esc_html__('continue reading', 'core-blog'));
?>
	<article class="post">
				<header>
					<div class="title">
						<?php
						if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
						else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;

						if ( 'post' === get_post_type() ) :
						?>
						<div class="entry-meta">
						
						</div><!-- .entry-meta -->
						<?php endif; ?>
					</div>
					<div class="meta">
						<?php core_blog_posted_on();?>
						<?php core_blog_posted_by(); ?>
					</div>
				</header>
				<?php core_blog_post_thumbnail(); ?>
				<?php
                    if (is_singular()) {
                        the_content();
                    } else {
                            the_excerpt();
                    }
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'core-blog'),
                        'after' => '</div>',
                    ));
                 ?>
				<footer>
					<ul class="actions">
						<li><a class="button large" href="<?php the_permalink();?>">
                        <?php echo esc_html($readmore);?>
                    </a></li>
					</ul>
					<ul class="stats">
						<?php core_blog_entry_footer();?>
					</ul>
				</footer>
	</article>
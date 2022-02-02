<?php
$readmore=get_theme_mod('core_blog_read_more_label', esc_html__('continue reading', 'core-blog'));
$post_view = get_theme_mod('core_blog_archive_co_view',true);
$post_author = get_theme_mod('core_blog_archive_co_post_author',true);
$post_date = get_theme_mod('core_blog_archive_co_post_date',true);
$post_image = get_theme_mod('core_blog_archive_co_featured_image',true);
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
					<?php if($post_date!='' || $post_author!=''){?>
					<div class="meta">
						<?php 
							if($post_date){
							  core_blog_posted_on();
							}
							if($post_author){
							  core_blog_posted_by();
							}  
						?>
					</div>
					<?php } ?>
				</header>
				<?php if($post_image){?>
				<span class="image featured"><?php core_blog_post_thumbnail(); ?></span>
				<?php
					}
                    if (is_singular()) {
                            the_content();
                    } else {
                            the_excerpt();
                    }
                 ?>
				<footer>
					<?php if($readmore){?>
					<ul class="actions">
						<li><a class="button large" href="<?php the_permalink();?>">
                        <?php echo esc_html($readmore);?>
                    </a></li>
					</ul>
					<?php } ?>
					<ul class="stats">
						<?php core_blog_entry_footer();

						if($post_view){
						?>
						<li>
							<i class="fa fa-eye"></i>
			                <?php if(core_blog_get_post_view()!=0){ 
			                     echo esc_html(core_blog_get_post_view()); 
			                 } else {
			                    	echo esc_html('0');
			                 }?>
						</li>
						<?php } ?>
					</ul>
				</footer>
			</article>
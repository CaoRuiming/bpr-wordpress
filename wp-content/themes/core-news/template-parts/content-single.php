<?php core_blog_set_post_view(); 

$post_category = get_theme_mod('core_blog_single_co_post_category',true);
$post_view = get_theme_mod('core_blog_single_co_view',true);
$post_author = get_theme_mod('core_blog_single_co_post_author',true);
$post_date = get_theme_mod('core_blog_single_co_post_date',true);
$post_image = get_theme_mod('core_blog_single_co_featured_image_post',true);
?>

<!-- Post -->
	<article class="post">
		<div class="entry-cover">
			<?php if($post_image){ ?>
			<span class="image featured"><?php core_blog_post_thumbnail(); ?></span>
			<?php
			}?>
		</div>
		<div class="entry-content">
			<div class="entry-header-single	">
				<span class="post-category">
					<?php core_blog_entry_footer();?>		
				</span>
				<div class="post-meta">
				<?php
					if ( is_singular() ) :
			        the_title( '<h1 class="mb-20">', '</h1>' );
			        else :
			        the_title( '<h2 class="mb-20"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			        endif;
				?>
				</div>
				<?php if($post_date!='' || $post_author!=''){?>
			<div class="meta">
				<?php 
				if($post_author){
					core_blog_posted_by(); 
				}
				if($post_date){
					?>
						<span class="posted-date">
                        	<time>
                        		<?php  if($post_date){
							  				core_blog_posted_on();
										}
								?>
							</time>
                    	</span>
					<?php
				}

			if($post_view){
				?>
				<span class="viewcount">
					<i class="fa fa-eye"></i>
		            <?php if(core_blog_get_post_view()!=0){ 
		                 echo esc_html(core_blog_get_post_view()); 
		             } else {
		                	echo esc_html('0');
		             }?>
				</span>
			<?php } 
				
				?>
			</div>
			<?php } ?>
			</div>
			<?php
                if (is_singular()) {
                    the_content();
                } else {
                        the_excerpt();
                }
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'core-news'),
                    'after' => '</div>',
                ));
         	?>
		</div>
	</article>
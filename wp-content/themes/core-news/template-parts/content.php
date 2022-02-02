<?php
$readmore=get_theme_mod('core_blog_read_more_label', esc_html__('read more', 'core-news'));
$post_view = get_theme_mod('core_blog_archive_co_view',true);
$post_author = get_theme_mod('core_blog_archive_co_post_author',true);
$post_date = get_theme_mod('core_blog_archive_co_post_date',true);
$post_image = get_theme_mod('core_blog_archive_co_featured_image',true);
?>

<div class="row article">
	<?php if(has_post_thumbnail()){ ?>
	<div class="col-md-6 column-756">
		<?php if($post_image) {
			core_blog_post_thumbnail();
			}
		?>

		<div class="post-meta">
			<span class="byline">
				<?php
				if($post_author){
					core_blog_posted_by(); 
				}
				?>
			</span>
			
			<?php
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
			<?php } ?>
		</div>
	</div>
	<?php } 
	if(!has_post_thumbnail()){
		?>
		<div class="col-md-12">
		<?php
	}
	else{
		?>
		<div class="col-md-6 column-756">
		<?php
	}
	?>
		<div class="entry-content">
			<div class="entry-header">	
				<span class="post-category">
					<?php core_blog_entry_footer();?>										
				</span>
				<h3 class="entry-title">
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
					
				</h3>
			</div>								
			<?php
	            if (is_singular()) {
	                    the_content();
	            } else {
	                    the_excerpt();
	            }
             ?>
			<?php if($readmore){?>
					<a class="readmore" href="<?php the_permalink();?>">
                        <?php echo esc_html($readmore);?>
                    </a>
			<?php } ?>
		</div>
	</div>
</div>
			
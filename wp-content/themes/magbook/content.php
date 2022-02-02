<?php
/**
 * The template for displaying content.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
$magbook_settings = magbook_get_theme_options(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
		<?php $magbook_blog_post_image = $magbook_settings['magbook_blog_post_image'];
		$entry_format_meta_blog = $magbook_settings['magbook_entry_meta_blog'];
		$magbook_tag_text = $magbook_settings['magbook_tag_text'];
		$content_display = $magbook_settings['magbook_blog_content_layout'];
		$tag_list = get_the_tag_list();
		$format = get_post_format();
		if( has_post_thumbnail() && $magbook_blog_post_image == 'on') { ?>
			<div class="post-image-content">
				<figure class="post-featured-image">
					<a href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>">
					<?php the_post_thumbnail('magbook-featured-blog'); ?>
					</a>
				</figure><!-- end.post-featured-image  -->
			</div><!-- end.post-image-content -->
		<?php } ?>
			<header class="entry-header">
				<?php if($entry_format_meta_blog != 'hide-meta' ){ ?> 
					<div class="entry-meta">
						<?php do_action('magbook_post_categories_list_id'); ?>
					</div>
				<?php } ?>
				<h2 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute('echo=0'); ?>"> <?php the_title();?> </a> </h2> <!-- end.entry-title -->

				<?php if($entry_format_meta_blog != 'hide-meta' ){
					echo  '<div class="entry-meta">';
					echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_attr(get_the_author()).'</a></span>';
						printf( '<span class="posted-on"><a href="%1$s" title="%2$s"><i class="fa fa-calendar-o"></i> %3$s</a></span>',
										esc_url(get_the_permalink()),
										esc_attr( get_the_time(get_option( 'date_format' )) ),
										esc_html( get_the_time(get_option( 'date_format' )) )
									);
					if ( comments_open() ) { ?>
							<span class="comments">
							<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'magbook' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'magbook' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'magbook' ), '', __( 'Comments Off', 'magbook' ) ); ?> </span>
					<?php }
						if ( current_theme_supports( 'post-formats', $format ) ) {
								printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
								sprintf( ''),
								esc_url( get_post_format_link( $format ) ),
								esc_html(get_post_format_string( $format ))
							);
						}
						if(!empty($tag_list)){ ?>
							<span class="tag-links">
								<?php   echo get_the_tag_list(); ?>
							</span> <!-- end .tag-links -->
						<?php }
					echo  '</div> <!-- end .entry-meta -->';
				} ?>
			</header><!-- end .entry-header -->
			<div class="entry-content">
				<?php
				if($content_display == 'excerptblog_display'):
						the_excerpt(); ?>
					<a href="<?php echo esc_url(get_permalink());?>" class="more-link"><?php echo esc_html($magbook_tag_text);?><span class="screen-reader-text"> <?php the_title(); ?></span></a><!-- wp-default -->
					<?php else:
						the_content( esc_html($magbook_tag_text));
					endif; ?>
			</div> <!-- end .entry-content -->
			<?php wp_link_pages( array( 
					'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'magbook' ),
					'after'             => '</div>',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'pagelink'          => '%',
					'echo'              => 1
				) ); ?>
		</article><!-- end .post -->
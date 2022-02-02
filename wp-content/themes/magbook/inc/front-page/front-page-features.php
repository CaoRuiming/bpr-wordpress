<?php
/**
 * Front Page Features
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
/* Frontpage Product Featured Brands */
add_action('magbook_display_front_page_feature_news','magbook_frontpage_feature_news');
function magbook_frontpage_feature_news(){
	$magbook_settings = magbook_get_theme_options();
	$entry_format_meta_blog = $magbook_settings['magbook_entry_meta_blog'];
	$magbook_feature_news_title = $magbook_settings['magbook_feature_news_title'];
	$magbook_disable_feature_news = $magbook_settings['magbook_disable_feature_news'];
	$query = new WP_Query(array(
			'posts_per_page' =>  intval($magbook_settings['magbook_total_feature_news']),
			'post_type'					=> 'post',
			'category_name' => esc_attr($magbook_settings['magbook_featured_news_category']),
	));
	if($magbook_disable_feature_news !=1){ ?>
		<div class="feature-news-box">
						<div class="wrap">
							<?php if($magbook_feature_news_title !=''){ ?> 
							<div class="feature-news-header">
								<h2 class="feature-news-title"><?php echo esc_html($magbook_feature_news_title); ?></h2>
							</div>
							<?php } ?> 
							<div class="feature-news-slider">
								<ul class="slides">
									<?php while ($query->have_posts()):$query->the_post(); ?>
									<li>
										<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
											<?php if(has_post_thumbnail() ){ ?>
											<figure class="post-featured-image">
												<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('magbook-featured-image'); ?></a>
												<?php if($entry_format_meta_blog != 'hide-meta' ){
													echo  '<div class="entry-meta">';
														do_action('magbook_post_categories_list_id');
													echo '</div> <!-- end .entry-meta -->';
												} ?>
											</figure>
											<!-- end .post-featured-image -->
											<?php } ?>
											<header class="entry-header">		
												<h2 class="entry-title">
													<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h2>
												<!-- end.entry-title -->
												<?php if($entry_format_meta_blog != 'hide-meta' ){
													echo  '<div class="entry-meta">';
													echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_html(get_the_author()).'</a></span>';
														printf( '<span class="posted-on"><a href="%1$s" title="%2$s"><i class="fa fa-calendar-o"></i> %3$s</a></span>',
																		esc_url(get_the_permalink()),
																		esc_attr( get_the_time(get_option( 'date_format' )) ),
																		esc_html( get_the_time(get_option( 'date_format' )) )
																	);
													if ( comments_open()  && $entry_format_meta_blog != 'hide-comments') { ?>
															<span class="comments">
															<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'magbook' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'magbook' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'magbook' ), '', __( 'Comments Off', 'magbook' ) ); ?> </span>
													<?php }
													echo  '</div> <!-- end .entry-meta -->';
												} ?>
											</header>
											<!-- end .entry-header -->
										</article>
										<!-- end .post -->
									</li>
								<?php endwhile;
								wp_reset_postdata(); ?>
								</ul>
							</div>
							<!-- end .feature-news-slider -->
						</div>
						<!-- end .wrap -->
		</div> <!-- end .feature-news-box -->
<?php }
wp_reset_postdata();
}
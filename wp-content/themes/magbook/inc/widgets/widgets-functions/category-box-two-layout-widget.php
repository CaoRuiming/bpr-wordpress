<?php

/**
 * 
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

class Magbook_category_box_two_column_Widgets extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	function __construct() {
		$widget_ops = array( 'classname' => 'widget-cat-box-2', 'description' => __( 'Display Category box two layout widget', 'magbook') );
		$control_ops = array('width' => 200, 'height' => 250);
		parent::__construct( false, $name=__('TF: Category Box Two Layout Widget','magbook'), $widget_ops, $control_ops );
	}


	function form($instance) {
		$instance = wp_parse_args(( array ) $instance, array('title' => '','title2' => '','number' => '4','category' => '', 'category2' => '', 'link'=>'', 'link2'=>'','box_layout'=> 'box-two-layout-1'));
		$title    = esc_attr($instance['title']);
		$title2    = esc_attr($instance['title2']);
		$link    = esc_url($instance['link']);
		$link2    = esc_url($instance['link2']);
		$number = absint( $instance[ 'number' ] );
		$category = $instance[ 'category' ];
		$category2 = $instance[ 'category2' ];
		$box_layout = $instance[ 'box_layout' ];
		?>

		<p>
			<label for="<?php echo $this->get_field_id('box_layout'); ?>">
			<?php _e( 'Category Box Layout:', 'magbook' ); ?>
			</label> <br>
			<input type="radio" <?php checked($box_layout, 'box-two-layout-1') ?> id="<?php echo $this->get_field_id( 'box_layout' ); ?>" name="<?php echo $this->get_field_name( 'box_layout' ); ?>" value="box-two-layout-1"/><?php _e( 'Box Layout 1', 'magbook' );?> &nbsp; &nbsp; &nbsp;
			<input type="radio" <?php checked($box_layout, 'box-two-layout-2') ?> id="<?php echo $this->get_field_id( 'box_layout' ); ?>" name="<?php echo $this->get_field_name( 'box_layout' ); ?>" value="box-two-layout-2"/><?php _e( 'Box Layout 2', 'magbook' );?><br>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">
			<?php _e( 'Number of Post:', 'magbook' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo absint($number); ?>" size="3" />
		</p>
		<hr>

		<p>
			<label for="<?php echo $this->get_field_id('title');?>">
				<?php _e('Title:', 'magbook');?>
			</label>
			<input id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo esc_attr($title);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link');?>">
				<?php _e('Custom Link:', 'magbook');?>
			</label>
			<input id="<?php echo $this->get_field_id('link');?>" name="<?php echo $this->get_field_name('link');?>" type="text" value="<?php echo esc_url($link);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'magbook' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category'), 'value_field' => 'name' , 'selected' => $category ) ); ?>
		</p>
		<hr> <br>
		<p>
			<label for="<?php echo $this->get_field_id('title2');?>">
				<?php _e('Title:', 'magbook');?>
			</label>
			<input id="<?php echo $this->get_field_id('title2');?>" name="<?php echo $this->get_field_name('title2');?>" type="text" value="<?php echo esc_attr($title2);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link2');?>">
				<?php _e('Custom Link 2:', 'magbook');?>
			</label>
			<input id="<?php echo $this->get_field_id('link2');?>" name="<?php echo $this->get_field_name('link2');?>" type="text" value="<?php echo esc_url($link2);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category2' ); ?>"><?php _e( 'Select category', 'magbook' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category2' ), 'value_field' => 'name', 'selected' => $category2 ) ); ?>
		</p>
		<?php
	}
	function update($new_instance, $old_instance) {

		$instance  = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['title2'] = sanitize_text_field($new_instance['title2']);
		$instance['link'] = esc_url_raw($new_instance['link']);
		$instance['link2'] = esc_url_raw($new_instance['link2']);
		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );
		$instance[ 'category' ] = wp_kses_post($new_instance[ 'category' ]);
		$instance[ 'category2' ] = wp_kses_post($new_instance[ 'category2' ]);
		$instance[ 'box_layout' ] = sanitize_key($new_instance[ 'box_layout' ]);
		return $instance;
	}
	function widget($args, $instance) {
		$magbook_settings = magbook_get_theme_options();
		$entry_format_meta_blog = $magbook_settings['magbook_entry_meta_blog'];
		$magbook_tag_text = $magbook_settings['magbook_tag_text'];
		$content_display = $magbook_settings['magbook_blog_content_layout'];
		extract($args);
		extract($instance);
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$title2 = isset( $instance[ 'title2' ] ) ? $instance[ 'title2' ] : '';
		$link = isset( $instance[ 'link' ] ) ? $instance[ 'link' ] : '';
		$link2 = isset( $instance[ 'link2' ] ) ? $instance[ 'link2' ] : '';
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$category2 = isset( $instance[ 'category2' ] ) ? $instance[ 'category2' ] : '';
		$box_layout = isset( $instance[ 'box_layout' ] ) ? $instance[ 'box_layout' ] : 'box-two-layout-1' ;

		if($category !='-1'){

		$get_featured_posts = new WP_Query( array(
				'posts_per_page' 			=> absint($number),
				'category_name'				=> esc_attr($category),
				'post_status'		=>	'publish',
				'ignore_sticky_posts'=>	'true'
			) );
		} else {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page' 			=> absint($number),
				'post_status'		=>	'publish',
				'ignore_sticky_posts'=>	'true'
			) );
		}

		if($category !='-1'){

		$get_featured_posts2 = new WP_Query( array(
				'posts_per_page' 			=> absint($number),
				'box_layout'					=> 'post',
				'category_name'				=> esc_attr($category2),
				'post_status'		=>	'publish',
				'ignore_sticky_posts'=>	'true'
			) );
		} else {
			$get_featured_posts2 = new WP_Query( array(
				'posts_per_page' 			=> absint($number),
				'box_layout'					=> 'post',
				'post_status'		=>	'publish',
				'ignore_sticky_posts'=>	'true'
			) );
		}



		echo '<!-- Category Box Widget Two Layout-1 ============================================= -->' .$before_widget; ?>

		<?php if($box_layout == 'box-two-layout-1'){
				$category_box_class='1';
			} else{
				$category_box_class='2';
			}?>

			<div class="box-two-layout-<?php echo absint($category_box_class);?>">
				<div class="cat-box-two-wrap clearfix">
					<div class="widget widget-cat-box-left">
						<?php
						if ( $title!='' || $link!='' ){ ?>
							<h2 class="widget-title">
								<?php if ( $title != '' ){ ?>
									<span><?php echo esc_html($title); ?></span>
								<?php } 
								if ( $link != '' ){ ?>
								
								<a href="<?php echo esc_url($link);?>" class="more-btn"><?php echo esc_html($magbook_tag_text); ?></a>
								<?php } ?>
							</h2>
						<?php	}
					
						$i=1;
						while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
						if($i==1){
							echo '<div class="cat-box-two-primary">';
						} else {
							echo '<div class="cat-box-two-secondary">';
						} ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
								<?php if(has_post_thumbnail() ){ ?>
									<div class="cat-box-two-image">
										<figure class="post-featured-image">
											<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('magbook-featured-image'); ?></a>
										</figure> <!-- end .post-featured-image -->
									</div> <!-- end .cat-box-two-image -->
								<?php } ?>
								<div class="cat-box-two-text">
									<header class="entry-header">
										<?php if($entry_format_meta_blog != 'hide-meta' ){
												echo  '<div class="entry-meta">';
													do_action('magbook_post_categories_list_id');
												echo '</div> <!-- end .entry-meta -->';
											} ?>
											<h2 class="entry-title">
												<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h2> <!-- end.entry-title -->
											<?php if($entry_format_meta_blog != 'hide-meta' ){
												echo  '<div class="entry-meta">';
												echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_html(get_the_author()).'</a></span>';
												printf( '<span class="posted-on"><a href="%1$s" title="%2$s"><i class="fa fa-calendar-o"></i> %3$s</a></span>',
																	esc_url(get_the_permalink()),
																	esc_attr( get_the_time(get_option( 'date_format' )) ),
																	esc_html( get_the_time(get_option( 'date_format' )) )
																);
													if ( comments_open()) { ?>
														<span class="comments">
														<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'magbook' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'magbook' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'magbook' ), '', __( 'Comments Off', 'magbook' ) ); ?> </span>
												<?php }
												echo  '</div> <!-- end .entry-meta -->'; ?>
											<?php } ?>
									</header>
									<!-- end .entry-header -->
									<div class="entry-content">
										<?php
										if($content_display == 'excerptblog_display'):
											the_excerpt();
										else:
											the_content( esc_html($magbook_tag_text));
										endif; ?>
									</div>
									<!-- end .entry-content -->
								</div> <!-- end .cat-box-text -->
							</article> <!-- end .post -->
							<?php 
							echo '</div>';
							$i++;
						endwhile;
						wp_reset_postdata();  ?>
					</div> <!-- end .widget-cat-box-left -->

					<div class="widget widget-cat-box-right">
						<?php
						if ( $title2!='' || $link2!='' ){ ?>
							<h2 class="widget-title">
								<?php if ( $title2 != '' ){ ?>
									<span><?php echo esc_html($title2); ?></span>
								<?php } 
								if ( $link2 != '' ){ ?>
								
								<a href="<?php echo esc_url($link2);?>" class="more-btn"><?php echo esc_html($magbook_tag_text); ?></a>
								<?php } ?>
							</h2>
						<?php	}
					
						$j=1;
						while( $get_featured_posts2->have_posts() ):$get_featured_posts2->the_post();
						if($j==1){
							echo '<div class="cat-box-two-primary">';
						} else {
							echo '<div class="cat-box-two-secondary">';
						} ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
								<?php if(has_post_thumbnail() ){ ?>
									<div class="cat-box-two-image">
										<figure class="post-featured-image">
											<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('magbook-featured-image'); ?></a>
										</figure> <!-- end .post-featured-image -->
									</div> <!-- end .cat-box-two-image -->
								<?php } ?>
								<div class="cat-box-two-text">
									<header class="entry-header">
										<?php if($entry_format_meta_blog != 'hide-meta' ){
												echo  '<div class="entry-meta">';
													do_action('magbook_post_categories_list_id');
												echo '</div> <!-- end .entry-meta -->';
											} ?>
											<h2 class="entry-title">
												<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h2> <!-- end.entry-title -->
											<?php if($entry_format_meta_blog != 'hide-meta' ){
												echo  '<div class="entry-meta">';
												echo '<span class="author vcard"><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_attr(get_the_author()).'</a></span>';
												printf( '<span class="posted-on"><a href="%1$s" title="%2$s"><i class="fa fa-calendar-o"></i> %3$s</a></span>',
																	esc_url(get_the_permalink()),
																	esc_attr( get_the_time(get_option( 'date_format' )) ),
																	esc_html( get_the_time(get_option( 'date_format' )) )
																); ?>

												<?php if ( comments_open() ) { ?>
														<span class="comments">
														<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'magbook' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'magbook' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'magbook' ), '', __( 'Comments Off', 'magbook' ) ); ?> </span>
												<?php }
												echo  '</div> <!-- end .entry-meta -->'; ?>
											<?php } ?>
									</header>
									<!-- end .entry-header -->
									<div class="entry-content">
										<?php
										if($content_display == 'excerptblog_display'):
											the_excerpt();
										else:
											the_content( esc_html($magbook_tag_text));
										endif; ?>
									</div>
									<!-- end .entry-content -->
								</div> <!-- end .cat-box-text -->
							</article> <!-- end .post -->
							<?php 
							echo '</div>';
							$j++;
						endwhile;
						wp_reset_postdata();  ?>
					</div> <!-- end .widget-cat-box-right -->
				</div> <!-- end .cat-box-wrap -->
			</div><!-- end .box-two-layout-1 -->

	<?php echo $after_widget.'<!-- end .widget-cat-box -->';
	}
}
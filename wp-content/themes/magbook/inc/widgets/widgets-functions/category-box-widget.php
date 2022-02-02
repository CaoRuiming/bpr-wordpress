<?php

/**
 * Display Category box widget with layout 1, layout 2 and layout 3
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

class Magbook_category_box_Widgets extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	function __construct() {
		$widget_ops = array( 'classname' => 'widget-cat-box', 'description' => __( 'Displays Category box widget with layout 1, layout 2 and layout 3', 'magbook') );
		$control_ops = array('width' => 200, 'height' => 250);
		parent::__construct( false, $name=__('TF: Category Box Widget','magbook'), $widget_ops, $control_ops );
	}


	function form($instance) {
		$instance = wp_parse_args(( array ) $instance, array('title' => '','number' => '5','box_layout'=> 'box-layout-1','category' => '', 'link'=>''));
		$title    = esc_attr($instance['title']);
		$number = absint( $instance[ 'number' ] );
		$link = esc_url( $instance[ 'link' ] );
		$box_layout = $instance[ 'box_layout' ];
		$category = $instance[ 'category' ];
		?>
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
			<label for="<?php echo $this->get_field_id('number'); ?>">
			<?php _e( 'Number of Post:', 'magbook' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo absint($number); ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('box_layout'); ?>">
			<?php _e( 'Category Box Layout:', 'magbook' ); ?>
			</label> <br>
			<input type="radio" <?php checked($box_layout, 'box-layout-1') ?> id="<?php echo $this->get_field_id( 'box_layout' ); ?>" name="<?php echo $this->get_field_name( 'box_layout' ); ?>" value="box-layout-1"/><?php _e( 'Box Layout 1', 'magbook' );?> &nbsp; &nbsp; &nbsp;
			<input type="radio" <?php checked($box_layout, 'box-layout-2') ?> id="<?php echo $this->get_field_id( 'box_layout' ); ?>" name="<?php echo $this->get_field_name( 'box_layout' ); ?>" value="box-layout-2"/><?php _e( 'Box Layout 2', 'magbook' );?>&nbsp; &nbsp; &nbsp;

		 	<input type="radio" <?php checked($box_layout,'box-layout-3') ?> id="<?php echo $this->get_field_id( 'box_layout' ); ?>" name="<?php echo $this->get_field_name( 'box_layout' ); ?>" value="box-layout-3"/><?php _e( 'Box Layout 3', 'magbook' );?><br>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'magbook' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category'), 'value_field' => 'name' , 'selected' => $category ) ); ?>
		</p>
		<?php
	}
	function update($new_instance, $old_instance) {

		$instance  = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['link'] = esc_url_raw($new_instance['link']);
		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );
		$instance[ 'box_layout' ] = sanitize_key($new_instance[ 'box_layout' ]);
		$instance[ 'category' ] = wp_kses_post($new_instance[ 'category' ]);
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
		$link = isset( $instance[ 'link' ] ) ? $instance[ 'link' ] : '';
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$box_layout = isset( $instance[ 'box_layout' ] ) ? $instance[ 'box_layout' ] : 'box-layout-1' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

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

		echo '<!-- Category Box Widget ============================================= -->' .$before_widget;
		?>
			<?php if($box_layout == 'box-layout-1'){
				$category_box_class='1';
			} elseif ($box_layout == 'box-layout-2'){
				$category_box_class='2';
			}else{
				$category_box_class='3';
			}?>
			<div class="box-layout-<?php echo absint($category_box_class);?>">
			<?php
			if ( $title!='' || $link!='' ){ ?>
				<h2 class="widget-title">
					<?php if ( $title != '' ){ ?>
						<span><?php echo esc_html($title); ?></span>
					<?php } 
					if ( $link != '' ){ ?>
					
					<a href="<?php echo esc_url($link);?>" class="more-btn"><?php echo esc_html($magbook_tag_text); ?></a>
					<?php } ?>
				</h2><!-- end .widget-title -->
			<?php	} ?>
				<div class="cat-box-wrap clearfix">
					<?php
					$i=1;
					while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post(); 

					if(($box_layout == 'box-layout-1' && $i==1) || ($box_layout == 'box-layout-2' && $i<=2) || ($box_layout == 'box-layout-3' && $i<=3) ){

							$category_box_class='cat-box-primary';

						}else{
							$category_box_class='cat-box-secondary';
						} ?>
					<div class="<?php echo esc_attr($category_box_class); ?>">
 						<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
							<?php if(has_post_thumbnail() ){ ?>
							<div class="cat-box-image">
								<figure class="post-featured-image">
									<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('magbook-featured-image'); ?></a>
								</figure>
								<!-- end .post-featured-image -->
							</div>
							<!-- end .cat-box-image -->
							<?php } ?>
							<div class="cat-box-text">
								<header class="entry-header">
									<?php if($entry_format_meta_blog != 'hide-meta' ){
												echo  '<div class="entry-meta">';
													do_action('magbook_post_categories_list_id');
												echo '</div> <!-- end .entry-meta -->';
											} ?>
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
												if ( comments_open()) { ?>
														<span class="comments">
														<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'magbook' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'magbook' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'magbook' ), '', __( 'Comments Off', 'magbook' ) ); ?> </span>
												<?php }
												echo  '</div> <!-- end .entry-meta -->';
											} ?>
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
							</div>
							<!-- end .cat-box-text -->
						</article>
						<!-- end .post -->
					</div> <!-- end .cat-box-primary/ secondary -->
						<?php $i++;

					endwhile;
					wp_reset_postdata(); 

					?>
				</div>
				<!-- end .cat-box-wrap -->
			</div>
			<!-- end .box-layout-1 -->
	<?php echo $after_widget.'<!-- end .widget-cat-box -->';
	}
}
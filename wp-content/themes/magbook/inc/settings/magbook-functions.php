<?php
/**
 * Custom functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
/********************* Set Default Value if not set ***********************************/
	if ( !get_theme_mod('magbook_theme_options') ) {
		set_theme_mod( 'magbook_theme_options', magbook_get_option_defaults_values() );
	}
/********************* MAGBOOK RESPONSIVE AND CUSTOM CSS OPTIONS ***********************************/
function magbook_responsiveness() {
	$magbook_settings = magbook_get_theme_options();
	if( $magbook_settings['magbook_responsive'] == 'on' ) { ?>
	<meta name="viewport" content="width=device-width" />
	<?php } else { ?>
	<meta name="viewport" content="width=1170" />
	<?php  }
}
add_filter( 'wp_head', 'magbook_responsiveness');

/******************************** EXCERPT LENGTH *********************************/
function magbook_excerpt_length($magbook_excerpt_length) {
	$magbook_settings = magbook_get_theme_options();
	if( is_admin() ){
		return absint($magbook_excerpt_length);
	}

	$magbook_excerpt_length = $magbook_settings['magbook_excerpt_length'];
	return absint($magbook_excerpt_length);
}
add_filter('excerpt_length', 'magbook_excerpt_length');

/********************* CONTINUE READING LINKS FOR EXCERPT *********************************/
function magbook_continue_reading($more) {
	if( is_admin() ){
		return $more;
	}

	return '&hellip; ';
}
add_filter('excerpt_more', 'magbook_continue_reading');

/***************** USED CLASS FOR BODY TAGS ******************************/
function magbook_body_class($magbook_class) {
	$magbook_settings = magbook_get_theme_options();
	$magbook_blog_layout = $magbook_settings['magbook_blog_layout'];
	$magbook_site_layout = $magbook_settings['magbook_design_layout'];
	$magbook_header_design_layout = $magbook_settings['magbook_header_design_layout'];
	if ($magbook_site_layout =='boxed-layout') {
		$magbook_class[] = 'boxed-layout';
	}elseif ($magbook_site_layout =='small-boxed-layout') {
		$magbook_class[] = 'boxed-layout-small';
	}else{
		$magbook_class[] = '';
	}
	if(!is_single()){
		if ($magbook_blog_layout == 'medium_image_display' && !is_page_template('page-templates/magbook-template.php')){
			$magbook_class[] = "small-image-blog";
		}elseif($magbook_blog_layout == 'two_column_image_display' && !is_page_template('page-templates/magbook-template.php')){
			$magbook_class[] = "two-column-blog";
		}else{
			$magbook_class[] = "";
		}
	}

	if ( is_singular() && false !== strpos( get_queried_object()->post_content, '<!-- wp:' ) ) {
		$magbook_class[] = 'gutenberg';
	}

	if(is_page_template('page-templates/magbook-template.php')) {
		$magbook_class[] = 'magbook-corporate';

		if(!is_active_sidebar( 'magbook_template_sidebar_section' )){
			$magbook_class[] = 'magbook-no-sidebar';
		}
	}

	if($magbook_settings['magbook_slider_design_layout']=='no-slider') {
		$magbook_class[] = 'n-sld';
	}elseif ($magbook_settings['magbook_slider_design_layout']=='small-slider'){
		$magbook_class[] = 'small-sld';
	} else {
		$magbook_class[] = '';
	}

	if($magbook_header_design_layout == ''){
		$magbook_class[] = '';
	}else{
		$magbook_class[] = 'top-logo-title';
	}
	return $magbook_class;
}
add_filter('body_class', 'magbook_body_class');

/********************** SCRIPTS FOR DONATE/ UPGRADE BUTTON ******************************/
function magbook_customize_scripts() {
	wp_enqueue_style( 'magbook_customizer_custom', get_template_directory_uri() . '/inc/css/magbook-customizer.css');
}
add_action( 'customize_controls_print_scripts', 'magbook_customize_scripts');

/**************************** SOCIAL MENU *********************************************/
function magbook_social_links_display() {
		if ( has_nav_menu( 'social-link' ) ) : ?>
	<div class="social-links clearfix">
	<?php
		wp_nav_menu( array(
			'container' 	=> '',
			'theme_location' => 'social-link',
			'depth'          => 1,
			'items_wrap'      => '<ul>%3$s</ul>',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
		) );
	?>
	</div><!-- end .social-links -->
	<?php endif; ?>
<?php }
add_action ('magbook_social_links', 'magbook_social_links_display');

/******************* DISPLAY BREADCRUMBS ******************************/
function magbook_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb home">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}
/*********************** Breaking News ***********************************/
function magbook_breaking_news_display(){
	global $post;
	$magbook_settings = magbook_get_theme_options();
	$category = $magbook_settings['magbook_disable_breaking_news'];
	$query = new WP_Query(array(
		'posts_per_page' =>  intval($magbook_settings['magbook_total_breaking_news']),
		'post_type' => array(
			'post'
		) ,
		'category_name' => esc_attr($magbook_settings['magbook_breaking_news_category']),
	));
	
	if($query->have_posts() && $category==0){ ?>
		<div class="breaking-news-box">
			<div class="wrap">
				<div class="breaking-news-wrap">
					<?php if( $magbook_settings['magbook_breaking_news_title']!=''){ ?>
					<div class="breaking-news-header">
						<h2 class="news-header-title"><?php echo esc_html($magbook_settings['magbook_breaking_news_title']); ?></h2>
					</div>
					<?php } ?>
					<div class="breaking-news-slider">
						<ul class="slides">
		<?php
		while ($query->have_posts()):$query->the_post(); ?>

			<li>
				<h2 class="breaking-news-title">
					<a title="<?php the_title_attribute()?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<!-- end.breaking-news-title -->
			</li>
							
		<?php	endwhile;
		wp_reset_postdata();
		echo '</ul>
			</div> <!-- end .breaking-news-slider -->
					</div>
					<!-- end .breaking-news-wrap -->
				</div>
				<!-- end .wrap -->
			</div>
			<!-- end .breaking-news-box -->';
	}

}

add_action ('magbook_breaking_news', 'magbook_breaking_news_display');

/*********************** magbook Category SLIDERS ***********************************/
function magbook_category_sliders() {
	global $post;
	$magbook_settings = magbook_get_theme_options();
	global $excerpt_length;
	$magbook_tag_text = $magbook_settings['magbook_tag_text'];
	$magbook_slider_design_layout = $magbook_settings['magbook_slider_design_layout'];
	$entry_format_meta_blog = $magbook_settings['magbook_entry_meta_blog'];
	$category = $magbook_settings['magbook_default_category_slider'];
	$magbook_small_slider_post_category = $magbook_settings['magbook_small_slider_post_category'];
	$query = new WP_Query(array(
				'posts_per_page' =>  intval($magbook_settings['magbook_slider_number']),
				'post_type' => array(
					'post'
				) ,
				'category_name' => esc_attr($category),
			));

	$small_query = new WP_Query(array(
				'posts_per_page' =>  4,
				'post_type' => array(
					'post'
				) ,
				'category_name' => esc_attr($magbook_small_slider_post_category),
			));
	
	if(($query->have_posts() ) ||  ($small_query->have_posts() && !empty($magbook_small_slider_post_category) ) ){ ?>

		<div class="main-slider clearfix">
		<?php
		if ($magbook_slider_design_layout=='no-slider'){
			echo  '<div class="no-slider">';
		} elseif ($magbook_slider_design_layout=='layer-slider'){
			echo  '<div class="layer-slider">';
		} elseif ($magbook_slider_design_layout=='small-slider'){
		echo '<div class="small-slider">';
		} else {
			echo  '<div class="multi-slider">';
		}
		echo  '<ul class="slides">';
		while ($query->have_posts()):$query->the_post();
			$attachment_id = get_post_thumbnail_id();
			$image_attributes = wp_get_attachment_image_src($attachment_id,'magbook_slider_image');
			$excerpt = get_the_excerpt();
				echo '<li>';
				if ($image_attributes) {
					echo  '<div class="image-slider" title="'.the_title_attribute('echo=0').'"' .' style="background-image:url(' ."'" .esc_url($image_attributes[0])."'" .')">';
				}else{
					echo  '<div class="image-slider">';
				}
				echo  '<article class="slider-content">';
				if ($image_attributes != '' || $excerpt != '') {
					echo  '<div class="slider-text-content">';

					if($entry_format_meta_blog != 'hide-meta' ){
						echo  '<div class="entry-meta">';
							do_action('magbook_post_categories_list_id');
						echo '</div> <!-- end .entry-meta -->';
					}
					
					$remove_link = $magbook_settings['magbook_slider_link'];
						if($remove_link == 0){

								echo '<h2 class="slider-title"><a href="'.esc_url(get_permalink()).'" title="'.the_title_attribute('echo=0').'" rel="bookmark">'.get_the_title().'</a></h2><!-- .slider-title -->';

						}else{
							echo '<h2 class="slider-title">'.get_the_title().'</h2><!-- .slider-title -->';
						}

						if ($excerpt != '') {
							echo '<p class="slider-text">'.wp_strip_all_tags( get_the_excerpt(), true ).'</p><!-- end .slider-text -->';
						}
					if($entry_format_meta_blog != 'hide-meta' ){
						echo  '<div class="entry-meta">';
						echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_attr(get_the_author()).'</a></span>';
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
					}
					echo  '</div><!-- end .slider-text-content -->';
				}
				if( $magbook_settings['magbook_slider_button'] == 0 && $magbook_tag_text !='' ){
					echo '<div class="slider-buttons">';
					echo  '<a title='.'"'.the_title_attribute('echo=0'). '"'. ' '.'href="'.esc_url(get_permalink()).'"'.' class="btn-default">'.esc_html($magbook_tag_text).'</a>';
					
					echo  '</div><!-- end .slider-buttons -->';
				}
				echo '</article><!-- end .slider-content --> ';
				echo '</div><!-- end .image-slider -->
				</li>';
			endwhile;
			wp_reset_postdata(); ?>
			</ul><!-- end .slides -->
		</div> <!-- end .layer-slider -->
		<?php if ($magbook_settings['magbook_slider_design_layout']=='small-slider'){ ?>
		<div class="small-sld-cat">
			<?php
			while ($small_query->have_posts()):$small_query->the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
					<div class="sld-cat-wrap">
						<?php if( has_post_thumbnail() ){ ?>
							<div class="sld-cat-image">
								<figure class="post-featured-image">
									<a href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>">
										<?php the_post_thumbnail('magbook-featured-image'); ?>
									</a>
								</figure>
								<!-- end .post-featured-image -->
							</div>
							<!-- end .sld-cat-image -->
							<?php } ?>
							<div class="sld-cat-text">
								<header class="entry-header">		
									<h2 class="entry-title">
										 <a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute('echo=0'); ?>"> <?php the_title();?> </a>
									</h2>
									<!-- end.entry-title -->
									<?php if($entry_format_meta_blog != 'hide-meta' ){
										echo  '<div class="entry-meta">';
										echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_html(get_the_author()).'</a></span>';
										printf( '<span class="posted-on"><a href="%1$s" title="%2$s"><i class="fa fa-calendar-o"></i> %3$s</a></span>',
															esc_url(get_the_permalink()),
															esc_attr( get_the_time(get_option( 'date_format' )) ),
															esc_html( get_the_time(get_option( 'date_format' )) )
														); ?>

										<?php if ( comments_open()) { ?>
												<span class="comments">
												<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'magbook' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'magbook' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'magbook' ), '', __( 'Comments Off', 'magbook' ) ); ?> </span>
										<?php }
										echo  '</div> <!-- end .entry-meta -->';
									} ?>
								</header>
								<!-- end .entry-header -->
							</div>
							<!-- end .sld-cat-text -->
						</div>
						<!-- end .sld-cat-wrap -->
					</article>
					<!-- end .post -->
			<?php  endwhile;
			wp_reset_postdata(); ?>
		</div> <!-- end .small-sld-cat-->
		<?php } ?>
	</div> <!-- end .main-slider -->
<?php }
}
/*************************** Getting Cat ID dynamic ****************************************/
function magbook_post_categories_list() {
	global $post;
	$magbook_post_id = $post->ID;
	$magbook_categories_list = get_the_category($magbook_post_id); ?>
	<span class="cats-links">
		<?php if( !empty( $magbook_categories_list ) ) {
				foreach ( $magbook_categories_list as $category_list ) {
					$magbook_category_name = $category_list->name;
					$magbook_category_id = $category_list->term_id;
					$magbook_category_link = get_category_link( $magbook_category_id ); ?>
						<a class="cl-<?php echo esc_attr( $magbook_category_id ); ?>" href="<?php echo esc_url( $magbook_category_link ); ?>"><?php echo esc_html( $magbook_category_name ); ?></a>
			<?php  }
			} ?>
	</span><!-- end .cat-links -->
<?php }

add_action( 'magbook_post_categories_list_id', 'magbook_post_categories_list' );

/*************************** Adding Category to menu ****************************************/
$magbook_settings = magbook_get_theme_options();
	function magbook_category_nav_class( $classes, $item ){
	    if( 'category' == $item->object ){
	        $category = get_category( $item->object_id );

			if(isset($category->term_id)) {

	        	$classes[] = 'cl-' . $category->term_id;
			}
	    }
	    return $classes;
	}
	add_filter( 'nav_menu_css_class', 'magbook_category_nav_class', 10, 2 );
/*************************** ENQUEING STYLES AND SCRIPTS ****************************************/
function magbook_scripts() {
	$magbook_settings = magbook_get_theme_options();
	$magbook_stick_menu = $magbook_settings['magbook_stick_menu'];
	wp_enqueue_script('magbook-main', get_template_directory_uri().'/js/magbook-main.js', array('jquery'), false, true);
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_style( 'magbook-style', get_stylesheet_uri() );
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/font-awesome/css/font-awesome.min.css');

	if( $magbook_stick_menu != 1 ):

		wp_enqueue_script('jquery-sticky', get_template_directory_uri().'/assets/sticky/jquery.sticky.min.js', array('jquery'), false, true);
		wp_enqueue_script('magbook-sticky-settings', get_template_directory_uri().'/assets/sticky/sticky-settings.js', array('jquery'), false, true);

	endif;

	wp_enqueue_script('magbook-navigation', get_template_directory_uri().'/js/navigation.js', array('jquery'), false, true);
	wp_enqueue_script('jquery-flexslider', get_template_directory_uri().'/js/jquery.flexslider-min.js', array('jquery'), false, true);
	wp_enqueue_script('magbook-slider', get_template_directory_uri().'/js/flexslider-setting.js', array('jquery-flexslider'), false, true);
	wp_enqueue_script('magbook-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array('jquery'), false, true);

	$magbook_animation_effect   = esc_attr($magbook_settings['magbook_animation_effect']);
	$magbook_slideshowSpeed    = absint($magbook_settings['magbook_slideshowSpeed'])*1000;
	$magbook_animationSpeed = absint($magbook_settings['magbook_animationSpeed'])*100;
	wp_localize_script(
		'magbook-slider',
		'magbook_slider_value',
		array(
			'magbook_animation_effect'   => $magbook_animation_effect,
			'magbook_slideshowSpeed'    => $magbook_slideshowSpeed,
			'magbook_animationSpeed' => $magbook_animationSpeed,
		)
	);
	wp_enqueue_script( 'magbook-slider' );
	if( $magbook_settings['magbook_responsive'] == 'on' ) {
		wp_enqueue_style('magbook-responsive', get_template_directory_uri().'/css/responsive.css');
	}
	/********* Adding Multiple Fonts ********************/
	$magbook_googlefont = array();
	array_push( $magbook_googlefont, 'Open+Sans');
	array_push( $magbook_googlefont, 'Lato');
	$magbook_googlefonts = implode("|", $magbook_googlefont);

	wp_register_style( 'magbook-google-fonts', '//fonts.googleapis.com/css?family='.$magbook_googlefonts .':300,400,400i,500,600,700');
	wp_enqueue_style( 'magbook-google-fonts' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* Custom Css */
	$magbook_internal_css='';

	if ($magbook_settings['magbook_logo_high_resolution'] !=0){
		$magbook_internal_css .= '/* Logo for high resolution screen(Use 2X size image) */
		.custom-logo-link .custom-logo {
			height: 80px;
			width: auto;
		}

		.top-logo-title .custom-logo-link {
			display: inline-block;
		}

		.top-logo-title .custom-logo {
			height: auto;
			width: 50%;
		}

		.top-logo-title #site-detail {
			display: block;
			text-align: center;
		}
		.side-menu-wrap .custom-logo {
			height: auto;
			width:100%;
		}

		@media only screen and (max-width: 767px) { 
			.top-logo-title .custom-logo-link .custom-logo {
				width: 60%;
			}
		}

		@media only screen and (max-width: 480px) { 
			.top-logo-title .custom-logo-link .custom-logo {
				width: 80%;
			}
		}';
	}

	if($magbook_settings['magbook_slider_content_bg_color'] =='on' && $magbook_settings['magbook_slider_design_layout'] == 'layer-slider'){
		$magbook_internal_css .= '/* Slider Content With background color(For Layer Slider only) */
		.layer-slider .slider-content {
			background-color: rgba(0, 0, 0, 0.5);
			padding: 30px;
		}';
	}
	if ($magbook_settings['magbook_post_category'] !=0){
		$magbook_internal_css .= '
			/* Hide Category */
			.entry-meta .cats-links,
			.box-layout-1 .cat-box-primary .cat-box-text .cats-links,
			.widget-cat-box-2 .post:nth-child(2) .cats-links,
			.main-slider .no-slider .slides li:first-child .slider-text-content .cats-links {
				display: none;
				visibility: hidden;
			}';
	}
	if ($magbook_settings['magbook_post_author'] !=1){
		$magbook_internal_css .= '
			/* Show Author */
			.entry-meta .author,
			.mb-entry-meta .author {
				float: left;
				display: block;
				visibility: visible;
			}';
	}
	if ($magbook_settings['magbook_post_date'] !=0){
		$magbook_internal_css .= '/* Hide Date */
			.entry-meta .posted-on,
			.mb-entry-meta .posted-on {
				display: none;
				visibility: hidden;
			}';
	}
	if ($magbook_settings['magbook_post_comments'] !=0){
		$magbook_internal_css .= '/* Hide Comments */
			.entry-meta .comments,
			.mb-entry-meta .comments {
				display: none;
				visibility: hidden;
			}';
	}
	if($magbook_settings['magbook_header_display']=='header_logo'){
		$magbook_internal_css .= '
		#site-branding #site-title, #site-branding #site-description{
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}';
	}

	wp_add_inline_style( 'magbook-style', wp_strip_all_tags($magbook_internal_css) );
}
add_action( 'wp_enqueue_scripts', 'magbook_scripts' );

/**************** Categoy Lists ***********************/

if( !function_exists( 'magbook_categories_lists' ) ):
    function magbook_categories_lists() {
        $magbook_cat_args = array(
            'type'       => 'post',
            'taxonomy'   => 'category',
        );
        $magbook_categories = get_categories( $magbook_cat_args );
        $magbook_categories_lists = array();
        $magbook_categories_lists = array('' => esc_html__('--Select--','magbook'));
        foreach( $magbook_categories as $category ) {
            $magbook_categories_lists[esc_attr( $category->slug )] = esc_html( $category->name );
        }
        return $magbook_categories_lists;
    }
endif;

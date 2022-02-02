<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package News Block
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function news_block_body_classes( $classes ) {
	global $post;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Main site layout
	$site_layout = get_theme_mod( 'site_layout', 'box-layout' );
	$classes[] = esc_attr( 'mainsite--' . $site_layout );

	// Menu hover effect
	$menu_hover = get_theme_mod( 'menu_hover_style', 'menu_hover_1' );
	$classes[] = esc_attr( $menu_hover );

	$header_layout = get_theme_mod( 'header_layout', 'layout-default' );
	$classes[] = esc_attr( 'header--' . $header_layout );

	// Manage sidebar layouts
	if( is_page() || is_404() ) {
		$page_sidebar_option = get_theme_mod( 'page_sidebar_option', true );
		$page_sidebar_layout = get_theme_mod( 'page_sidebar_layout', 'right-sidebar' );
		$sidebar_layout = $page_sidebar_option ? esc_attr( $page_sidebar_layout ) : 'no-sidebar';
		//layout settings
		$layout = esc_html( get_theme_mod( 'page_layout', 'full-width' ) ); // layout value
	} else if( is_home() ) {
		// posts layout
		$archive_posts_layout = get_theme_mod( 'archive_posts_layout', 'list-layout' );
		$classes[] = esc_html( 'posts--'. $archive_posts_layout );
		
	} else if( is_single() ) {
		$post_sidebar_option = get_theme_mod( 'post_sidebar_option', true );
		$post_sidebar_layout = get_theme_mod( 'post_sidebar_layout', 'right-sidebar' );
		$sidebar_layout = $post_sidebar_option ? $post_sidebar_layout : 'no-sidebar';
		//layout settings
		$layout = esc_html( get_theme_mod( 'post_layout', 'boxed-content-width' ) ); // layout value
	} else if ( is_archive() || is_search() || is_home() ) {
		// posts layout
		$archive_posts_layout = get_theme_mod( 'archive_posts_layout', 'list-layout' );
		$classes[] = esc_html( 'posts--'. $archive_posts_layout );

		$archive_sidebar_option = get_theme_mod( 'archive_sidebar_option', true );
		$archive_sidebar_layout = get_theme_mod( 'archive_sidebar_layout', 'right-sidebar' );
		$layout = get_theme_mod( 'archive_layout', 'boxed-content-width' ); // layout value
		$sidebar_layout = $archive_sidebar_option ? esc_attr( $archive_sidebar_layout ) : 'no-sidebar';
	}
	$classes[] = isset( $sidebar_layout ) ? esc_attr( $sidebar_layout ) : 'no-sidebar'; // sidebar class
	$classes[] = isset( $layout ) ? esc_attr( $layout ) : 'boxed-content-width'; // layout class

	return $classes;
}
add_filter( 'body_class', 'news_block_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function news_block_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'news_block_pingback_header' );

/**
 * Enqueue scripts and styles.
 */
function news_block_scripts() {
	wp_enqueue_style( 'fontAwesome', get_template_directory_uri() . '/assets/lib/fontawesome/css/all.min.css', array(), '5.15.3', 'all' );
	wp_enqueue_style( 'slick-slider', get_template_directory_uri() . '/assets/lib/slick/slick.css', array(), '1.8.1', 'all' );
	// Theme Main Style
	wp_enqueue_style( 'news_block_maincss', get_template_directory_uri() . '/assets/style/main.css', array(), NEWS_BLOCK_VERSION );
	//Theme Block Style
	wp_enqueue_style( 'news_block_blockcss', get_template_directory_uri() . '/assets/style/blocks/blocks.css', array(), NEWS_BLOCK_VERSION );

	// enqueue inline style
	ob_start();
		include get_template_directory() . '/inc/inline-styles.php';
	$news_block_theme_inline_sss = ob_get_clean();
	wp_add_inline_style( 'news_block_maincss', wp_strip_all_tags($news_block_theme_inline_sss) );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'news-block-fonts', news_block_fonts_url(), array(), null );

	wp_enqueue_style( 'news-block-style', get_stylesheet_uri(), array(), NEWS_BLOCK_VERSION );
	wp_style_add_data( 'news-block-style', 'rtl', 'replace' );

	wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/assets/lib/slick/slick.min.js', array('jquery'), '1.8.1', true );
	wp_enqueue_script( 'waypoint', get_template_directory_uri() . '/assets/lib/waypoint/jquery.waypoint.min.js', array('jquery'), '4.0.1', true );
	wp_enqueue_script( 'news-block-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), NEWS_BLOCK_VERSION, true );
	// stickey js
	wp_enqueue_script( 'sticky-sidebar-js', get_template_directory_uri() . '/assets/lib/sticky/theia-sticky-sidebar.js', array(), '1.7.0', true );
	// theme js
	wp_enqueue_script( 'news-block-theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), NEWS_BLOCK_VERSION, true );
	$scriptVars = array(
		'scrollToTop'		=> esc_attr( get_theme_mod( 'scroll_to_top_option', true ) ),
		'stickeyHeader_one' => esc_attr( get_theme_mod( 'sticky_header_option', false ) ),
		'ajaxPostsLoad'		=> false
	);
	wp_localize_script( 'news-block-theme', 'newsBlockThemeObject', $scriptVars );

	wp_localize_script( 'news-block-navigation', 'newsBlockscreenReaderText', array(
		'expand'   => __( 'expand child menu', 'news-block' ),
		'collapse' => __( 'collapse child menu', 'news-block' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'news_block_scripts' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function news_block_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'news-block' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'news-block' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// footer sidebars
	register_sidebars( 2, array(
			'name'          => esc_html__( 'Footer Column %d', 'news-block' ),
			'id'            => 'footer-column',
			'description'   => esc_html__( 'Add widgets here.', 'news-block' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'news_block_widgets_init' );

//define constant
define( 'NEWS_BLOCKS_DEFAULT_POST_IMAGE', get_template_directory_uri() . '/images/site-images/post-default-image.jpg' );
define( 'NEWS_BLOCKS_INCLUDES_PATH', get_template_directory() . '/inc/' );

/**
 * Elementor modules file
 */
require NEWS_BLOCKS_INCLUDES_PATH . 'elementor-widgets/elementor.php';

/**
 * Theme Hooks
 */
if( !class_exists( 'Breadcrumb_Trail' ) ) :
	require NEWS_BLOCKS_INCLUDES_PATH . 'class-breadcrumb.php';
endif;
/**
 * Theme Hooks
 */
require NEWS_BLOCKS_INCLUDES_PATH . 'hooks/hooks.php';

/**
 * Theme Admin Page 
 * 
 */
require NEWS_BLOCKS_INCLUDES_PATH . 'admin/class-theme-info.php';

/**
 * Register Google fonts.
 * @return string Google fonts URL for the theme.
 */
if ( ! function_exists( 'news_block_fonts_url' ) ) :
function news_block_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'cyrillic,cyrillic-ext';
		
	// Translators: If there are characters in your language that are not supported by Raleway, translate this to 'off'. Do not translate into your own language. 
	if ( 'off' !== esc_html_x( 'on', 'Playfair Display: on or off', 'news-block' ) ) {
		$fonts[] = 'Playfair Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
	}	

	// Translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. 
	if ( 'off' !== esc_html_x( 'on', 'Oswald: on or off', 'news-block' ) ) {
		$fonts[] = 'Oswald:wght@200;300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
	}

	// Translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. 
	if ( 'off' !== esc_html_x( 'on', 'Montserrat: on or off', 'news-block' ) ) {
		$fonts[] = 'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Oswald:wght@200;300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
	}
	
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

if( !function_exists( 'news_block_get_all_posts_ids' ) ) :
	/**
	 * Get all posts ids
	 * 
	 * @return array
	 */
	function news_block_get_all_posts_ids() {
		$all_post_ids = get_posts([
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post_type' => 'post',
			'fields' => 'ids',
		]);
		return apply_filters( 'news_block_get_all_posts_ids_filter', $all_post_ids );
	}
endif;

if( !function_exists( 'news_block_get_organized_all_posts_ids' ) ) :
	/**
	 * Get organized all posts ids
	 * 
	 * @return array
	 */
	function news_block_get_organized_all_posts_ids() {
		$ids = array();
		foreach( news_block_get_all_posts_ids() as $key => $value ) {
			$ids[$value] = $value;
		}
		return apply_filters( 'news_block_get_organized_all_posts_ids_filter', $ids );
	}
endif;

if( !function_exists( 'news_block_get_content_type' ) ) :
	/**
	 * Get content type
	 * @return string
	 */
	function news_block_get_content_type() {
		$content_type = apply_filters( 'news_block_post_content_type_filter', 'content' );
		if( is_archive() || is_search() || is_home() ) {
			$archive_content_type = get_theme_mod( 'archive_content_type', 'excerpt' );
			$content_type = ( $archive_content_type ) ? esc_html( $archive_content_type ) : 'excerpt';
		}
		return apply_filters( 'news_block_post_content_type_filter', $content_type );
	}
endif;

// navigation fallback
if ( ! function_exists( 'news_block_primary_navigation_fallback' ) ) :

	/**
	 * Fallback for primary navigation.
	 *
	 * @since 1.0.0
	 */
	function news_block_primary_navigation_fallback() {

		echo '<ul id="menu-main-menu" class="primary-menu">';
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'news-block' ) . '</a></li>';
		$args = array(
			'posts_per_page' => 5,
			'post_type'      => 'page',
			'orderby'        => 'name',
			'order'          => 'ASC',
			);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				the_title( '<li class="menu-item"><a href="' . esc_url( get_permalink() ) . '">', '</a></li>' );
			}
			wp_reset_postdata();
		}
		echo '</ul>';
	}
endif;
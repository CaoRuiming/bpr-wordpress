<?php
if (!defined('CORE_BLOG_S_VERSION'))
{
    // Replace the version number of the theme on each release.
    define('CORE_BLOG_S_VERSION', '1.0.0');
}

if (!function_exists('core_blog_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function core_blog_setup()
    {

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*add_image_size( 'core-blog-latest-post-sidebar', 75, 60, true );
        add_image_size( 'core-blog-latest-post-footer', 100, 107, true );
*/
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
        */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'core-blog') ,
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
        */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('core_blog_custom_background_args', array(
            'default-color' => '#f4f4f4',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'core_blog_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function core_blog_content_width()
{
    $GLOBALS['content_width'] = apply_filters('core_blog_content_width', 640);
}
add_action('after_setup_theme', 'core_blog_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function core_blog_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'core-blog') ,
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'core-blog') ,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Sidebar Navigation', 'core-blog') ,
        'id' => 'sidebar-2',
        'description' => esc_html__('Add widgets here.', 'core-blog') ,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 1', 'core-blog') ,
        'id' => 'footer-1',
        'description' => esc_html__('Add widgets here.', 'core-blog') ,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 2', 'core-blog') ,
        'id' => 'footer-2',
        'description' => esc_html__('Add widgets here.', 'core-blog') ,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 3', 'core-blog') ,
        'id' => 'footer-3',
        'description' => esc_html__('Add widgets here.', 'core-blog') ,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 4', 'core-blog') ,
        'id' => 'footer-4',
        'description' => esc_html__('Add widgets here.', 'core-blog') ,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_widget( 'Core_Blog_Widget_style' );
    
}
add_action('widgets_init', 'core_blog_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function core_blog_scripts()
{
    wp_enqueue_style('core-blog-style', get_stylesheet_uri() , array() , CORE_BLOG_S_VERSION);

    wp_enqueue_style('core-blog-font', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Raleway:400,800,900');


    wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/assets/css/fontawesome-all.css');
    
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css');

    //JS
    wp_enqueue_script('breakpoints-js', get_template_directory_uri() . '/assets/js/breakpoints.js', array(
        'jquery'
    ) , CORE_BLOG_S_VERSION, true);


    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.js', array(
        'jquery'
    ) , CORE_BLOG_S_VERSION, true);

    wp_enqueue_script('popper-js', get_template_directory_uri() . '/assets/js/popper.js', array(
        'jquery'
    ) , CORE_BLOG_S_VERSION, true);

    wp_enqueue_script('modal-accessibility-js', get_template_directory_uri() . '/assets/js/core-blog-modal-accessibility.js', array(
        'jquery'
    ) , CORE_BLOG_S_VERSION, true);


    wp_enqueue_script('core-blog-util', get_template_directory_uri() . '/assets/js/core-blog-util.js', array(
        'jquery'
    ) , CORE_BLOG_S_VERSION, true);
    
    wp_enqueue_script('core-blog-main', get_template_directory_uri() . '/assets/js/core-blog-main.js', array(
        'jquery'
    ) , CORE_BLOG_S_VERSION, true);

    wp_style_add_data('core-blog-style', 'rtl', 'replace');

    if (is_singular() && comments_open() && get_option('thread_comments'))
    {
        wp_enqueue_script('comment-reply');
    }

    
}
add_action('wp_enqueue_scripts', 'core_blog_scripts');

function core_blog_excerpt_more($more)
{
    $more = '...';
    if (is_admin())
    {
        return $more;
    }
}
add_filter('excerpt_more', 'core_blog_excerpt_more');



function core_blog_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'core_blog_post_views_count', true );
    return "$count";
}
function core_blog_set_post_view() {
    $key = 'core_blog_post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Control for customizer.
 */

require get_template_directory() . '/inc/controls.php';
require get_template_directory() . '/inc/breadcrumb-class.php';

/**
 * Core Blog Custom Widgets.
 */
require get_template_directory() . '/inc/core-blog-widgets.php';

/**
 * Custom Header.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory()  . '/inc/tgm/class-tgm-plugin-activation.php';
require get_template_directory(). '/inc/tgm/hook-tgm.php';

require_once( trailingslashit( get_template_directory() ) . '/inc/custom-button/class-customize.php' );

/**
 * Add theme admin page.
 */
if ( is_admin() ) {
	require get_parent_theme_file_path( 'inc/about.php' );
}

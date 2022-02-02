<?php
function core_blog_customize_register($wp_customize)
{
    $wp_customize->remove_control("header_image");
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh))
    {
        $wp_customize
            ->selective_refresh
            ->add_partial('blogname', array(
            'selector' => '.site-title a',
            'render_callback' => 'core_blog_customize_partial_blogname',
        ));
        $wp_customize
            ->selective_refresh
            ->add_partial('blogdescription', array(
            'selector' => '.site-description',
            'render_callback' => 'core_blog_customize_partial_blogdescription',
        ));
    }
    require get_template_directory() . '/inc/customizer-settings.php';
}
add_action('customize_register', 'core_blog_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function core_blog_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function core_blog_customize_partial_blogdescription()
{
    bloginfo('description');
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */

function core_blog_customize_preview_js() {
    wp_enqueue_script('core-blog-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array(
        'customize-preview'
    ) , CORE_BLOG_S_VERSION, true);
}
add_action( 'customize_preview_init', 'core_blog_customize_preview_js' );

if (!function_exists('core_blog_header_social_active_callback')):
    function core_blog_header_social_active_callback()
    {
        $show_social = get_theme_mod('core_blog_left_header_social_icon_display', true);

        if ($show_social)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
endif;

if (!function_exists('core_blog_footer_copyright_callback')):
    function core_blog_footer_copyright_callback()
    {
        $show_copyright = get_theme_mod('core_blog_footer_copyright_display', true);

        if (true == $show_copyright)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
endif;

if (!function_exists('core_blog_copyright_callback')):
    function core_blog_copyright_callback()
    {
        $show_copyright = get_theme_mod('core_blog_footer_copyright_display', true);

        if (true == $show_copyright)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
endif;

if (!function_exists('core_blog_slider_callback')):
    function core_blog_slider_callback()
    {
        $show_slider = get_theme_mod('core_blog_slider_display', true);

        if (true == $show_slider)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
endif;
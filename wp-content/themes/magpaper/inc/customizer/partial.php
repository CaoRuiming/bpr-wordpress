<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Magpaper
* @since Magpaper 1.0.0
*/

if ( ! function_exists( 'magpaper_popular_post_title_partial' ) ) :
    // copyright text
    function magpaper_popular_post_title_partial() {
        $options = magpaper_get_theme_options();
        return esc_html( $options['popular_post_title'] );
    }
endif;

if ( ! function_exists( 'magpaper_blog_title_partial' ) ) :
    // copyright text
    function magpaper_blog_title_partial() {
        $options = magpaper_get_theme_options();
        return esc_html( $options['blog_section_title'] );
    }
endif;

if ( ! function_exists( 'magpaper_copyright_text_partial' ) ) :
    // copyright text
    function magpaper_copyright_text_partial() {
        $options = magpaper_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;

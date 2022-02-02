<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function magpaper_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'magpaper' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function magpaper_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'magpaper' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    wp_reset_postdata();
    return  $choices;
}

if ( ! function_exists( 'magpaper_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function magpaper_site_layout() {
        $magpaper_site_layout = array(
            'wide'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'magpaper_site_layout', $magpaper_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'magpaper_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function magpaper_selected_sidebar() {
        $magpaper_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'magpaper' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'magpaper' ),
        );

        $output = apply_filters( 'magpaper_selected_sidebar', $magpaper_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'magpaper_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function magpaper_sidebar_position() {
        $magpaper_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'magpaper_sidebar_position', $magpaper_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'magpaper_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function magpaper_pagination_options() {
        $magpaper_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'magpaper' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'magpaper' ),
        );

        $output = apply_filters( 'magpaper_pagination_options', $magpaper_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'magpaper_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function magpaper_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'magpaper' ),
            'off'       => esc_html__( 'Disable', 'magpaper' )
        );
        return apply_filters( 'magpaper_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'magpaper_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function magpaper_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'magpaper' ),
            'off'       => esc_html__( 'No', 'magpaper' )
        );
        return apply_filters( 'magpaper_hide_options', $arr );
    }
endif;


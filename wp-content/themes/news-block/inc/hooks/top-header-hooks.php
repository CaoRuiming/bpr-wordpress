<?php
/**
 * Handles hooks for the top header area of the themes
 * 
 * @package News Block
 * @since 1.0.0
 * 
 */
 if( !function_exists( 'news_block_top_header_start' ) ) {
     /**
      * Top header start
      */
    function news_block_top_header_start() {
    echo '<div id="blaze-top-header">';
    echo '<div class="container"><div class="row align-items-center top_header_inner_wrap">';
    }
 }

 if( !function_exists( 'news_block_top_header_date' ) ) {
    /**
     * Top header date element
     * 
     */
    function news_block_top_header_date() {
        $top_header_date_option = get_theme_mod( 'top_header_date_option', true );
        if( !$top_header_date_option ) {
            return;
        }
    ?>
        <div class="top-header-date_outerwrap">
            <div class="top-header-date has_dot ">
                <?php
                    $top_header_date_format = get_theme_mod( 'top_header_date_format', esc_attr( 'l-M-d,-Y' ) );
                    echo esc_attr( date( str_replace( '-', ' ',  $top_header_date_format ) ) );
                ?>
            </div>
        </div>
    <?php
    }
 }

 if( !function_exists( 'news_block_top_header_menu' ) ) {
    /**
     * Top header menu element
     * 
     */
    function news_block_top_header_menu() {
        $top_header_menu_option = get_theme_mod( 'top_header_menu_option', true );
        if( !$top_header_menu_option ) {
            return;
        }
    ?>
        <div class="top-header-menu_outerwrap">
            <div class="top-header-menu_wrap">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'menu-2',
    					'menu_id'        => 'top-header-menu',
                        'depth'           => 1,
                        'fallback_cb'     => false
                    ));
                ?>
            </div>
        </div>
    <?php
    }
 }

 if( !function_exists( 'top_header_social_icons' ) ) {
    /**
     * Top header social icons element
     * 
     */
    function top_header_social_icons() {
        $top_header_social_icons_option = get_theme_mod( 'top_header_social_icons_option', true );
        if( !$top_header_social_icons_option ) {
            return;
        }
    ?>
        <div class="top-header-social-icons_outerwrap">
            <div class="top-header-social-icons">
                <?php
                    $top_header_social_icon_one_url = get_theme_mod( 'top_header_social_icon_one_url', '#' );
                    if( !empty( $top_header_social_icon_one_url ) ) {
                        $top_header_social_icon_one = get_theme_mod( 'top_header_social_icon_one', 'facebook' );
                        echo '<a href="'.esc_url( $top_header_social_icon_one_url ).'" target="_self" rel="noopener"><i class="fab fa-' .esc_attr( $top_header_social_icon_one ). '"></i></a>';
                    }

                    $top_header_social_icon_two_url = get_theme_mod( 'top_header_social_icon_two_url', '#' );
                    if( !empty( $top_header_social_icon_two_url ) ) {
                        $top_header_social_icon_two = get_theme_mod( 'top_header_social_icon_two', 'vimeo' );
                        echo '<a href="'.esc_url( $top_header_social_icon_two_url ).'" target="_self" rel="noopener"><i class="fab fa-' .esc_attr( $top_header_social_icon_two ). '"></i></a>';
                    }

                    $top_header_social_icon_three_url = get_theme_mod( 'top_header_social_icon_three_url', '#' );
                    if( !empty( $top_header_social_icon_three_url ) ) {
                        $top_header_social_icon_three = get_theme_mod( 'top_header_social_icon_three', 'twitter' );
                        echo '<a href="'.esc_url( $top_header_social_icon_three_url ).'" target="_self" rel="noopener"><i class="fab fa-' .esc_attr( $top_header_social_icon_three ). '"></i></a>';
                    }
                ?>
            </div>
        </div>
    <?php
    }
 }

 if( !function_exists( 'news_block_top_header_close' ) ) {
    /**
     * Top header close
     */
    function news_block_top_header_close() {
    echo '</div><!-- .row -->';
    echo '</div><!-- .container -->';
    echo '</div><!-- #blaze-top-header -->';
    }
 }
add_action( 'news_block_top_header_hook', 'news_block_top_header_start', 5 );
add_action( 'news_block_top_header_hook', 'news_block_top_header_date', 5 );
add_action( 'news_block_top_header_hook', 'news_block_top_header_menu', 15 );
add_action( 'news_block_top_header_hook', 'top_header_social_icons', 20 );
add_action( 'news_block_top_header_hook', 'news_block_top_header_close', 100 );
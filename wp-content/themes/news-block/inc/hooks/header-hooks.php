<?php
/**
 * Handles hooks for the header area of the themes
 * 
 * @package News Block
 * @since 1.0.0
 * 
 */

if( !function_exists( 'news_block_header_start' ) ) {
    /**
     * Header start
     */
   function news_block_header_start() {
    echo '<header id="masthead" class="site-header">';
   }
}

if( !function_exists( 'news_block_header_site_sec_wrap_open' ) ) :
    /**
     * Site branding section wrap open
     * 
     */
    function news_block_header_site_sec_wrap_open() {
        echo '<div class="site-branding-section-wrap">';
        echo "<div class='container'>";
        echo '<div class="row align-items-center site-branding-inner-wrap">';
    }
endif;

if( !function_exists( 'news_block_header_site_branding' ) ) {
   /**
    * Header site branding element
    * 
    */
   function news_block_header_site_branding() {
   ?>
      <div class="site-branding">
  			<?php
  			    the_custom_logo();
  			if ( is_front_page() && is_home() ) :
  				?>
  				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
  				<?php
  			else :
  				?>
  				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
  				<?php
  			endif;
  			$news_block_description = get_bloginfo( 'description', 'display' );
  			if ( $news_block_description || is_customize_preview() ) :
  				?>
  				<p class="site-description"><?php echo esc_html( $news_block_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
  			<?php endif; ?>
		</div><!-- .site-branding -->
   <?php
   }
}

if( !function_exists( 'news_block_header_ad_banner' ) ) {
    /**
     * Header Ad Banner element
     * 
     */
    function news_block_header_ad_banner() {
        $header_ad_banner_image = get_theme_mod( 'header_ad_banner_image' );
        if( empty( $header_ad_banner_image ) ) { 
            return;
        }
    ?>
        <div class="blaze-ad-banner">
            <?php
                $header_ad_banner_link = get_theme_mod( 'header_ad_banner_link' );
                $header_ad_banner_link_target = get_theme_mod( 'header_ad_banner_link_target', false );
                $link_target = '_self';
                if( $header_ad_banner_link_target ) $link_target = '_blank';
                echo '<a href="' .esc_url( $header_ad_banner_link ). '" target="' .esc_html( $link_target ). '"><img src="' .esc_url( $header_ad_banner_image ). '"></a>';
            ?>
        </div><!-- #blaze-ad-banner -->
    <?php
    }
 }

 if( !function_exists( 'news_block_header_site_sec_wrap_close' ) ) :
    /**
     * Site branding section wrap close
     * 
     */
    function news_block_header_site_sec_wrap_close() {
        echo '</div><!-- .row-->';
        echo '</div><!-- .container -->';
        echo '</div><!-- .site-branding-section-wrap -->';
    }
endif;

if( !function_exists( 'news_block_header_main_menu_sec_wrap_open' ) ) :
    /**
     * Main menu wrap open
     * 
     */
    function news_block_header_main_menu_sec_wrap_open() {
        echo '<div class="main-navigation-section-wrap">';
        echo '<div class="container">';
        echo '<div class="row align-items-center menu_search_wrap_inner">';
    }
endif;

if( !function_exists( 'news_block_header_main_menu' ) ) {
   /**
    * Header menu element
    * 
    */
   function news_block_header_main_menu() {
   ?>
    <div class="main-navigation-wrap">
      <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'news-block' ); ?>">
  		  <button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
          <i class="fas fa-bars"></i>
        </button>
        <div id="site-header-menu" class="site-header-menu">
    			<?php
                    wp_nav_menu(
                        array(
                            'theme_location'=> 'menu-1',
                            'menu_class'    => 'primary-menu',
                            'fallback_cb'   => 'news_block_primary_navigation_fallback'
                        )
                    );
    			?>
        </div>
  		</nav><!-- #site-navigation -->
    </div>
   <?php
   }
}

if( !function_exists( 'news_block_header_search_bar' ) ) {
   /**
    * Header search bar element
    * 
    */
   function news_block_header_search_bar() {
       $header_search_bar_option = get_theme_mod( 'header_search_bar_option', true );
       if( !$header_search_bar_option ) return;
   ?>
        <div class="header-search-wrap">
            <div class="header-search-bar">
                <?php get_search_form(); ?>
            </div><!-- !header-search-bar -->
        </div>
   <?php
   }
}

if( !function_exists( 'news_block_header_main_menu_sec_wrap_close' ) ) :
    /**
     * Main menu wrap close
     * 
     */
    function news_block_header_main_menu_sec_wrap_close() {
        echo '</div><!-- .row -->';
        echo '</div><!-- .container -->';
        echo '</div><!-- .main-navigation-section-wrap -->';
    }
endif;

if( !function_exists( 'news_block_header_close' ) ) {
   /**
    * Header close
    */
   function news_block_header_close() {
    echo '</header><!-- #masthead -->';
   }
}
add_action( 'news_block_header_hook', 'news_block_header_start', 5 );
add_action( 'news_block_header_hook', 'news_block_header_site_sec_wrap_open', 10 );
add_action( 'news_block_header_hook', 'news_block_header_site_branding', 15 );
add_action( 'news_block_header_hook', 'news_block_header_ad_banner', 20 );
add_action( 'news_block_header_hook', 'news_block_header_site_sec_wrap_close', 25 );
add_action( 'news_block_header_hook', 'news_block_header_main_menu_sec_wrap_open', 30 );
add_action( 'news_block_header_hook', 'news_block_header_main_menu', 35 );
add_action( 'news_block_header_hook', 'news_block_header_search_bar', 40 );
add_action( 'news_block_header_hook', 'news_block_header_main_menu_sec_wrap_close', 45 );
add_action( 'news_block_header_hook', 'news_block_header_close', 100 );

if ( ! function_exists( 'news_block_breadcrumb_trail' ) ) {
    /**
     * Breadcrumbs hook
     * 
     * @package News Block
     * @since 1.0.0
     */
    function news_block_breadcrumb_trail() {
        //check customizer if breadcrumb is enabled
        if ( get_theme_mod ( 'breadcrumb_option', true ) != true ) return;

        if( !function_exists( 'news_block_breadcrumb_trail_fnc' ) ) return;
        $breadcrumb_prefix_title    = get_theme_mod( 'breadcrumb_prefix_title', esc_html__( 'Browse : ', 'news-block' ) );
        if( empty( $breadcrumb_prefix_title ) ) {
            $show_browse = false;
        } else {
            $show_browse = true;
        }
        $breadcrumb_home_title      = get_theme_mod( 'breadcrumb_home_title', esc_html__( 'Home', 'news-block' ) );
        $breadcrumb_search_title    = get_theme_mod( 'breadcrumb_search_title', esc_html__( 'Search results for: ', 'news-block' ) );
        $breadcrumb_error_title     = get_theme_mod( 'breadcrumb_error_title', esc_html__( '404 Not Found', 'news-block' ) );
        $theme_args = array(
            'container'       => 'nav',
            'show_on_front'   => false,
            'network'         => false,
            'show_title'      => true,
            'show_browse'     => $show_browse,
            'labels' => array(
                'browse'              => esc_html( $breadcrumb_prefix_title ),
                'home'                => esc_html( $breadcrumb_home_title ),
                'error_404'           => esc_html( $breadcrumb_error_title ),
                'search'              => esc_html( $breadcrumb_search_title ) . ' %s'
            )
        );
        echo '<div class="container"><div class="row">';
            news_block_breadcrumb_trail_fnc( $theme_args );
        echo '</div></div>';
    }
    add_action( 'news_block_before_content_hook', 'news_block_breadcrumb_trail', 10 );
}
<?php
/**
 * Handles hooks for the footer area of the themes
 * 
 * @package News Block
 * @since 1.0.0
 * 
 */

if( !function_exists( 'news_block_footer_start' ) ) {
    /**
     * Footer start
     */
   function news_block_footer_start() {
    $footer_widget_column = get_theme_mod( 'footer_widget_column', 'column-four' );
    echo '<footer id="colophon" class="site-footer footer-' .esc_attr( $footer_widget_column ). '">';
    echo '<div class="container footer-inner">';
   }
}

if( !function_exists( 'news_block_footer_widget_content' ) ) :
  /**
   * Footer widget content
   * 
   */
  function news_block_footer_widget_content() {
    get_template_part( '/footer-columns' );
  }
endif;
if( !function_exists( 'news_block_footer_close' ) ) {
  /**
   * Footer close
   */
 function news_block_footer_close() {
  echo '</div><!-- .container -->';
  echo '</footer><!-- #colophon -->';
 }
}

add_action( 'news_block_footer_hook', 'news_block_footer_start', 5 );
add_action( 'news_block_footer_hook', 'news_block_footer_widget_content', 10 );
add_action( 'news_block_footer_hook', 'news_block_footer_close', 100 );

/************************************ 
 * Bottom Footer Hook *
 * ***********************************/
if( !function_exists( 'news_block_bottom_footer_start' ) ) {
  /**
   * Bottom Footer start
   */
 function news_block_bottom_footer_start() {
  echo '<div id="bottom-footer">';
  echo '<div class="container bottom-footer-inner">';
 }
}

if( !function_exists( 'news_block_bottom_footer_site_logo' ) ) {
  /**
   * Bottom Footer site logo
   */
  function news_block_bottom_footer_site_logo() {
    $footer_site_logo_option = get_theme_mod( 'footer_site_logo_option', true );
    $footer_site_logo = get_theme_mod( 'footer_logo_image' );
    if( !$footer_site_logo_option ) {
      return;
    }
    if($footer_site_logo){
      ?>
      <div class="footer_logo">
        <img src="<?php echo esc_url($footer_site_logo); ?>">
      </div>
      <?php
    }
  }
}

if( !function_exists( 'news_block_bottom_footer_menu' ) ) :
  /**
   * Bottom Footer navigation Info
   * 
   */
  function news_block_bottom_footer_menu() { 
    $bottom_footer_menu_option = get_theme_mod( 'bottom_footer_menu_option', true );
    if( !$bottom_footer_menu_option ) {
      return;
    }
    ?>
      <div class="bottom-footer-menu">
        <?php
          wp_nav_menu(
            array(
              'theme_location'  => 'menu-3',
              'menu_id'         => 'bottom-footer-menu',
              'depth'           => 1,
              'fallback_cb'     => false
            )
          );
        ?>
      </div>
    <?php
  }
endif;

if( !function_exists( 'news_block_bottom_footer_site_info' ) ) :
  /**
   * Site Info
   * 
   */
  function news_block_bottom_footer_site_info() {
    $bottom_footer_site_info = get_theme_mod( 'bottom_footer_site_info', sprintf( 'Copyright | News Block by %s', '<a href="' .esc_url( 'https://blazethemes.com/' ). '" target="_blank">' . esc_html( 'Blazethemes', 'news-block' ). '</a>' ) );
    if( empty( $bottom_footer_site_info ) ) { 
      return;
    }
    ?>
      <div class="site-info">
          <?php
            echo wp_kses_post( $bottom_footer_site_info );
          ?>
      </div><!-- .site-info -->
    <?php
  }
endif;

if( !function_exists( 'news_block_bottom_footer_close' ) ) {
/**
 * Bottom Footer close
 */
function news_block_bottom_footer_close() {
echo '</div><!-- .container -->';
echo '</div><!-- #bottom-footer -->';
}
}

add_action( 'news_block_bottom_footer_hook', 'news_block_bottom_footer_start', 5 );
add_action( 'news_block_bottom_footer_hook', 'news_block_bottom_footer_site_logo', 10 );
add_action( 'news_block_bottom_footer_hook', 'news_block_bottom_footer_menu', 30 );
add_action( 'news_block_bottom_footer_hook', 'news_block_bottom_footer_site_info', 50 );
add_action( 'news_block_bottom_footer_hook', 'news_block_bottom_footer_close', 100 );
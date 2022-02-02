<?php
/**
 * Handles hooks file and functioning for entire theme
 * 
 * @package News Block
 * @since 1.0.0
 * 
 */

if( !function_exists( 'news_block_site_preloader' ) ) :
    /**
     * Preloader functions
     * 
     */
    function news_block_site_preloader() {
        $preloader_option = get_theme_mod( 'preloader_option', false );
        if( !$preloader_option ) {
            return;
        }
        if (( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] )) {
            return;
        }
        $preloader_background_color = get_theme_mod( 'preloader_background_color', '#fff' );
        ?>
            <div id="news-block-preloader">
                <div class="news-block-preloader-item">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: <?php echo esc_attr( $preloader_background_color ); ?>; display: block; shape-rendering: auto;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><rect x="19" y="19" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0s" calcMode="discrete"></animate></rect><rect x="40" y="19" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.125s" calcMode="discrete"></animate></rect><rect x="61" y="19" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.25s" calcMode="discrete"></animate></rect><rect x="19" y="40" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.875s" calcMode="discrete"></animate></rect><rect x="61" y="40" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.375s" calcMode="discrete"></animate></rect><rect x="19" y="61" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.75s" calcMode="discrete"></animate></rect><rect x="40" y="61" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.625s" calcMode="discrete"></animate></rect><rect x="61" y="61" width="20" height="20" fill="#000000"><animate attributeName="fill" values="<?php echo esc_attr( $preloader_background_color ); ?>;#000000;#000000" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.5s" calcMode="discrete"></animate></rect></svg>
                </div>
            </div>
        <?php
    }
    add_action( 'news_block_site_preloader_hook', 'news_block_site_preloader' );
 endif;

 if( !function_exists( 'news_block_archive_read_more_button' ) ) :
    /**
     * Archive read more button fnc
     * 
     */
    function news_block_archive_read_more_button() {
        $archive_read_more_option   = get_theme_mod( 'archive_read_more_option', true );
        if( !$archive_read_more_option ) {
            return;
        }
        $archive_read_more_text     = get_theme_mod( 'archive_read_more_text', esc_html__( 'Read more . . ', 'news-block' ) );
        $news_blog_archie_layout = get_theme_mod( 'archive_posts_layout', 'list-layout' );

        $news_blog_layout = 'grid';
        if( $news_blog_archie_layout == 'list-layout') {
            $news_blog_layout = 'list';
        }
        switch( $news_blog_layout ) {
            case 'list' : echo '<div class="bmm-read-more-two"><a href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $archive_read_more_text ) . '</a></div>';
                        break;
            default : echo '<div class="bmm-read-more-two"><a href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $archive_read_more_text ) . '</a></div>';
                        break;
        }
    }
    add_action( 'news_block_archive_single_post_before_article_hook', 'news_block_archive_read_more_button', 10 );
 endif;

 if( !function_exists( 'news_block_scroll_to_top' ) ) :
    /**
     * scroll to top fnc
     * 
     */
    function news_block_scroll_to_top() {
        $scroll_to_top_option = get_theme_mod( 'scroll_to_top_option', true );
        if( !$scroll_to_top_option ) {
            return;
        }
        $scroll_to_top_align = get_theme_mod( 'scroll_to_top_align', 'align--right' );
    ?>
        <div id="news-block-scroll-to-top" class="<?php echo esc_attr( $scroll_to_top_align ); ?>">
            <a href="#" data-tooltip="Back To Top">
                <span class="back_txt"><?php esc_html_e( 'Back to Top', 'news-block' ); ?></span>
                <i class="fas fa-long-arrow-alt-up"></i>
            </a>
        </div><!-- #news-block-scroll-to-top -->
    <?php
    }
    add_action( 'news_block_after_footer_hook', 'news_block_scroll_to_top' );
 endif;

 if( ! function_exists( 'news_block_pagination_fnc' ) ) :
    /**
     * Renders pagination
     * 
     */
    function news_block_pagination_fnc() {
        if( is_null( paginate_links() ) ) {
            return;
        }
        $pagination_type = get_theme_mod( 'archive_pagination_type', 'pagination' );
        if( is_search() ) {
            $pagination_type = get_theme_mod( 'search_pagination_type', 'pagination' );
        }
        switch( $pagination_type ) {
            default : echo '<div class="bmm-pagination-links">'.paginate_links().'</div>';
                    break;
        }
    }
    add_action( 'news_block_pagination_link_hook', 'news_block_pagination_fnc' );
 endif;
 /**
 * Theme Hooks
 */
require NEWS_BLOCKS_INCLUDES_PATH . 'hooks/top-header-hooks.php';
require NEWS_BLOCKS_INCLUDES_PATH . 'hooks/header-hooks.php';
require NEWS_BLOCKS_INCLUDES_PATH . 'hooks/footer-hooks.php';
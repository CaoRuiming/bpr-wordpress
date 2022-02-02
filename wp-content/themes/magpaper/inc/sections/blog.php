<?php
/**
 * Blog section
 *
 * This is the template for the content of blog section
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */
if ( ! function_exists( 'magpaper_add_blog_section' ) ) :
    /**
    * Add blog section
    *
    *@since Magpaper 1.0.0
    */
    function magpaper_add_blog_section() {
    	$options = magpaper_get_theme_options();
        // Check if blog is enabled on frontpage
        $blog_enable = apply_filters( 'magpaper_section_status', true, 'blog_section_enable' );

        if ( true !== $blog_enable ) {
            return false;
        }
        // Get blog section details
        $section_details = array();
        $section_details = apply_filters( 'magpaper_filter_blog_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render blog section now.
        magpaper_render_blog_section( $section_details );
    }
endif;
add_action( 'magpaper_primary_content', 'magpaper_add_blog_section', 40 );

if ( ! function_exists( 'magpaper_get_blog_section_details' ) ) :
    /**
    * blog section details.
    *
    * @since Magpaper 1.0.0
    * @param array $input blog section details.
    */
    function magpaper_get_blog_section_details( $input ) {
        $options = magpaper_get_theme_options();

        // Content type.
        $blog_content_type  = $options['blog_content_type'];
        
        $content = array();
        switch ( $blog_content_type ) {

            case 'category':
                $cat_id = ! empty( $options['blog_content_category'] ) ? $options['blog_content_category'] : '';
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 9,
                    'cat'               => absint( $cat_id ),
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            case 'recent':
                $cat_ids = ! empty( $options['blog_category_exclude'] ) ? $options['blog_category_exclude'] : array();
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 9,
                    'category__not_in'  => ( array ) $cat_ids,
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            default:
            break;
        }

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = magpaper_trim_content( 35 );
                $page_post['author_id'] = get_the_author_meta('ID');
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'medium_large' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-600x600.jpg';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// blog section content details.
add_filter( 'magpaper_filter_blog_section_details', 'magpaper_get_blog_section_details' );


if ( ! function_exists( 'magpaper_render_blog_section' ) ) :
  /**
   * Start blog section
   *
   * @return string blog content
   * @since Magpaper 1.0.0
   *
   */
   function magpaper_render_blog_section( $content_details = array() ) {
        $options = magpaper_get_theme_options();
        $blog_content_type  = $options['blog_content_type'];
        $title = ! empty( $options['blog_section_title'] ) ? $options['blog_section_title'] : '';
        $readmore = ! empty( $options['blog_section_btn_label'] ) ? $options['blog_section_btn_label'] : esc_html__( 'Read More', 'magpaper' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="latest-posts" class="page-section relative">
            <div class="wrapper">
                <?php if ( ! empty( $title ) ) : ?>
                    <div class="section-header">
                        <h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
                    </div><!-- .section-header -->
                <?php endif; ?>

                <div class="section-content grid">
                    <?php foreach ( $content_details as $content ) : ?>
                        <article class="grid-item">
                            <div class="post-item-wrapper">
                                <div class="entry-meta">
                                    <?php  
                                        magpaper_posted_on( $content['id'] );
                                        echo magpaper_author( $content['author_id'] );
                                    ?>
                                </div><!-- .entry-meta -->
                                
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>
                                
                                <?php if ( ! empty( $content['image'] ) ) : ?>
                                    <div class="featured-image">
                                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="post-thumbnail-link"><img src="<?php echo esc_url( $content['image'] ); ?>"></a>
                                    </div>
                                <?php endif; ?>

                                <div class="entry-content">
                                    <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                </div><!-- .entry-content -->

                                <div class="read-more">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>" class="more-link">
                                        <?php 
                                            echo esc_html( $readmore ); 
                                            echo magpaper_get_svg( array( 'icon' => 'right' ) );
                                        ?>
                                    </a>
                                </div>
                            </div><!-- .post-item-wrapper -->
                        </article>
                    <?php endforeach; ?>

                </div><!-- .section-content -->

            </div><!-- .wrapper -->
        </div><!-- #latest-posts -->

    <?php }
endif;
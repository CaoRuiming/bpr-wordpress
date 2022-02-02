<?php
/**
 * Popular post section
 *
 * This is the template for the content of popular_post section
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */
if ( ! function_exists( 'magpaper_add_popular_post_section' ) ) :
    /**
    * Add popular_post section
    *
    *@since Magpaper 1.0.0
    */
    function magpaper_add_popular_post_section() {
    	$options = magpaper_get_theme_options();
        // Check if popular_post is enabled on frontpage
        $popular_post_enable = apply_filters( 'magpaper_section_status', true, 'popular_post_section_enable' );

        if ( true !== $popular_post_enable ) {
            return false;
        }
        // Get popular_post section details
        $section_details = array();
        $section_details = apply_filters( 'magpaper_get_popular_post_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render popular_post section now.
        magpaper_render_popular_post_section( $section_details );
    }
endif;
add_action( 'magpaper_primary_content', 'magpaper_add_popular_post_section', 20 );

if ( ! function_exists( 'magpaper_get_popular_post_section_details' ) ) :
    /**
    * popular_post section details.
    *
    * @since Magpaper 1.0.0
    * @param array $input popular_post section details.
    */
    function magpaper_get_popular_post_section_details( $input ) {
        $options = magpaper_get_theme_options();

        $popular_post_count = ! empty( $options['popular_post_count'] ) ? $options['popular_post_count'] : 3;
        
        $content = array();
        $content['left']  = array();
        $content['right'] = array();
        
                $cat_id = ! empty( $options['popular_post_left_content_category'] ) ? $options['popular_post_left_content_category'] : '';
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 2,
                    'cat'               => absint( $cat_id ),
                    'ignore_sticky_posts'   => true,
                    );                    
        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['author_id'] = get_the_author_meta('ID');
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'medium' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-600x600.jpg';

                // Push to the main array.
                array_push( $content['left'], $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

        $page_id = '';

            if ( ! empty( $options['popular_post_right_content_page'] ) )
                $page_id = $options['popular_post_right_content_page'];
        
        $args = array(
            'post_type'         => 'page',
            'p'                 => absint( $page_id ),
            'posts_per_page'    => 1,
            );                     

        // Run The Loop.
        $query_2 = new WP_Query( $args );
        if ( $query_2->have_posts() ) : 
            while ( $query_2->have_posts() ) : $query_2->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['content']     = get_the_excerpt();
                $page_post['url']       = get_the_permalink();
                $page_post['author_id'] = get_the_author_meta('ID');
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'medium_large' ) : '';

                // Push to the main array.
                array_push( $content['right'], $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// popular_post section content details.
add_filter( 'magpaper_get_popular_post_section_details', 'magpaper_get_popular_post_section_details' );


if ( ! function_exists( 'magpaper_render_popular_post_section' ) ) :
  /**
   * Start popular_post section
   *
   * @return string popular_post content
   * @since Magpaper 1.0.0
   *
   */
   function magpaper_render_popular_post_section( $content_details = array() ) {
        $options = magpaper_get_theme_options();
        $popular_post_title  = ! empty( $options['popular_post_title'] ) ? $options['popular_post_title'] : '';
        if ( empty( $content_details ) ) {
            return;
        } 
        ?>
        <div id="featured-highlights-posts" class="relative">
            <div class="wrapper">
                <?php if ( ! empty( $popular_post_title ) ) : ?>
                    <div class="section-header">
                        <h2 class="section-title"><?php echo esc_html( $popular_post_title ); ?></h2>
                    </div><!-- .section-header -->
                <?php endif; ?>

                <div class="section-content">
                    <div class="hentry">
                        <?php foreach ( $content_details['right'] as $content ) : ?>
                            <article>
                                <?php if ( ! empty( $content['image'] ) ) : ?>
                                    <div class="featured-image"><a href="<?php echo esc_url( $content['url'] ); ?>"><img src="<?php echo esc_url( $content['image'] ); ?>"></a></div>
                                <?php endif; ?>
                                <div class="entry-meta">
                                    <?php  
                                        magpaper_posted_on( $content['id'] );
                                        echo magpaper_author( $content['author_id'] );
                                    ?>
                                </div><!-- .entry-meta -->
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>

                                <div class="entry-content">
                                    <p><?php echo  wp_kses_post( $content['content'] ); ?></p>
                                </div><!-- .entry-content -->
                            </article>
                        <?php endforeach; ?>
                    </div><!-- .hentry -->
                    <div class="hentry">
                        <?php foreach ( $content_details['left'] as $content ) : ?>
                            <article>
                                <?php if ( ! empty( $content['image'] ) ) : ?>
                                    <div class="featured-image"><a href="<?php echo esc_url( $content['url'] ); ?>"><img src="<?php echo esc_url( $content['image'] ); ?>"></a></div>
                                <?php endif; ?>

                                <div class="entry-meta">
                                    <?php  
                                        magpaper_posted_on( $content['id'] );
                                        echo magpaper_author( $content['author_id'] );
                                    ?>
                                </div><!-- .entry-meta -->
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>

                            </article>
                        <?php endforeach; ?>
                    </div><!-- .hentry -->

                    
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #popular-posts -->
    <?php 
    }
endif;
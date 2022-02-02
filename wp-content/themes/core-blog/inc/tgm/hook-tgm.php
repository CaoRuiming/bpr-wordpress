<?php
/**
 * Recommended plugins
 *
 * @package Blogwaves
 */

if ( ! function_exists( 'core_blog_recommended_plugins' ) ) :

    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function core_blog_recommended_plugins() {

        $plugins = array(
            array(
                'name'     => esc_html__( 'Accordion Slider Gallery', 'core-blog' ),
                'slug'     => 'accordion-slider-gallery',
                'required' => false,
            ),
			
			 array(
                'name'     => esc_html__( 'Timeline', 'core-blog' ),
                'slug'     => 'timeline-event-history',
                'required' => false,
            ),
          
             array(
                'name'     => esc_html__( 'Photo Gallery', 'core-blog' ),
                'slug'     => 'photo-gallery-builder',
                'required' => false,
            ),
        );

        tgmpa( $plugins );

    }

endif;

add_action( 'tgmpa_register', 'core_blog_recommended_plugins' );

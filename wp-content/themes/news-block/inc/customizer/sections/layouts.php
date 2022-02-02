<?php
/**
 * Layouts settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_layouts_section_register', 10 );
/**
 * Add settings for layouts section in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_layouts_section_register( $wp_customize ) {
    /**
     * Layouts Section
     * 
     * panel - news_block_theme_panel
     */
    $wp_customize->add_section( 'layouts_section', array(
        'title' => esc_html__( 'Layouts Settings', 'news-block' ),
        'panel' => 'news_block_theme_panel',
        'priority'  => 40,
    ));
    
    /**
     * Whole Site Layout Settings Heading
     * 
     */
    $wp_customize->add_setting( 'site_layout_setting_header', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'site_layout_setting_header', array(
          'label'       => esc_html__( 'MAin Site Layout', 'news-block' ),
          'section'     => 'layouts_section',
          'settings'    => 'site_layout_setting_header',
          'type'        => 'section-heading',
      ))
    );

    /**
     * Site layout settings
     * 
     */
    $wp_customize->add_setting( 'site_layout',
      array(
        'default'           => 'box-layout',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Image_Control(
        $wp_customize,
        'site_layout',
        array(
          'section'  => 'layouts_section',
          'choices'  => array(
            'box-layout' => array(
              'label' => esc_html__( 'Boxed Width', 'news-block' ),
              'url'   => '%s/images/customizer/site-boxed.png'
            ),
            'full-layout' => array(
              'label' => esc_html__( 'Full Width', 'news-block' ),
              'url'   => '%s/images/customizer/site-full-width.png'
            )
          )
        )
      )
    );
    
    /**
     * Post Layout Settings Heading
     * 
     */
    $wp_customize->add_setting( 'post_layout_setting_header', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'post_layout_setting_header', array(
          'label'       => esc_html__( 'Post Layout', 'news-block' ),
          'section'     => 'layouts_section',
          'settings'    => 'post_layout_setting_header',
          'type'        => 'section-heading',
      ))
    );

    /**
     * Post layout settings
     * 
     */
    $wp_customize->add_setting( 'post_layout',
      array(
        'default'           => 'boxed-content-width',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Image_Control(
        $wp_customize,
        'post_layout',
        array(
          'section'  => 'layouts_section',
          'choices'  => array(
            'full-width' => array(
              'label' => esc_html__( 'Full Width', 'news-block' ),
              'url'   => '%s/images/customizer/full_width_layout.jpg'
            ),
            'boxed-content-width' => array(
              'label' => esc_html__( 'Box Content Width', 'news-block' ),
              'url'   => '%s/images/customizer/boxed_width_layout.jpg'
            )
          )
        )
      )
    );

    /**
     * Page Layout Settings Heading
     * 
     */
    $wp_customize->add_setting( 'page_layout_setting_header', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'page_layout_setting_header', array(
          'label'       => esc_html__( 'Page Layout', 'news-block' ),
          'section'     => 'layouts_section',
          'settings'    => 'page_layout_setting_header',
          'type'        => 'section-heading',
      ))
    );

    /**
     * Page layout settings
     * 
     */
    $wp_customize->add_setting( 'page_layout',
      array(
        'default'           => 'full-width',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Image_Control(
        $wp_customize,
        'page_layout',
        array(
          'section'  => 'layouts_section',
          'choices'  => array(
            'full-width' => array(
              'label' => esc_html__( 'Full Width', 'news-block' ),
              'url'   => '%s/images/customizer/full_width_layout.jpg'
            ),
            'boxed-content-width' => array(
              'label' => esc_html__( 'Box Content Width', 'news-block' ),
              'url'   => '%s/images/customizer/boxed_width_layout.jpg'
            )
          )
        )
      )
    );

    /**
     * Archive Layout Settings Heading
     * 
     */
    $wp_customize->add_setting( 'archive_layout_setting_header', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'archive_layout_setting_header', array(
          'label'       => esc_html__( 'Archive Layout', 'news-block' ),
          'section'     => 'layouts_section',
          'settings'    => 'archive_layout_setting_header',
          'type'        => 'section-heading',
      ))
    );

    /**
     * Archive layout settings
     * 
     */
    $wp_customize->add_setting( 'archive_layout',
      array(
        'default'           => 'boxed-content-width',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Image_Control(
        $wp_customize,
        'archive_layout',
        array(
          'section'  => 'layouts_section',
          'choices'  => array(
            'full-width' => array(
              'label' => esc_html__( 'Full Width', 'news-block' ),
              'url'   => '%s/images/customizer/full_width_layout.jpg'
            ),
            'boxed-content-width' => array(
              'label' => esc_html__( 'Box Content Width', 'news-block' ),
              'url'   => '%s/images/customizer/boxed_width_layout.jpg'
            )
          )
        )
      )
    );
}
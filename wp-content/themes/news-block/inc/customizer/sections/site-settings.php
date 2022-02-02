<?php
/**
 * Site settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_site_section_register', 10 );
/**
 * Add settings for site in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_site_section_register( $wp_customize ) {
    /**
     * Site Section
     * 
     * panel - news_block_theme_panel
     */

    $wp_customize->add_section( 'site_section', array(
      'title' => esc_html__( 'Site Settings', 'news-block' ),
      'panel' => 'news_block_theme_panel',
      'priority'  => 5,
    ));
    
    /**
     * Sticky Header Settings Heading
     * 
     */
    $wp_customize->add_setting( 'sticky_header_settings_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'sticky_header_settings_header', array(
            'label'	      => esc_html__( 'Sticky Header Setting', 'news-block' ),
            'section'     => 'site_section',
            'settings'    => 'sticky_header_settings_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Sticky Header On Scroll down
     * 
     */
    $wp_customize->add_setting( 'sticky_header_option', array(
        'default'           => false,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'sticky_header_option', array(
            'label'	      => esc_html__( 'Enable Sticky Header on Scroll Down', 'news-block' ),
            'section'     => 'site_section',
            'settings'    => 'sticky_header_option',
            'type'        => 'toggle',
        ))
    );

    /**
     * Scroll To Top Settings Heading
     * 
     */
    $wp_customize->add_setting( 'scroll_to_top_settings_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'scroll_to_top_settings_header', array(
            'label'	      => esc_html__( 'Scroll To Top Setting', 'news-block' ),
            'section'     => 'site_section',
            'settings'    => 'scroll_to_top_settings_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Scroll To Top Option
     * 
     */
    $wp_customize->add_setting( 'scroll_to_top_option', array(
        'default'           => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'scroll_to_top_option', array(
            'label'	      => esc_html__( 'Enable Scroll To Top', 'news-block' ),
            'section'     => 'site_section',
            'settings'    => 'scroll_to_top_option',
            'type'        => 'toggle',
        ))
    );
    
    /**
     * Site Images Settings Heading
     * 
     */
    $wp_customize->add_setting( 'site_image_settings_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'site_image_settings_header', array(
            'label'	      => esc_html__( 'Image Background Setting', 'news-block' ),
            'section'     => 'site_section',
            'settings'    => 'site_image_settings_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Site Image Background color
     * 
     */
    $wp_customize->add_setting( 'site_image_bg_color', array(
      'default' => '#ffc72c',
      'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( 
      new WP_Customize_Color_Control( $wp_customize, 'site_image_bg_color', array(
          'label'      => __( 'Site Images Bg Color', 'news-block' ),
          'section'     => 'site_section',
          'settings'   => 'site_image_bg_color',
      ))
    );
}
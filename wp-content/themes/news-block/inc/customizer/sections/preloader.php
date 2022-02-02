<?php
/**
 * Preloader settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_preloader_section_register', 10 );
/**
 * Add settings for preloader in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_preloader_section_register( $wp_customize ) {
    /**
     * Preloader Section
     * 
     * panel - news_block_theme_panel
     */

    $wp_customize->add_section( 'preloader_section', array(
      'title' => esc_html__( 'Preloader Settings', 'news-block' ),
      'panel' => 'news_block_theme_panel',
      'priority'  => 5,
    ));

    /**
     * Preloader Settings Heading
     * 
     */
    $wp_customize->add_setting( 'preloader_settings_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));
    
    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'preloader_settings_header', array(
            'label'	      => esc_html__( 'Preloader Settings', 'news-block' ),
            'section'     => 'preloader_section',
            'settings'    => 'preloader_settings_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Preloader Option
     * 
     */
    $wp_customize->add_setting( 'preloader_option', array(
        'default'           => false,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'preloader_option', array(
            'label'	      => esc_html__( 'Enable Preloader', 'news-block' ),
            'section'     => 'preloader_section',
            'settings'    => 'preloader_option',
            'type'        => 'toggle',
        ))
    );

    /**
     * Preloader Background Color
     * 
     */
    $wp_customize->add_setting( 'preloader_background_color', array(
        'default' => '#fff',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control( 
    new WP_Customize_Color_Control( $wp_customize, 'preloader_background_color', 
        array(
            'label'      => esc_html__( 'Backgroud Color', 'news-block' ),
            'section'    => 'preloader_section',
            'settings'   => 'preloader_background_color',
            'active_callback' => 'preloader_option_callback'
        ))
    );
}
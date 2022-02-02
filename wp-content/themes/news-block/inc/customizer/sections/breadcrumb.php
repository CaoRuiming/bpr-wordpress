<?php
/**
 * Breadcrumb settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_breadcrumb_section_register', 10 );
/**
 * Add settings for breadcrumb section in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_breadcrumb_section_register( $wp_customize ) {
    /**
     * Breadcrumb Section
     * 
     * panel - news_block_theme_panel
     */
    $wp_customize->add_section( 'breadcrumb_section', array(
        'title' => esc_html__( 'Breadcrumb Settings', 'news-block' ),
        'panel' => 'news_block_theme_panel',
        'priority'  => 110,
    ));


    /**
     * Breadcrumb Show Hide
     * 
     */
    $wp_customize->add_setting( 'breadcrumb_option', array(
      'default'         => true,
      'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'breadcrumb_option', array(
          'label'         => esc_html__( 'Show/Hide Breadcrumb', 'news-block' ),
          'section'     => 'breadcrumb_section',
          'settings'    => 'breadcrumb_option',
          'type'        => 'toggle'
      ))
    );

    /**
     * Breadcrumb prefix title
     * 
     */
    $wp_customize->add_setting( 'breadcrumb_prefix_title', array(
        'default'        => esc_html__( 'Browse : ', 'news-block' ),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'breadcrumb_prefix_title', array(
        'label'    => esc_html__( 'Prefix Title', 'news-block' ),
        'section'  => 'breadcrumb_section',		
        'type'     => 'text',
        'active_callback'   => 'breadcrumb_option_callback'
    ));
}
<?php
/**
 * Top header settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_top_header_section_register', 10 );
/**
 * Add settings for top header in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_top_header_section_register( $wp_customize ) {
    /**
     * Top Header Section
     * 
     * panel - news_block_theme_panel
     */
    $wp_customize->add_section( 'top_header_section', array(
      'title' => esc_html__( 'Top Header Section', 'news-block' ),
      'panel' => 'news_block_theme_panel',
      'priority'  => 10,
    ));

    /**
     * Top Header tab settings
     * 
     */
    $wp_customize->add_setting( 'top_header_settings_tab',
      array(
        'default'           => 'general',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Tab_Control(
			$wp_customize,
			'top_header_settings_tab',
        array(
          'label'    => esc_html__( 'Filter top header settings', 'news-block' ),
          'section'  => 'top_header_section',
          'choices'  => array(
            'general' => array(
              'label' => esc_html__( 'General', 'news-block' )
            )
          )
        )
    ));

    /**
     * Top Header General Settings Heading
     * 
     */
    $wp_customize->add_setting( 'top_header_general_setting_header', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'top_header_general_setting_header', array(
          'label'	      => esc_html__( 'General Settings', 'news-block' ),
          'section'     => 'top_header_section',
          'settings'    => 'top_header_general_setting_header',
          'type'        => 'section-heading',
          'active_callback' => 'top_header_settings_tab_general_callback'
      ))
    );

    /**
     * Top Header Date Option
     * 
     */
    $wp_customize->add_setting( 'top_header_date_option', array(
      'default'         => true,
      'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
      new News_Block_WP_Toggle_Control( $wp_customize, 'top_header_date_option', array(
          'label'	      => esc_html__( 'Show/Hide Current Date', 'news-block' ),
          'section'     => 'top_header_section',
          'settings'    => 'top_header_date_option',
          'type'        => 'toggle',
          'active_callback' => 'top_header_settings_tab_general_callback'
      ))
    );

    /**
     * Top Header Date Format
     * 
     */
    $wp_customize->add_setting( 'top_header_date_format', array(
      'default'         => esc_attr( 'l-M-d,-Y' ),
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'top_header_date_format', array(
          'label'	      => esc_html__( 'Date format', 'news-block' ),
          'section'     => 'top_header_section',
          'type'        => 'select',
          'choices'     => array(
            'l-M-d,-Y' => date('l M d, Y'),
            'l-F-d,-Y' => date('l F d, Y')
          ),
          'active_callback' => 'top_header_date_option_callback'
      )
    );

    /**
     * Top Header Menu Option
     * 
     */
    $wp_customize->add_setting( 'top_header_menu_option', array(
      'default'         => true,
      'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
      new News_Block_WP_Toggle_Control( $wp_customize, 'top_header_menu_option', array(
          'label'	      => esc_html__( 'Show/Hide Menu', 'news-block' ),
          'section'     => 'top_header_section',
          'settings'    => 'top_header_menu_option',
          'type'        => 'toggle',
          'active_callback' => 'top_header_settings_tab_general_callback'
      ))
    );

    /**
     * Top Header Social Icons
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icons_option', array(
      'default'         => true,
      'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
      new News_Block_WP_Toggle_Control( $wp_customize, 'top_header_social_icons_option', array(
          'label'	      => esc_html__( 'Show/Hide Social Icons', 'news-block' ),
          'section'     => 'top_header_section',
          'settings'    => 'top_header_social_icons_option',
          'type'        => 'toggle',
          'active_callback' => 'top_header_settings_tab_general_callback'
      ))
    );

    /**
     * Social Icon One
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icon_one', array(
      'default'         => 'facebook',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'top_header_social_icon_one', array(
          'label'	      => esc_html__( 'Icon', 'news-block' ),
          'section'     => 'top_header_section',
          'type'        => 'select',
          'choices'     => array(
            'facebook'  => esc_html__( 'Facebook', 'news-block' ),
            'vimeo'     => esc_html__( 'Vimeo', 'news-block' ),
            'twitter'   => esc_html__( 'Twitter', 'news-block' ),
            'pinterest' => esc_html__( 'Pinterest', 'news-block' ),
            'instagram' => esc_html__( 'Instagram', 'news-block' )
          ),
          'active_callback' => 'top_header_date_option_callback'
      )
    );

    /**
     * Social Icon One Url
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icon_one_url', array(
      'default'        => '#',
      'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( 'top_header_social_icon_one_url', array(
        'label'    => esc_html__( 'Icon Url', 'news-block' ),
        'section'  => 'top_header_section',		
        'type'     => 'url',
        'active_callback' => 'top_header_social_icons_option_callback'
    ));

    /**
     * Social Icon Two
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icon_two', array(
      'default'         => 'vimeo',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'top_header_social_icon_two', array(
          'label'	      => esc_html__( 'Icon', 'news-block' ),
          'section'     => 'top_header_section',
          'type'        => 'select',
          'choices'     => array(
            'facebook'  => esc_html__( 'Facebook', 'news-block' ),
            'vimeo'     => esc_html__( 'Vimeo', 'news-block' ),
            'twitter'   => esc_html__( 'Twitter', 'news-block' ),
            'pinterest' => esc_html__( 'Pinterest', 'news-block' ),
            'instagram' => esc_html__( 'Instagram', 'news-block' )
          ),
          'active_callback' => 'top_header_date_option_callback'
      )
    );

    /**
     * Social Icon Two Url
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icon_two_url', array(
      'default'        => '#',
      'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( 'top_header_social_icon_two_url', array(
        'label'    => esc_html__( 'Icon Url', 'news-block' ),
        'section'  => 'top_header_section',		
        'type'     => 'url',
        'active_callback' => 'top_header_social_icons_option_callback'
    ));

    /**
     * Social Icon Three
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icon_three', array(
      'default'         => 'twitter',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'top_header_social_icon_three', array(
          'label'	      => esc_html__( 'Icon', 'news-block' ),
          'section'     => 'top_header_section',
          'type'        => 'select',
          'choices'     => array(
            'facebook'  => esc_html__( 'Facebook', 'news-block' ),
            'vimeo'     => esc_html__( 'Vimeo', 'news-block' ),
            'twitter'   => esc_html__( 'Twitter', 'news-block' ),
            'pinterest' => esc_html__( 'Pinterest', 'news-block' ),
            'instagram' => esc_html__( 'Instagram', 'news-block' )
          ),
          'active_callback' => 'top_header_date_option_callback'
      )
    );

    /**
     * Social Icon Three Url
     * 
     */
    $wp_customize->add_setting( 'top_header_social_icon_three_url', array(
      'default'        => '#',
      'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( 'top_header_social_icon_three_url', array(
        'label'    => esc_html__( 'Icon Url', 'news-block' ),
        'section'  => 'top_header_section',		
        'type'     => 'url',
        'active_callback' => 'top_header_social_icons_option_callback'
    ));
}
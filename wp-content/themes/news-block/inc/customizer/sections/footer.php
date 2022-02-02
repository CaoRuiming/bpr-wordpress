<?php
/**
 * Footer settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_footer_section_register', 10 );
/**
 * Add settings for footer in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_footer_section_register( $wp_customize ) {
    /**
     * Footer Section
     * 
     * panel - news_block_theme_panel
     */

    $wp_customize->add_section( 'footer_section', array(
      'title' => esc_html__( 'Footer Section', 'news-block' ),
      'panel' => 'news_block_theme_panel',
      'priority'  => 100,
    ));

    /**
     * Footer Settings Heading
     * 
     */
    $wp_customize->add_setting( 'footer_settings', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'footer_settings', array(
            'label'	      => esc_html__( 'Footer Settings', 'news-block' ),
            'section'     => 'footer_section',
            'settings'    => 'footer_settings',
            'type'        => 'section-heading',
        ))
    );
    
    /**
     * Footer Tab settings
     * 
     */
    $wp_customize->add_setting( 'footer_settings_tab',
      array(
        'default'           => 'general',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Tab_Control(
			$wp_customize,
			'footer_settings_tab',
        array(
          'label'    => esc_html__( 'Filter footer settings', 'news-block' ),
          'section'  => 'footer_section',
          'choices'  => array(
              'general' => array(
                'label' => esc_html__( 'General', 'news-block' )
              )
            ),
        )
    ));

    /**
     * Footer General Settings Heading
     * 
     */
    $wp_customize->add_setting( 'footer_general_setting', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'footer_general_setting', array(
            'label'	      => esc_html__( 'Main Footer General Settings', 'news-block' ),
            'section'     => 'footer_section',
            'settings'    => 'footer_general_setting',
            'type'        => 'section-heading'
        ))
    );

    /**
     * Footer column settings
     * 
     */
    $wp_customize->add_setting( 'footer_widget_column',
      array(
        'default'           => 'column-two',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Image_Control(
        $wp_customize,
        'footer_widget_column',
        array(
          'label'    => esc_html__( 'Footer Layout', 'news-block' ),
          'section'  => 'footer_section',
          'choices'  => array(
              'column-two' => array(
                'label' => esc_html__( 'Column Two', 'news-block' ),
                'url'   => '%s/images/customizer/bz_footer_two.jpg'
              ),
              'column-one' => array(
                'label' => esc_html__( 'Column One', 'news-block' ),
                'url'   => '%s/images/customizer/bz_footer_one.jpg'
              )
          )
        )
      )
    );

    /**
     * Bottom Footer Settings Heading
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_settings', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'bottom_footer_settings', array(
            'label'	      => esc_html__( 'Bottom Footer Settings', 'news-block' ),
            'section'     => 'footer_section',
            'settings'    => 'bottom_footer_settings',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Bottom Footer Tab settings
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_settings_tab',
      array(
        'default'           => 'general',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );

    // Add the layout control.
    $wp_customize->add_control( new News_Block_WP_Radio_Tab_Control(
			$wp_customize,
			'bottom_footer_settings_tab',
        array(
          'label'    => esc_html__( 'Filter bottom footer settings', 'news-block' ),
          'section'  => 'footer_section',
          'choices'  => array(
            'general' => array(
              'label' => esc_html__( 'General', 'news-block' )
            ),
            'style' => array(
              'label' => esc_html__( 'Style', 'news-block' )
            )
          )
        )
    ));

    /**
     * Bottom Footer General Settings Heading
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_general_setting', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'bottom_footer_general_setting', array(
            'label'	      => esc_html__( 'General Settings', 'news-block' ),
            'section'     => 'footer_section',
            'settings'    => 'bottom_footer_general_setting',
            'type'        => 'section-heading',
            'active_callback' => 'bottom_footer_settings_tab_general_callback'
        ))
    );
    
    /**
     * Site Logo Option
     * 
     */
    $wp_customize->add_setting( 'footer_site_logo_option', array(
      'default'           => true,
      'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'footer_site_logo_option', array(
          'label'	      => esc_html__( 'Show/Hide footer site logo', 'news-block' ),
          'section'     => 'footer_section',
          'settings'    => 'footer_site_logo_option',
          'type'        => 'toggle',
          'active_callback' => 'bottom_footer_settings_tab_general_callback'
      ))
    );

    /**
     * Footer Site Logo
     * 
     */
    $wp_customize->add_setting( 'footer_logo_image', array(
      'sanitize_callback' => 'esc_url_raw'
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo_image',
          array(
              'label'      => __( 'Footer Logo Image', 'news-block' ),
              'description'=> __( 'Upload image suitable for footer logo area', 'news-block' ),
              'section'    => 'footer_section',
              'settings'   => 'footer_logo_image',
              'active_callback' => 'bottom_footer_settings_tab_general_callback'
          )
      )
    );

    /**
     * Footer Menu Option
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_menu_option', array(
      'default'           => true,
      'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'bottom_footer_menu_option', array(
          'label'	      => esc_html__( 'Show/Hide footer menu', 'news-block' ),
          'description' => esc_html__( 'Goto Appearance > Menus & assign non-empty menu to Bottom Footer in Menu Settings section', 'news-block' ),
          'section'     => 'footer_section',
          'settings'    => 'bottom_footer_menu_option',
          'type'        => 'toggle',
          'active_callback' => 'bottom_footer_settings_tab_general_callback'
      ))
    );
    
    /**
     * Bottom Footer Style Settings Heading
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_style_setting', array(
      'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'bottom_footer_style_setting', array(
          'label'	      => esc_html__( 'Style Settings', 'news-block' ),
          'section'     => 'footer_section',
          'settings'    => 'bottom_footer_style_setting',
          'type'        => 'section-heading',
          'active_callback' => 'bottom_footer_settings_tab_style_callback'
      ))
    );

    /**
     * Bottom Footer Bg Color
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_bg_color', array(
      'default' => '#f7f7f7',
      'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( 
      new WP_Customize_Color_Control( $wp_customize, 'bottom_footer_bg_color', array(
          'label'      => __( 'Backgroud Color', 'news-block' ),
          'section'    => 'footer_section',
          'settings'   => 'bottom_footer_bg_color',
          'active_callback' => 'bottom_footer_settings_tab_style_callback'
      ))
    );

    /**
     * Bottom Footer Text Color
     * 
     */
    $wp_customize->add_setting( 'bottom_footer_text_color', array(
      'default' => '#020202',
      'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( 
      new WP_Customize_Color_Control( $wp_customize, 'bottom_footer_text_color', array(
          'label'      => __( 'Text Color', 'news-block' ),
          'section'    => 'footer_section',
          'settings'   => 'bottom_footer_text_color',
          'active_callback' => 'bottom_footer_settings_tab_style_callback'
      ))
    );
}
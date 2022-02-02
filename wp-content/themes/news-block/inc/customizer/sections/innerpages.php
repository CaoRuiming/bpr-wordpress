<?php
/**
 * Inner Pages settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_innerpages_section_register', 10 );
/**
 * Add settings for innerpages in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_innerpages_section_register( $wp_customize ) {
    /**
     * Inner Pages Setting
     * 
     * panel - news_block_theme_panel
     */
    $wp_customize->add_section(
         new News_Block_WP_Customize_Section( $wp_customize, 'innerpages_section', array(
                'title' => esc_html__( 'InnerPages Setting', 'news-block' ),
                'panel' => 'news_block_theme_panel',
            )
        )
    );

    /**
     *  Archive Page Section
     * 
     */
    $wp_customize->add_section(
        new News_Block_WP_Customize_Section( $wp_customize, 'innerpages_archive_page_section', array(
               'title'      => esc_html__( 'Archive Page', 'news-block' ),
               'section'    => 'innerpages_section',
               'panel' => 'news_block_theme_panel',
           )
       )
    );
    
    /**
     * Archive general content settings
     * 
     */
    $wp_customize->add_setting( 'archive_general_content_setting_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'archive_general_content_setting_header', array(
            'label'       => esc_html__( 'General Content Settings', 'news-block' ),
            'section'     => 'innerpages_archive_page_section',
            'settings'    => 'archive_general_content_setting_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Archive post content type
     * 
     */
    $wp_customize->add_setting( 'archive_content_type', array(
        'default' => 'excerpt',
        'sanitize_callback' => 'news_block_sanitize_select_control'
    ));
      
    $wp_customize->add_control( 'archive_content_type', array(
        'type'      => 'select',
        'section'   => 'innerpages_archive_page_section',
        'label'     => __( 'Post Content to display', 'news-block' ),
        'choices'   => array(
            'excerpt' => esc_html__( 'Excerpt', 'news-block' ),
            'content' => esc_html__( 'Content', 'news-block' )
        ),
    ));
    
    /**
     * Archive Posted on Date Option
     * 
     */
    $wp_customize->add_setting( 'archive_post_date_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'archive_post_date_option', array(
            'label'	      => esc_html__( 'Show/Hide post date', 'news-block' ),
            'section'     => 'innerpages_archive_page_section',
            'settings'    => 'archive_post_date_option',
            'type'        => 'toggle'
        ))
    );

    /**
     * Archive Author Option
     * 
     */
    $wp_customize->add_setting( 'archive_post_author_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'archive_post_author_option', array(
            'label'	      => esc_html__( 'Show/Hide post author', 'news-block' ),
            'section'     => 'innerpages_archive_page_section',
            'settings'    => 'archive_post_author_option',
            'type'        => 'toggle'
        ))
    );

    /**
     * Archive Category Option
     * 
     */
    $wp_customize->add_setting( 'archive_post_categories_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'archive_post_categories_option', array(
            'label'	      => esc_html__( 'Show/Hide post categories', 'news-block' ),
            'section'     => 'innerpages_archive_page_section',
            'settings'    => 'archive_post_categories_option',
            'type'        => 'toggle'
        ))
    );
    
    /**
     * Archive Tag Option
     * 
     */
    $wp_customize->add_setting( 'archive_post_tags_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'archive_post_tags_option', array(
            'label'	      => esc_html__( 'Show/Hide post tags', 'news-block' ),
            'section'     => 'innerpages_archive_page_section',
            'settings'    => 'archive_post_tags_option',
            'type'        => 'toggle'
        ))
    );

    /**
     * Archive Read more Option
     * 
     */
    $wp_customize->add_setting( 'archive_read_more_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'archive_read_more_option', array(
            'label'	      => esc_html__( 'Show/Hide read more', 'news-block' ),
            'section'     => 'innerpages_archive_page_section',
            'settings'    => 'archive_read_more_option',
            'type'        => 'toggle'
        ))
    );
    /*-------------------------------------------------------------------------------------------------------------------------------------------*/

    /**
     *  Single Page Section
     * 
     */
    $wp_customize->add_section(
        new News_Block_WP_Customize_Section( $wp_customize, 'innerpages_single_page_section', array(
               'title'      => esc_html__( 'Single Page', 'news-block' ),
               'section'    => 'innerpages_section',
               'panel' => 'news_block_theme_panel',
           )
       )
    );

    /**
     * Single general content settings
     * 
     */
    $wp_customize->add_setting( 'single_general_content_setting_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'single_general_content_setting_header', array(
            'label'       => esc_html__( 'General Content Settings', 'news-block' ),
            'section'     => 'innerpages_single_page_section',
            'settings'    => 'single_general_content_setting_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Single Posted on Date Option
     * 
     */
    $wp_customize->add_setting( 'single_post_date_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'single_post_date_option', array(
            'label'	      => esc_html__( 'Show/Hide post date', 'news-block' ),
            'section'     => 'innerpages_single_page_section',
            'settings'    => 'single_post_date_option',
            'type'        => 'toggle'
        ))
    );

    /**
     * Single Author Option
     * 
     */
    $wp_customize->add_setting( 'single_post_author_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'single_post_author_option', array(
            'label'	      => esc_html__( 'Show/Hide post author', 'news-block' ),
            'section'     => 'innerpages_single_page_section',
            'settings'    => 'single_post_author_option',
            'type'        => 'toggle'
        ))
    );

    /**
     * Single Category Option
     * 
     */
    $wp_customize->add_setting( 'single_post_categories_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'single_post_categories_option', array(
            'label'	      => esc_html__( 'Show/Hide post categories', 'news-block' ),
            'section'     => 'innerpages_single_page_section',
            'settings'    => 'single_post_categories_option',
            'type'        => 'toggle'
        ))
    );
    
    /**
     * Single Tag Option
     * 
     */
    $wp_customize->add_setting( 'single_post_tags_option', array(
        'default'         => true,
        'sanitize_callback' => 'news_block_sanitize_toggle_control',
    ));
  
    $wp_customize->add_control( 
        new News_Block_WP_Toggle_Control( $wp_customize, 'single_post_tags_option', array(
            'label'	      => esc_html__( 'Show/Hide post tags', 'news-block' ),
            'section'     => 'innerpages_single_page_section',
            'settings'    => 'single_post_tags_option',
            'type'        => 'toggle'
        ))
    );
    /*-------------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     *  Search Page Section
     * 
     */
    $wp_customize->add_section(
        new News_Block_WP_Customize_Section( $wp_customize, 'innerpages_search_page_section', array(
               'title' => esc_html__( 'Search Page', 'news-block' ),
               'section'    => 'innerpages_section',
               'panel' => 'news_block_theme_panel',
           )
       )
    );

    /**
     * Search Page on search keyword found Heading
     * 
     */
    $wp_customize->add_setting( 'search_on_found_setting_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'search_on_found_setting_header', array(
          'label'       => esc_html__( 'On Search results found', 'news-block' ),
          'section'     => 'innerpages_search_page_section',
          'settings'    => 'search_on_found_setting_header',
          'type'        => 'section-heading',
      ))
    );

    /**
     * Search Page Title Setting
     * 
     */
    $wp_customize->add_setting( 'search_page_title', array(
        'default'        => esc_html__( 'Search Results for:', 'news-block' ),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'search_page_title', array(
        'label'    => esc_html__( 'Search Title', 'news-block' ),
        'section'  => 'innerpages_search_page_section',		
        'type'     => 'text'
    ));
    /*-------------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     *  404  Error Page Section
     * 
     */
    $wp_customize->add_section(
        new News_Block_WP_Customize_Section( $wp_customize, 'innerpages_error_page_section', array(
               'title'      => esc_html__( '404 Page', 'news-block' ),
               'section'    => 'innerpages_section',
               'panel'      => 'news_block_theme_panel'
           )
       )
    );

    /**
     * Error Page Image
     * 
     */
    $wp_customize->add_setting( 'error_page_image', array(
        'sanitize_callback' => 'esc_url_raw'
    ));
  
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'error_page_image',
        array(
            'label'      => __( '404 Error Page Image', 'news-block' ),
            'description'=> __( 'Upload image that shows you are on 404 error page', 'news-block' ),
            'section'    => 'innerpages_error_page_section',
            'settings'   => 'error_page_image'
        )
    ));    
}
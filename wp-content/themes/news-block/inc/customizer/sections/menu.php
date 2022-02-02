<?php
/**
 * Menu settings
 * 
 * @package News Block
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_customize_menu_section_register', 10 );
/**
 * Add settings for Menu in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_customize_menu_section_register( $wp_customize ) {
    /**
     * Menu Section
     * 
     * panel - news_block_theme_panel
     */
    $wp_customize->add_section( 'menu_section', array(
      'title' 		=> esc_html__( 'Menu Section', 'news-block' ),
      'panel' 		=> 'news_block_theme_panel',
      'priority' 	=> 6,
    ));

	/**
     * Primary Menu Heading
     * 
     */
    $wp_customize->add_setting( 'menu_hover_style_header', array(
        'sanitize_callback' => 'sanitize_text_field'
      ));

    $wp_customize->add_control( 
        new News_Block_WP_Section_Heading_Control( $wp_customize, 'menu_hover_style_header', array(
            'label'       => esc_html__( 'Primary Menu Hover', 'news-block' ),
            'section'     => 'menu_section',
            'settings'    => 'menu_hover_style_header',
            'type'        => 'section-heading',
        ))
    );

    /**
     * Primary Menu  Hover Settings
     * 
     */
	$wp_customize->add_setting( 'menu_hover_style', array(
		'default' => 'menu_hover_1',
		'sanitize_callback' => 'news_block_sanitize_menuhover',
	) );  
	$wp_customize->add_control( 
		'menu_hover_style', array(
			'type' 		=> 'radio',
			'section' 	=> 'menu_section',
			'choices' 	=> array(	
					'menu_hover_1' => __( 'Menu Hover Effect 1', 'news-block' ),
					'menu_hover_none' => __( 'Menu Hover Effect none', 'news-block' )
			)
		)
	);
}
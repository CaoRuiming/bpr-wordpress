<?php
/**
 * Footer settings
 * 
 * @since 1.0.0
 */

add_action( 'customize_register', 'news_block_upsell_section_register', 10 );
/**
 * Add settings for upsell links
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_block_upsell_section_register( $wp_customize ) {
	require get_template_directory() . '/inc/admin/customizer-upsell/upsell-section/upsell-button.php';
    require get_template_directory() . '/inc/admin/customizer-upsell/upsell-section/upsell-control.php';
    $wp_customize->register_section_type( 'News_Block_Upsell_Button' );
    $wp_customize->register_section_type( 'News_Block_Upsell_Control' );

    /**
     * Add Upsell Button
     * 
     */
    $wp_customize->add_section(
		new News_Block_Upsell_Button( $wp_customize, 
            'upsell_button', [
                'button_text'   => esc_html__( 'Upgrade To Pro', 'news-block' ),
                'button_url'    => esc_url( '//blazethemes.com/theme/news-block-pro/' ),
                'priority'      => 1
            ]
        )
	);

    /**
     * Add premium features listing section
     * 
     */
	$wp_customize->add_section( 'upgrade_section', array(
        'title' => esc_html__( 'Premium Features', 'news-block' ),
        'priority'  => 1,
    ));

    /**
     * List out "features" settings
     * 
     */
    $wp_customize->add_setting( 'upgrade_settings',
		array(
            'sanitize_callback' => 'wp_kses_post',
      )
	);

    $wp_customize->add_control( 
        new News_Block_Upsell_Control( $wp_customize, 'upgrade_settings', array(
            'section'     => 'upgrade_section',
            'description'   => esc_html__( "Upgrade To Pro", "news-block" ),
            'type'		  => 'news-block-upsell',
            'features' 	  => array(
                esc_html__( 'Unlock more advanced features', 'news-block' ),
                esc_html__( 'Easy One Demo Install', 'news-block' ),
                esc_html__( 'Numerous Color Options', 'news-block' ),
                esc_html__( 'Unlimited Social Icons', 'news-block' ),
                esc_html__( 'In-built post views count filter', 'news-block' ),
                esc_html__( 'Customize hyperlinks target', 'news-block' ),
                esc_html__( 'Show/hide post elements ( For each blocks )', 'news-block' ),
                esc_html__( 'Customize content length', 'news-block' ),
                esc_html__( 'Customize category/tags count', 'news-block' ),
                sprintf( '%1$1s & %2$1s', esc_html__( 'Gutenberg Blocks', 'news-block' ), esc_html__( 'Elementor Widgets', 'news-block' ) ),
                esc_html__( 'Multiple Header Layouts ( 2 )', 'news-block' ),
                esc_html__( 'Menu Colors', 'news-block' ),
                esc_html__( 'Menu Hover Colors', 'news-block' ),
                esc_html__( 'Menu Hover Effects', 'news-block' ),
                esc_html__( 'Image Hover Effects', 'news-block' ),
                esc_html__( 'Fallback Image', 'news-block' ),
                esc_html__( 'AJAX pagination and load more ( load posts without page reload )', 'news-block' ),
                esc_html__( 'Breadcrumbs more settings', 'news-block' ),
                esc_html__( 'Meta prefix text changable', 'news-block' ),
                esc_html__( 'More ( post/archive/page/blog/home ) layouts ', 'news-block' ),
                esc_html__( 'More ( post/archive/page/blog/home ) sidebar layouts', 'news-block' ),
                esc_html__( 'Footer four column', 'news-block' ),
                esc_html__( 'Style Settings ( colors, fonts, variants )', 'news-block' ),
                esc_html__( 'Typography Settings ( font size, colors, font family, variants )', 'news-block' ),
                esc_html__( '600+ google fonts', 'news-block' ),
                sprintf( '%1$1s & %2$1s', esc_html__( 'Pagination in Blocks', 'news-block' ), esc_html__( 'Widgets', 'news-block' ) ),
                esc_html__( 'Optimized for Speed', 'news-block' ),
                esc_html__( 'Fully Multilingual and Translation ready', 'news-block' ),
                esc_html__( 'Unlimited Support', 'news-block' ),
                sprintf( '& %1$1s', esc_html__( 'many more ....', 'news-block' ) )
            ),
        ))
    );

    /**
     * Add Upsell Button
     * 
     */
    $wp_customize->add_section(
        new News_Block_Upsell_Button( $wp_customize, 
            'demo_import_button', array(
                'button_text'   => esc_html__( 'Go to Import', 'news-block' ),
                'button_url'    => esc_url( admin_url('themes.php?page=news-block-info.php') ),
                'title'         => esc_html__('Import Demo Data', 'news-block'),
                'priority'  => 1000,
            )
        )
    );
}

/**
 * Enqueue theme upsell controls scripts
 * 
 */
function news_block_upsell_scripts() {
    wp_enqueue_style( 'news-block-upsell', get_template_directory_uri() . '/inc/admin/customizer-upsell/upsell-section/upsell.css', array(), '1.0.0', 'all' );
    wp_enqueue_script( 'news-block-upsell', get_template_directory_uri() . '/inc/admin/customizer-upsell/upsell-section/upsell.js', array(), '1.0.0', 'all' );
}
add_action( 'customize_controls_enqueue_scripts', 'news_block_upsell_scripts' );
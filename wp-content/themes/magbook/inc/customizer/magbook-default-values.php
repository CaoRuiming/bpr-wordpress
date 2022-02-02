<?php
if(!function_exists('magbook_get_option_defaults_values')):
	/******************** MAGBOOK DEFAULT OPTION VALUES ******************************************/
	function magbook_get_option_defaults_values() {
		global $magbook_default_values;
		$magbook_default_values = array(
			'magbook_responsive'	=> 'on',
			'magbook_logo_sitetitle_display' => 'above_menubar',
			'magbook_design_layout' => 'boxed-layout',
			'magbook_sidebar_layout_options' => 'right',
			'magbook_blog_layout' => 'two_column_image_display',
			'magbook_search_custom_header' => 0,
			'magbook_side_menu'	=> 0,
			'magbook_img-upload-footer-image' => '',
			'magbook_header_display'=> 'header_text',
			'magbook_scroll'	=> 0,
			'magbook_tag_text' => esc_html__('View More','magbook'),
			'magbook_excerpt_length'	=> '25',
			'magbook_reset_all' => 0,
			'magbook_stick_menu'	=>0,
			'magbook_logo_high_resolution'	=> 0,
			'magbook_blog_post_image' => 'on',
			'magbook_search_text' => esc_html__('Search &hellip;','magbook'),
			'magbook_blog_content_layout'	=> 'excerptblog_display',
			'magbook_header_design_layout'	=> '',
			'magbook_entry_meta_single' => 'show',
			'magbook_entry_meta_blog' => 'show-meta',
			'magbook_post_category' => 0,
			'magbook_post_author' => 1,
			'magbook_post_date' => 0,
			'magbook_post_comments' => 0,
			'magbook_footer_column_section'	=>'4',
			'magbook_disable_main_menu' => 0,
			'magbook_current_date'=>0,
			'magbook_disable_cat_color_menu'=>0,

			/* Slider Settings */
			'magbook_slider_button' => 0,
			'magbook_slider_content_bg_color' => 'off',
			'magbook_slider_type'	=> 'default_slider',
			'magbook_slider_design_layout'	=> 'no-slider',
			'magbook_slider_link' =>0,
			'magbook_enable_slider' => 'frontpage',
			'magbook_default_category_slider' => '',
			'magbook_small_slider_post_category' => '',
			'magbook_slider_number'	=> '5',
			/* Layer Slider */
			'magbook_animation_effect' => 'fade',
			'magbook_slideshowSpeed' => '5',
			'magbook_animationSpeed' => '7',
			'magbook_display_page_single_featured_image'=>0,
			/* Front page feature */
			/* Frontpage Feature News */
			'magbook_disable_feature_news'	=> 1,
			'magbook_total_feature_news'	=> '6',
			'magbook_feature_news_title'	=> '',
			'magbook_featured_news_category' => '',
			/* Frontpage Breaking News */
			'magbook_disable_breaking_news'	=> 1,
			'magbook_total_breaking_news'	=> '7',
			'magbook_breaking_news_title'	=> esc_html__('Breaking News','magbook'),
			'magbook_breaking_news_category' => '',
			/*Social Icons */
			'magbook_top_social_icons' =>0,
			'magbook_side_menu_social_icons' =>0,
			'magbook_buttom_social_icons'	=>0,
			);
		return apply_filters( 'magbook_get_option_defaults_values', $magbook_default_values );
	}
endif;
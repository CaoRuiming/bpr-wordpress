<?php
/**
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
/**************** MAGBOOK REGISTER WIDGETS ***************************************/
add_action('widgets_init', 'magbook_widgets_init');
function magbook_widgets_init() {

	register_sidebar(array(
			'name' => __('Main Sidebar', 'magbook'),
			'id' => 'magbook_main_sidebar',
			'description' => __('Shows widgets at Main Sidebar.', 'magbook'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('Top Header Info', 'magbook'),
			'id' => 'magbook_header_info',
			'description' => __('Shows widgets on all page.', 'magbook'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Header Banner', 'magbook'),
			'id' => 'magbook_header_banner',
			'description' => __('Shows widgets on header.', 'magbook'),
			'before_widget' => '<div class="advertisement-wrap" id="%1$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Side Menu', 'magbook'),
			'id' => 'magbook_side_menu',
			'description' => __('Shows widgets on all page.', 'magbook'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Slider Section', 'magbook'),
			'id' => 'slider_section',
			'description' => __('Use any Slider Plugins and drag that slider widgets to this Slider Section.', 'magbook'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Magbook Template Section', 'magbook'),
			'id' => 'magbook_template_section',
			'description' => __('Shows widgets only on Magbook Template.', 'magbook'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Magbook Template Sidebar Section', 'magbook'),
			'id' => 'magbook_template_sidebar_section',
			'description' => __('Shows widgets only on Magbook Template Sidebar.', 'magbook'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Contact Page Sidebar', 'magbook'),
			'id' => 'magbook_contact_page_sidebar',
			'description' => __('Shows widgets on Contact Page Template.', 'magbook'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Iframe Code For Google Maps', 'magbook'),
			'id' => 'magbook_form_for_contact_page',
			'description' => __('Add Iframe Code using text widgets', 'magbook'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('WooCommerce Sidebar', 'magbook'),
			'id' => 'magbook_woocommerce_sidebar',
			'description' => __('Add WooCommerce Widgets Only', 'magbook'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	$magbook_settings = magbook_get_theme_options();
	for($i =1; $i<= $magbook_settings['magbook_footer_column_section']; $i++){
	register_sidebar(array(
			'name' => __('Footer Column ', 'magbook') . $i,
			'id' => 'magbook_footer_'.$i,
			'description' => __('Shows widgets at Footer Column ', 'magbook').$i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	}
	//Register Widget.
	register_widget( 'Magbook_tab_Widgets' );
	register_widget( 'Magbook_category_box_Widgets' );
	register_widget( 'Magbook_category_box_two_column_Widgets' );
}
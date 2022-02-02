<?php /**
 * Register color schemes for Magbook.
 *
 * Can be filtered with {@see 'magbook_color_schemes'}.
 *
 * The order of colors in a colors array:
 * @since Magbook 1.1
 *
 * @return array An associative array of color scheme options.
 */
function magbook_get_color_schemes() {
	return apply_filters( 'magbook_color_schemes', array(
		'default_color' => array(
			'label'  => __( '--Default--', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#0c4cba',
				'#0c4cba',
				'#0c4cba',
			),
		),
		'dark'    => array(
			'label'  => __( 'Dark', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#111111',
				'#111111',
				'#111111',
			),
		),
		'yellow'  => array(
			'label'  => __( 'Yellow', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#ffae00',
				'#ffae00',
				'#ffae00',
			),
		),
		'pink'    => array(
			'label'  => __( 'Orange', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#ff8c00',
				'#ff8c00',
				'#ff8c00',
			),
		),
		'red'   => array(
			'label'  => __( 'Red', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#d4000e',
				'#d4000e',
				'#d4000e',
			),
		),
		'purple'   => array(
			'label'  => __( 'Purple', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#9651cc',
				'#9651cc',
				'#9651cc',
			),
		),
		'vanburenborwn'    => array(
			'label'  => __( 'Van Buren Brown', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#a57a6b',
				'#a57a6b',
				'#a57a6b',
			),
		),
		'green'    => array(
			'label'  => __( 'Green', 'magbook' ),
			'colors' => array(
				'#0c4cba',
				'#2dcc70',
				'#2dcc70',
				'#2dcc70',
			),
		),
	) );
}

if ( ! function_exists( 'magbook_get_color_scheme' ) ) :
/**
 * Get the current Magbook color scheme.
 *
 * @since Magbook 1.0
 *
 * @return array An associative array of either the current or default color scheme hex values.
 */
function magbook_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default_color' );
	$color_schemes       = magbook_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default_color']['colors'];
}
endif;

if ( ! function_exists( 'magbook_get_color_scheme_choices' ) ) :
/**
 * Returns an array of color scheme choices registered for Magbook.
 *
 * @since Magbook 1.0
 *
 * @return array Array of color schemes.
 */
function magbook_get_color_scheme_choices() {
	$color_schemes                = magbook_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif; // magbook_get_color_scheme_choices

if ( ! function_exists( 'magbook_sanitize_color_scheme' ) ) :
/**
 * Sanitization callback for color schemes.
 *
 * @since Magbook 1.0
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function magbook_sanitize_color_scheme( $value ) {
	$color_schemes = magbook_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default_color';
	}

	return $value;
}
endif; // magbook_sanitize_color_scheme

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Magbook 1.0
 *
 * @see wp_add_inline_style()
 */
function magbook_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default_color' );

	// Don't do anything if the default_color color scheme is selected.
	if ( 'default_color' === $color_scheme_option ) {
		return;
	}

	$color_scheme = magbook_get_color_scheme();

	$colors = array(
		'magbook_site_page_nav_link_title_color'        => get_theme_mod('magbook_site_page_nav_link_title_color',$color_scheme[3]),
		'magbook_button_color'    => get_theme_mod('magbook_button_color',$color_scheme[3]),
		'magbook_top_bar_bg_color'    => get_theme_mod('magbook_top_bar_bg_color',$color_scheme[3]),
		'magbook_breaking_news_color'    => get_theme_mod('magbook_breaking_news_color',$color_scheme[3]),
		'magbook_feature_news_color'    => get_theme_mod('magbook_feature_news_color',$color_scheme[3]),
		'magbook_tag_widget_color'    => get_theme_mod('magbook_tag_widget_color',$color_scheme[3]),
		'magbook_category_box_widget_color'    => get_theme_mod('magbook_category_box_widget_color',$color_scheme[3]),
		'magbook_category_box_widget_2_color'    => get_theme_mod('magbook_category_box_widget_2_color',$color_scheme[3]),
		'magbook_bbpress_woocommerce_color'        => get_theme_mod('magbook_bbpress_woocommerce_color',$color_scheme[3]),
		'magbook_category_slider_widget_color'        => get_theme_mod('magbook_category_slider_widget_color',$color_scheme[3]),
		'magbook_category_grid_widget_color'        => get_theme_mod('magbook_category_grid_widget_color',$color_scheme[3]),
	);

	$color_scheme_css = magbook_get_color_scheme_css( $colors );

	wp_add_inline_style( 'magbook-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'magbook_color_scheme_css' );

/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since Magbook 1.0
 */
function magbook_customize_control_js() {
	wp_enqueue_script( 'magbook-color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls' ), '20180501', true );
	wp_localize_script( 'magbook-color-scheme-control', 'colorScheme', magbook_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'magbook_customize_control_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Magbook 1.0
 */
function magbook_customize_preview_js() {
	wp_enqueue_script( 'magbook-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20160824', true );
}

add_action( 'customize_preview_init', 'magbook_customize_preview_js' );

/**
 * Returns CSS for the color schemes.
 *
 * @since Magbook 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function magbook_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'magbook_site_page_nav_link_title_color'        => '#0c4cba',
		'magbook_button_color'    => '#0c4cba',
		'magbook_top_bar_bg_color'    => '#0c4cba',
		'magbook_breaking_news_color'    => '#0c4cba',
		'magbook_feature_news_color'    => '#0c4cba',
		'magbook_tag_widget_color'    => '#0c4cba',
		'magbook_category_box_widget_color'    => '#0c4cba',
		'magbook_category_box_widget_2_color'    => '#0c4cba',
		'magbook_bbpress_woocommerce_color'        => '#0c4cba',
		'magbook_category_slider_widget_color'        => '#0c4cba',
		'magbook_category_grid_widget_color'        => '#0c4cba',
		
	) );
	$css = <<<CSS
	/****************************************************************/
						/*.... Color Style ....*/
	/****************************************************************/
	/* Nav, links and hover */

a,
ul li a:hover,
ol li a:hover,
.top-bar .top-bar-menu a:hover,
.top-bar .top-bar-menu a:focus,
.main-navigation a:hover, /* Navigation */
.main-navigation a:focus,
.main-navigation ul li.current-menu-item a,
.main-navigation ul li.current_page_ancestor a,
.main-navigation ul li.current-menu-ancestor a,
.main-navigation ul li.current_page_item a,
.main-navigation ul li:hover > a,
.main-navigation li.current-menu-ancestor.menu-item-has-children > a:after,
.main-navigation li.current-menu-item.menu-item-has-children > a:after,
.main-navigation ul li:hover > a:after,
.main-navigation li.menu-item-has-children > a:hover:after,
.main-navigation li.page_item_has_children > a:hover:after,
.main-navigation ul li ul li a:hover,
.main-navigation ul li ul li a:focus,
.main-navigation ul li ul li:hover > a,
.main-navigation ul li.current-menu-item ul li a:hover,
.side-menu-wrap .side-nav-wrap a:hover, /* Side Menu */
.side-menu-wrap .side-nav-wrap a:focus,
.entry-title a:hover, /* Post */
.entry-title a:focus,
.entry-title a:active,
.entry-meta a:hover,
.image-navigation .nav-links a,
a.more-link,
.widget ul li a:hover, /* Widgets */
.widget ul li a:focus,
.widget-title a:hover,
.widget_contact ul li a:hover,
.widget_contact ul li a:focus,
.site-info .copyright a:hover, /* Footer */
.site-info .copyright a:focus,
#secondary .widget-title,
#colophon .widget ul li a:hover,
#colophon .widget ul li a:focus,
#footer-navigation a:hover,
#footer-navigation a:focus {
	color: {$colors['magbook_site_page_nav_link_title_color']};
}


.cat-tab-menu li:hover,
.cat-tab-menu li.active {
	color: {$colors['magbook_site_page_nav_link_title_color']} !important;
}

#sticky-header,
#secondary .widget-title,
.side-menu {
	border-top-color: {$colors['magbook_site_page_nav_link_title_color']};
}

/* Webkit */
::selection {
	background: {$colors['magbook_site_page_nav_link_title_color']};
	color: #fff;
}

/* Gecko/Mozilla */
::-moz-selection {
	background: {$colors['magbook_site_page_nav_link_title_color']};
	color: #fff;
}

/* Accessibility
================================================== */
.screen-reader-text:hover,
.screen-reader-text:active,
.screen-reader-text:focus {
	background-color: #f1f1f1;
	color: {$colors['magbook_site_page_nav_link_title_color']};
}

/* Default Buttons
================================================== */
input[type="reset"],/* Forms  */
input[type="button"],
input[type="submit"],
.main-slider .flex-control-nav a.flex-active,
.main-slider .flex-control-nav a:hover,
.go-to-top .icon-bg,
.search-submit,
.btn-default,
.widget_tag_cloud a {
	background-color: {$colors['magbook_button_color']};
}

/* Top Bar Background
================================================== */
.top-bar {
	background-color: {$colors['magbook_top_bar_bg_color']};
}

/* Breaking News
================================================== */
.breaking-news-header,
.news-header-title:after {
	background-color: {$colors['magbook_breaking_news_color']};
}

.breaking-news-slider .flex-direction-nav li a:hover,
.breaking-news-slider .flex-pauseplay a:hover {
	background-color: {$colors['magbook_breaking_news_color']};
	border-color: {$colors['magbook_breaking_news_color']};
}

/* Feature News
================================================== */
.feature-news-title {
	border-color: {$colors['magbook_feature_news_color']};
}

.feature-news-slider .flex-direction-nav li a:hover {
	background-color: {$colors['magbook_feature_news_color']};
	border-color: {$colors['magbook_feature_news_color']};
}

/* Tab Widget
================================================== */
.tab-menu,
.mb-tag-cloud .mb-tags a {
	background-color: {$colors['magbook_tag_widget_color']};
}

/* Category Box Widgets
================================================== */
.widget-cat-box .widget-title {
	color: {$colors['magbook_category_box_widget_color']};
}

.widget-cat-box .widget-title span {
	border-bottom: 1px solid {$colors['magbook_category_box_widget_color']};
}

/* Category Box two Widgets
================================================== */
.widget-cat-box-2 .widget-title {
	color: {$colors['magbook_category_box_widget_2_color']};
}

.widget-cat-box-2 .widget-title span {
	border-bottom: 1px solid {$colors['magbook_category_box_widget_2_color']};
}

/* #bbpress
================================================== */
#bbpress-forums .bbp-topics a:hover {
	color: {$colors['magbook_bbpress_woocommerce_color']};
}

.bbp-submit-wrapper button.submit {
	background-color: {$colors['magbook_bbpress_woocommerce_color']};
	border: 1px solid {$colors['magbook_bbpress_woocommerce_color']};
}

/* Woocommerce
================================================== */
.woocommerce #respond input#submit,
.woocommerce a.button, 
.woocommerce button.button, 
.woocommerce input.button,
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt,
.woocommerce-demo-store p.demo_store,
.top-bar .cart-value {
	background-color: {$colors['magbook_bbpress_woocommerce_color']};
}

.woocommerce .woocommerce-message:before {
	color: {$colors['magbook_bbpress_woocommerce_color']};
}

/* Category Slider widget */
.widget-cat-slider .widget-title {
	color: {$colors['magbook_category_slider_widget_color']};
}

.widget-cat-slider .widget-title span {
	border-bottom: 1px solid {$colors['magbook_category_slider_widget_color']};
}

/* Category Grid widget */
.widget-cat-grid .widget-title {
	color: {$colors['magbook_category_grid_widget_color']};
}

.widget-cat-grid .widget-title span {
	border-bottom: 1px solid {$colors['magbook_category_grid_widget_color']};
}

CSS;

	return $css;
}
function magbook_color_scheme_css_template() {
	$colors = array(

		// Color Styles
		'magbook_site_page_nav_link_title_color'        => '{{ data.magbook_site_page_nav_link_title_color }}',
		'magbook_button_color'    => '{{ data.magbook_button_color }}',
		'magbook_top_bar_bg_color'    => '{{ data.magbook_top_bar_bg_color }}',
		'magbook_breaking_news_color'    => '{{ data.magbook_breaking_news_color }}',
		'magbook_feature_news_color'    => '{{ data.magbook_feature_news_color }}',
		'magbook_tag_widget_color'    => '{{ data.magbook_tag_widget_color }}',
		'magbook_category_box_widget_color'    => '{{ data.magbook_category_box_widget_color }}',
		'magbook_category_box_widget_2_color'    => '{{ data.magbook_category_box_widget_2_color }}',
		'magbook_bbpress_woocommerce_color'        => '{{ data.magbook_bbpress_woocommerce_color }}',
		'magbook_category_slider_widget_color'        => '{{ data.magbook_category_slider_widget_color }}',
		'magbook_category_grid_widget_color'        => '{{ data.magbook_category_grid_widget_color }}',
	);
	?>
	<script type="text/html" id="tmpl-magbook-color-scheme">
		<?php echo magbook_get_color_scheme_css( $colors ); ?>
	</script>
<?php
}
add_action( 'customize_controls_print_footer_scripts', 'magbook_color_scheme_css_template' );

/************** Category Color **************************************/
function magbook_category_colors( $magbook_category_id){
	$magbook_settings = magbook_get_theme_options();
	$magbook_categories = get_terms( 'category' );
	$magbook_category_list = array();
	$output_css='';
	foreach ( $magbook_categories as $category_list) {
		 $magbook_category_list = get_theme_mod('magbook_category_color_'.esc_html( strtolower( $category_list->name ) ) );
		 $magbook_cat_id = esc_attr( $category_list->term_id );
		 ?>
		 <?php if( $magbook_category_list != '' && $magbook_category_list != '#ffffff'){

			 	$output_css .= '.cats-links .cl-'.$magbook_cat_id.'{

					border-color:'.esc_attr($magbook_category_list).';'.'
					color:'.esc_attr($magbook_category_list).';'.'

				}
				.menu-item-object-category.cl-'.$magbook_cat_id. ' a, .widget-cat-tab-box .cat-tab-menu .cl-'.$magbook_cat_id. '{
					color:'.esc_attr($magbook_category_list).';'.'

				}';
			}
			if($magbook_settings['magbook_disable_cat_color_menu'] ==1){
				$output_css .= 'li.menu-item-object-category[class*="cl-"] a {
					color: #222;
				}';
			}
	}
wp_add_inline_style( 'magbook-style', $output_css );
}
add_action( 'wp_enqueue_scripts', 'magbook_category_colors', 100 );


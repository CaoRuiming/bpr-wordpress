<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */
/**
 * Set up the WordPress core custom header feature.
 *
 * @uses magpaper_header_style()
 */
function magpaper_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'magpaper_custom_header_args', array(
		'default-image'          => '%s/assets/uploads/header-image.jpg',
		'default-text-color'     => 'fff',
		'width'                  => 1200,
		'height'                 => 528,
		'flex-height'            => true,
		'wp-head-callback'       => 'magpaper_header_style',
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/uploads/header-image.jpg',
			'thumbnail_url' => '%s/assets/uploads/header-image.jpg',
			'description'   => esc_html__( 'Default Header Image', 'magpaper' ),
		),
	) );
}
add_action( 'after_setup_theme', 'magpaper_custom_header_setup' );

if ( ! function_exists( 'magpaper_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see magpaper_custom_header_setup().
	 */
	function magpaper_header_style() {
		$options = magpaper_get_theme_options();
		$css = '';

		$header_title_color = $options['header_title_color'];
		$header_tagline_color = $options['header_tagline_color'];

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
		 */
		if ( $header_title_color && $header_tagline_color ) {

			$css .='
			.site-title a {
				color: '.esc_attr( $header_title_color ).';
			}
			#site-identity p.site-description {
				color: '.esc_attr( $header_tagline_color ).';
			}';
		}

		$css .= '.trail-items li:not(:last-child):after {
			    content: "' . html_entity_decode( esc_attr( $options['breadcrumb_separator'] ) ) . '";
		        color: #fff;
				padding: 0 5px;
			}';
		
		wp_add_inline_style( 'magpaper-style', $css );
	}
endif;
add_action( 'wp_enqueue_scripts', 'magpaper_header_style', 10 );
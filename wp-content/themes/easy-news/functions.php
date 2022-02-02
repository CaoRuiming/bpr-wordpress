<?php

if ( ! function_exists( 'easy_news_enqueue_styles' ) ) :

	function easy_news_enqueue_styles() {
		wp_enqueue_style( 'easy-news-style-parent', get_template_directory_uri() . '/style.css' );

		wp_enqueue_style( 'easy-news-style', get_stylesheet_directory_uri() . '/style.css', array( 'easy-news-style-parent' ), '1.0' );

		wp_enqueue_style( 'easy-news-fonts', easy_news_fonts_url(), array(), null );
	}
endif;
add_action( 'wp_enqueue_scripts', 'easy_news_enqueue_styles', 99 );


if ( ! function_exists( 'easy_news_fonts_url' ) ) :

	function easy_news_fonts_url() {
		
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';


		if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'easy-news' ) ) {
			$fonts[] = 'Raleway:400,500,600,700';
		}

		if ( 'off' !== _x( 'on', 'Lato font: on or off', 'easy-news' ) ) {
			$fonts[] = 'Lato:400';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		);

		if ( $fonts ) {
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;
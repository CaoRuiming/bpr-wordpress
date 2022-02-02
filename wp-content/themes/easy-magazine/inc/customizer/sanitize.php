<?php
/**
 * Sanitization functions.
 *
 * @package Easy Magazine
 */

if ( ! function_exists( 'easy_magazine_sanitize_select' ) ) :

	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *	
	 */
	function easy_magazine_sanitize_select( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

	}

endif;

if ( ! function_exists( 'easy_magazine_dropdown_pages' ) ) :
	function easy_magazine_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );
	  
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}
endif;

if ( ! function_exists( 'easy_magazine_dropdown_posts' ) ) :

	/**
	 * Post Dropdown.
	 *
	 * @since 1.0.0	 *
	 */
	function easy_magazine_dropdown_posts() {

		$posts = get_posts( array( 'numberposts' => -1 ) );
		$choices = array();
		$choices[0] = esc_html__( '--Select--', 'easy-magazine' );
		foreach ( $posts as $post ) {
			$choices[$post->ID] = $post->post_title;
		}
		return $choices;
	}

endif;

if ( ! function_exists( 'easy_magazine_sanitize_checkbox' ) ) :

	/**
	 * Sanitize checkbox.
	 *
	 * @since 1.0.0
	 *	
	 */
	function easy_magazine_sanitize_checkbox( $checked ) {

		return ( ( isset( $checked ) && true === $checked ) ? true : false );

	}

endif;


if ( ! function_exists( 'easy_magazine_sanitize_number_range' ) ) :

	/**
	 * Sanitize number range.
	 *	
	 */
	function easy_magazine_sanitize_number_range( $input, $setting ) {

		// Ensure input is an absolute integer.
		$input = absint( $input );

		// Get the input attributes associated with the setting.
		$atts = $setting->manager->get_control( $setting->id )->input_attrs;

		// Get min.
		$min = ( isset( $atts['min'] ) ? $atts['min'] : $input );

		// Get max.
		$max = ( isset( $atts['max'] ) ? $atts['max'] : $input );

		// Get Step.
		$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

		// If the input is within the valid range, return it; otherwise, return the default.
		return ( $min <= $input && $input <= $max && is_int( $input / $step ) ? $input : $setting->default );

	}

endif;

if ( ! function_exists( 'easy_magazine_sanitize_textarea_content' ) ) :

	/**
	 * Sanitize textarea content.
	 *
	 * @since 1.0.0
	 *
	 */
	function easy_magazine_sanitize_textarea_content( $input, $setting ) {

		return ( stripslashes( wp_filter_post_kses( addslashes( $input ) ) ) );

	}
endif;

if ( ! function_exists( 'easy_magazine_sanitize_positive_integer' ) ) :

	/**
	 * Sanitize positive integer.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input Number to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized number; otherwise, the setting default.
	 */
	function easy_magazine_sanitize_positive_integer( $input, $setting ) {

		$input = absint( $input );

		// If the input is an positive integer, return it.
		// otherwise, return the default.
		return ( $input ? $input : $setting->default );
	}

endif;

/**
 * Image sanitization callback example.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 * 
 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function easy_magazine_sanitize_image( $image, $setting ) {
    /*
     * Array of valid image file types.
     *
     * The array includes image mime types that are included in wp_get_mime_types()
     */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    // Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Sanitize social links.
 *
 * @since 1.0.0
 *
 * @param mixed                $input The value to sanitize.
 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
 * @return mixed Sanitized value.
 */
function easy_magazine_sanitize_social_links( $input, $setting ) {

	if ( empty( $input ) ) {
		return '';
	}

	$exploded = explode( '|', $input );
	$new_array = array_map( 'esc_url_raw', $exploded );
	$output = implode( '|', $new_array );

	return $output;
}

if ( ! function_exists( 'easy_magazine_sanitize_sortable' ) ) :
	/**
	* Sanitizes strings in array
	* @param  $input entered value
	* @return sanitized output
	*
	* @since Easy Magazine 1.0
	*/
	function easy_magazine_sanitize_sortable( $input ) {

		// Ensure $input is an array.
		if ( ! is_array( $input ) )
			$input = explode( ',', $input );

		$output = array_map( 'sanitize_text_field', $input );

		return implode( ',', $output );
	}
endif;

/**
* Sanitizes email
* @param  $input entered value
* @return sanitized output
*
* @since Creativ Musician 1.0
*/
function easy_magazine_sanitize_array_int( $input ) {

	// Ensure $input is an url.
	$links = array_map( 'absint', $input );

	return $links;
}

if ( ! function_exists( 'easy_magazine_sanitize_phone_number' ) ) :

	/**
	 * Sanitize Phone number.
	 *
	 * @since 1.0.0
	 *	
	 */
	function easy_magazine_sanitize_phone_number( $phone ) {
		return preg_replace( '/[^\d+]/', '', $phone );
	}

endif;
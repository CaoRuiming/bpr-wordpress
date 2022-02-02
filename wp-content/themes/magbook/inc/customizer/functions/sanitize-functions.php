<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
/********************* MAGBOOK CUSTOMIZER SANITIZE FUNCTIONS *******************************/
function magbook_checkbox_integer( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function magbook_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

function magbook_sanitize_category_select($input) {
	
	$input = sanitize_key( $input );
	return ( ( isset( $input ) && true == $input ) ? $input : '' );

}

function magbook_numeric_value( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}

function magbook_reset_alls( $input ) {
	if ( $input == 1 ) {
		delete_option( 'magbook_theme_options');
		$input=0;
		return absint($input);
	} 
	else {
		return '';
	}
}
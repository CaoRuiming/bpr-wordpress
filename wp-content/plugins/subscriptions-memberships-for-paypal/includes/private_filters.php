<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// media button inserter - change button text

function wpeppsub_change_button_text( $translation, $text, $domain )
{
    if ( 'default' == $domain and 'Insert into Post' == $text )
    {
        remove_filter( 'gettext', 'wpeppsub_change_button_text' );
        return 'Use this image';
    }
    return $translation;
}
add_filter( 'gettext', 'wpeppsub_change_button_text', 10, 3 );


// currency validation

function wpeppsub_sanitize_currency_meta( $value ) {

	if (!empty($value)) {
		$value = (float) preg_replace('/[^0-9.]*/','',$value);
		return number_format((float)$value, 2, '.', '');
	}
}
add_filter( 'sanitize_post_meta_currency_wpeppsub', 'wpeppsub_sanitize_currency_meta' );
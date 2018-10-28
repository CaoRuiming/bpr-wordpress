<?php
/**
Plugin Name: Dropcaps Shortcode And Widgets
Plugin URI: http://OTWthemes.com
Description:  Create Dropcaps. Nice and easy interface. Insert anywhere in your site - page/post editor, sidebars, template files.
Author: OTWthemes.com
Version: 1.5

Author URI: http://themeforest.net/user/OTWthemes
*/

load_plugin_textdomain('otw_dcsw',false,dirname(plugin_basename(__FILE__)) . '/languages/');

load_plugin_textdomain('otw-shortcode-widget',false,dirname(plugin_basename(__FILE__)) . '/languages/');

$wp_dcsw_tmc_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_dcsw' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_dcsw' ) )
);

$wp_dcsw_agm_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_dcsw' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_dcsw' ) )
);

$wp_dcsw_cs_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_dcsw' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_dcsw' ) )
);

$otw_dcsw_plugin_url = plugin_dir_url( __FILE__);
$otw_dcsw_css_version = '1.8';
$otw_dcsw_js_version = '1.8';

$otw_dcsw_plugin_options = get_option( 'otw_dcsw_plugin_options' );

//include functons
require_once( plugin_dir_path( __FILE__ ).'/include/otw_dcsw_functions.php' );

//otw components
$otw_dcsw_shortcode_component = false;
$otw_dcsw_form_component = false;
$otw_dcsw_validator_component = false;

//load core component functions
@include_once( 'include/otw_components/otw_functions/otw_functions.php' );

if( !function_exists( 'otw_register_component' ) ){
	wp_die( 'Please include otw components' );
}

//register form component
otw_register_component( 'otw_form', dirname( __FILE__ ).'/include/otw_components/otw_form/', $otw_dcsw_plugin_url.'/include/otw_components/otw_form/' );

//register validator component
otw_register_component( 'otw_validator', dirname( __FILE__ ).'/include/otw_components/otw_validator/', $otw_dcsw_plugin_url.'/include/otw_components/otw_validator/' );

//register shortcode component
otw_register_component( 'otw_shortcode', dirname( __FILE__ ).'/include/otw_components/otw_shortcode/', $otw_dcsw_plugin_url.'/include/otw_components/otw_shortcode/' );

/** 
 *call init plugin function
 */
add_action('init', 'otw_dcsw_init' );
add_action('widgets_init', 'otw_dcsw_widgets_init' );

?>
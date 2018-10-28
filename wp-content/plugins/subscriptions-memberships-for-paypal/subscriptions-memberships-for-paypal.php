<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Plugin Name: Subscriptions & Memberships for PayPal
Plugin URI: https://wpplugin.org/paypal-subscriptions-memberships
Description: A simple and easy way to sell subscriptions or memberships.
Tags: PayPal, subscription, membership, subscriptions, memberships, PayPal Buttons, eCommerce
Author: Scott Paterson
Author URI: https://wpplugin.org
License: GPL2
Version: 1.1.2
*/

/*  Copyright 2014-2017 Scott Paterson

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//// variables
// plugin function 	  			= wpeppsub
// shortcode 		  			= wpeppsub
// subscription post type	  	= wpplugin_subscr
// expired post type	  		= wpplugin_subscr_eot
// cancelled post type	  		= wpplugin_subscr_cancel - not used
// button post type	  			= wpplugin_sub_button
// order post type	  			= wpplugin_sub_order
// log post type	  			= wpplugin__sub_log
$plugin_basename = plugin_basename(__FILE__);



function activation_wpeppsub() {
	
	// get admin email
	$admin_email = get_option( 'admin_email' );
	
	$current_user = wp_get_current_user();
	
	// make new post for logging
	if( !get_option("wpeppsub_settingsoptions") ) {
		$my_post = array(
			 'post_title'    		=> 'wpplugin__sub_logs'
			,'post_status'   		=> 'publish'
			,'post_author'   		=> $current_user->ID
			,'post_type'     		=> 'wpplugin__sub_log'
		);
		$log_id = wp_insert_post( $my_post );
	} else {
		$log_id = "";
	}
	
	// initial options
	$wpeppsub_settingsoptions = array(
		 'currency'    			=> '25'
		,'language'   			=> '3'
		,'liveaccount'   		=> ''
		,'sandboxaccount'    	=> ''
		,'mode'    				=> '2'
		,'show_currency'    	=> '0'
		,'opens'    			=> '2'
		,'size'    				=> '2'
		,'no_note'    			=> '1'
		,'subscriber'    		=> '1'
		,'content'    			=> '1'
		,'hideadmin'    		=> '1'
		,'guest_text'    		=> 'Subscribers please login to see content.'
		,'cancelled_text'    	=> 'Your subscription has expired or been cancelled.'
		,'no_shipping'    		=> '1'
		,'cancel'    			=> ''
		,'return'    			=> ''
		,'note'    				=> '1'
		,'upload_image'    		=> ''
		,'log'		    		=> '2'
		,'logs'		    		=> ''
		,'logging_id'			=> $log_id
		,'uninstall'			=> '2'
	);
	
	// save options
	add_option("wpeppsub_settingsoptions", $wpeppsub_settingsoptions);
	
}

function deactivation_wpeppsub() {

	delete_option("wpeppsub_notice_shown");
	
}

function uninstall_wpeppsub() {

	// remove all plugin data if option is enabled
	$options = get_option('wpeppsub_settingsoptions');
	foreach ($options as $k => $v ) {
		
		$value[$k] =  wp_kses($v, array(
				'a' => array(
				'href' => array(),
				'title' => array()
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		));	
		
	}
	
	if ($value['uninstall'] == "1") {
		
		// logs
		$args = array('numberposts' => 5,'post_type' =>'wpeppsub_log');
		$posts = get_posts( $args );
		if (is_array($posts)) {
			foreach ($posts as $post) {
			   wp_delete_post( $post->ID, true);
			}
		}
		
		// buttons
		$args = array('numberposts' => 1000,'post_type' =>'wpplugin_sub_button');
		$posts = get_posts( $args );
		if (is_array($posts)) {
			foreach ($posts as $post) {
			   wp_delete_post( $post->ID, true);
			}
		}
		
		// orders
		$args = array('numberposts' => 1000,'post_type' =>'wpplugin_sub_order');
		$posts = get_posts( $args );
		if (is_array($posts)) {
			foreach ($posts as $post) {
			   wp_delete_post( $post->ID, true);
			}
		}
		
		// subscribers
		$args = array('numberposts' => 1000,'post_type' =>'wpplugin_subscr');
		$posts = get_posts( $args );
		if (is_array($posts)) {
			foreach ($posts as $post) {
			   wp_delete_post( $post->ID, true);
			}
		}
		
		// expired subscriptions
		$args = array('numberposts' => 1000,'post_type' =>'wpplugin_subscr_eot');
		$posts = get_posts( $args );
		if (is_array($posts)) {
			foreach ($posts as $post) {
			   wp_delete_post( $post->ID, true);
			}
		}
		
		delete_option("wpeppsub_notice_shown");
		delete_option("wpeppsub_settingsoptions");
		
	}
	
}

// register hooks
register_activation_hook(__FILE__,'activation_wpeppsub');
register_deactivation_hook(__FILE__, 'deactivation_wpeppsub');
register_uninstall_hook(__FILE__,'uninstall_wpeppsub');
	

//// plugin includes
include_once ('includes/private_functions.php');
include_once ('includes/private_button_inserter.php');
include_once ('includes/private_orders.php');
include_once ('includes/private_subscribers.php');
include_once ('includes/private_buttons.php');
include_once ('includes/private_restrict.php');
include_once ('includes/private_settings.php');
include_once ('includes/public_shortcode.php');
include_once ('includes/private_filters.php');
include_once ('includes/public_ipn.php');

?>
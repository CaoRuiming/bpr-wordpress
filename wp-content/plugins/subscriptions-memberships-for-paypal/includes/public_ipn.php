<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// IPN post
function wpeppsub_listen_for_paypal_ipn() {
	if (isset($_REQUEST['wpeppsub-listener']) && $_REQUEST['wpeppsub-listener'] == 'IPN') {
		
		wpeppsub_log("IPN - Listener request received.");		
		
		// Check the request method is POST
		if (isset( $_SERVER['REQUEST_METHOD'] )&& $_SERVER['REQUEST_METHOD'] != 'POST' ) {
			wpeppsub_log("IPN - GET request detected.");
			return;
		}
		
		// Set initial post data to empty string
		$post_data = '';
		
		// Fallback just in case post_max_size is lower than needed
		if ( ini_get( 'allow_url_fopen' ) ) {
			$post_data = file_get_contents( 'php://input' );
		} else {
			// If allow_url_fopen is not enabled, then make sure that post_max_size is large enough
			ini_set( 'post_max_size', '12M' );
		}
		// Start the encoded data collection with notification command
		$encoded_data = 'cmd=_notify-validate';

		// Get current arg separator
		$arg_separator = wpeppsub_get_php_arg_separator_outputa();
		
		// Verify there is a post_data
		if ( $post_data || strlen( $post_data ) > 0 ) {
			// Append the data
			$encoded_data .= $arg_separator.$post_data;
		} else {
			// Check if POST is empty
			if ( empty( $_POST ) ) {
				// Nothing to do
				return;
			} else {
				// Loop through each POST
				foreach ( $_POST as $key => $value ) {
					// Encode the value and append the data
					$encoded_data .= $arg_separator."$key=" . urlencode( $value );
				}
			}
		}
		
		// Convert collected post data to an array
		parse_str( $encoded_data, $encoded_data_array );
		
		foreach ( $encoded_data_array as $key => $value ) {
		
			if ( false !== strpos( $key, 'amp;' ) ) {
				$new_key = str_replace( '&amp;', '&', $key );
				$new_key = str_replace( 'amp;', '&' , $new_key );
				
				unset( $encoded_data_array[ $key ] );
				$encoded_data_array[ $new_key ] = $value;
			}
			
		}
		
		// Get the PayPal redirect uri
		$paypal_redirect = wpeppsub_get_paypal_redirect( true );
		
		//disable_paypal_verification setting
		$bypass = '0';
		
		if ( $bypass == '1' ) {
			
			// Validate the IPN
			
			$remote_post_vars      = array(
				'method'           => 'POST',
				'timeout'          => 45,
				'redirection'      => 5,
				'httpversion'      => '1.1',
				'blocking'         => true,
				'headers'          => array(
					'host'         => 'www.paypal.com',
					'connection'   => 'close',
					'content-type' => 'application/x-www-form-urlencoded',
					'post'         => '/cgi-bin/webscr HTTP/1.1',
					
				),
				'sslverify'        => false,
				'body'             => $encoded_data_array
			);
			
			// Get response
			$api_response = wp_remote_post( wpeppsub_get_paypal_redirect(), $remote_post_vars );
			
			if ( is_wp_error($api_response)) {
				$error = json_encode($api_response);
				wpeppsub_log("Invalid IPN verification response. IPN data:".$error);
				return; // Something went wrong
			}
			
			if ( $api_response['body'] !== 'VERIFIED' && wpeppsub_get_option( 'disable_paypal_verification', false)) {
				$error = json_encode($api_response);
				wpeppsub_log("Invalid IPN verification response. IPN data:".$error);
				return; // Response not okay
			}
			
		}
			
		// Check if $post_data_array has been populated
		if ( ! is_array( $encoded_data_array ) && !empty( $encoded_data_array ) ) {
			return;
		}
			
		$defaults = array(
			'txn_type'       => '',
			'payment_status' => ''
		);
		
		// Get POST values from PayPal
		$encoded_data_array = wp_parse_args( $encoded_data_array, $defaults );
		
		$encoded_data_arraya = serialize($encoded_data_array);
		
		
		// log all post data
		wpeppsub_log($encoded_data_arraya);
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		if (isset($encoded_data_array['txn_type']) && ($encoded_data_array['txn_type'] == "subscr_payment" || $encoded_data_array['txn_type'] == "subscr_signup" || $encoded_data_array['txn_type'] == "subscr_cancel" || $encoded_data_array['txn_type'] == "subscr_eot")) {
			
			wpeppsub_log("IPN - POST data received from PayPal successfully.");
			
			// sanatize post array
			$data = array_map('esc_attr', $encoded_data_array);
			
			// assign posted variables to local variables
			$custom = sanitize_text_field($encoded_data_array['custom']);
			
			
			
			
			
			
			
			if ($encoded_data_array['txn_type'] != "subscr_cancel" && $encoded_data_array['txn_type'] != "subscr_eot") {
			
			
				// for making accounts 
				if ($encoded_data_array['txn_type'] == "subscr_signup") {
					$post_type = "wpplugin_subscr";
					
					// create new wp account for subscriber
					$options = get_option('wpeppsub_settingsoptions');
					foreach ($options as $k => $v ) { $valuea[$k] = $v; }
					
					if ($valuea['subscriber'] == "1") {
						
						$payer_email = $encoded_data_array['payer_email'];
						
						//$user_id = username_exists( $payer_email );
						
						if (email_exists($payer_email) == false) {
							$random_password = wp_generate_password($length=12, $include_standard_special_chars=false);
							$user_id = wp_create_user($payer_email, $random_password, $payer_email);
							wp_send_new_user_notifications($user_id);
						} else {
							// user already exists
						}
						
					}
					
				}
				
				
				// for payments
				if ($encoded_data_array['txn_type'] == "subscr_payment") {
					$post_type = "wpplugin_sub_order";
				}
					
				$payer_email = $encoded_data_array['payer_email'];
				
				// save to db
				$my_post = array(
					'post_title'    => $payer_email,
					'post_status'   => 'publish',
					'post_type'     => $post_type
				);
				$post_id = wp_insert_post($my_post);
				
				// save post data
				update_post_meta($post_id, 'wpeppsub_order_data', $data);
				
				
				// subscription status
				if ($encoded_data_array['txn_type'] == "subscr_signup") {
					
					// check to see if expires post has come in
					
					$subscr_id = $encoded_data_array['subscr_id'];
					
					$args = array(
							'orderby' 			=> 'ID',
							'order' 			=> 'DESC',
							'posts_per_page'	=> -1,
							'post_type' 		=> 'wpplugin_subscr_eot',
							'meta_query' 		=> array(
								'relation'=>'or',
								array(
									'key' 		=> 'wpeppsub_order_data',
									'value' 	=> $subscr_id,
									'compare' 	=> 'LIKE',
							   )
							)
					);
					
					$posts = get_posts($args);
					
					$count = "0";
					foreach ($posts as $post) {
						$id = esc_attr($posts[$count]->ID);
						$count++;
					}
					
					if (!empty($id)) {
						$status = "Expired";
						// add one day to current time
						$expires_date = time() + 24*60*60;
						update_post_meta($post_id, 'wpeppsub_order_status', $status);
						update_post_meta($post_id, 'wpeppsub_order_expires_date', $expires_date);
					} else {
					
						// not expired yet
						$status = "Active";
						update_post_meta($post_id, 'wpeppsub_order_status', $status);
					
					}
				}
				
			}
			
			
			
			
			
			
			
			
			
			
			
			
			// subscription cancel or expired
			
			if ($encoded_data_array['txn_type'] == "subscr_cancel" || $encoded_data_array['txn_type'] == "subscr_eot") {
				
				
				
				
				// for cancelled - we are assuming that the cancelled ipn post isn't going to come before signup post
				if ($encoded_data_array['txn_type'] == "subscr_cancel") {
					
					// post subscription id
					$subscr_id = $encoded_data_array['subscr_id'];
					
					// lookup existing subscriber post id
					$args = array(
							'orderby' 			=> 'ID',
							'order' 			=> 'DESC',
							'posts_per_page'	=> -1,
							'post_type' 		=> 'wpplugin_subscr',
							'meta_query' 		=> array(
								'relation'=>'or',
								array(
									'key' 		=> 'wpeppsub_order_data',
									'value' 	=> $subscr_id,
									'compare' 	=> 'LIKE',
							   )
							)
					);
					
					$posts = get_posts($args);
					
					$count = "0";
					foreach ($posts as $post) {
						$id = esc_attr($posts[$count]->ID);
						$count++;
					}
					
					$post_type = "wpplugin_subscr_cancel";
					$status = "Cancelled";
					update_post_meta($id, 'wpeppsub_order_status', $status);
				}
				
				
				
				
				
				
				
				// for expired - need to save it to the db since expired post can come before signup post if subscription period is one day
				if ($encoded_data_array['txn_type'] == "subscr_eot") {
					$post_type = "wpplugin_subscr_eot";
					$status = "Expired";
					// add one day to current time
					$expires_date = time() + 24*60*60;
					
					// post subscription id
					$subscr_id = $encoded_data_array['subscr_id'];
					
					// lookup existing subscriber post id
					$args = array(
							'orderby' 			=> 'ID',
							'order' 			=> 'DESC',
							'posts_per_page'	=> -1,
							'post_type' 		=> 'wpplugin_subscr',
							'meta_query' 		=> array(
								'relation'=>'or',
								array(
									'key' 		=> 'wpeppsub_order_data',
									'value' 	=> $subscr_id,
									'compare' 	=> 'LIKE',
							   )
							)
					);
					
					$posts = get_posts($args);
					
					$count = "0";
					foreach ($posts as $post) {
						$id = esc_attr($posts[$count]->ID);
						$count++;
					}
					
					if (!empty($id)) {
						update_post_meta($id, 'wpeppsub_order_status', $status);
						update_post_meta($id, 'wpeppsub_order_expires_date', $expires_date);
					} else {
						// save to db, since the signup post hasnt come yet
						
						
						$payer_email = $encoded_data_array['payer_email'];
						$post_type = "wpplugin_subscr_eot";
						
						// save to db
						$my_post = array(
							'post_title'    => $payer_email,
							'post_status'   => 'publish',
							'post_type'     => $post_type
						);
						$post_id = wp_insert_post($my_post);
						
						// save post data
						update_post_meta($post_id, 'wpeppsub_order_data', $data);
						
						
						
					}
					
				}
				
				
			}	
		}	
	}
}
add_action( 'init', 'wpeppsub_listen_for_paypal_ipn' );




function wpeppsub_get_paypal_redirect( $ssl_check = false ) {

	// Check if SSL is being used on the site
	if ( is_ssl() || ! $ssl_check ) {
		$protocal = 'https://';
	} else {
		$protocal = 'http://';
	}

	// Check the current payment mode
	$options = get_option('wpeppsub_settingsoptions');
	foreach ($options as $k => $v ) { $value[$k] = $v; }
	
	if ($value['mode'] == "1") {
		$paypal_uri = $protocal . 'www.sandbox.paypal.com/cgi-bin/webscr';
	} else {
		$paypal_uri = $protocal . 'www.paypal.com/cgi-bin/webscr';
	}

	return apply_filters( 'wpeppsub_paypal_uri', $paypal_uri );
}
<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// display activation notice
function wpeppsub_admin_notices() {
	if (!get_option('wpeppsub_notice_shown')) {
		echo "<div class='updated notice is-dismissible'><p>Subscriptions & Memberships for PayPal: <a href='admin.php?page=wpeppsub_settings'>Click here to view the plugin settings</a>.</p></div>";
		update_option("wpeppsub_notice_shown", "true");
	}
}
add_action('admin_notices', 'wpeppsub_admin_notices');



// add paypal menu
function wpeppsub_plugin_menu() {
	global $plugin_dir_url;
	
	add_menu_page("Subscription", "Subscriptions", "manage_options", "wpeppsub_menu", "wpeppsub_plugin_orders",'dashicons-cart','28.5');
	
	add_submenu_page("wpeppsub_menu", "Payments", "Payments", "manage_options", "wpeppsub_menu", "wpeppsub_plugin_orders");
	
	add_submenu_page("wpeppsub_menu", "Subscribers", "Subscribers", "manage_options", "wpeppsub_subscribers", "wpeppsub_plugin_subscribers");
	
	add_submenu_page("wpeppsub_menu", "Buttons", "Buttons", "manage_options", "wpeppsub_buttons", "wpeppsub_plugin_buttons");
	
	add_submenu_page("wpeppsub_menu", "Settings", "Settings", "manage_options", "wpeppsub_settings", "wpeppsub_plugin_options");
}
add_action("admin_menu", "wpeppsub_plugin_menu");



// plugins menu links
function wpeppsub_action_links($links) {
	global $support_link, $edit_link, $settings_link;
	
	$links[] = '<a href="https://wordpress.org/support/plugin/subscriptions-memberships-for-paypal" target="_blank">Support</a>';
	$links[] = '<a href="admin.php?page=wpeppsub_settings">Settings</a>';
	
	return $links;
}
add_filter( 'plugin_action_links_' . $plugin_basename, 'wpeppsub_action_links' );




// logging
function wpeppsub_log($input) {
	
	// check if logging in enabled
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


	if ($value['log'] == "1") {
		
		// read current post 
		$post_data = get_post($value['logging_id']);
		$data = $post_data->post_content;
		$date = date('m/d/Y H:i:s', current_time('timestamp', 0));
		$data = $date.": ".$input."\n".$data;
		
		// setup new post data
		$my_post = array(
			'ID'           => $value['logging_id'],
			'post_title'   => 'wpeppsub_logs',
			'post_content' => $data,
		);
		
		// update
		wp_update_post( $my_post );
		
	}

}

// clear logs
function wpeppsub_clear_log() {
	
	// check if logging in enabled
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
		
		$data = "";
		
		// setup new post data
		$my_post = array(
			'ID'           => $value['logging_id'],
			'post_title'   => 'wpeppsub_logs',
			'post_content' => $data,
		);
		
		// update
		wp_update_post( $my_post );

}

// get php arg separator
function wpeppsub_get_php_arg_separator_outputa() {
	return ini_get( 'arg_separator.output' );
}




// hide admin bar for subscribers
function wpeppsub_hide_admin_bar() {
	if (current_user_can('read') && !current_user_can('upload_files')) {
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
		if ($value['hideadmin'] == "1") {
			show_admin_bar( false );
		}
	}
}
add_action('init', 'wpeppsub_hide_admin_bar');
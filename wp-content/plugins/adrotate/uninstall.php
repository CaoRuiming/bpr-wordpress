<?php
if(!defined('ABSPATH') OR !defined('WP_UNINSTALL_PLUGIN')) exit;
if(!current_user_can('activate_plugins')) return;

/*-------------------------------------------------------------
 Name:      adrotate_initiate_uninstall
 Purpose:   Loop through all instances and init adrotate_uninstall_setup()
 Since:		5.7
-------------------------------------------------------------*/
function adrotate_initiate_uninstall() {
	global $network_wide, $wpdb; 

	if(is_multisite()) {
		$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");	
	
		if($blog_ids) {	
			foreach($blog_ids as $blog_id) {
				switch_to_blog($blog_id);
				adrotate_uninstall_setup();
				restore_current_blog();
			}
		}
	} else {
		adrotate_uninstall_setup();
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_uninstall_setup
 Purpose:   Delete all data per instance
 Since:		5.7
-------------------------------------------------------------*/
function adrotate_uninstall_setup() {
	global $wpdb, $wp_roles;

	// Clean up capabilities from ALL users
	$editable_roles = apply_filters('editable_roles', $wp_roles->roles);	
	foreach($editable_roles as $role => $details) {
		$wp_roles->remove_cap($details['name'], "adrotate_ad_manage");
		$wp_roles->remove_cap($details['name'], "adrotate_ad_delete");
		$wp_roles->remove_cap($details['name'], "adrotate_group_manage");
		$wp_roles->remove_cap($details['name'], "adrotate_group_delete");
	}

	// Clear out userroles
	remove_role('adrotate_advertiser');

	// Clear out wp_cron
	wp_clear_scheduled_hook('adrotate_evaluate_ads');
	wp_clear_scheduled_hook('adrotate_empty_trackerdata');

	// Drop MySQL Tables
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate`");
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate_groups`");
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate_linkmeta`");
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate_stats`");
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate_stats_archive`");
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate_schedule`");
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}adrotate_tracker`");
	
	// Delete Options	
	delete_option('adrotate_activate');
	delete_option('adrotate_config');
	delete_option('adrotate_crawlers');
	delete_option('adrotate_version');
	delete_option('adrotate_db_version');
	delete_option('adrotate_db_timer');
	delete_option('adrotate_debug');
	delete_option('adrotate_geo_required');
	delete_option('adrotate_geo_requests');
	delete_option('adrotate_geo_reset');
	delete_option('adrotate_group_css');
	delete_option('adrotate_header_output');
	delete_option('adrotate_dynamic_required');
	delete_option('adrotate_hide_license');
	delete_option('adrotate_hide_review');
	delete_option('adrotate_hide_competition');
	delete_option('adrotate_hide_getpro');
	delete_option('adrotate_hide_birthday');
	delete_option('adrotate_advert_status');
	delete_option('adrotate_notifications');

	// Cleanup user meta
	$wpdb->query("DELETE FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = 'adrotate_is_advertiser';");
	$wpdb->query("DELETE FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = 'adrotate_notes';");
	$wpdb->query("DELETE FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = 'adrotate_permissions';");
}

// Run the uninstaller
adrotate_initiate_uninstall();
?>
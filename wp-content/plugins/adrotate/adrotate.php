<?php
/*
Plugin Name: AdRotate
Plugin URI: https://ajdg.solutions/product/adrotate-banner-manager/?pk_campaign=adrotatefree&pk_keyword=plugin_info
Author: Arnan de Gans
Author URI: https://www.arnan.me/?pk_campaign=adrotatefree&pk_keyword=plugin_info
Description: Monetize your website with adverts while keeping things simple. Start making money today!
Text Domain: adrotate
Version: 5.8.21
License: GPLv3
*/

/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2021 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */

/*--- AdRotate values ---------------------------------------*/
define("ADROTATE_DISPLAY", '5.8.21');
define("ADROTATE_VERSION", 399);
define("ADROTATE_DB_VERSION", 66);
$plugin_folder = plugin_dir_path(__FILE__);
/*-----------------------------------------------------------*/

/*--- Load Files --------------------------------------------*/
include_once($plugin_folder.'/adrotate-setup.php');
include_once($plugin_folder.'/adrotate-manage-publisher.php');
include_once($plugin_folder.'/adrotate-functions.php');
include_once($plugin_folder.'/adrotate-statistics.php');
include_once($plugin_folder.'/adrotate-portability.php');
include_once($plugin_folder.'/adrotate-output.php');
include_once($plugin_folder.'/adrotate-widget.php');
/*-----------------------------------------------------------*/

/*--- Check and Load config ---------------------------------*/
load_plugin_textdomain('adrotate', false, 'adrotate/language');
$adrotate_config = get_option('adrotate_config');
$adrotate_crawlers = get_option('adrotate_crawlers');
$adrotate_version = get_option("adrotate_version");
$adrotate_db_version = get_option("adrotate_db_version");
/*-----------------------------------------------------------*/

/*--- Core --------------------------------------------------*/
register_activation_hook(__FILE__, 'adrotate_activate');
register_deactivation_hook(__FILE__, 'adrotate_deactivate');
register_uninstall_hook(__FILE__, 'adrotate_uninstall');
add_action('adrotate_evaluate_ads', 'adrotate_evaluate_ads');
add_action('adrotate_empty_trackerdata', 'adrotate_empty_trackerdata');
add_action('widgets_init', 'adrotate_widget');
add_filter('adrotate_apply_photon','adrotate_apply_jetpack_photon');
/*-----------------------------------------------------------*/

/*--- Front end ---------------------------------------------*/
if(!is_admin()) {
	add_shortcode('adrotate', 'adrotate_shortcode');
	add_action('wp_head', 'adrotate_header');
	add_action("wp_enqueue_scripts", 'adrotate_scripts');
	add_filter('the_content', 'adrotate_inject_posts', 12);
}

if($adrotate_config['stats'] == 1){
	add_action('wp_ajax_adrotate_impression', 'adrotate_impression_callback');
	add_action('wp_ajax_nopriv_adrotate_impression', 'adrotate_impression_callback');
	add_action('wp_ajax_adrotate_click', 'adrotate_click_callback');
	add_action('wp_ajax_nopriv_adrotate_click', 'adrotate_click_callback');
}
/*-----------------------------------------------------------*/

/*--- Back End ----------------------------------------------*/
if(is_admin()) {
	adrotate_check_config();
	add_action('admin_menu', 'adrotate_dashboard');
	add_action("admin_enqueue_scripts", 'adrotate_dashboard_scripts');
	add_action("admin_print_styles", 'adrotate_dashboard_styles');
	add_action('admin_notices','adrotate_notifications_dashboard');
	add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'adrotate_action_links');
	/*--- Internal redirects ------------------------------------*/
	if(isset($_POST['adrotate_generate_submit'])) add_action('init', 'adrotate_generate_input');
	if(isset($_POST['adrotate_ad_submit'])) add_action('init', 'adrotate_insert_input');
	if(isset($_POST['adrotate_group_submit'])) add_action('init', 'adrotate_insert_group');
	if(isset($_POST['adrotate_media_submit'])) add_action('init', 'adrotate_insert_media');
	if(isset($_POST['adrotate_folder_submit'])) add_action('init', 'adrotate_insert_folder');
	if(isset($_POST['adrotate_action_submit'])) add_action('init', 'adrotate_request_action');
	if(isset($_POST['adrotate_disabled_action_submit'])) add_action('init', 'adrotate_request_action');
	if(isset($_POST['adrotate_error_action_submit'])) add_action('init', 'adrotate_request_action');
	if(isset($_POST['adrotate_save_options'])) add_action('init', 'adrotate_options_submit');
	if(isset($_POST['adrotate_request_submit'])) add_action('init', 'adrotate_mail_message');
	if(isset($_POST['adrotate_cleanup_submit'])) add_action('init', 'adrotate_clean_setup');
	if(isset($_POST['adrotate_evaluate_submit'])) add_action('init', 'adrotate_prepare_evaluate_ads');
}

/*-------------------------------------------------------------
 Name:      adrotate_dashboard
 Purpose:   Add pages to admin menus
-------------------------------------------------------------*/
function adrotate_dashboard() {
	$adrotate_page = $adrotate_pro = $adrotate_adverts = $adrotate_groups = $adrotate_settings =  '';

	add_menu_page('AdRotate', 'AdRotate', 'adrotate_ad_manage', 'adrotate', 'adrotate_manage', plugins_url('/images/icon-menu.png', __FILE__), '25.8');
	$adrotate_adverts = add_submenu_page('adrotate', 'AdRotate · '.__('Manage Adverts', 'adrotate'), __('Manage Adverts', 'adrotate'), 'adrotate_ad_manage', 'adrotate', 'adrotate_manage');
	$adrotate_groups = add_submenu_page('adrotate', 'AdRotate · '.__('Manage Groups', 'adrotate'), __('Manage Groups', 'adrotate'), 'adrotate_group_manage', 'adrotate-groups', 'adrotate_manage_group');
	$adrotate_schedules = add_submenu_page('adrotate', 'AdRotate · '.__('Manage Schedules', 'adrotate'), __('Manage Schedules', 'adrotate'), 'adrotate_ad_manage', 'adrotate-schedules', 'adrotate_manage_schedules');
	$adrotate_media = add_submenu_page('adrotate', 'AdRotate · '.__('Manage Media', 'adrotate'), __('Manage Media', 'adrotate'), 'adrotate_ad_manage', 'adrotate-media', 'adrotate_manage_media');
	$adrotate_statistics = add_submenu_page('adrotate', 'AdRotate · '.__('Statistics', 'adrotate'), __('Statistics', 'adrotate'), 'adrotate_ad_manage', 'adrotate-statistics', 'adrotate_statistics');
	$adrotate_pro = add_submenu_page('adrotate', 'AdRotate · '.__('Get AdRotate Pro', 'adrotate'), __('Get AdRotate Pro', 'adrotate'), 'adrotate_ad_manage', 'adrotate-pro', 'adrotate_pro');
	$adrotate_support = add_submenu_page('adrotate', 'AdRotate · '.__('Support', 'adrotate'), __('Support', 'adrotate'), 'manage_options', 'adrotate-support', 'adrotate_support');
	$adrotate_settings = add_submenu_page('adrotate', 'AdRotate · '.__('Settings', 'adrotate'), __('Settings', 'adrotate'), 'manage_options', 'adrotate-settings', 'adrotate_options');

	// Add help tabs
	add_action('load-'.$adrotate_adverts, 'adrotate_help_info');
	add_action('load-'.$adrotate_groups, 'adrotate_help_info');
	add_action('load-'.$adrotate_schedules, 'adrotate_help_info');
	add_action('load-'.$adrotate_media, 'adrotate_help_info');
	add_action('load-'.$adrotate_statistics, 'adrotate_help_info');
	add_action('load-'.$adrotate_pro, 'adrotate_help_info');
	add_action('load-'.$adrotate_settings, 'adrotate_help_info');
}

/*-------------------------------------------------------------
 Name:      adrotate_pro
 Purpose:   AdRotate Pro Sales
-------------------------------------------------------------*/
function adrotate_pro() {
?>
	<div class="wrap">
		<h1><?php _e('Get AdRotate Professional', 'adrotate'); ?></h1>

		<br class="clear" />

		<?php include("dashboard/adrotatepro.php"); ?>

		<br class="clear" />
	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_manage
 Purpose:   Admin management page
-------------------------------------------------------------*/
function adrotate_manage() {
	global $wpdb, $userdata, $adrotate_config;

	$status = $file = $view = $ad_edit_id = '';
	if(isset($_GET['status'])) $status = esc_attr($_GET['status']);
	if(isset($_GET['file'])) $file = esc_attr($_GET['file']);
	if(isset($_GET['view'])) $view = esc_attr($_GET['view']);
	if(isset($_GET['ad'])) $ad_edit_id = esc_attr($_GET['ad']);

	if(!is_numeric($status)) $status = 0;
	if(!is_numeric($ad_edit_id)) $ad_edit_id = 0;

	$now 			= current_time('timestamp');
	$today 			= adrotate_date_start('day');
	$in2days 		= $now + 172800;
	$in7days 		= $now + 604800;
	$in84days 		= $now + 7257600;

	if(isset($_GET['month']) AND isset($_GET['year'])) {
		$month = esc_attr($_GET['month']);
		$year = esc_attr($_GET['year']);
	} else {
		$month = date("m");
		$year = date("Y");
	}
	$monthstart = mktime(0, 0, 0, $month, 1, $year);
	$monthend = mktime(0, 0, 0, $month+1, 0, $year);
	?>
	<div class="wrap">
		<h1><?php _e('Manage Adverts', 'adrotate'); ?></h1>

		<?php
		if($status > 0) adrotate_status($status, array('file' => $file));

		$allbanners = $wpdb->get_results("SELECT `id`, `title`, `type`, `tracker`, `weight` FROM `{$wpdb->prefix}adrotate` WHERE (`type` != 'empty' OR `type` != 'a_empty' OR `type` != 'queue') ORDER BY `id` ASC;");

		$active = $disabled = $error = false;
		foreach($allbanners as $singlebanner) {
			$starttime = $stoptime = 0;
			$starttime = $wpdb->get_var("SELECT `starttime` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '{$singlebanner->id}' AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `starttime` ASC LIMIT 1;");
			$stoptime = $wpdb->get_var("SELECT `stoptime` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '{$singlebanner->id}' AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `stoptime` DESC LIMIT 1;");

			$type = $singlebanner->type;
			if($type == 'active' AND $stoptime <= $in7days) $type = '7days';
			if($type == 'active' AND $stoptime <= $in2days) $type = '2days';
			if($type == 'active' AND $stoptime <= $now) $type = 'expired';

			$title = (strlen($singlebanner->title) == 0) ? 'Advert '.$singlebanner->id.' [temp]' : $singlebanner->title;

			if($type == 'active' OR $type == '7days') {
				$active[$singlebanner->id] = array(
					'id' => $singlebanner->id,
					'title' => $title,
					'type' => $type,
					'tracker' => $singlebanner->tracker,
					'weight' => $singlebanner->weight,
					'firstactive' => $starttime,
					'lastactive' => $stoptime
				);
			}

			if($type == 'error' OR $type == 'expired' OR $type == '2days') {
				$error[$singlebanner->id] = array(
					'id' => $singlebanner->id,
					'title' => $title,
					'type' => $type,
					'tracker' => $singlebanner->tracker,
					'weight' => $singlebanner->weight,
					'firstactive' => $starttime,
					'lastactive' => $stoptime
				);
			}

			if($type == 'disabled') {
				$disabled[$singlebanner->id] = array(
					'id' => $singlebanner->id,
					'title' => $title,
					'type' => $type,
					'tracker' => $singlebanner->tracker,
					'weight' => $singlebanner->weight,
					'firstactive' => $starttime,
					'lastactive' => $stoptime
				);
			}
		}
		?>

		<div class="tablenav">
			<div class="alignleft actions">
				<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate');?>"><?php _e('Manage', 'adrotate'); ?></a>
				&nbsp;|&nbsp;<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate&view=generator');?>"><?php _e('Advert Generator', 'adrotate'); ?></a>
				&nbsp;|&nbsp;<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate&view=addnew');?>"><?php _e('New Advert', 'adrotate'); ?></a>
				&nbsp;|&nbsp;<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-pro');?>"><?php _e('Get AdRotate Pro', 'adrotate'); ?></a>
			</div>
		</div>

    	<?php
	    if ($view == "" OR $view == "manage") {
			// Show list of errorous ads if any
			if ($error) {
				include("dashboard/publisher/adverts-error.php");
			}

			include("dashboard/publisher/adverts-main.php");

			// Show disabled ads, if any
			if ($disabled) {
				include("dashboard/publisher/adverts-disabled.php");
			}
		} else if($view == "addnew" OR $view == "edit") {
			include("dashboard/publisher/adverts-edit.php");
	   	} else if($view == "generator") {
			include("dashboard/publisher/adverts-generator.php");
		}
		?>
		<br class="clear" />

		<?php adrotate_credits(); ?>

	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_manage_group
 Purpose:   Manage groups
-------------------------------------------------------------*/
function adrotate_manage_group() {
	global $wpdb, $adrotate_config;

	$status = $view = $group_edit_id = '';
	if(isset($_GET['status'])) $status = esc_attr($_GET['status']);
	if(isset($_GET['view'])) $view = esc_attr($_GET['view']);
	if(isset($_GET['group'])) $group_edit_id = esc_attr($_GET['group']);

	if(!is_numeric($status)) $status = 0;
	if(!is_numeric($group_edit_id)) $group_edit_id = 0;

	if(isset($_GET['month']) AND isset($_GET['year'])) {
		$month = esc_attr($_GET['month']);
		$year = esc_attr($_GET['year']);
	} else {
		$month = date("m");
		$year = date("Y");
	}
	$monthstart = mktime(0, 0, 0, $month, 1, $year);
	$monthend = mktime(0, 0, 0, $month+1, 0, $year);

	$today = adrotate_date_start('day');
	$now 			= current_time('timestamp');
	$today 			= adrotate_date_start('day');
	$in2days 		= $now + 172800;
	$in7days 		= $now + 604800;
	?>
	<div class="wrap">
		<h1><?php _e('Manage Groups', 'adrotate'); ?></h1>

		<?php if($status > 0) adrotate_status($status); ?>

		<div class="tablenav">
			<div class="alignleft actions">
				<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-groups&view=manage');?>"><?php _e('Manage', 'adrotate'); ?></a>
				&nbsp;|&nbsp;<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-groups&view=addnew');?>"><?php _e('Add New', 'adrotate'); ?></a>
				&nbsp;|&nbsp;<a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-pro');?>"><?php _e('Get AdRotate Pro', 'adrotate'); ?></a>
			</div>
		</div>

		<?php
		if ($view == "" OR $view == "manage") {
			include("dashboard/publisher/groups-main.php");
		} else if($view == "addnew" OR $view == "edit") {
			include("dashboard/publisher/groups-edit.php");
		}
		?>
		<br class="clear" />

		<?php adrotate_credits(); ?>

	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_manage_schedules
 Purpose:   Manage schedules for ads
-------------------------------------------------------------*/
function adrotate_manage_schedules() {
	global $wpdb, $adrotate_config;

	$now = current_time('timestamp');
	$in2days = $now + 172800;
	?>
	<div class="wrap">
		<h1><?php _e('Manage Schedules', 'adrotate'); ?></h1>

    	<?php
		include("dashboard/publisher/schedules-main.php");
		?>

		<br class="clear" />

		<?php adrotate_credits(); ?>

	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_manage_media
 Purpose:   Manage banner images for ads
-------------------------------------------------------------*/
function adrotate_manage_media() {
	global $wpdb, $adrotate_config;

	$status = $file = '';
	if(isset($_GET['status'])) $status = esc_attr($_GET['status']);
	if(isset($_GET['file'])) $file = esc_attr($_GET['file']);

	if(!is_numeric($status)) $status = 0;

	if(strlen($file) > 0 AND wp_verify_nonce($_REQUEST['_wpnonce'], 'adrotate_delete_media_'.$file)) {
		if(adrotate_unlink($file)) {
			$status = 206;
		} else {
			$status = 207;
		}
	}
	?>

	<div class="wrap">
		<h1><?php _e('Manage Media and Assets', 'adrotate'); ?></h1>

		<?php if($status > 0) adrotate_status($status); ?>

		<p><?php _e('Upload images to the AdRotate Pro banners folder from here. This is useful if you have HTML5 adverts containing multiple files.', 'adrotate'); ?></p>

		<?php
		include("dashboard/publisher/media.php");
		?>

		<br class="clear" />

		<?php adrotate_credits(); ?>

	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_statistics
 Purpose:   Advert and Group stats
-------------------------------------------------------------*/
function adrotate_statistics() {
	global $wpdb, $adrotate_config;

	$status = $view = $file = $id = '';
	if(isset($_GET['status'])) $status = esc_attr($_GET['status']);
	if(isset($_GET['view'])) $view = esc_attr($_GET['view']);
	if(isset($_GET['id'])) $id = esc_attr($_GET['id']);
	if(isset($_GET['file'])) $file = esc_attr($_GET['file']);

	if(!is_numeric($status)) $status = 0;
	if(!is_numeric($id)) $id = 0;

	if(isset($_GET['month']) AND isset($_GET['year'])) {
		$month = esc_attr($_GET['month']);
		$year = esc_attr($_GET['year']);
	} else {
		$month = date("m");
		$year = date("Y");
	}
	$monthstart = gmmktime(0, 0, 0, $month, 1, $year);
	$monthend = gmmktime(0, 0, 0, $month+1, 0, $year);
	$today = adrotate_date_start('day');
	?>
	<div class="wrap">
		<h2><?php _e('Advert Statistics', 'adrotate'); ?></h2>

		<?php if($status > 0) adrotate_status($status, array('file' => $file)); ?>

		<?php
	    if ($view == "") {
			include("dashboard/publisher/statistics-main.php");
		} else if($view == "advert") {
			include("dashboard/publisher/statistics-advert.php");
		} else if($view == "group") {
			include("dashboard/publisher/statistics-group.php");
		}
		?>
		<br class="clear" />

		<?php adrotate_credits(); ?>

	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_support
 Purpose:   Get help
-------------------------------------------------------------*/
function adrotate_support() {
	global $wpdb, $adrotate_config;

	$status = $file = '';
	if(isset($_GET['status'])) $status = esc_attr($_GET['status']);
	if(isset($_GET['file'])) $file = esc_attr($_GET['file']);

	if(!is_numeric($status)) $status = 0;
	$current_user = wp_get_current_user();

	if(adrotate_is_networked()) {
		$a = get_site_option('adrotate_activate');
	} else {
		$a = get_option('adrotate_activate');
	}
	?>

	<div class="wrap">
		<h1><?php _e('AdRotate Support', 'adrotate'); ?></h1>

		<?php if($status > 0) adrotate_status($status); ?>

		<?php
		include("dashboard/support.php");
		?>

	</div>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_options
 Purpose:   Admin options page
-------------------------------------------------------------*/
function adrotate_options() {
	global $wpdb, $wp_roles;

    $active_tab = (isset($_GET['tab'])) ? esc_attr($_GET['tab']) : 'general';
	$status = (isset($_GET['status'])) ? esc_attr($_GET['status']) : '';

	if(!is_numeric($status)) $status = 0;

	$action = (isset($_GET['action'])) ? esc_attr($_GET['action']) : '';
	if($action == 'update-db') adrotate_check_upgrade();
	if($action == 'reset-tasks') adrotate_check_schedules();
	if($action == 'disable-3rdparty') adrotate_disable_thirdparty();
	?>

	<div class="wrap">
	  	<h1><?php _e('AdRotate Settings', 'adrotate'); ?></h1>

		<?php if($status > 0) adrotate_status($status); ?>

		<h2 class="nav-tab-wrapper">
            <a href="?page=adrotate-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'adrotate'); ?></a>
            <a href="?page=adrotate-settings&tab=notifications" class="nav-tab <?php echo $active_tab == 'notifications' ? 'nav-tab-active' : ''; ?>"><?php _e('Notifications', 'adrotate'); ?></a>
            <a href="?page=adrotate-settings&tab=stats" class="nav-tab <?php echo $active_tab == 'stats' ? 'nav-tab-active' : ''; ?>"><?php _e('Statistics', 'adrotate'); ?></a>
            <a href="?page=adrotate-settings&tab=geo" class="nav-tab <?php echo $active_tab == 'geo' ? 'nav-tab-active' : ''; ?>"><?php _e('Geo Targeting', 'adrotate'); ?></a>
            <a href="?page=adrotate-settings&tab=roles" class="nav-tab <?php echo $active_tab == 'roles' ? 'nav-tab-active' : ''; ?>"><?php _e('Access Roles', 'adrotate'); ?></a>
            <a href="?page=adrotate-settings&tab=misc" class="nav-tab <?php echo $active_tab == 'misc' ? 'nav-tab-active' : ''; ?>"><?php _e('Miscellaneous', 'adrotate'); ?></a>
            <a href="?page=adrotate-settings&tab=maintenance" class="nav-tab <?php echo $active_tab == 'maintenance' ? 'nav-tab-active' : ''; ?>"><?php _e('Maintenance', 'adrotate'); ?></a>
        </h2>

		<?php
		$adrotate_config = get_option('adrotate_config');

		if($active_tab == 'general') {
			$adrotate_crawlers = get_option('adrotate_crawlers');

			$crawlers = '';
			if(is_array($adrotate_crawlers)) {
				$crawlers = implode(', ', $adrotate_crawlers);
			}

			include("dashboard/settings/general.php");
		} elseif($active_tab == 'notifications') {
			$adrotate_notifications	= get_option("adrotate_notifications");
			include("dashboard/settings/notifications.php");
		} elseif($active_tab == 'stats') {
			include("dashboard/settings/statistics.php");
		} elseif($active_tab == 'geo') {
			include("dashboard/settings/geotargeting.php");
		} elseif($active_tab == 'roles') {
			include("dashboard/settings/roles.php");
		} elseif($active_tab == 'misc') {
			include("dashboard/settings/misc.php");
		} elseif($active_tab == 'maintenance') {
			$adrotate_version = get_option('adrotate_version');
			$adrotate_db_version = get_option('adrotate_db_version');
			$advert_status	= get_option("adrotate_advert_status");

			$adevaluate = wp_next_scheduled('adrotate_evaluate_ads');
			$adschedule = wp_next_scheduled('adrotate_notification');
			$tracker = wp_next_scheduled('adrotate_empty_trackerdata');

			include("dashboard/settings/maintenance.php");
		} elseif($active_tab == 'license') {
			$adrotate_is_networked = adrotate_is_networked();
			$adrotate_hide_license = get_option('adrotate_hide_license');
			if($adrotate_is_networked) {
				$adrotate_activate = get_site_option('adrotate_activate');
			} else {
				$adrotate_activate = get_option('adrotate_activate');
			}

			include("dashboard/settings/license.php");
		}
		?>

		<br class="clear" />

		<?php adrotate_credits(); ?>

	</div>
<?php
}
?>
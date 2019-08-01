<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2019 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      adrotate_is_networked
 Purpose:   Determine if AdRotate is network activated
 Since:		3.9.8
-------------------------------------------------------------*/
function adrotate_is_networked() {
	if(!function_exists('is_plugin_active_for_network')) require_once(ABSPATH.'/wp-admin/includes/plugin.php');
	 
	if(is_plugin_active_for_network('adrotate/adrotate.php')) {
		return true;
	}		
	return false;
}

/*-------------------------------------------------------------
 Name:      adrotate_is_human
 Purpose:   Check if visitor is a bot
 Since:		3.11.10
-------------------------------------------------------------*/
function adrotate_is_human() {
	global $adrotate_crawlers;

	if(is_array($adrotate_crawlers)) {
		$crawlers = $adrotate_crawlers;
	} else {
		$crawlers = array();
	}

	if(isset($_SERVER['HTTP_USER_AGENT'])) {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$useragent = trim($useragent, ' \t\r\n\0\x0B');
	} else {
		$useragent = '';
	}

	$nocrawler = array(true);
	if(strlen($useragent) > 0) {
		foreach($crawlers as $key => $crawler) {
			if(preg_match('/'.$crawler.'/i', $useragent)) $nocrawler[] = false;
		}
	}
	$nocrawler = (!in_array(false, $nocrawler)) ? true : false; // If no bool false in array it's not a bot
	
	// Returns true if no bot.
	return $nocrawler;
}

/*-------------------------------------------------------------
 Name:      adrotate_filter_schedule

 Purpose:   Weed out ads that are over the limit of their schedule
 Receive:   $selected, $banner
 Return:    $selected
 Since:		3.6.11
-------------------------------------------------------------*/
function adrotate_filter_schedule($selected, $banner) { 
	global $wpdb, $adrotate_config, $adrotate_debug;

	$now = adrotate_now();

	if($adrotate_debug['general'] == true) {
		echo "<p><strong>[DEBUG][adrotate_filter_schedule()] Filtering banner</strong><pre>";
		print_r($banner->id); 
		echo "</pre></p>"; 
	}
	
	// Get schedules for advert
	$schedules = $wpdb->get_results("SELECT `{$wpdb->prefix}adrotate_schedule`.`id`, `starttime`, `stoptime`, `maxclicks`, `maximpressions` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` AND `ad` = '".$banner->id."' ORDER BY `starttime` ASC LIMIT 1;");
	$schedule = $schedules[0];
	
	if($adrotate_debug['general'] == true) {
		echo "<p><strong>[DEBUG][adrotate_filter_schedule] Ad ".$banner->id." - Has schedule (id: ".$schedule->id.")</strong><pre>";
		echo "<br />Start: ".$schedule->starttime." (".date("F j, Y, g:i a", $schedule->starttime).")";
		echo "<br />End: ".$schedule->stoptime." (".date("F j, Y, g:i a", $schedule->stoptime).")";
		echo "</pre></p>";
	}

	if($now < $schedule->starttime OR $now > $schedule->stoptime) {
		unset($selected[$banner->id]);
	} else {
		if($adrotate_config['stats'] == 1 AND $banner->tracker == "Y") {
			$stat = adrotate_stats($banner->id, $schedule->starttime, $schedule->stoptime);

			if($stat['clicks'] >= $schedule->maxclicks AND $schedule->maxclicks > 0) {
				unset($selected[$banner->id]);
			}

			if($stat['impressions'] >= $schedule->maximpressions AND $schedule->maximpressions > 0) {
				unset($selected[$banner->id]);
			}
		}
	}
	
	return $selected;
} 

/*-------------------------------------------------------------
 Name:      adrotate_array_unique

 Purpose:   Filter out duplicate records in multidimensional arrays
 Receive:   $array
 Return:    $array|$return
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_array_unique($array) {
	if(count($array) > 0) {
		if(is_array($array[0])) {
			$return = array();
			// multidimensional
			foreach($array as $row) {
				if(!in_array($row, $return)) {
					$return[] = $row;
				}
			}
			return $return;
		} else {
			// not multidimensional
			return array_unique($array);
		}
	} else {
		return $array;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_rand

 Purpose:   Generate a random string
 Receive:   $length
 Return:    $result
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_rand($length = 8) {
	$available_chars = "abcdefghijklmnopqrstuvwxyz";	

	$result = '';
	$size = strlen($available_chars);
	for($i = 0; $i < $length; $i++) {
		$result .= $available_chars[rand(0, $size - 1)];
	}

	return $result;
}

/*-------------------------------------------------------------
 Name:      adrotate_shuffle

 Purpose:   Randomize and slice an array but keep keys intact
 Receive:   $array
 Return:    $shuffle
 Since:		3.8.8.3
-------------------------------------------------------------*/
function adrotate_shuffle($array) { 
	if(!is_array($array)) return $array; 
	$keys = array_keys($array); 
	shuffle($keys);
	
	$shuffle = array(); 
	foreach($keys as $key) {
		$shuffle[$key] = $array[$key];
	}
	return $shuffle; 
}

/*-------------------------------------------------------------
 Name:      adrotate_select_categories

 Purpose:   Create scrolling menu of all categories.
 Receive:   $savedcats, $count, $child_of, $parent
 Return:    $output
 Since:		3.8.4
-------------------------------------------------------------*/
function adrotate_select_categories($savedcats, $count = 2, $child_of = 0, $parent = 0) {
	if(!is_array($savedcats)) $savedcats = explode(',', $savedcats);
	$categories = get_categories(array('child_of' => $parent, 'parent' => $parent,  'orderby' => 'id', 'order' => 'asc', 'hide_empty' => 0));

	if(!empty($categories)) {
		$output = '';
		if($parent == 0) {
			$output .= '<table width="100%">';
			$output .= '<thead>';
			$output .= '<tr><td class="check-column" style="padding: 0px;"><input type="checkbox" /></td><td style="padding: 0px;">Select All</td></tr>';
			$output .= '</thead>';
			$output .= '<tbody>';
		}
		foreach($categories as $category) {
			if($category->parent > 0) {
				if($category->parent != $child_of) {
					$count = $count + 1;
				}
				$indent = '&nbsp;'.str_repeat('-', $count * 2).'&nbsp;';
			} else {
				$indent = '';
			}
			$output .= '<tr>';

			$output .= '<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_categories[]" value="'.$category->cat_ID.'"';
			$output .= (in_array($category->cat_ID, $savedcats)) ? ' checked' : '';
			$output .= '></td><td style="padding: 0px;">'.$indent.$category->name.' ('.$category->category_count.')</td>';

			$output .= '</tr>';
			$output .= adrotate_select_categories($savedcats, $count, $category->parent, $category->cat_ID);
			$child_of = $parent;
		}
		if($parent == 0) {
			$output .= '</tbody></table>';
		}
		return $output;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_select_pages

 Purpose:   Create scrolling menu of all pages.
 Receive:   $savedpages, $count, $child_of, $parent
 Return:    $output
 Since:		3.8.4
-------------------------------------------------------------*/
function adrotate_select_pages($savedpages, $count = 2, $child_of = 0, $parent = 0) {
	if(!is_array($savedpages)) $savedpages = explode(',', $savedpages);
	$pages = get_pages(array('child_of' => $parent, 'parent' => $parent, 'sort_column' => 'ID', 'sort_order' => 'asc'));

	if(!empty($pages)) {
		$output = '';
		if($parent == 0) {
			$output = '<table width="100%">';
			if(count($pages) > 5) {
				$output .= '<thead><tr><td class="check-column" style="padding: 0px;"><input type="checkbox" /></td><td style="padding: 0px;">Select All</td></tr></thead>';
			}
			$output .= '<tbody>';
		}
		foreach($pages as $page) {
			if($page->post_parent > 0) {
				if($page->post_parent != $child_of) {
					$count = $count + 1;
				}
				$indent = '&nbsp;'.str_repeat('-', $count * 2).'&nbsp;';
			} else {
				$indent = '';
			}
			$output .= '<tr>';
			$output .= '<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_pages[]" value="'.$page->ID.'"';
			if(in_array($page->ID, $savedpages)) {
				$output .= ' checked';
			}
			$output .= '></td><td style="padding: 0px;">'.$indent.$page->post_title.'</td>';
			$output .= '</tr>';
			$output .= adrotate_select_pages($savedpages, $count, $page->post_parent, $page->ID);
			$child_of = $parent;
		}
		if($parent == 0) {
			$output .= '</tbody></table>';
		}
		return $output;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_prepare_evaluate_ads

 Purpose:   Initiate evaluations for errors and determine the ad status
 Receive:   $return, $id
 Return:    
 Since:		3.6.5
-------------------------------------------------------------*/
function adrotate_prepare_evaluate_ads($return = true) {
	global $wpdb;
	
	// Fetch ads
	$ads = $wpdb->get_results("SELECT `id` FROM `{$wpdb->prefix}adrotate` WHERE `type` != 'disabled' AND `type` != 'generator' AND `type` != 'empty' ORDER BY `id` ASC;");

	// Determine error states
	$error = $expired = $expiressoon = $normal = $unknown = 0;
	foreach($ads as $ad) {
		$result = adrotate_evaluate_ad($ad->id);
		if($result == 'error') {
			$error++;
			$wpdb->query("UPDATE `{$wpdb->prefix}adrotate` SET `type` = 'error' WHERE `id` = '".$ad->id."';");
		} 

		if($result == 'expired') {
			$expired++;
			$wpdb->query("UPDATE `{$wpdb->prefix}adrotate` SET `type` = 'expired' WHERE `id` = '".$ad->id."';");
		} 
		
		if($result == '2days') {
			$expiressoon++;
			$wpdb->query("UPDATE `{$wpdb->prefix}adrotate` SET `type` = '2days' WHERE `id` = '".$ad->id."';");
		}
		
		if($result == '7days') {
			$normal++;
			$wpdb->query("UPDATE `{$wpdb->prefix}adrotate` SET `type` = '7days' WHERE `id` = '".$ad->id."';");
		}
		
		if($result == 'active') {
			$normal++;
			$wpdb->query("UPDATE `{$wpdb->prefix}adrotate` SET `type` = 'active' WHERE `id` = '".$ad->id."';");
		}
		
		if($result == 'unknown') {
			$unknown++;
		}
	}

	$result = array('error' => $error, 'expired' => $expired, 'expiressoon' => $expiressoon, 'normal' => $normal, 'unknown' => $unknown);
	update_option('adrotate_advert_status', $result);
	if($return) adrotate_return('adrotate-settings', 405, array('tab' => 'maintenance'));
}

/*-------------------------------------------------------------
 Name:      adrotate_evaluate_ads

 Purpose:   Initiate automated evaluations for errors and determine the ad status
 Receive:   -None-
 Return:    -None-
 Since:		3.8.5.1
-------------------------------------------------------------*/
function adrotate_evaluate_ads() {
	// Verify all ads
	adrotate_prepare_evaluate_ads(false);
}

/*-------------------------------------------------------------
 Name:      adrotate_evaluate_ad

 Purpose:   Evaluates ads for errors
 Receive:   $ad_id
 Return:    boolean
 Since:		3.6.5
-------------------------------------------------------------*/
function adrotate_evaluate_ad($ad_id) {
	global $wpdb, $adrotate_config;
	
	$now = adrotate_now();
	$in2days = $now + 172800;
	$in7days = $now + 604800;

	// Fetch ad
	$ad = $wpdb->get_row($wpdb->prepare("SELECT `id`, `bannercode`, `tracker`, `imagetype`, `image` FROM `{$wpdb->prefix}adrotate` WHERE `id` = %d;", $ad_id));
	$stoptime = $wpdb->get_var("SELECT `stoptime` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '{$ad->id}' AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `stoptime` DESC LIMIT 1;");
	$schedules = $wpdb->get_var("SELECT COUNT(`schedule`) FROM `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '".$ad->id."' AND `group` = 0 AND `user` = 0;");

	$bannercode = stripslashes(htmlspecialchars_decode($ad->bannercode, ENT_QUOTES));
	// Determine error states
	if(
		strlen($bannercode) < 1 // AdCode empty
		OR (!preg_match_all('/<(a|script|embed|iframe)[^>](.*?)>/i', $bannercode, $things) AND $ad->tracker == 'Y') // Clicktracking active but no valid link/tag present
		OR (preg_match_all("/(%image%|%asset%)/i", $bannercode, $things) AND $ad->image == '' AND $ad->imagetype == '') // Did use %image% but didn't select an image
		OR (!preg_match_all("/(%image%|%asset%)/i", $bannercode, $things) AND $ad->image != '' AND $ad->imagetype != '') // Didn't use %image% but selected an image
		OR (($ad->image == '' AND $ad->imagetype != '') OR ($ad->image != '' AND $ad->imagetype == '')) // Image and Imagetype mismatch
		OR $schedules == 0 // No Schedules for this ad
	) {
		return 'error';
	} else if(
		$stoptime <= $now // Past the enddate
	){
		return 'expired';
	} else if(
		$stoptime <= $in2days AND $stoptime >= $now // Expires in 2 days
	){
		return '2days';
	} else if(
		$stoptime <= $in7days AND $stoptime >= $now	// Expires in 7 days
	){
		return '7days';
	} else {
		return 'active';
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_prepare_color

 Purpose:   Check if ads are expired and set a color for its end date
 Receive:   $banner_id
 Return:    $result
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_prepare_color($enddate) {
	$now = adrotate_now();
	$in2days = $now + 172800;
	$in7days = $now + 604800;
	
	if($enddate <= $now) {
		return '#CC2900'; // red
	} else if($enddate <= $in2days AND $enddate >= $now) {
		return '#F90'; // orange
	} else if($enddate <= $in7days AND $enddate >= $now) {
		return '#E6B800'; // yellow
	} else {
		return '#009900'; // green
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_ad_is_in_groups

 Purpose:   Build list of groups the ad is in (overview)
 Receive:   $id
 Return:    $output
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_ad_is_in_groups($id) {
	global $wpdb;

	$output = '';
	$groups	= $wpdb->get_results("
		SELECT 
			`{$wpdb->prefix}adrotate_groups`.`name` 
		FROM 
			`{$wpdb->prefix}adrotate_groups`, 
			`{$wpdb->prefix}adrotate_linkmeta` 
		WHERE 
			`{$wpdb->prefix}adrotate_linkmeta`.`ad` = '".$id."'
			AND `{$wpdb->prefix}adrotate_linkmeta`.`group` = `{$wpdb->prefix}adrotate_groups`.`id`
			AND `{$wpdb->prefix}adrotate_linkmeta`.`user` = 0
		;");
	if($groups) {
		foreach($groups as $group) {
			$output .= $group->name.", ";
		}
	}
	$output = rtrim($output, ", ");
	
	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_hash
 Purpose:   Generate the adverts clicktracking hash
 Since:		3.9.12
-------------------------------------------------------------*/
function adrotate_hash($ad, $group = 0, $blog_id = 0) {
	global $adrotate_debug, $adrotate_config;
	
	if($adrotate_debug['timers'] == true) {
		$timer = 0;
	} else {
		$timer = $adrotate_config['impression_timer'];
	}
		
	if($adrotate_debug['track'] == true) {
		return "$ad,$group,$blog_id,$timer";
	} else {
		return base64_encode("$ad,$group,$blog_id,$timer");
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_get_remote_ip
 Purpose:   Get the remote IP from the visitor
 Since:		3.6.2
-------------------------------------------------------------*/
function adrotate_get_remote_ip(){
	if(empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$remote_ip = $_SERVER["REMOTE_ADDR"];
	} else {
		$remote_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	$buffer = explode(',', $remote_ip, 2);

	return $buffer[0];
}

/*-------------------------------------------------------------
 Name:      adrotate_apply_jetpack_photon
 Purpose:   Use Jetpack Photon if possible
 Since:		4.11
-------------------------------------------------------------*/
function adrotate_apply_jetpack_photon($image) {
	if(class_exists('Jetpack_Photon') AND Jetpack::is_module_active('photon') AND function_exists('jetpack_photon_url')) {
		return jetpack_photon_url($image);
	} else {
		return $image;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_get_sorted_roles
 Purpose:   Returns all roles and capabilities, sorted by user level. Lowest to highest.
 Since:		3.2
-------------------------------------------------------------*/
function adrotate_get_sorted_roles() {	
	global $wp_roles;

	$editable_roles = apply_filters('editable_roles', $wp_roles->roles);
	$sorted = array();
	
	foreach($editable_roles as $role => $details) {
		$sorted[$details['name']] = get_role($role);
	}

	$sorted = array_reverse($sorted);

	return $sorted;
}

/*-------------------------------------------------------------
 Name:      adrotate_set_capability
 Purpose:   Grant or revoke capabilities to a role and all higher roles
 Since:		3.2
-------------------------------------------------------------*/
function adrotate_set_capability($lowest_role, $capability){
	$check_order = adrotate_get_sorted_roles();
	$add_capability = false;
	
	foreach($check_order as $role) {
		if($lowest_role == $role->name) $add_capability = true;
		if(empty($role)) continue;
		$add_capability ? $role->add_cap($capability) : $role->remove_cap($capability) ;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_remove_capability
 Purpose:   Remove the $capability from the all roles
 Since:		3.2
-------------------------------------------------------------*/
function adrotate_remove_capability($capability){
	$check_order = adrotate_get_sorted_roles();

	foreach($check_order as $role) {
		$role = get_role($role->name);
		$role->remove_cap($capability);
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_dashboard_scripts
 Purpose:   Load file uploaded popup
 Since:		3.6
-------------------------------------------------------------*/
function adrotate_dashboard_scripts() {
	$page = (isset($_GET['page'])) ? $_GET['page'] : '';
    if(strpos($page, 'adrotate') !== false) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('raphael', plugins_url('/library/raphael-min.js', __FILE__), array('jquery'));
		wp_enqueue_script('elycharts', plugins_url('/library/elycharts.min.js', __FILE__), array('jquery', 'raphael'));
		wp_enqueue_script('textatcursor', plugins_url('/library/textatcursor.js', __FILE__));
		wp_enqueue_script('tablesorter', plugins_url('/library/jquery.tablesorter.min.js', __FILE__), array('jquery'));
		wp_enqueue_script('adrotate-tablesorter', plugins_url('/library/jquery.adrotate.tablesorter.js', __FILE__), array('jquery', 'tablesorter'));
		wp_enqueue_script('adrotate-datepicker', plugins_url('/library/jquery.adrotate.datepicker.js', __FILE__), array('jquery'));
	}

	// WP Pointers
	$seen_it = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
	if(!in_array('adrotatefree_'.ADROTATE_VERSION.ADROTATE_DB_VERSION, $seen_it)) {
		wp_enqueue_script('wp-pointer');
		add_action('admin_print_footer_scripts', 'adrotate_welcome_pointer');
    }
}

/*-------------------------------------------------------------
 Name:      adrotate_dashboard_styles

 Purpose:   Load file uploaded popup
 Receive:   -None-
 Return:	-None-
 Since:		3.6
-------------------------------------------------------------*/
function adrotate_dashboard_styles() {
	wp_enqueue_style('adrotate-admin-stylesheet', plugins_url('library/dashboard.css', __FILE__));

	$page = (isset($_GET['page'])) ? $_GET['page'] : '';
    if(strpos($page, 'adrotate') !== false) {
		wp_enqueue_style('jquery-ui-datepicker');
	}

	// WP Pointers
	$seen_it = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
	if(!in_array('adrotatefree_'.ADROTATE_VERSION.ADROTATE_DB_VERSION, $seen_it)) {
		wp_enqueue_style('wp-pointer');
    }
}

/*-------------------------------------------------------------
 Name:      adrotate_folder_contents
 Purpose:   Populate dropdown menu for creating adverts with relevant assets
 Since:		0.4
-------------------------------------------------------------*/
function adrotate_folder_contents($current, $kind = 'all') {
	global $wpdb, $adrotate_config;

	$output = '';
	$asset_folder = WP_CONTENT_DIR."/".$adrotate_config['banner_folder'];
	$files = array();

	// Read Banner folder
	if($handle = opendir($asset_folder)) {
		if($kind == "image") {
			$extensions = array('jpg', 'jpeg', 'gif', 'png');
		} else if($kind == "html5") {
			$extensions = array('swf', 'flv', 'html', 'htm');
		} else {
			$extensions = array('jpg', 'jpeg', 'gif', 'png', 'swf', 'flv', 'html', 'htm');
		}

	    while (false !== ($file = readdir($handle))) {
	        if($file != "." AND $file != ".." AND $file != "index.php" AND $file != ".DS_Store" AND !is_dir($asset_folder.'/'.$file)) {
				$files[] = $file;
	        }
	    }
	    closedir($handle);

		$i = count($files);
	    if($i > 0) {
			sort($files);
			foreach($files as $file) {
				$fileinfo = pathinfo($file);
				if(in_array($fileinfo['extension'], $extensions)) {
				    $output .= "<option value='".$file."'";
				    if(($current == WP_CONTENT_URL.'/banners/'.$file) OR ($current == WP_CONTENT_URL."/%folder%/".$file)) { $output .= "selected"; }
				    $output .= ">".$file."</option>";
				}
			}
		} else {
	    	$output .= "<option disabled>&nbsp;&nbsp;&nbsp;".__('No files found', 'adrotate')."</option>";
		}
	} else {
    	$output .= "<option disabled>&nbsp;&nbsp;&nbsp;".__('Folder not found or not accessible', 'adrotate')."</option>";
	}
	
	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_subfolder_contents
 Purpose:   List sub-folder contents for media manager
 Since:		4.9
-------------------------------------------------------------*/
function adrotate_subfolder_contents($asset_folder, $level = 1) {
	$index = $assets = array();

	// Read Banner folder
	if($handle = opendir($asset_folder)) {
	    while(false !== ($file = readdir($handle))) {
	        if($file != "." AND $file != ".." AND $file != "index.php" AND $file != ".DS_Store") {
	            $assets[] = $file;
	        }
	    }
	    closedir($handle);

	    if(count($assets) > 0) {
			$new_level = $level + 1;
			$extensions = array('jpg', 'jpeg', 'gif', 'png', 'swf', 'flv', 'html', 'htm', 'js');

			foreach($assets as $key => $asset) {
				$fileinfo = pathinfo($asset);
				unset($fileinfo['dirname']);
				if(is_dir($asset_folder.'/'.$asset)) { // Read subfolder
					if($level <= 2) { // Not to deep
						$fileinfo['contents'] = adrotate_subfolder_contents($asset_folder.'/'.$asset, $new_level);
						$index[] = $fileinfo;
					}
				} else { // It's a file
					if(in_array($fileinfo['extension'], $extensions)) {
						$index[] = $fileinfo;
					}
				}
				unset($fileinfo);
			}
			unset($level, $new_level);
		}
	}
	
	return $index;
}

/*-------------------------------------------------------------
 Name:      adrotate_return
 Purpose:   Internal redirects
 Since:		3.12
-------------------------------------------------------------*/
function adrotate_return($page, $status, $args = null) {
	if(strlen($page) > 0 AND ($status > 0 AND $status < 1000)) {
		$defaults = array(
			'status' => $status
		);
		$arguments = wp_parse_args($args, $defaults);
		$redirect = 'admin.php?page=' . $page . '&'.http_build_query($arguments);
	} else {
		$redirect = 'admin.php?page=adrotate&status=1'; // Unexpected error
	}

	wp_redirect($redirect);
}

/*-------------------------------------------------------------
 Name:      adrotate_status
 Purpose:   Internal redirects
 Since:		3.12
-------------------------------------------------------------*/
function adrotate_status($status, $args = null) {

	$defaults = array(
		'ad' => '',
		'group' => '',
		'file' => ''
	);
	$arguments = wp_parse_args($args, $defaults);

	switch($status) {
		// Management messages
		case '200' :
			echo '<div id="message" class="updated"><p>'. __('Ad saved', 'adrotate') .'</p></div>';
		break;

		case '201' :
			echo '<div id="message" class="updated"><p>'. __('Group saved', 'adrotate') .'</p></div>';
		break;

		case '203' :
			echo '<div id="message" class="updated"><p>'. __('Ad(s) deleted', 'adrotate') .'</p></div>';
		break;

		case '204' :
			echo '<div id="message" class="updated"><p>'. __('Group deleted', 'adrotate') .'</p></div>';
		break;

		case '208' :
			echo '<div id="message" class="updated"><p>'. __('Ad(s) statistics reset', 'adrotate') .'</p></div>';
		break;

		case '209' :
			echo '<div id="message" class="updated"><p>'. __('Ad(s) renewed', 'adrotate') .'</p></div>';
		break;

		case '210' :
			echo '<div id="message" class="updated"><p>'. __('Ad(s) deactivated', 'adrotate') .'</p></div>';
		break;

		case '211' :
			echo '<div id="message" class="updated"><p>'. __('Ad(s) activated', 'adrotate') .'</p></div>';
		break;

		case '213' :
			echo '<div id="message" class="updated"><p>'. __('Group including it\'s Ads deleted', 'adrotate') .'</p></div>';
		break;

		case '215' :
			echo '<div id="message" class="updated"><p>'. __('Export created', 'adrotate') .'. <a href="' . WP_CONTENT_URL . '/reports/'.$arguments['file'].'">Download</a>.</p></div>';
		break;

		case '226' :
			echo '<div id="message" class="updated"><p>'. __('Advert HTML generated and placed in the AdCode field. Configure your advert below.', 'adrotate') .'</div>';
		break;

		// Settings
		case '400' :
			echo '<div id="message" class="updated"><p>'. __('Settings saved', 'adrotate') .'</p></div>';
		break;

		case '403' :
			echo '<div id="message" class="updated"><p>'. __('Database optimized', 'adrotate') .'</p></div>';
		break;

		case '404' :
			echo '<div id="message" class="updated"><p>'. __('Database repaired', 'adrotate') .'</p></div>';
		break;

		case '405' :
			echo '<div id="message" class="updated"><p>'. __('Ads evaluated and statuses have been corrected where required', 'adrotate') .'</p></div>';
		break;

		case '406' :
			echo '<div id="message" class="updated"><p>'. __('Cleanup complete', 'adrotate') .'</p></div>';
		break;

		// (all) Error messages
		case '500' :
			echo '<div id="message" class="error"><p>'. __('Action prohibited', 'adrotate') .'</p></div>';
		break;

		case '501' :
			echo '<div id="message" class="error"><p>'. __('The ad was saved but has an issue which might prevent it from working properly. Review the colored ad.', 'adrotate') .'</p></div>';
		break;

		case '503' :
			echo '<div id="message" class="error"><p>'. __('No data found in selected time period', 'adrotate') .'</p></div>';
		break;

		case '504' :
			echo '<div id="message" class="error"><p>'. __('Database can only be optimized or cleaned once every hour', 'adrotate') .'</p></div>';
		break;

		case '505' :
			echo '<div id="message" class="error"><p>'. __('Form can not be (partially) empty!', 'adrotate') .'</p></div>';
		break;

		case '509' :
			echo '<div id="message" class="updated"><p>'. __('No ads found.', 'adrotate') .'</p></div>';
		break;
		
		default :
			echo '<div id="message" class="updated"><p>'. __('Unexpected error', 'adrotate') .'</p></div>';			
		break;
	}
	
	unset($arguments, $args);
}
?>
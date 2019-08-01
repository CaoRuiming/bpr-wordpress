<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      adrotate_draw_graph

 Purpose:   Draw graph using ElyCharts
 Receive:   $id, $labels, $clicks, $impressions
 Return:    -None-
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_draw_graph($id = 0, $labels = 0, $clicks = 0, $impressions = 0) {

	if($id == 0 OR !is_numeric($id) OR strlen($labels) < 1 OR strlen($clicks) < 1 OR strlen($impressions) < 1) {
		echo 'Syntax error, graph can not de drawn!';
		echo 'id '.$id;
		echo ' labels '.$labels;
		echo ' clicks '.$clicks;
		echo ' impressions '.$impressions;
	} else {
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#chart-'.$id.'").chart({ 
			    type: "line",
			    margins: [5, 45, 45, 45],
		        values: {
		            serie1: ['.$clicks.'], serie2: ['.$impressions.']
		        },
        		labels: ['.$labels.'],
			    tooltips: function(env, serie, index, value, label) {
			        return "<div class=\"adrotate_label\">" + label + "<br /><span class=\"adrotate_clicks\">Clicks:</span> " + env.opt.values[\'serie1\'][index] + "<br /><span class=\"adrotate_impressions\">Impressions:</span> " + env.opt.values[\'serie2\'][index] + "</div>";
			    },
			    defaultSeries: {
					plotProps: { "stroke-width": 3 }, dot: true, rounded: true, dotProps: { stroke: "white", size: 5, "stroke-width": 1, opacity: 0 }, highlight: { scaleSpeed: 0, scaleEasing: "", scale: 1.2, newProps: { opacity: 1 } }, tooltip: { height: 55, width: 120, padding: [0], offset: [-10, -10], frameProps: { opacity: 0.95, stroke: "#000" } }
			    },
			    series: {
			        serie1: {
			            fill: true, fillProps: { opacity: .1 }, color: "#26B",
			        },
			        serie2: {
			            axis: "r", color: "#F80", plotProps: { "stroke-width": 2 }, dotProps: { stroke: "white", size: 3, "stroke-width": 1 }
			        }
			
			    },
			    defaultAxis: {
			        labels: true, labelsProps: { fill: "#777", "font-size": "10px", }, labelsAnchor: "start", labelsMargin: 5, labelsDistance: 8, labelsRotate: 65
			    },
 			    axis: {
			        l: { // left axis
			            labels: true, labelsSkip: 1, labelsAnchor: "end", labelsMargin: 15, labelsDistance: 4, labelsProps: { fill: "#26B", "font-size": "11px", "font-weight": "bold" }
			        },
			        r: { // right axis
			            labels: true, labelsSkip: 1, labelsAnchor: "start", labelsMargin: 15, labelsDistance: 4, labelsProps: { fill: "#F80", "font-size": "11px", "font-weight": "bold" }
			        }
			    },
			    features: {
			        mousearea: {
			            type: "axis"
			        },
			        tooltip: {
			            positionHandler: function(env, tooltipConf, mouseAreaData, suggestedX, suggestedY) {
			                return [mouseAreaData.event.pageX, mouseAreaData.event.pageY, true]
			            }
			        },
			        grid: {
			            draw: true, // draw both x and y grids
			            forceBorder: [true, true, true, true], // force grid for external border
			            props: {
			                stroke: "#eee" // color for the grid
			            }
			        }
			    }
			});
		});
		</script>
		';
	}

}

/*-------------------------------------------------------------
 Name:      adrotate_stats
 Purpose:   Generate latest number of clicks and impressions
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_stats($ad, $archive = false, $when = 0, $until = 0) {
	global $wpdb;

	if($when > 0 AND is_numeric($when) AND $until > 0 AND is_numeric($until)) { // date range
		$whenquery = " AND `thetime` >= '$when' AND `thetime` <= '$until' GROUP BY `ad` ASC";
	} else if($when > 0 AND is_numeric($when) AND $until == 0) { // one day
		$until = $when + 86400;
		$whenquery =  " AND `thetime` >= '$when' AND `thetime` <= '$until'";
	} else { // everything
		$whenquery = "";
	}

	$ad_query = '';
	if(is_array($ad)) {
		$ad_query .= '(';
		foreach($ad as $key => $value) {
			$ad_query .= '`ad` = '.$value.' OR ';
		}
		$ad_query = rtrim($ad_query, " OR ");
		$ad_query .= ')';
	} else {
		$ad_query = '`ad` = '.$ad;
	}

	$cachekey = "adrotate_stats_".md5($ad_query.$whenquery);
	$stats = wp_cache_get($cachekey);
	if(false === $stats) { 
		$stats = $wpdb->get_row("SELECT SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}adrotate_stats` WHERE {$ad_query}{$whenquery};", ARRAY_A);
		wp_cache_set($cachekey, $stats, '', 300);
	}
	unset($cachekey);

	if(empty($stats['clicks'])) $stats['clicks'] = '0';
	if(empty($stats['impressions'])) $stats['impressions'] = '0';

	return $stats;
}

/*-------------------------------------------------------------
 Name:      adrotate_stats_nav

 Purpose:   Create browsable links for graph
 Receive:   $type, $id, $month, $year
 Return:    $nav
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_stats_nav($type, $id, $month, $year) {
	global $wpdb;

	$lastmonth = $month-1;
	$nextmonth = $month+1;
	$lastyear = $nextyear = $year;
	if($month == 1) {
		$lastmonth = 12;
		$lastyear = $year - 1;
	}
	if($month == 12) {
		$nextmonth = 1;
		$nextyear = $year + 1;
	}
	$months = array(__('January', 'adrotate'), __('February', 'adrotate'), __('March', 'adrotate'), __('April', 'adrotate'), __('May', 'adrotate'), __('June', 'adrotate'), __('July', 'adrotate'), __('August', 'adrotate'), __('September', 'adrotate'), __('October', 'adrotate'), __('November', 'adrotate'), __('December', 'adrotate'));
	
	$page = '';
	if($type == 'ads') $page = 'adrotate-statistics&view=advert&id='.$id;
	if($type == 'groups') $page = 'adrotate-statistics&view=group&id='.$id;
	if($type == 'fullreport') $page = 'adrotate-statistics';
	if($type == 'advertiser') $page = 'adrotate-advertiser&view=report&ad='.$id;
	if($type == 'advertiserfull') $page = 'adrotate-advertiser';
	
	$nav = '<a href="admin.php?page='.$page.'&month='.$lastmonth.'&year='.$lastyear.'">&lt;&lt; '.__('Previous', 'adrotate').'</a> - ';
	$nav .= '<strong>'.$months[$month-1].' '.$year.'</strong> - ';
	$nav .= '(<a href="admin.php?page='.$page.'">'.__('This month', 'adrotate').'</a>) - ';
	$nav .= '<a href="admin.php?page='.$page.'&month='.$nextmonth.'&year='.$nextyear.'">'. __('Next', 'adrotate').' &gt;&gt;</a>';
	
	return $nav;
}

/*-------------------------------------------------------------
 Name:      adrotate_stats_graph

 Purpose:   Generate graph
 Receive:   $type, $id, $chartid, $start, $end
 Return:    $output
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_stats_graph($type, $archive = false, $id, $chartid, $start, $end, $height = 300) {
	global $wpdb;

	$table = 'adrotate_stats';
	if($archive) {
		$table = 'adrotate_stats_archive';
	}

	if($type == 'ads' OR $type == 'advertiser') {
		$stats = $wpdb->get_results($wpdb->prepare("SELECT `thetime`, SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}{$table}` WHERE `ad` = %d AND `thetime` >= %d AND `thetime` <= %d GROUP BY `thetime` ASC;", $id, $start, $end), ARRAY_A);
	}

	if($type == 'groups') {
		$stats = $wpdb->get_results($wpdb->prepare("SELECT `thetime`, SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}{$table}` WHERE `group` = %d AND `thetime` >= %d AND `thetime` <= %d GROUP BY `thetime` ASC;", $id, $start, $end), ARRAY_A);
	}

	if($type == 'fullreport') {
		$stats = $wpdb->get_results($wpdb->prepare("SELECT `thetime`, SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}{$table}` WHERE `thetime` >= %d AND `thetime` <= %d GROUP BY `thetime` ASC;", $start, $end), ARRAY_A);
	}
	
	if($type == 'advertiserfull') {
		$stats = $wpdb->get_results($wpdb->prepare("SELECT `thetime`, SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}{$table}`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `{$wpdb->prefix}adrotate_stats`.`ad` = `{$wpdb->prefix}adrotate_linkmeta`.`ad` AND `{$wpdb->prefix}adrotate_linkmeta`.`user` = %d AND `{$wpdb->prefix}adrotate_stats`.`thetime` >= %d AND `{$wpdb->prefix}adrotate_stats`.`thetime` <= %d GROUP BY `thetime` ASC;", $id, $start, $end), ARRAY_A);
	}

	if($stats) {
		$dates = $clicks = $impressions = '';

		foreach($stats as $result) {
			if(empty($result['clicks'])) $result['clicks'] = '0';
			if(empty($result['impressions'])) $result['impressions'] = '0';
			
			$dates .= ',"'.date_i18n("d M", $result['thetime']).'"';
			$clicks .= ','.$result['clicks'];
			$impressions .= ','.$result['impressions'];
		}

		$dates = trim($dates, ",");
		$clicks = trim($clicks, ",");
		$impressions = trim($impressions, ",");
		
		$output = '';
		$output .= '<div id="chart-'.$chartid.'" style="height:'.$height.'px; width:100%;"></div>';
		$output .= adrotate_draw_graph($chartid, $dates, $clicks, $impressions);
		unset($stats, $graph, $dates, $clicks, $impressions);
	} else {
		$output = __('No data to show!', 'adrotate');
	} 

	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_ctr

 Purpose:   Calculate Click-Through-Rate
 Receive:   $clicks, $impressions, $round
 Return:    $ctr
 Since:		3.7
-------------------------------------------------------------*/
function adrotate_ctr($clicks = 0, $impressions = 0, $round = 2) { 

	if($impressions > 0 AND $clicks > 0) {
		$ctr = round($clicks/$impressions*100, $round);
	} else {
		$ctr = 0;
	}
	
	return $ctr;
} 

/*-------------------------------------------------------------
 Name:      adrotate_prepare_fullreport
 Purpose:   Generate live stats for admins
 Since:		3.5
-------------------------------------------------------------*/
function adrotate_prepare_fullreport() {
	global $wpdb;
	
	$today = adrotate_date_start('day');

	$stats['banners'] = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'active';");
	$stats['tracker'] = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `tracker` = 'Y' AND `type` = 'active';");
	$stats['overall_clicks'] = $wpdb->get_var("SELECT SUM(`clicks`) as `clicks` FROM `{$wpdb->prefix}adrotate_stats`;");
	$stats['overall_impressions'] = $wpdb->get_var("SELECT SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}adrotate_stats`;");

	$this_month_start = mktime(0, 0, 0, date("m"), 1, date("Y"));
	$this_month_end = mktime(0, 0, 0, date("m"), date("t"), date("Y"));
	$stats['this_month_clicks'] = $wpdb->get_var("SELECT SUM(`clicks`) as `clicks` FROM `{$wpdb->prefix}adrotate_stats` WHERE `thetime` >= {$this_month_start} AND `thetime` <= {$this_month_end};");
	$stats['this_month_impressions'] = $wpdb->get_var("SELECT SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}adrotate_stats` WHERE `thetime` >= {$this_month_start} AND `thetime` <= {$this_month_end};");

	$last_month_start = mktime(0, 0, 0, date("m")-1, 1, date("Y"));
	$last_month_end = mktime(0, 0, 0, date("m"), 0, date("Y"));
	$stats['last_month_clicks'] = $wpdb->get_var("SELECT SUM(`clicks`) as `clicks` FROM `{$wpdb->prefix}adrotate_stats` WHERE `thetime` >= {$last_month_start} AND `thetime` <= {$last_month_end};");
	$stats['last_month_impressions'] = $wpdb->get_var("SELECT SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}adrotate_stats` WHERE `thetime` >= {$last_month_start} AND `thetime` <= {$last_month_end};");

	if(!$stats['banners']) $stats['banners'] = 0;
	if(!$stats['tracker']) $stats['tracker'] = 0;
	if(!$stats['overall_clicks']) $stats['overall_clicks'] = 0;
	if(!$stats['overall_impressions']) $stats['overall_impressions'] = 0;
	if(!$stats['last_month_clicks']) $stats['last_month_clicks'] = 0;
	if(!$stats['last_month_impressions']) $stats['last_month_impressions'] = 0;
	if(!$stats['this_month_clicks']) $stats['this_month_clicks'] = 0;
	if(!$stats['this_month_impressions']) $stats['this_month_impressions'] = 0;

	return $stats;
}

/*-------------------------------------------------------------
 Name:      adrotate_prepare_advertiser_report

 Purpose:   Generate live stats for advertisers
 Receive:   $user
 Return:    -None-
 Since:		3.5
-------------------------------------------------------------*/
function adrotate_prepare_advertiser_report($user, $ads) {
	global $wpdb;
	
	if($ads) {
		$stats['ad_amount']	= count($ads);
		if(empty($stats['total_impressions'])) $stats['total_impressions'] = 0;
		if(empty($stats['total_clicks'])) $stats['total_clicks'] = 0;
		if(empty($stats['thebest'])) $stats['thebest'] = array('id' => 0, 'title' => __('Not found', 'adrotate'), 'clicks' => 0);
		if(empty($stats['theworst'])) $stats['theworst'] = array('id' => 0, 'title' => __('Not found', 'adrotate'), 'clicks' => 0);

		foreach($ads as $ad) {
			$result = adrotate_stats($ad['id']);
			$stats['total_impressions'] = $stats['total_impressions'] + $result['impressions'];
			$stats['total_clicks'] = $stats['total_clicks'] + $result['clicks'];
			unset($result);
		}

		$stats['thebest'] = $wpdb->get_row($wpdb->prepare("
		SELECT `{$wpdb->prefix}adrotate`.`id`,  `{$wpdb->prefix}adrotate`.`title`, SUM(`{$wpdb->prefix}adrotate_stats`.`clicks`) as `clicks` 
		FROM `{$wpdb->prefix}adrotate`, `{$wpdb->prefix}adrotate_linkmeta`, `{$wpdb->prefix}adrotate_stats` 
		WHERE `{$wpdb->prefix}adrotate`.`id` = `{$wpdb->prefix}adrotate_linkmeta`.`ad` 
		AND `{$wpdb->prefix}adrotate_linkmeta`.`ad` = `{$wpdb->prefix}adrotate_stats`.`ad` 
		AND `{$wpdb->prefix}adrotate`.`tracker` = 'Y' 
		AND `{$wpdb->prefix}adrotate`.`type` = 'active' 
		AND `{$wpdb->prefix}adrotate_linkmeta`.`user` = %d
		GROUP BY `{$wpdb->prefix}adrotate`.`id`
		ORDER BY `{$wpdb->prefix}adrotate_stats`.`clicks` DESC LIMIT 1;
		", $user), ARRAY_A);

		$stats['theworst'] = $wpdb->get_row($wpdb->prepare("
		SELECT `{$wpdb->prefix}adrotate`.`id`,  `{$wpdb->prefix}adrotate`.`title`, SUM(`{$wpdb->prefix}adrotate_stats`.`clicks`) as `clicks` 
		FROM `{$wpdb->prefix}adrotate`, `{$wpdb->prefix}adrotate_linkmeta`, `{$wpdb->prefix}adrotate_stats` 
		WHERE `{$wpdb->prefix}adrotate`.`id` = `{$wpdb->prefix}adrotate_linkmeta`.`ad` 
		AND `{$wpdb->prefix}adrotate_linkmeta`.`ad` = `{$wpdb->prefix}adrotate_stats`.`ad` 
		AND `{$wpdb->prefix}adrotate`.`tracker` = 'Y'
		AND `{$wpdb->prefix}adrotate`.`type` = 'active'
		AND `{$wpdb->prefix}adrotate_linkmeta`.`user` = %d
		GROUP BY `{$wpdb->prefix}adrotate`.`id`
		ORDER BY `{$wpdb->prefix}adrotate_stats`.`clicks` ASC LIMIT 1;
		", $user), ARRAY_A);
		
		return $stats;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_date_start

 Purpose:   Get and return the localized UNIX time for the current hour, day and start of the week
 Receive:   $what
 Return:    int
 Since:		3.8.7.1
-------------------------------------------------------------*/
function adrotate_date_start($what) {
	$now = adrotate_now();
	$string = gmdate('Y-m-d H:i:s', time());
	preg_match('#([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#', $string, $matches);

	switch($what) {
		case 'hour' :
			$string_time = gmmktime($matches[4], 0, 0, $matches[2], $matches[3], $matches[1]);
			$result = gmdate('U', $string_time + (get_option('gmt_offset') * 3600));
		break;
		case 'day' :
			$timezone = get_option('timezone_string');
			if($timezone) {
				$server_timezone = date('e');
				date_default_timezone_set($timezone);
				$result = strtotime('00:00:00') + (get_option('gmt_offset') * 3600);
				date_default_timezone_set($server_timezone);
			} else {
				$result = gmdate('U', gmmktime(0, 0, 0, gmdate('n'), gmdate('j')));
			}
		break;
		case 'week' :
			$timezone = get_option('timezone_string');
			if($timezone) {
				$server_timezone = date('e');
				date_default_timezone_set($timezone);
				$result = strtotime('Last Monday', $now) + (get_option('gmt_offset') * 3600);
				date_default_timezone_set($server_timezone);
			} else {
				$result = gmdate('U', gmmktime(0, 0, 0));
			}
		break;
	}

	return $result;
}

/*-------------------------------------------------------------
 Name:      adrotate_now

 Purpose:   Get and return the localized UNIX time for "now"
 Receive:   -None-
 Return:    int
 Since:		3.8.6.2
-------------------------------------------------------------*/
function adrotate_now() {
	return time() + (get_option('gmt_offset') * HOUR_IN_SECONDS);
}

/*-------------------------------------------------------------
 Name:      adrotate_archive_stats

 Purpose:   Move stats into a secondary table when adverst are archived
 Since:		4.0
-------------------------------------------------------------*/
function adrotate_archive_stats($id) {
	global $wpdb;

	$insert = $delete = false;
	$stats = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}adrotate_stats` WHERE `ad` = {$id} ORDER BY `id` ASC;");

	foreach($stats as $stat) {
		if($stat->id > 0) {
			$insert[] = "(".$stat->ad.", ".$stat->group.", ".$stat->thetime.", ".$stat->clicks.", ".$stat->impressions.")";
			$delete[] = $stat->id;
		}
	}

	// Split the data into chunks
	$insert = array_chunk($insert, 30);
	
	// Insert each chunk to the archive table
	if(is_array($insert)) {
		foreach($insert as $chunk) {
			$wpdb->query("INSERT INTO `{$wpdb->prefix}adrotate_stats_archive` (`ad`, `group`, `thetime`, `clicks`, `impressions`)
	VALUES ".implode(",", $chunk).";");
			unset($chunk);
		}
	
		// Delete old stats
		$wpdb->query("DELETE FROM `{$wpdb->prefix}adrotate_stats` WHERE `id` IN (".implode(",", $delete).");");
	}

	unset($stats, $insert, $delete);	
}

/*-------------------------------------------------------------
 Name:      adrotate_count_impression
 Purpose:   Count Impressions where needed
 Since:		3.11.3
-------------------------------------------------------------*/
function adrotate_count_impression($ad, $group = 0, $blog_id = 0) { 
	global $wpdb, $adrotate_config, $adrotate_debug;

	if(($adrotate_config['enable_loggedin_impressions'] == 'Y' AND is_user_logged_in()) OR !is_user_logged_in()) {
		$now = adrotate_now();
		$today = adrotate_date_start('day');
		$remote_ip = adrotate_get_remote_ip();

		if($blog_id > 0 AND adrotate_is_networked()) {
			$current_blog = $wpdb->blogid;
			switch_to_blog($blog_id);
		}

		if($adrotate_debug['timers'] == true) {
			$impression_timer = $now;
		} else {
			$impression_timer = $now - $adrotate_config['impression_timer'];
		}

		if($remote_ip != "unknown" AND !empty($remote_ip)) {
			$saved_timer = $wpdb->get_var($wpdb->prepare("SELECT `timer` FROM `{$wpdb->prefix}adrotate_tracker` WHERE `ipaddress` = '%s' AND `stat` = 'i' AND `bannerid` = %d ORDER BY `timer` DESC LIMIT 1;", $remote_ip, $ad));
			if($saved_timer < $impression_timer AND adrotate_is_human()) {
				$stats = $wpdb->get_var($wpdb->prepare("SELECT `id` FROM `{$wpdb->prefix}adrotate_stats` WHERE `ad` = %d AND `group` = %d AND `thetime` = {$today};", $ad, $group));
				if($stats > 0) {
					$wpdb->query("UPDATE `{$wpdb->prefix}adrotate_stats` SET `impressions` = `impressions` + 1 WHERE `id` = {$stats};");
				} else {
					$wpdb->insert($wpdb->prefix.'adrotate_stats', array('ad' => $ad, 'group' => $group, 'thetime' => $today, 'clicks' => 0, 'impressions' => 1));
				}
	
				$wpdb->insert($wpdb->prefix."adrotate_tracker", array('ipaddress' => $remote_ip, 'timer' => $now, 'bannerid' => $ad, 'stat' => 'i'));
			}
		}

		if($blog_id > 0 AND adrotate_is_networked()) {
			switch_to_blog($current_blog);
		}
	}
} 

/*-------------------------------------------------------------
 Name:      adrotate_impression_callback
 Purpose:   Register a impression for dynamic groups
 Since:		3.11.4
-------------------------------------------------------------*/
function adrotate_impression_callback() {
	define('DONOTCACHEPAGE', true);
	define('DONOTCACHEDB', true);
	define('DONOTCACHCEOBJECT', true);

	global $adrotate_debug;

	$meta = $_POST['track'];
	if($adrotate_debug['track'] != true) {
		$meta = base64_decode($meta);
	}
		
	$meta = esc_attr($meta);
	// Don't use $impression_timer - It's for impressions used in javascript
	list($ad, $group, $blog_id, $impression_timer) = explode(",", $meta, 4);
	adrotate_count_impression($ad, $group, $blog_id);

	wp_die();
}

/*-------------------------------------------------------------
 Name:      adrotate_click_callback
 Purpose:   Register clicks for clicktracking
 Since:		3.11.4
-------------------------------------------------------------*/
function adrotate_click_callback() {
	define('DONOTCACHEPAGE', true);
	define('DONOTCACHEDB', true);
	define('DONOTCACHCEOBJECT', true);

	global $wpdb, $adrotate_config, $adrotate_debug;

	$meta = $_POST['track'];

	if($adrotate_debug['track'] != true) {
		$meta = base64_decode($meta);
	}
	
	$meta = esc_attr($meta);
	// Don't use $impression_timer - It's for impressions used in javascript
	list($ad, $group, $blog_id, $impression_timer) = explode(",", $meta, 4);

	if(is_numeric($ad) AND is_numeric($group) AND is_numeric($blog_id)) {

		if($blog_id > 0 AND adrotate_is_networked()) {
			$current_blog = $wpdb->blogid;
			switch_to_blog($blog_id);
		}
	
		if(($adrotate_config['enable_loggedin_clicks'] == 'Y' AND is_user_logged_in()) OR !is_user_logged_in()) {
			$remote_ip = adrotate_get_remote_ip();
	
			if(adrotate_is_human() AND $remote_ip != "unknown" AND !empty($remote_ip)) {
				$now = adrotate_now();
				$today = adrotate_date_start('day');

				if($adrotate_debug['timers'] == true) {
					$click_timer = $now;
				} else {
					$click_timer = $now - $adrotate_config['click_timer'];
				}
	
				$saved_timer = $wpdb->get_var($wpdb->prepare("SELECT `timer` FROM `{$wpdb->prefix}adrotate_tracker` WHERE `ipaddress` = '%s' AND `stat` = 'c' AND `bannerid` = %d ORDER BY `timer` DESC LIMIT 1;", $remote_ip, $ad));
				if($saved_timer < $click_timer) {
					$stats = $wpdb->get_var($wpdb->prepare("SELECT `id` FROM `{$wpdb->prefix}adrotate_stats` WHERE `ad` = %d AND `group` = %d AND `thetime` = {$today};", $ad, $group));
					if($stats > 0) {
						$wpdb->query("UPDATE `{$wpdb->prefix}adrotate_stats` SET `clicks` = `clicks` + 1 WHERE `id` = {$stats};");
					} else {
						$wpdb->insert($wpdb->prefix.'adrotate_stats', array('ad' => $ad, 'group' => $group, 'thetime' => $today, 'clicks' => 1, 'impressions' => 1));
					}

					$wpdb->insert($wpdb->prefix.'adrotate_tracker', array('ipaddress' => $remote_ip, 'timer' => $now, 'bannerid' => $ad, 'stat' => 'c'));
				}

				// Advertising budget
				$wpdb->query("UPDATE `{$wpdb->prefix}adrotate` SET `budget` = `budget` - `crate` WHERE `id` = {$ad} AND `crate` > 0;");
			}
		}

		if($blog_id > 0 AND adrotate_is_networked()) {
			switch_to_blog($current_blog);
		}

		unset($remote_ip, $track, $meta, $ad, $group, $remote, $banner);
	}

	wp_die();
}
?>
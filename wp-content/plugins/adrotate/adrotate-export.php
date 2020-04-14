<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2020 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      adrotate_export_ads

 Purpose:   Export adverts in various formats
 Receive:   $ids, $format
 Return:    -- None --
 Since:		3.11
-------------------------------------------------------------*/
function adrotate_export_ads($ids) {
	global $wpdb;

	$where = false;
	if(count($ids) > 1) {
		$where = "`id` = ";
		foreach($ids as $key => $id) {
			$where .= "'{$id}' OR `id` = ";
		}
		$where = rtrim($where, " OR `id` = ");
	}
	
	if(count($ids) == 1) {
		$where = "`id` = '{$ids[0]}'";
	}
	
	if($where) {
		$to_export = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}adrotate` WHERE {$where} ORDER BY `id` ASC;", ARRAY_A);
	}

	$adverts = array();
	foreach($to_export as $export) {
		$starttime = $stoptime = 0;
		$starttime = $wpdb->get_var("SELECT `starttime` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '".$export['id']."' AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `starttime` ASC LIMIT 1;");
		$stoptime = $wpdb->get_var("SELECT `stoptime` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '".$export['id']."' AND  `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `stoptime` DESC LIMIT 1;");

		$export['imagetype'] = (empty($export['imagetype'])) ? '' : $export['imagetype'];
		$export['image'] = (empty($export['image'])) ? '' : $export['image'];
		$export['cities'] = (empty($export['cities'])) ? serialize(array()) : $export['cities'];
		$export['countries'] = (empty($export['countries'])) ? serialize(array()) : $export['countries'];
		
		$adverts[$export['id']] = array(
			'id' => $export['id'], 'title' => $export['title'], 'bannercode' => stripslashes($export['bannercode']),
			'imagetype' => $export['imagetype'], 'image' => $export['image'],
			'tracker' => $export['tracker'], 'desktop' => $export['desktop'], 'mobile' => $export['mobile'], 'tablet' => $export['tablet'],
			'os_ios' => $export['os_ios'], 'os_android' => $export['os_android'], 'os_other' => $export['os_other'],
			'weight' => $export['weight'], 'budget' => $export['budget'], 'crate' => $export['crate'], 'irate' => $export['irate'],
			'cities' => $export['cities'], 'countries' => $export['countries'],
			'schedule_start' => $starttime, 'schedule_end' => $stoptime
		);
	}

	if(count($adverts) > 0) {
		$filename = "AdRotate_export_adverts_".date_i18n("mdYHis").".csv";
		if(!file_exists(WP_CONTENT_DIR . '/reports/')) mkdir(WP_CONTENT_DIR . '/reports/', 0755);
		$fp = fopen(WP_CONTENT_DIR . '/reports/'.$filename, 'w');
		
		if($fp) {
			$generated = array('Generated', date_i18n("M d Y, H:i:s"));
			$version = array('Version', 'AdRotate '.ADROTATE_DISPLAY);
			$keys = array('id', 'name', 'bannercode', 'imagetype', 'image_url', 'enable_stats', 'show_desktop', 'show_mobile', 'show_tablet', 'show_ios', 'show_android', 'show_otheros', 'weight', 'budget', 'click_rate', 'impression_rate', 'geo_cities', 'geo_countries', 'schedule_start', 'schedule_end');

			fputcsv($fp, $generated);
			fputcsv($fp, $version);
			fputcsv($fp, $keys);
			foreach($adverts as $advert) {
				fputcsv($fp, $advert);
			}
			
			fclose($fp);

			adrotate_return('adrotate-ads', 215, array('file' => $filename));
			exit;
		}
	} else {
		adrotate_return('adrotate-ads', 509);
	}
}
?>
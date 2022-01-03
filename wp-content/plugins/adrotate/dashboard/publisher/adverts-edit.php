<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2020 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */

if(!$ad_edit_id) {
	$edit_id = $wpdb->get_var("SELECT `id` FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'empty' ORDER BY `id` DESC LIMIT 1;");
	if($edit_id == 0) {
	    $wpdb->insert($wpdb->prefix."adrotate", array('title' => '', 'bannercode' => '', 'thetime' => $now, 'updated' => $now, 'author' => $userdata->user_login, 'imagetype' => 'dropdown', 'image' => '', 'tracker' => 'N', 'show_everyone' => 'Y', 'desktop' => 'Y', 'mobile' => 'Y', 'tablet' => 'Y', 'os_ios' => 'Y', 'os_android' => 'Y', 'os_other' => 'Y', 'type' => 'empty', 'weight' => 6, 'autodelete' => 'N', 'budget' => 0, 'crate' => 0, 'irate' => 0, 'state_req' => 'N', 'cities' => serialize(array()), 'states' => serialize(array()), 'countries' => serialize(array())));
	    $edit_id = $wpdb->insert_id;

		$wpdb->insert($wpdb->prefix.'adrotate_schedule', array('name' => 'Schedule for ad '.$edit_id, 'starttime' => $now, 'stoptime' => $in84days, 'maxclicks' => 0, 'maximpressions' => 0, 'spread' => 'N', 'daystarttime' => '0000', 'daystoptime' => '0000', 'day_mon' => 'Y', 'day_tue' => 'Y', 'day_wed' => 'Y', 'day_thu' => 'Y', 'day_fri' => 'Y', 'day_sat' => 'Y', 'day_sun' => 'Y', 'autodelete' => 'N'));
	    $schedule_id = $wpdb->insert_id;
		$wpdb->insert($wpdb->prefix.'adrotate_linkmeta', array('ad' => $edit_id, 'group' => 0, 'user' => 0, 'schedule' => $schedule_id));
	}
	$ad_edit_id = $edit_id;
}

$edit_banner = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}adrotate` WHERE `id` = '{$ad_edit_id}';");

if($edit_banner) {
	$groups	= $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '' ORDER BY `id` ASC;");
	$schedule = $wpdb->get_row("SELECT `{$wpdb->prefix}adrotate_schedule`.`id`, `starttime`, `stoptime`, `maxclicks`, `maximpressions` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '{$edit_banner->id}' AND `group` = 0 AND `user` = 0 AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `{$wpdb->prefix}adrotate_schedule`.`id` ASC LIMIT 1;");
	$linkmeta = $wpdb->get_results("SELECT `group` FROM `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '{$edit_banner->id}' AND `user` = 0 AND `schedule` = 0;");

	wp_enqueue_media();
	wp_enqueue_script('uploader-hook', plugins_url().'/adrotate/library/uploader-hook.js', array('jquery'));

	// Set up start and end date
	list($start_day, $start_month, $start_year, $start_hour, $start_minute) = explode(" ", date("d m Y H i", $schedule->starttime));
	list($end_day, $end_month, $end_year, $end_hour, $end_minute) = explode(" ", date("d m Y H i", $schedule->stoptime));
	$start_date = $start_day.'-'.$start_month.'-'.$start_year;
	$end_date = $end_day.'-'.$end_month.'-'.$end_year;

	$meta_array = array();
	foreach($linkmeta as $meta) {
		$meta_array[] = $meta->group;
	}

	if($ad_edit_id) {
		if($edit_banner->type != 'empty') {
			// Errors
			if(strlen($edit_banner->bannercode) < 1 AND $edit_banner->type != 'empty')
				echo '<div class="error"><p>'. __('The AdCode cannot be empty!', 'adrotate').'</p></div>';

			if(!preg_match("/(%asset%)/i", $edit_banner->bannercode, $things) AND $edit_banner->image != '')
				echo '<div class="error"><p>'. __('You did not use %asset% in your AdCode but did select a file to use!', 'adrotate').'</p></div>';

			if(preg_match("/(%asset%)/i", $edit_banner->bannercode, $things) AND $edit_banner->image == '')
				echo '<div class="error"><p>'. __('You did use %asset% in your AdCode but did not select a file to use!', 'adrotate').'</p></div>';

			if((($edit_banner->imagetype != '' AND $edit_banner->image == '') OR ($edit_banner->imagetype == '' AND $edit_banner->image != '')))
				echo '<div class="error"><p>'. __('There is a problem saving the image. Please re-set your image and re-save the ad!', 'adrotate').'</p></div>';

			if((!preg_match_all('/<(a)[^>](.*?)>/i', stripslashes(htmlspecialchars_decode($edit_banner->bannercode, ENT_QUOTES)), $things) OR preg_match_all('/<(ins|script|embed|iframe)[^>](.*?)>/i', stripslashes(htmlspecialchars_decode($edit_banner->bannercode, ENT_QUOTES)), $things)) AND $edit_banner->tracker == 'Y')
				echo '<div class="error"><p>'. __("This kind of advert can not have statistics enabled in AdRotate. Impression counting is available in AdRotate Pro.", 'adrotate').'</p></div>';

			// Ad Notices
			$adstate = adrotate_evaluate_ad($edit_banner->id);
			if($adstate == 'expired')
				echo '<div class="error"><p>'. __('This advert is expired and currently not shown on your website!', 'adrotate').'</p></div>';

			if($adstate == '2days')
				echo '<div class="updated"><p>'. __('The advert will expire in less than 2 days!', 'adrotate').'</p></div>';

			if($adstate == '7days')
				echo '<div class="updated"><p>'. __('This advert will expire in less than 7 days!', 'adrotate').'</p></div>';

			if($edit_banner->type == 'disabled')
				echo '<div class="updated"><p>'. __('This advert has been disabled and does not rotate on your site!', 'adrotate').'</p></div>';

			if($edit_banner->type == 'error' AND $adstate == 'active')
				echo '<div class="error"><p>'. __('AdRotate cannot find an error but the advert is marked erroneous, try re-saving the ad!', 'adrotate').'</p></div>';
			
			// Legacy support
			if(preg_match("/(%image%)/i", $edit_banner->bannercode, $things))
				echo '<div class="error"><p>'. __('This advert still uses the %image% tag. Please change it to %asset%!', 'adrotate').'</p></div>';		
		}
	}

	// Determine image field
	if($edit_banner->imagetype == "field") {
		$image_field = $edit_banner->image;
		$image_dropdown = '';
	} else if($edit_banner->imagetype == "dropdown") {
		$image_field = '';
		$image_dropdown = $edit_banner->image;
	} else {
		$image_field = '';
		$image_dropdown = '';
	}
	?>

	<form method="post" action="admin.php?page=adrotate">
		<?php wp_nonce_field('adrotate_save_ad','adrotate_nonce'); ?>
		<input type="hidden" name="adrotate_username" value="<?php echo $userdata->user_login;?>" />
		<input type="hidden" name="adrotate_id" value="<?php echo $edit_banner->id;?>" />
		<input type="hidden" name="adrotate_type" value="<?php echo $edit_banner->type;?>" />
		<input type="hidden" name="adrotate_schedule" value="<?php echo $schedule->id;?>" />

		<?php if($edit_banner->type == 'empty') { ?>
			<h3><?php _e('New Advert', 'adrotate'); ?></h3>
		<?php } else { ?>
			<h3><?php _e('Edit Advert', 'adrotate'); ?></h3>
		<?php } ?>

		<table class="widefat" style="margin-top: .5em;">
			<tbody>
	      	<tr>
		        <th width="15%"><?php _e('Name', 'adrotate'); ?></th>
		        <td>
		        	<input tabindex="1" id="adrotate_title" name="adrotate_title" type="text" size="70" class="ajdg-inputfield ajdg-fullwidth" value="<?php echo stripslashes($edit_banner->title);?>" autocomplete="off" />
		        </td>
		        <td width="35%">
		        	&nbsp;
		        </td>
	      	</tr>
	      	<tr>
		        <th valign="top"><?php _e('AdCode', 'adrotate'); ?></th>
		        <td>
		        	<textarea tabindex="2" id="adrotate_bannercode" name="adrotate_bannercode" cols="70" rows="10" class="ajdg-fullwidth"><?php echo stripslashes($edit_banner->bannercode); ?></textarea>
		        </td>
		        <td width="35%" rowspan="2">
			        <p><strong><?php _e('Basic Examples:', 'adrotate'); ?></strong></p>
			        <p><em><?php _e('Click any of the examples to use it.', 'adrotate'); ?></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://www.ajdg.net/&quot;&gt;&lt;img src=&quot;%asset%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="https://www.ajdg.net/"&gt;&lt;img src="%asset%" /&gt;&lt;/a&gt;</a></em></p>
			        <p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;iframe src=&quot;%asset%&quot; height=&quot;250&quot; frameborder=&quot;0&quot; style=&quot;border:none;&quot;&gt;&lt;/iframe&gt;');return false;">&lt;iframe src=&quot;%asset%&quot; height=&quot;250&quot; frameborder=&quot;0&quot; style=&quot;border:none;&quot;&gt;&lt;/iframe&gt;</a></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;http://www.arnan.me/&quot;&gt;Visit arnan.me&lt;/a&gt;');return false;">&lt;a href="http://www.arnan.me/"&gt;Visit arnan.me&lt;/a&gt;</a></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://www.ajdg.net/&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;%asset%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="https://www.ajdg.net/" target=&quot;_blank&quot;&gt;&lt;img src="%asset%" /&gt;&lt;/a&gt;</a></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://www.ajdg.net/?timestamp=%random%&quot;&gt;&lt;img src=&quot;%asset%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="https://www.ajdg.net/?timestamp=%random%"&gt;&lt;img src="%asset%" /&gt;&lt;/a&gt;</a></em></p>
		        </td>
	     	</tr>
	      	<tr>
		        <th valign="top"><?php _e('Useful tags', 'adrotate'); ?></th>
		        <td colspan="2">
			        <span class="description"><a href="#" onclick="textatcursor('adrotate_bannercode','%id%');return false;"><span class="ajdg-tooltip">%id%<span class="ajdg-tooltiptext ajdg-tooltip-top"><?php _e('Insert the advert ID Number.', 'adrotate'); ?></span></span></a> <a href="#" onclick="textatcursor('adrotate_bannercode','%asset%');return false;"><span class="ajdg-tooltip">%asset%<span class="ajdg-tooltiptext ajdg-tooltip-top"><?php _e('Use this tag when selecting a image below.', 'adrotate'); ?></span></span></a> <a href="#" onclick="textatcursor('adrotate_bannercode','%title%');return false;"><span class="ajdg-tooltip">%title%<span class="ajdg-tooltiptext ajdg-tooltip-top"><?php _e('Insert the advert name.', 'adrotate'); ?></span></span></a> <a href="#" onclick="textatcursor('adrotate_bannercode','%random%');return false;"><span class="ajdg-tooltip">%random%<span class="ajdg-tooltiptext ajdg-tooltip-top"><?php _e('Insert a random string. Useful for DFP/DoubleClick type adverts.', 'adrotate'); ?></span></span></a> <a href="#" onclick="textatcursor('adrotate_bannercode','target=&quot;_blank&quot;');return false;"><span class="ajdg-tooltip">target="_blank"<span class="ajdg-tooltiptext ajdg-tooltip-top"><?php _e('Add inside the &lt;a&gt; tag to open the advert in a new window.', 'adrotate'); ?></span></span></a> <a href="#" onclick="textatcursor('adrotate_bannercode','rel=&quot;nofollow&quot;');return false;"><span class="ajdg-tooltip">rel="nofollow"<span class="ajdg-tooltiptext ajdg-tooltip-top"><?php _e('Add inside the &lt;a&gt; tag to tell crawlers to ignore this link.', 'adrotate'); ?></span></span></a></em><br />
			        <?php _e('Place the cursor where you want to add a tag and click to add it to your AdCode.', 'adrotate'); ?></p>
		        </td>
	      	</tr>
		  	<?php if($edit_banner->type != 'empty') { ?>
	     	<tr>
		        <th valign="top"><?php _e('Preview', 'adrotate'); ?></th>
		        <td colspan="3">
		        	<div><?php echo adrotate_preview($edit_banner->id); ?></div>
			        <br /><em><?php _e('Note: While this preview is an accurate one, it might look different then it does on the website.', 'adrotate'); ?>
					<br /><?php _e('This is because of CSS differences. Your themes CSS file is not active here!', 'adrotate'); ?></em>
				</td>
	      	</tr>
			<?php } ?>
			<tr>
		        <th valign="top"><?php _e('Banner asset', 'adrotate'); ?></th>
				<td colspan="3">
					<?php _e('WordPress media:', 'adrotate'); ?> <input tabindex="3" id="adrotate_image" type="text" size="50" name="adrotate_image" value="<?php echo $image_field; ?>" class="ajdg-inputfield" /> <input tabindex="4" id="adrotate_image_button" class="button" type="button" value="<?php _e('Select Banner', 'adrotate'); ?>" />
					<br />
					<?php _e('- OR -', 'adrotate'); ?><br />
					<?php _e('Banner folder:', 'adrotate'); ?> <select tabindex="5" name="adrotate_image_dropdown" style="min-width: 200px;">
   						<option value=""><?php _e('No image selected', 'adrotate'); ?></option>
						<?php
						$assets = adrotate_dropdown_folder_contents(WP_CONTENT_DIR."/".$adrotate_config['banner_folder'], array('jpg', 'jpeg', 'gif', 'png', 'html', 'htm'));
						foreach($assets as $key => $option) {
							echo "<option value=\"$option\"";
							if($image_dropdown == WP_CONTENT_URL."/banners/".$option) { echo " selected"; }
							echo ">$option</option>";
						}
						?>
					</select><br />
					<em><?php _e('Use %asset% in the adcode instead of the file path.', 'adrotate'); ?> <?php _e('Use either the text field or the dropdown. If the textfield has content that field has priority.', 'adrotate'); ?></em>
				</td>
			</tr>
			<?php if($adrotate_config['stats'] > 0) { ?>
	      	<tr>
		        <th width="15%" valign="top"><?php _e('Statistics', 'adrotate'); ?></th>
		        <td colspan="3">
		        	<label for="adrotate_tracker"><input tabindex="6" type="checkbox" name="adrotate_tracker" id="adrotate_tracker" <?php if($edit_banner->tracker == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Count clicks and impressions.', 'adrotate'); ?></label><br />
		        	<em><?php _e('Click counting does not work for Javascript/html5 adverts such as those provided by Google AdSense/DFP/DoubleClick.', 'adrotate'); ?></em>
		        </td>
	      	</tr>
			<?php } ?>
	      	<tr>
		        <th><?php _e('Activate', 'adrotate'); ?></th>
		        <td colspan="3">
			        <select tabindex="7" name="adrotate_active">
						<option value="active" <?php if($edit_banner->type == "active" OR $edit_banner->type == "error") { echo 'selected'; } ?>><?php _e('Enabled, this ad will be visible', 'adrotate'); ?></option>
						<option value="disabled" <?php if($edit_banner->type == "disabled") { echo 'selected'; } ?>><?php _e('Disabled, do not show this advert anywhere', 'adrotate'); ?></option>
					</select>
				</td>
	      	</tr>
			</tbody>
		</table>
		<center><?php _e('Target your audience with Geo Targeting and easily select which devices and mobile operating systems the advert should show on with AdRotate Pro!', 'adrotate'); ?>  <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>

		<h2><?php _e('Schedule your advert', 'adrotate'); ?></h2>
		<p><em><?php _e('Time uses a 24 hour clock. When you\'re used to the AM/PM system keep this in mind: If the start or end time is after lunch, add 12 hours. 2PM is 14:00 hours. 6AM is 6:00 hours.', 'adrotate'); ?></em></p>
		<table class="widefat" style="margin-top: .5em">
			<tbody>
			<tr>
		        <th width="15%"><?php _e('Start date', 'adrotate'); ?> (dd-mm-yyyy)</th>
		        <td width="35%">
					<input tabindex="8" type="text" id="startdate_picker" name="adrotate_start_date" value="<?php echo $start_date; ?>" class="datepicker ajdg-inputfield" autocomplete="off" />
		        </td>
		        <th width="15%"><?php _e('End date', 'adrotate'); ?> (dd-mm-yyyy)</th>
		        <td>
					<input tabindex="9" type="text" id="enddate_picker" name="adrotate_end_date" value="<?php echo $end_date; ?>" class="datepicker ajdg-inputfield" autocomplete="off" />
				</td>
	      	</tr>
			<tr>
		        <th><?php _e('Start time', 'adrotate'); ?> (hh:mm)</th>
		        <td>
					<input tabindex="10" name="adrotate_start_hour" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $start_hour; ?>" autocomplete="off" /> :
					<input tabindex="11" name="adrotate_start_minute" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $start_minute; ?>" autocomplete="off" />
		        </td>
		        <th><?php _e('End time', 'adrotate'); ?> (hh:mm)</th>
		        <td>
					<input tabindex="12" name="adrotate_end_hour" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $end_hour; ?>" autocomplete="off" /> :
					<input tabindex="13" name="adrotate_end_minute" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $end_minute; ?>" autocomplete="off" />
				</td>
	      	</tr>
			<?php if($adrotate_config['stats'] == 1) { ?>
	      	<tr>
	      		<th><?php _e('Maximum Clicks', 'adrotate'); ?></th>
		        <td><input tabindex="14" name="adrotate_maxclicks" type="text" size="5" class="ajdg-inputfield" autocomplete="off" value="<?php echo $schedule->maxclicks;?>" /> <em><?php _e('Leave empty or 0 to skip this.', 'adrotate'); ?></em></td>
			    <th><?php _e('Maximum Impressions', 'adrotate'); ?></th>
		        <td><input tabindex="15" name="adrotate_maxshown" type="text" size="5" class="ajdg-inputfield" autocomplete="off" value="<?php echo $schedule->maximpressions;?>" /> <em><?php _e('Leave empty or 0 to skip this.', 'adrotate'); ?></em></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
		<center><?php _e('Plan ahead and create multiple and more advanced schedules for each advert with AdRotate Pro.', 'adrotate'); ?> <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>

		<h2><?php _e('Usage', 'adrotate'); ?></h2>
		<table class="widefat" style="margin-top: .5em">
			<tbody>
	      	<tr>
		        <th width="15%"><?php _e('Widget', 'adrotate'); ?></th>
		        <td colspan="3"><?php _e('Drag the AdRotate widget to the sidebar where you want to place the advert and select the advert or the group the advert is in.', 'adrotate'); ?></td>
	      	</tr>
	      	<tr>
		        <th width="15%"><?php _e('In a post or page', 'adrotate'); ?></th>
		        <td width="35%">[adrotate banner="<?php echo $edit_banner->id; ?>"]</td>
		        <th width="15%"><?php _e('Directly in a theme', 'adrotate'); ?></th>
		        <td>&lt;?php echo adrotate_ad(<?php echo $edit_banner->id; ?>); ?&gt;</td>
	      	</tr>
	      	</tbody>
		</table>

		<p class="submit">
			<input tabindex="16" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>

		<?php if($groups) { ?>
		<h3><?php _e('Select Groups', 'adrotate'); ?></h3>
		<table class="widefat" style="margin-top: .5em">
			<thead>
			<tr>
				<td width="2%" scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></td>
				<th width="2%"><center><?php _e('ID', 'adrotate'); ?></center></th>
				<th><?php _e('Name', 'adrotate'); ?></th>
				<th width="5%"><center><?php _e('Adverts', 'adrotate'); ?></center></th>
			</tr>
			</thead>

			<tbody>
			<?php
			$class = '';
			foreach($groups as $group) {
				if($group->adspeed > 0) $adspeed = $group->adspeed / 1000;
		        if($group->modus == 0) $modus[] = __('Default', 'adrotate');
		        if($group->modus == 1) $modus[] = __('Dynamic', 'adrotate').' ('.$adspeed.' '. __('second rotation', 'adrotate').')';
		        if($group->modus == 2) $modus[] = __('Block', 'adrotate').' ('.$group->gridrows.' x '.$group->gridcolumns.' '. __('grid', 'adrotate').')';
		        if($group->cat_loc > 0 OR $group->page_loc > 0) $modus[] = __('Post Injection', 'adrotate');
		        if($group->geo == 1 AND $adrotate_config['enable_geo'] > 0) $modus[] = __('Geolocation', 'adrotate');

				$ads_in_group = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_linkmeta` WHERE `group` = ".$group->id." AND `user` = 0 AND `schedule` = 0;");
				$class = ('alternate' != $class) ? 'alternate' : ''; ?>
			    <tr id='group-<?php echo $group->id; ?>' class=' <?php echo $class; ?>'>
					<th class="check-column"><input type="checkbox" name="groupselect[]" value="<?php echo $group->id; ?>" <?php if(in_array($group->id, $meta_array)) echo "checked"; ?> /></th>
					<td><center><?php echo $group->id; ?></center></td>
					<td><?php echo $group->name; ?><span style="color:#999;"><?php echo '<br /><span style="font-weight:bold;">'.__('Mode', 'adrotate').':</span> '.implode(', ', $modus); ?></span></td>
					<td><center><?php echo $ads_in_group; ?></center></td>
				</tr>
				<?php
				unset($modus);
			}
			?>
			</tbody>
		</table>

		<p class="submit">
			<input tabindex="17" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
		<?php } ?>

		<?php if($edit_banner->type != 'empty') { ?>
		<h2><?php _e('Portability', 'adrotate'); ?></h2>
		<p><em><?php _e('This long code is your advert. It includes all settings from above except the schedule and group selection. You can import this hash into another setup of AdRotate or AdRotate Professional. Do not alter the hash or the advert will not work. In most browsers you can tripleclick in the field to select the whole thing. You can paste the hash into the \'Advert Hash\' field in the Advert Generator of another AdRotate setup.', 'adrotate'); ?></em></p>
		<table class="widefat" style="margin-top: .5em">
			<tbody>
	      	<tr>
		        <th width="15%" valign="top"><?php _e('Advert hash', 'adrotate'); ?></th>
		        <td colspan="3"><textarea tabindex="18" id="adrotate_portable" name="adrotate_portable" cols="70" rows="5" class="ajdg-fullwidth"><?php echo adrotate_portable_hash('export', $edit_banner); ?></textarea></td>
	      	</tr>
	      	</tbody>
		</table>
		<?php } ?>

	</form>
<?php
} else {
	echo adrotate_error('error_loading_item');
}
?>
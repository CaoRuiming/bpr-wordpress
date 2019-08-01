<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2019 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

if(!$ad_edit_id) {
	$edit_id = $wpdb->get_var("SELECT `id` FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'empty' ORDER BY `id` DESC LIMIT 1;");
	if($edit_id == 0) {
	    $wpdb->insert($wpdb->prefix."adrotate", array('title' => '', 'bannercode' => '', 'thetime' => $now, 'updated' => $now, 'author' => $userdata->user_login, 'imagetype' => 'dropdown', 'image' => '', 'tracker' => 'N', 'show_everyone' => 'Y', 'desktop' => 'Y', 'mobile' => 'Y', 'tablet' => 'Y', 'os_ios' => 'Y', 'os_android' => 'Y', 'os_other' => 'Y', 'type' => 'empty', 'weight' => 6, 'autodelete' => 'N', 'budget' => 0, 'crate' => 0, 'irate' => 0, 'cities' => serialize(array()), 'countries' => serialize(array())));
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
	
	// Random banner for Media.net
	$partner = mt_rand(1,3);
	
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
	
			if(!preg_match("/(%image%|%asset%)/i", $edit_banner->bannercode, $things) AND $edit_banner->image != '') 
				echo '<div class="error"><p>'. __('You did not use %asset% (or %image%) in your AdCode but did select a file to use!', 'adrotate').'</p></div>';
		
			if(preg_match("/(%image%|%asset%)/i", $edit_banner->bannercode, $things) AND $edit_banner->image == '') 
				echo '<div class="error"><p>'. __('You did use %asset% (or %image%) in your AdCode but did not select a file to use!', 'adrotate').'</p></div>';
			
			if((($edit_banner->imagetype != '' AND $edit_banner->image == '') OR ($edit_banner->imagetype == '' AND $edit_banner->image != ''))) 
				echo '<div class="error"><p>'. __('There is a problem saving the image. Please reset your image and re-save the ad!', 'adrotate').'</p></div>';
	
			if(!preg_match_all('/<(a|script|embed|iframe)[^>](.*?)>/i', stripslashes(htmlspecialchars_decode($edit_banner->bannercode, ENT_QUOTES)), $things) AND $edit_banner->tracker == 'Y')
				echo '<div class="error"><p>'. __("Tracking is enabled but no valid link/tag was found in the adcode!", 'adrotate').'</p></div>';
	
			// Ad Notices
			$adstate = adrotate_evaluate_ad($edit_banner->id);
			if($edit_banner->type == 'error' AND $adstate == 'active')
				echo '<div class="error"><p>'. __('AdRotate cannot find an error but the ad is marked erroneous, try re-saving the ad!', 'adrotate').'</p></div>';
	
			if($adstate == 'expired')
				echo '<div class="error"><p>'. __('This ad is expired and currently not shown on your website!', 'adrotate').'</p></div>';
	
			if($adstate == '2days')
				echo '<div class="updated"><p>'. __('The ad will expire in less than 2 days!', 'adrotate').'</p></div>';
	
			if($adstate == '7days')
				echo '<div class="updated"><p>'. __('This ad will expire in less than 7 days!', 'adrotate').'</p></div>';
	
			if($edit_banner->type == 'disabled') 
				echo '<div class="updated"><p>'. __('This ad has been disabled and does not rotate on your site!', 'adrotate').'</p></div>';
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
	
	<form method="post" action="admin.php?page=adrotate-ads">
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
		        	<input tabindex="1" name="adrotate_title" type="text" class="ajdg-fullwidth ajdg-inputfield" value="<?php echo stripslashes($edit_banner->title);?>" autocomplete="off" />
		        </td>
		        <td width="35%">
		        	&nbsp;
		        </td>
	      	</tr>
	      	<tr>
		        <th valign="top"><?php _e('AdCode', 'adrotate'); ?></th>
		        <td>
		        	<label for="adrotate_bannercode"><textarea tabindex="2" id="adrotate_bannercode" name="adrotate_bannercode" cols="80" rows="15" class="ajdg-fullwidth"><?php echo stripslashes($edit_banner->bannercode); ?></textarea></label>
		        </td>
		        <td width="35%" rowspan="2">
			        <p><strong><?php _e('Basic Examples:', 'adrotate'); ?></strong></p>
			        <p><em><?php _e('Click any of the examples to use it.', 'adrotate'); ?></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://ajdg.solutions/&quot;&gt;&lt;img src=&quot;%asset%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="https://ajdg.solutions/"&gt;&lt;img src="%asset%" /&gt;&lt;/a&gt;</a></em></p>
			        <p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;iframe src=&quot;%asset%&quot; height=&quot;250&quot; frameborder=&quot;0&quot; style=&quot;border:none;&quot;&gt;&lt;/iframe&gt;');return false;">&lt;iframe src=&quot;%asset%&quot; height=&quot;250&quot; frameborder=&quot;0&quot; style=&quot;border:none;&quot;&gt;&lt;/iframe&gt;</a></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;http://www.arnan.me/&quot;&gt;Visit arnan.me&lt;/a&gt;');return false;">&lt;a href="http://www.arnan.me/"&gt;Visit arnan.me&lt;/a&gt;</a></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://ajdg.solutions/&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;%asset%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="https://ajdg.solutions/" target=&quot;_blank&quot;&gt;&lt;img src="%asset%" /&gt;&lt;/a&gt;</a></em></p>
					<p><em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://ajdg.solutions/?timestamp=%random%&quot;&gt;&lt;img src=&quot;%asset%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="https://ajdg.solutions/?timestamp=%random%"&gt;&lt;img src="%asset%" /&gt;&lt;/a&gt;</a></em></p>
		        </td>
	     	</tr>
	      	<tr>
		        <th valign="top"><?php _e('Useful tags', 'adrotate'); ?></th>
		        <td colspan="2">
			        <p><em><a href="#" title="<?php _e('Insert the advert ID Number.', 'adrotate'); ?>" onclick="textatcursor('adrotate_bannercode','%id%');return false;">%id%</a>, <a href="#" title="<?php _e('Required when selecting a asset below.', 'adrotate'); ?>" onclick="textatcursor('adrotate_bannercode','%asset%');return false;">%asset%</a>, <a href="#" title="<?php _e('Insert the advert name.', 'adrotate'); ?>" onclick="textatcursor('adrotate_bannercode','%title%');return false;">%title%</a>, <a href="#" title="<?php _e('Insert a random seed. Useful for DFP/DoubleClick type adverts.', 'adrotate'); ?>" onclick="textatcursor('adrotate_bannercode','%random%');return false;">%random%</a>, <a href="#" title="<?php _e('Add inside the <a> tag to open advert in a new window.', 'adrotate'); ?>" onclick="textatcursor('adrotate_bannercode','target=&quot;_blank&quot;');return false;">target="_blank"</a>, <a href="#" title="<?php _e('Add inside the <a> tag to tell crawlers to ignore this link', 'adrotate'); ?>" onclick="textatcursor('adrotate_bannercode','rel=&quot;nofollow&quot;');return false;">rel="nofollow"</a></em><br /><?php _e('Place the cursor in your AdCode where you want to add any of these tags and click to add it.', 'adrotate'); ?></p>
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
					<label for="adrotate_image">
						<?php _e('WordPress media:', 'adrotate'); ?> <input tabindex="3" id="adrotate_image" type="text" size="50" name="adrotate_image" value="<?php echo $image_field; ?>" class="ajdg-inputfield" /> <input tabindex="4" id="adrotate_image_button" class="button" type="button" value="<?php _e('Select Banner', 'adrotate'); ?>" />
					</label><br />
					<?php _e('- OR -', 'adrotate'); ?><br />
					<label for="adrotate_image_dropdown">
						<?php _e('Banner folder:', 'adrotate'); ?> <select tabindex="5" name="adrotate_image_dropdown" style="min-width: 200px;">
	   						<option value=""><?php _e('No image selected', 'adrotate'); ?></option>
							<?php echo adrotate_folder_contents($image_dropdown); ?>
						</select><br />
					</label>
					<em><?php _e('Use %asset% in the adcode instead of the file path.', 'adrotate'); ?> <?php _e('Use either the text field or the dropdown. If the textfield has content that field has priority.', 'adrotate'); ?></em>
				</td>
			</tr>
			<?php if($adrotate_config['stats'] > 0) { ?>
	      	<tr>
		        <th width="15%" valign="top"><?php _e('Statistics', 'adrotate'); ?></th>
		        <td colspan="3">
		        	<label for="adrotate_tracker"><input tabindex="6" type="checkbox" name="adrotate_tracker" <?php if($edit_banner->tracker == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Enable click and impression tracking for this advert.', 'adrotate'); ?> <br />
		        	<em><?php _e('Note: Clicktracking does not work for Javascript adverts such as those provided by Google AdSense/DFP/DoubleClick. HTML5/Flash adverts are not always supported.', 'adrotate'); ?></em>
			        </label>
		        </td>
	      	</tr>
			<?php } ?>
	      	<tr>
		        <th><?php _e('Activate', 'adrotate'); ?></th>
		        <td colspan="3">
			        <label for="adrotate_active">
				        <select tabindex="7" name="adrotate_active">
							<option value="active" <?php if($edit_banner->type == "active" OR $edit_banner->type == "error") { echo 'selected'; } ?>><?php _e('Yes, this ad will be used', 'adrotate'); ?></option>
							<option value="disabled" <?php if($edit_banner->type == "disabled") { echo 'selected'; } ?>><?php _e('No, do not show this ad anywhere', 'adrotate'); ?></option>
						</select>
					</label>
				</td>
	      	</tr>
			</tbody>
		</table>
		<center><?php _e('Get more features with AdRotate Pro.', 'adrotate'); ?> <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>
	
		<p class="submit">
			<input tabindex="8" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
	
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
	
		<?php
		$partner = mt_rand(1,4);
		if($partner < 4) {
		?>
		<h2><?php _e('Get your adverts from Media.net', 'adrotate'); ?></h2>
		<table class="widefat" style="margin-top: .5em">
			<tbody>
	      	<tr>
		        <th width="40%"><center><a href="https://ajdg.solutions/go/medianet/" target="_blank"><img src="<?php echo plugins_url("../images/offers/medianet-large-$partner.jpg", dirname(__FILE__)); ?>" width="440" /></a></center></th>
		        <td>
			        <p><a href="https://ajdg.solutions/go/medianet/" target="_blank">Media.net</a> is the <strong>#2 largest contextual ads platform</strong> in the world that provides its publishers with an <strong>exclusive access to the Yahoo! Bing Network of advertisers and $6bn worth of search demand.</strong></p>
		        	<p><a href="https://ajdg.solutions/go/medianet/" target="_blank">Media.net</a> <strong>ads are contextual</strong> and hence always relevant to your content. They are also <strong>native by design</strong> and highly customizable, delivering a great user experience and higher CTRs.</p>
				</td>
	      	</tr>
	      	</tbody>
		</table>
		<?php } else { ?>
		<h2><?php _e('Sign up with Blind Ferret', 'adrotate'); ?></h2>
		<table class="widefat" style="margin-top: .5em">
			<tbody>
	      	<tr>
		        <th width="40%"><center><a href="https://ajdg.solutions/go/blindferret/" target="_blank"><img src="<?php echo plugins_url("../images/offers/blindferret.jpg", dirname(__FILE__)); ?>" width="440" /></a></center></th>
		        <td>
			        <p>At <a href="https://ajdg.solutions/go/blindferret/" target="_blank">Blind Ferret</a>, we are publishers too, which means we know what's needed to create successful campaigns! We know that advertising isn't just "set it and forget it" anymore. Our Publisher Network features a wide range of creative and comic sites, is simple to take advantage of and intensely UI/UX focused.</p>
	
					<p>With over 15 years of experience, <a href="https://ajdg.solutions/go/blindferret/" target="_blank">Blind Ferret</a> can offer great ads at top dollar via header bidding, ensuring advertisers vie for your ad space, which brings in higher quality ads and makes you more money!</p>
				</td>
	      	</tr>
	      	</tbody>
		</table>
		<?php } ?>
	
		<h2><?php _e('Schedule your advert', 'adrotate'); ?></h2>
		<p><em><?php _e('Time uses a 24 hour clock. When you\'re used to the AM/PM system keep this in mind: If the start or end time is after lunch, add 12 hours. 2PM is 14:00 hours. 6AM is 6:00 hours.', 'adrotate'); ?></em></p>
		<table class="widefat" style="margin-top: .5em">
			<tbody>
			<tr>
		        <th width="15%"><?php _e('Start date', 'adrotate'); ?> (dd-mm-yyyy)</th>
		        <td width="35%">
					<input tabindex="9" type="text" id="startdate_picker" name="adrotate_start_date" value="<?php echo $start_date; ?>" class="datepicker ajdg-inputfield" autocomplete="off" />
		        </td>
		        <th width="15%"><?php _e('End date', 'adrotate'); ?> (dd-mm-yyyy)</th>
		        <td>
					<input tabindex="10" type="text" id="enddate_picker" name="adrotate_end_date" value="<?php echo $end_date; ?>" class="datepicker ajdg-inputfield" autocomplete="off" />
				</td>
	      	</tr>	
			<tr>
		        <th><?php _e('Start time', 'adrotate'); ?> (hh:mm)</th>
		        <td>
		        	<label for="adrotate_sday">
					<input tabindex="11" name="adrotate_start_hour" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $start_hour; ?>" autocomplete="off" /> :
					<input tabindex="12" name="adrotate_start_minute" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $start_hour; ?>" autocomplete="off" />
					</label>
		        </td>
		        <th><?php _e('End time', 'adrotate'); ?> (hh:mm)</th>
		        <td>
		        	<label for="adrotate_eday">
					<input tabindex="13" name="adrotate_end_hour" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $end_hour; ?>" autocomplete="off" /> :
					<input tabindex="14" name="adrotate_end_minute" class="ajdg-inputfield" type="text" size="2" maxlength="4" value="<?php echo $end_minute; ?>" autocomplete="off" />
					</label>
				</td>
	      	</tr>	
			<?php if($adrotate_config['stats'] == 1) { ?>
	      	<tr>
	      		<th><?php _e('Maximum Clicks', 'adrotate'); ?></th>
		        <td><input tabindex="19" name="adrotate_maxclicks" type="text" size="5" class="ajdg-inputfield" autocomplete="off" value="<?php echo $schedule->maxclicks;?>" /> <em><?php _e('Leave empty or 0 to skip this.', 'adrotate'); ?></em></td>
			    <th><?php _e('Maximum Impressions', 'adrotate'); ?></th>
		        <td><input tabindex="20" name="adrotate_maxshown" type="text" size="5" class="ajdg-inputfield" autocomplete="off" value="<?php echo $schedule->maximpressions;?>" /> <em><?php _e('Leave empty or 0 to skip this.', 'adrotate'); ?></em></td>
			</tr>
			<?php } ?>
			</tbody>					
		</table>
		<center><?php _e('Create multiple and more advanced schedules for each advert with AdRotate Pro.', 'adrotate'); ?> <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>
	
		<p class="submit">
			<input tabindex="21" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
	
		<h2><?php _e('Advanced', 'adrotate'); ?></h2>
		<p><em><?php _e('Available in AdRotate Pro!', 'adrotate'); ?></em></p>
		<table class="widefat" style="margin-top: .5em">
	
			<tbody>
			<tr>
		        <th width="15%" valign="top"><?php _e('Show to everyone', 'adrotate-pro'); ?></th>
		        <td colspan="5">
		        	<label for="adrotate_show_everyone"><input type="checkbox" name="adrotate_show_everyone" checked disabled /> <?php _e('Disable this option to hide the advert from logged-in visitors.', 'adrotate-pro'); ?>
			        </label>
	 	        </td>
			</tr>
	       	<tr>
			    <th width="15%" valign="top"><?php _e('Weight', 'adrotate'); ?></th>
		        <td width="17%">
		        	<label for="adrotate_weight">
		        	<center><input type="radio" disabled name="adrotate_weight" value="2" /><br /><?php _e('Few impressions', 'adrotate'); ?></center>
		        	</label>
				</td>
		        <td width="17%">
		        	<label for="adrotate_weight">
		        	<center><input type="radio" disabled name="adrotate_weight" value="4" /><br /><?php _e('Less than average', 'adrotate'); ?></center>
		        	</label>
				</td>
		        <td width="17%">
		        	<label for="adrotate_weight">
		        	<center><input type="radio" disabled name="adrotate_weight" value="6" checked="1" /><br /><?php _e('Normal impressions', 'adrotate'); ?></center>
		        	</label>
				</td>
		        <td width="17%">
		        	<label for="adrotate_weight">
		        	<center><input type="radio" disabled name="adrotate_weight" value="8" /><br /><?php _e('More than average', 'adrotate'); ?></center>
		        	</label>
				</td>
		        <td>
		        	<label for="adrotate_weight">
		        	<center><input type="radio" disabled name="adrotate_weight" value="10" /><br /><?php _e('Many impressions', 'adrotate'); ?>
		        	</label>
				</td>
			</tr>
	     	<tr>
		        <th width="15%" valign="top"><?php _e('Mobile', 'adrotate'); ?></th>
		        <td>
		        	<label for="adrotate_desktop"><center><input disabled type="checkbox" name="adrotate_desktop" checked="1" /><br /><?php _e('Desktops/Laptops', 'adrotate'); ?></center></label>
		        </td>
		        <td>
		        	<label for="adrotate_mobile"><center><input disabled type="checkbox" name="adrotate_mobile" checked="1" /><br /><?php _e('Smartphones', 'adrotate'); ?></center></label>
		        </td>
		        <td>
		        	<label for="adrotate_tablet"><center><input disabled type="checkbox" name="adrotate_tablet" checked="1" /><br /><?php _e('Tablets', 'adrotate'); ?></center></label>
		        </td>
		        <td colspan="2" rowspan="2">
		        	<em><?php _e("Also enable 'Mobile Support' in the group this advert goes in or 'Device' and 'Operating System' are ignored!", 'adrotate'); ?><br /><?php _e("Operating system detection only detects iOS and Android, select 'Not Mobile/Other' for everything else.", 'adrotate'); ?></em>
		        </td>
			</tr>
	     	<tr>
		        <th width="15%" valign="top"><?php _e('Mobile OS', 'adrotate'); ?></th>
		        <td>
		        	<label for="adrotate_ios"><center><input disabled type="checkbox" name="adrotate_ios" checked="1" /><br /><?php _e('iOS', 'adrotate'); ?></center></label>
		        </td>
		        <td>
		        	<label for="adrotate_android"><center><input disabled type="checkbox" name="adrotate_android" checked="1" /><br /><?php _e('Android', 'adrotate'); ?></center></label>
		        </td>
		        <td>
		        	<label for="adrotate_other"><center><input disabled type="checkbox" name="adrotate_other" checked="1" /><br /><?php _e('Not mobile/Others', 'adrotate'); ?></center></label>
		        </td>
			</tr>
	     	<tr>
		        <th valign="top"><?php _e('Auto-delete', 'adrotate'); ?></th>
		        <td colspan="5">
		        	<label for="adrotate_autodelete"><input tabindex="31" type="checkbox" name="adrotate_autodelete" disabled /></label> <?php _e('Automatically delete the advert 1 day after it expires?', 'adrotate'); ?><br /><em><?php _e('This is useful for short running campaigns that do not require attention after they finish.', 'adrotate'); ?></em>
		        </td>
			</tr>
			</tbody>
		</table>
		<center><?php _e('With AdRotate Pro you can easily select which devices and mobile operating systems the advert should show on!', 'adrotate'); ?>  <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>
	
		<h2><?php _e('Geo Targeting', 'adrotate'); ?></h2>
		<p><em><?php _e('Assign the advert to a group and enable that group to use Geo Targeting.', 'adrotate'); ?> <?php _e('Available in AdRotate Pro!', 'adrotate'); ?></em></p>
	
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
				<div id="left-column" class="ajdg-postbox-container">
	
					<div class="ajdg-postbox">				
						<h2 class="ajdg-postbox-title"><?php _e('Select Countries and or Regions', 'adrotate'); ?></h2>
						<div id="countries" class="ajdg-postbox-content">
							<div class="adrotate-select ajdg-fullwidth">
								<table width="100%">
									<tbody>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">United States</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Australia</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Germany</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Brazil</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Japan</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Netherlands</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Mexico</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">Canada</td>
									</tr>
									<tr>
										<td class="check-column" style="padding: 0px;"><input type="checkbox" name="adrotate_geo_countries[]" value="" disabled></td><td style="padding: 0px;">South Africa</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
		
				</div>
				<div id="right-column" class="ajdg-postbox-container">
		
					<div class="ajdg-postbox">
						<h2 class="ajdg-postbox-title"><?php _e('Enter cities, metro IDs, States or State ISO codes', 'adrotate'); ?></h2>
						<div id="cities" class="ajdg-postbox-content">
							<textarea name="adrotate_geo_cities" cols="40" rows="6" class="ajdg-fullwidth" disabled>Amsterdam, 29022, Noord Holland, New York, California, Tokyo, London, CA, NY, Ohio</textarea><br />
							<p><em><?php _e('A comma separated list of items:', 'adrotate'); ?> (Alkmaar, New York, Manila, Tokyo) <?php _e('AdRotate does not check the validity of names so make sure you spell them correctly!', 'adrotate'); ?></em></p>
						</div>
					</div>
		
				</div>
			</div>
		</div>
	
	   	<div class="clear"></div>
		<center><?php _e('Target your audience with Geo Targeting in AdRotate Pro', 'adrotate'); ?>, <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>
	
		<h3><?php _e('Usage', 'adrotate'); ?></h3>
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
			<input tabindex="24" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
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
			<input tabindex="25" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
		<?php } ?>
	</form>
<?php
} else {
	echo adrotate_error('error_loading_item');
}
?>
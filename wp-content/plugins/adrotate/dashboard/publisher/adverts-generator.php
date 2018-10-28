<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

if(!$ad_edit_id) { 
	$edit_id = $wpdb->get_var("SELECT `id` FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'generator' ORDER BY `id` DESC LIMIT 1;");
	if($edit_id == 0) {
	    $wpdb->insert($wpdb->prefix."adrotate", array('title' => '', 'bannercode' => '', 'thetime' => $now, 'updated' => $now, 'author' => $userdata->user_login, 'imagetype' => 'dropdown', 'image' => '', 'paid' => 'U', 'tracker' => 'N', 'desktop' => 'Y', 'mobile' => 'Y', 'tablet' => 'Y', 'os_ios' => 'Y', 'os_android' => 'Y', 'os_other' => 'Y', 'responsive' => 'N', 'type' => 'generator', 'weight' => 6, 'autodelete' => 'N', 'budget' => 0, 'crate' => 0, 'irate' => 0, 'cities' => serialize(array()), 'countries' => serialize(array())));
	    $edit_id = $wpdb->insert_id;

		$wpdb->insert($wpdb->prefix.'adrotate_schedule', array('name' => 'Schedule for ad '.$edit_id, 'starttime' => $now, 'stoptime' => $in84days, 'maxclicks' => 0, 'maximpressions' => 0, 'spread' => 'N', 'daystarttime' => '0000', 'daystoptime' => '0000', 'day_mon' => 'Y', 'day_tue' => 'Y', 'day_wed' => 'Y', 'day_thu' => 'Y', 'day_fri' => 'Y', 'day_sat' => 'Y', 'day_sun' => 'Y', 'autodelete' => 'N'));
	    $schedule_id = $wpdb->insert_id;
		$wpdb->insert($wpdb->prefix.'adrotate_linkmeta', array('ad' => $edit_id, 'group' => 0, 'user' => 0, 'schedule' => $schedule_id));
	}
	$ad_edit_id = $edit_id;
}

$edit_banner = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}adrotate` WHERE `id` = '$ad_edit_id';");

wp_enqueue_media();
wp_enqueue_script('uploader-hook', plugins_url().'/adrotate-pro/library/uploader-hook.js', array('jquery'));
?>

	<form method="post" action="admin.php?page=adrotate-ads">
	<?php wp_nonce_field('adrotate_generate_ad','adrotate_nonce'); ?>
	<input type="hidden" name="adrotate_id" value="<?php echo $edit_banner->id;?>" />

	<h2><?php _e('Generate Advert Code', 'adrotate'); ?></h2>
	<p><?php _e('Use the Generator if you have received a target url, banner image and/or some separate files with a description on how to use those. The AdRotate Generator will take your bits and pieces and try to generate a working adcode from it.', 'adrotate'); ?></p>

	<p><?php _e('If you have a complete and working ad code / ad tag you do not use the Generator. You can simply paste that code in the AdCode field when creating your advert. For example as provided by Media.net or Google AdSense among others.', 'adrotate'); ?></p>

	<h2><?php _e('Basic advert', 'adrotate'); ?></h2>
	<em><?php _e('This is a regular advert consisting of an image and a link, made up from HTML code.', 'adrotate'); ?></em>
	<table class="widefat" style="margin-top: .5em">

		<tbody>
		<tr>
	        <th valign="top"><?php _e('Banner asset', 'adrotate'); ?></th>
			<td>
				<label for="adrotate_basic_dropdown">
					<select tabindex="1" id="adrotate_basic_dropdown" name="adrotate_basic_dropdown" style="min-width: 300px;">
   						<option value=""><?php _e('No file selected', 'adrotate'); ?></option>
						<?php echo adrotate_folder_contents('', 'image'); ?>
					</select> <?php _e('Is your file not listed? Upload it via the AdRotate Media Manager.', 'adrotate'); ?></label><br />
					<?php _e('- OR -', 'adrotate'); ?><br />
	        	<label for="adrotate_text"><input tabindex="2" id="adrotate_text" name="adrotate_text" type="text" size="60" class="search-input" value="" autocomplete="off" /> <?php _e('Visible text if this is a text link banner.', 'adrotate'); ?><br /><em><?php _e('Use either the dropdown or the text field. If the dropdown is used, that field has priority.', 'adrotate'); ?></em></label>
				
			</td>
		</tr>
		<tr>
	        <th width="15%" valign="top"><?php _e('Target website', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_targeturl"><input tabindex="3" id="adrotate_targeturl" name="adrotate_targeturl" type="text" size="60" class="search-input" value="" autocomplete="off" /> <?php _e('Where does the person clicking the advert go?', 'adrotate'); ?></label>
	        </td>
		</tr>
     	<tr>
	        <th valign="top"><?php _e('Target window', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_newwindow_disabled"><input tabindex="4" type="checkbox" name="adrotate_newwindow_disabled" disabled="1" /></label> <?php _e('Available in AdRotate Pro.', 'adrotate'); ?> <?php _e('Open the target website in a new window?', 'adrotate'); ?>
	        </td>
 		</tr>
    	<tr>
	        <th valign="top"><?php _e('NoFollow', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_nofollow_disabled"><input tabindex="5" type="checkbox" name="adrotate_nofollow_disabled" disabled="1"/></label> <?php _e('Available in AdRotate Pro.', 'adrotate'); ?> <?php _e('Tell crawlers and search engines not to follow the target website url?', 'adrotate'); ?>
	        </td>
		</tr>
	    <tr>
			<th valign="top"><?php _e('Advert size', 'adrotate'); ?></strong></th>
			<td>
				<label for="adrotate_width"><input tabindex="6" name="adrotate_width" type="text" class="search-input" size="5" value="" autocomplete="off" /> <?php _e('px wide', 'adrotate'); ?>,</label> 
				<label for="adrotate_height"><input tabindex="7" name="adrotate_height" type="text" class="search-input" size="5" value="" autocomplete="off" /> <?php _e('px high.', 'adrotate'); ?></label> 
				<?php _e('Define the maximum size of the adverts in pixels.', 'adrotate'); ?> <?php _e('(Optional)', 'adrotate'); ?>
			</td>
		</tr>
		</tbody>

	</table>

	<h2><?php _e('HTML5 or Flash Advert', 'adrotate'); ?></h2>
	<em><?php _e('These are more advanced adverts, using a Flash file or HTML5 files. Try to avoid Flash. HTML5 is the new and better standard.', 'adrotate'); ?><br />
	<?php _e('If your HTML5 advert consists of multiple files, upload all files using the AdRotate Media Manager and select the HTML file here.', 'adrotate'); ?></em>
	<table class="widefat" style="margin-top: .5em">

		<tbody>
		<tr>
	        <th valign="top" width="15%"><?php _e('HTML/Flash file', 'adrotate'); ?></th>
			<td>
				<label for="adrotate_html5_dropdown">
					<select tabindex="8" id="adrotate_html5_dropdown" name="adrotate_html5_dropdown" style="min-width: 300px;">
   						<option value=""><?php _e('No file selected', 'adrotate'); ?></option>
						<?php echo adrotate_folder_contents('', 'html5'); ?>
					</select> <?php _e('Is your file not listed? Upload it via the AdRotate Media Manager.', 'adrotate'); ?>
				</label>
			</td>
		</tr>
	    <tr>
			<th valign="top"><?php _e('Advert size', 'adrotate'); ?></strong></th>
			<td>
				<label for="adrotate_html5_width"><input tabindex="9" name="adrotate_html5_width" type="text" class="search-input" size="5" value="" autocomplete="off" /> <?php _e('px wide', 'adrotate'); ?>,</label> 
				<label for="adrotate_html5_height"><input tabindex="10" name="adrotate_html5_height" type="text" class="search-input" size="5" value="" autocomplete="off" /> <?php _e('px high.', 'adrotate'); ?></label>
				<?php _e('Define the maximum size of the adverts in pixels.', 'adrotate'); ?>
			</td>
		</tr>
		<tr>
	        <th valign="top" width="15%"><?php _e('Flash clickTAG', 'adrotate'); ?></th>
			<td>
				<label for="adrotate_html5_clicktag">
					<?php _e('Parameter', 'adrotate'); ?> <select tabindex="11" id="adrotate_html5_clicktag_disabled" name="adrotate_html5_clicktag_disabled" style="min-width: 200px;" disabled="1">
   						<option value=""><?php _e('No clickTAG', 'adrotate'); ?></option>
					</select> <?php _e('URL', 'adrotate'); ?> <input tabindex="12" id="adrotate_html5_clicktag_disabled" name="adrotate_html5_clicktag_disabled" type="text" size="50" class="search-input" value="" autocomplete="off" disabled="1" /> <?php _e('(Optional)', 'adrotate'); ?><br /><em><?php _e('Available in AdRotate Pro.', 'adrotate'); ?> <?php _e('This option is ignored for HTML5 adverts. All choices do the exact same, but some developers write the parameter differently.', 'adrotate'); ?></em>
				</label>
			</td>
		</tr>
		</tbody>

	</table>

	<p class="submit">
		<input tabindex="13" type="submit" name="adrotate_generate_submit" class="button-primary" value="<?php _e('Generate and Configure Advert', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a> <?php _e('Always test your adverts before activating them.', 'adrotate'); ?>
	</p>

	<p><em><strong><?php _e('NOTE:', 'adrotate'); ?></strong> <?php _e('While the Code Generator has been tested and works, code generation, as always, is a interpretation of user input. If you provide the correct bits and pieces, a working advert may be generated. If you leave fields empty or insert the wrong info you probably end up with a broken advert.', 'adrotate'); ?><br /><?php _e('Based on your input and experiences later iterations of the Code Generator will be better and more feature rich.', 'adrotate'); ?></em></p>
</form>
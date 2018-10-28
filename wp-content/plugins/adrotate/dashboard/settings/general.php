<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */
?>

<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=general">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('General Settings', 'adrotate'); ?></h2>
<span class="description"><?php _e('General settings for AdRotate.', 'adrotate'); ?> <?php _e('Some options are only available in AdRotate Pro!', 'adrotate'); ?></span>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Shortcode in widgets', 'adrotate'); ?></th>
		<td><label for="adrotate_textwidget_shortcodes"><input type="checkbox" name="adrotate_textwidget_shortcodes" disabled /><?php _e('Enable this option to if your theme does not support shortcodes in the WordPress text widget.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Disable live preview', 'adrotate'); ?></th>
		<td><label for="adrotate_live_preview"><input type="checkbox" name="adrotate_live_preview" disabled checked /><?php _e('Enable this option if you have faulty adverts that overflow their designated area while creating/editing adverts.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Disable dynamic mode', 'adrotate'); ?></th>
		<td><label for="adrotate_mobile_dynamic_mode"><input type="checkbox" name="adrotate_mobile_dynamic_mode" <?php if($adrotate_config['mobile_dynamic_mode'] == 'Y') { ?>checked="checked" <?php } ?> /><?php _e('Enable this option to disable dynamic mode in groups for mobile devices if you notice skipping or jumpy content.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Load jQuery', 'adrotate'); ?></th>
		<td><label for="adrotate_jquery"><input type="checkbox" name="adrotate_jquery" <?php if($adrotate_config['jquery'] == 'Y') { ?>checked="checked" <?php } ?> /><?php _e('Enable this option if your theme does not load jQuery. jQuery is required for dynamic groups, statistics and some other features.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Load scripts in footer?', 'adrotate'); ?></th>
		<td><label for="adrotate_jsfooter"><input type="checkbox" name="adrotate_jsfooter" <?php if($adrotate_config['jsfooter'] == 'Y') { ?>checked="checked" <?php } ?> /><?php _e('Enable this option if you want to load all AdRotate Javascripts in the footer of your site.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Adblock disguise', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_adblock_disguise"><input name="adrotate_adblock_disguise" type="text" class="search-input" size="6" value="getpro" disabled /> <?php _e('Leave empty to disable. Use only lowercaps letters. For example:', 'adrotate'); ?> <?php echo adrotate_rand(6); ?><br />
			<span class="description"><?php _e('Try and avoid adblock plugins in most modern browsers when using shortcodes.', 'adrotate'); ?><br /><?php _e('To also apply this feature to widgets, use a text widget with a shortcode instead of the AdRotate widget.', 'adrotate'); ?><br /><?php _e('Avoid the use of obvious keywords or filenames in your adverts or this feature will have little effect!', 'adrotate'); ?></span>
		</td>
	</tr>
</table>

<h3><?php _e('Banner Folder', 'adrotate'); ?></h3>
<span class="description"><?php _e('Set a folder where your banner images will be stored.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Folder name', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_banner_folder"><?php echo WP_CONTENT_DIR; ?>/<input name="adrotate_banner_folder_disabled" type="text" class="search-input" size="20" value="<?php echo $adrotate_config['banner_folder']; ?>" disabled="1" />/ <?php _e('(Default: banners).', 'adrotate'); ?><br />
			<span class="description"><?php _e('To try and trick ad blockers you could set the folder to something crazy like:', 'adrotate'); ?> "<?php echo adrotate_rand(12); ?>".<br />
			<?php _e("This folder will not be automatically created if it doesn't exist. AdRotate will show errors when the folder is missing.", 'adrotate'); ?></span>
		</td>
	</tr>
</table>

<h3><?php _e('Bot filter', 'adrotate'); ?></h3>
<span class="description"><?php _e('The bot filter is used for the AdRotate stats tracker.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('User-Agent Filter', 'adrotate'); ?></th>
		<td>
			<textarea name="adrotate_crawlers" cols="90" rows="10"><?php echo $crawlers; ?></textarea><br />
			<span class="description"><?php _e('A comma separated list of keywords. Filter out bots/crawlers/user-agents.', 'adrotate'); ?><br />
			<?php _e('Keep in mind that this might give false positives. The word \'fire\' also matches \'firefox\', but not vice-versa. So be careful!', 'adrotate'); ?><br />
			<?php _e('Only words with alphanumeric characters and [ - _ ] are allowed. All other characters are stripped out.', 'adrotate'); ?><br />
			<?php _e('Additionally to the list specified here, empty User-Agents are blocked as well.', 'adrotate'); ?> (<?php _e('Learn more about', 'adrotate'); ?> <a href="http://en.wikipedia.org/wiki/User_agent" title="User Agents" target="_blank"><?php _e('user-agents', 'adrotate'); ?></a>.)</span>
		</td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
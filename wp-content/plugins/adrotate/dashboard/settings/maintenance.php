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
<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=maintenance">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Maintenance', 'adrotate'); ?></h2>
<span class="description"><?php _e('Use these functions when you notice your database is slow, unresponsive and sluggish.', 'adrotate'); ?></span>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Optimize Database', 'adrotate'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_db_optimize_submit" value="<?php _e('Optimize Database', 'adrotate'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to optimize the AdRotate database.', 'adrotate'); ?>\n\n<?php _e('Did you make a backup of your database?', 'adrotate'); ?>\n\n<?php _e('This may take a moment and may cause your website to respond slow temporarily!', 'adrotate'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate'); ?>')" /><br />
			<span class="description"><?php _e('Cleans up overhead data in the AdRotate tables.', 'adrotate'); ?><br />
			<?php _e('Overhead data is accumulated garbage resulting from many changes you\'ve made. This can vary from nothing to hundreds of KiB of data.', 'adrotate'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Clean-up Database and Files', 'adrotate'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_db_cleanup_submit" value="<?php _e('Clean-up Database', 'adrotate'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to clean up your database. This may delete expired schedules, older statistics and try to delete export files', 'adrotate'); ?>\n\n<?php _e('Are you sure you want to continue?', 'adrotate'); ?>\n<?php _e('THIS ACTION CAN NOT BE UNDONE!', 'adrotate'); ?>')" /><br />
			<label for="adrotate_db_cleanup_statistics"><input type="checkbox" name="adrotate_db_cleanup_statistics" value="1" /> <?php _e('Delete stats older than 365 days.', 'adrotate'); ?></label><br />
			<label for="adrotate_db_cleanup_exportfiles"><input type="checkbox" name="adrotate_db_cleanup_exportfiles" value="1" /> <?php _e('Delete leftover export files.', 'adrotate'); ?></label><br />
			<span class="description"><?php _e('For when you create an advert, group or schedule and it does not save or keep changes you make.', 'adrotate'); ?><br /><?php _e('Additionally you can delete statistics and/or unused export files. This will improve the speed of your site.', 'adrotate'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Re-evaluate Ads', 'adrotate'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_evaluate_submit" value="<?php _e('Re-evaluate all ads', 'adrotate'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to check all ads for errors.', 'adrotate'); ?>\n\n<?php _e('This might take a while and may slow down your site during this action!', 'adrotate'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate'); ?>')" /><br />
			<span class="description"><?php _e('This will apply all evaluation rules to all ads to see if any error slipped in. Normally you should not need this feature.', 'adrotate'); ?></span>
		</td>
	</tr>
</table>
<span class="description"><?php _e('DISCLAIMER: The above functions are intented to be used to OPTIMIZE your database. They only apply to your ads/groups and stats. Not to other settings or other parts of WordPress! Always always make a backup! If for any reason your data is lost, damaged or otherwise becomes unusable in any way or by any means in whichever way I will not take responsibility. You should always have a backup of your database. These functions do NOT destroy data. If data is lost, damaged or unusable in any way, your database likely was beyond repair already. Claiming it worked before clicking these buttons is not a valid point in any case.', 'adrotate'); ?></span>

<h3><?php _e('Troubleshooting', 'adrotate'); ?></h3>
<span class="description"><?php _e('The below options are not meant for normal use and are only there for developers to review saved settings or how ads are selected. These can be used as a measure of troubleshooting upon request but for normal use they SHOULD BE LEFT UNCHECKED!!', 'adrotate'); ?></span>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Developer Debug', 'adrotate'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_debug" <?php if($adrotate_debug['general'] == true) { ?>checked="checked" <?php } ?> /> General - <span class="description"><?php _e('Troubleshoot ads and how they are selected. Visible on the front-end.', 'adrotate'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_timers" <?php if($adrotate_debug['timers'] == true) { ?>checked="checked" <?php } ?> /> Clicktracking - <span class="description"><?php _e('Disable timers for clicks and impressions.', 'adrotate'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_track" <?php if($adrotate_debug['track'] == true) { ?>checked="checked" <?php } ?> /> Tracking Encryption - <span class="description"><?php _e('Temporarily disable encryption on the redirect url.', 'adrotate'); ?></span><br />
		</td>
	</tr>
</table>

<h3><?php _e('Status and Versions', 'adrotate'); ?></h3>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Current status of adverts', 'adrotate'); ?></th>
		<td colspan="3"><?php _e('Normal', 'adrotate'); ?>: <?php echo $advert_status['normal']; ?>, <?php _e('Error', 'adrotate'); ?>: <?php echo $advert_status['error']; ?>, <?php _e('Expired', 'adrotate'); ?>: <?php echo $advert_status['expired']; ?>, <?php _e('Expires Soon', 'adrotate'); ?>: <?php echo $advert_status['expiressoon']; ?>, <?php _e('Unknown', 'adrotate'); ?>: <?php echo $advert_status['unknown']; ?>.</td>
	</tr>
	<tr>
		<th width="15%"><?php _e('Banners/assets Folder', 'adrotate'); ?></th>
		<td colspan="3">
			<?php
			echo WP_CONTENT_DIR.'/'.$adrotate_config['banner_folder'].'/ -> ';
			echo (is_writeable(WP_CONTENT_DIR.'/'.$adrotate_config['banner_folder']).'/') ? '<span style="color:#009900;">'.__('Exists and appears writable', 'adrotate').'</span>' : '<span style="color:#CC2900;">'.__('Not writable or does not exist', 'adrotate').'</span>';
			?>
		</td>
	</tr>
	<tr>
		<th width="15%"><?php _e('Reports Folder', 'adrotate'); ?></th>
		<td colspan="3">
			<?php
			echo WP_CONTENT_DIR.'/reports/'.' -> ';
			echo (is_writable(WP_CONTENT_DIR.'/reports/')) ? '<span style="color:#009900;">'.__('Exists and appears writable', 'adrotate').'</span>' : '<span style="color:#CC2900;">'.__('Not writable or does not exist', 'adrotate').'</span>';
			?>
		</td>
	</tr>
	<tr>
		<th width="15%"><?php _e('Advert evaluation', 'adrotate'); ?></th>
		<td><?php if(!$adevaluate) '<span style="color:#CC2900;">'._e('Not scheduled! Re-activate the plugin from the plugins page.', 'adrotate').'</span>'; else echo '<span style="color:#009900;">'.date_i18n(get_option('date_format')." H:i", $adevaluate).'</span>'; ?></td>
		<th width="15%"><?php _e('Clean Trackerdata', 'adrotate'); ?></th>
		<td><?php if(!$tracker) '<span style="color:#CC2900;">'._e('Not scheduled!', 'adrotate').'</span>'; else echo '<span style="color:#009900;">'.date_i18n(get_option('date_format')." H:i", $tracker).'</span>'; ?></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Background tasks', 'adrotate'); ?></th>
		<td colspan="3">
			<a class="button" href="admin.php?page=adrotate&tasks=1"><?php _e('Reset background tasks', 'adrotate'); ?></a>
		</td>
	</tr>
</table>

<h2><?php _e('Internal Versions', 'adrotate'); ?></h2>
<span class="description"><?php _e('Unless you experience database issues or a warning shows below, these numbers are not really relevant for troubleshooting. Support may ask for them to verify your database status.', 'adrotate'); ?></span>
<table class="form-table">			
	<tr>
		<th width="15%" valign="top"><?php _e('AdRotate version', 'adrotate'); ?></th>
		<td><?php _e('Current:', 'adrotate'); ?> <?php echo '<span style="color:#009900;">'.$adrotate_version['current'].'</span>'; ?> <?php if($adrotate_version['current'] != ADROTATE_VERSION) { echo '<span style="color:#CC2900;">'; _e('Should be:', 'adrotate'); echo ' '.ADROTATE_VERSION; echo '</span>'; } ?><br /><?php _e('Previous:', 'adrotate'); ?> <?php echo $adrotate_version['previous']; ?></td>
		<th width="15%" valign="top"><?php _e('Database version', 'adrotate'); ?></th>
		<td><?php _e('Current:', 'adrotate'); ?> <?php echo '<span style="color:#009900;">'.$adrotate_db_version['current'].'</span>'; ?> <?php if($adrotate_db_version['current'] != ADROTATE_DB_VERSION) { echo '<span style="color:#CC2900;">'; _e('Should be:', 'adrotate'); echo ' '.ADROTATE_DB_VERSION; echo '</span>'; } ?><br /><?php _e('Previous:', 'adrotate'); ?> <?php echo $adrotate_db_version['previous']; ?></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Manual upgrade', 'adrotate'); ?></th>
		<td colspan="3">
			<a class="button" href="admin.php?page=adrotate&upgrade=1" onclick="return confirm('<?php _e('YOU ARE ABOUT TO DO A MANUAL UPDATE FOR ADROTATE.', 'adrotate'); ?>\n<?php _e('Make sure you have a database backup!', 'adrotate'); ?>\n\n<?php _e('This might take a while and may slow down your site during this action!', 'adrotate'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate'); ?>')"><?php _e('Run updater', 'adrotate'); ?></a>
		</td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
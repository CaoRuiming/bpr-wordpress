<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2020 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */
?>
<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=maintenance">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Maintenance', 'adrotate'); ?></h2>
<span class="description"><?php _e('Use these functions when you notice your database is slow, unresponsive and sluggish.', 'adrotate'); ?></span>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Check adverts', 'adrotate'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_evaluate_submit" value="<?php _e('Check for errors', 'adrotate'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to check all adverts for errors.', 'adrotate'); ?>\n\n<?php _e('This might take a few seconds!', 'adrotate'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate'); ?>')" />
			<br /><br />
			<span class="description"><?php _e('Apply all evaluation rules to all adverts to see if any error slipped in.', 'adrotate'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Clean-up Database and Files', 'adrotate'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_cleanup_submit" value="<?php _e('Run Clean-up', 'adrotate'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to do maintenance on your setup of AdRotate.', 'adrotate'); ?>\n\n<?php _e('This optionally may delete old statistics and tries to delete old export files.', 'adrotate'); ?>\n\n<?php _e('Are you sure you want to continue?', 'adrotate'); ?>\n<?php _e('THIS ACTION CAN NOT BE UNDONE!', 'adrotate'); ?>')" />
			<br /><br />
			<input type="checkbox" name="adrotate_db_cleanup_db" value="0" checked disabled /> <?php _e('Basic database maintenance.', 'adrotate'); ?><br />
			<label for="adrotate_db_cleanup_statistics"><input type="checkbox" name="adrotate_db_cleanup_statistics" id="adrotate_db_cleanup_statistics" value="1" /> <?php _e('Delete stats older than 365 days.', 'adrotate'); ?></label><br />
			<label for="adrotate_db_cleanup_exportfiles"><input type="checkbox" name="adrotate_db_cleanup_exportfiles" id="adrotate_db_cleanup_exportfiles" value="1" /> <?php _e('Delete leftover export files.', 'adrotate'); ?></label><br />
			<span class="description"><?php _e('For when you create an advert, group or schedule and it does not save or keep changes you make.', 'adrotate'); ?><br /><?php _e('Additionally you can delete statistics and/or unused export files. This will improve the speed of your site.', 'adrotate'); ?></span>
		</td>
	</tr>
</table>
<span class="description"><?php _e('DISCLAIMER: The above functions are intented to be used to OPTIMIZE your database or clean up overhead data. They only apply to your ads/groups and stats. Not to other settings or other parts of WordPress! Always always make a backup! If for any reason your data is lost, damaged or otherwise becomes unusable in any way or by any means in whichever way I will not take responsibility. You should always have a backup of your database. These functions do NOT destroy data. If data is lost, damaged or unusable in any way, your database likely was beyond repair already. Claiming it worked before clicking these buttons is not a valid point in any case.', 'adrotate'); ?></span>

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
			<a class="button" href="admin.php?page=adrotate-settings&tab=maintenance&action=reset-tasks"><?php _e('Reset background tasks', 'adrotate'); ?></a>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Unsupported plugins', 'adrotate'); ?></th>
		<td colspan="3">
			<a class="button" href="admin.php?page=adrotate-settings&tab=maintenance&action=disable-3rdparty"><?php _e('Disable 3rd party plugins', 'adrotate'); ?></a><br />
			<?php if(is_plugin_active('adrotate-extra-settings/adrotate-extra-settings.php') OR is_plugin_active('adrotate-email-add-on/adrotate-email-add-on.php') OR is_plugin_active('ad-builder-for-adrotate/ad-builder-for-adrotate.php') OR is_plugin_active('extended-adrotate-ad-placements/index.php')) { ?>
			<span style="color:#CC2900;"><?php _e('One or more unsupported 3rd party plugins detected.', 'adrotate'); ?></span><br />
			<?php } ?>
			<span class="description"><?php _e('These are plugins that alter functions of AdRotate or highjack parts of the dashboard which may affect security and/or stability.', 'adrotate'); ?></span>
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
			<a class="button" href="admin.php?page=adrotate-settings&tab=maintenance&action=update-db" onclick="return confirm('<?php _e('YOU ARE ABOUT TO DO A MANUAL UPDATE FOR ADROTATE.', 'adrotate'); ?>\n<?php _e('Make sure you have a database backup!', 'adrotate'); ?>\n\n<?php _e('This might take a while and may slow down your site during this action!', 'adrotate'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate'); ?>')"><?php _e('Run updater', 'adrotate'); ?></a>
		</td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */
?>
<h2><?php _e('Manage Schedules', 'adrotate'); ?></h2>
	<p><?php _e('In AdRotate Pro you can schedule adverts for multiple periods of time. One schedule can be assigned to many adverts allowing you to manage multi advert campaigns easily. Schedules can be active on certain days of the week or on certain hours of the day.', 'adrotate'); ?> <?php _e('Get more features', 'adrotate'); ?> - <a href="admin.php?page=adrotate-pro"><?php _e('Get AdRotate Pro', 'adrotate'); ?></a>!</p>

<form name="banners" id="post" method="post" action="admin.php?page=adrotate-schedules">
	<?php wp_nonce_field('adrotate_bulk_schedules','adrotate_nonce'); ?>

	<div class="tablenav top">
		<div class="alignleft actions">
			<select name="adrotate_action" id="cat" class="postform" disabled="1">
		        <option value=""><?php _e('Bulk Actions', 'adrotate'); ?></option>
			</select> <input type="submit" id="post-action-submit" name="adrotate_action_submit" value="<?php _e('Go', 'adrotate'); ?>" class="button-secondary" disabled="1" />
		</div>	
		<br class="clear" />
	</div>

	<table class="widefat tablesorter manage-schedules-main" style="margin-top: .5em">
		<thead>
		<tr>
			<td scope="col" class="manage-column column-cb check-column"><input type="checkbox" disabled="1" /></td>
			<th width="4%"><center><?php _e('ID', 'adrotate'); ?></center></th>
			<th width="20%"><?php _e('Start / End', 'adrotate'); ?></th>
			<th><?php _e('Name', 'adrotate'); ?></th>
	        <th width="4%"><center><?php _e('Adverts', 'adrotate'); ?></center></th>
	        <?php if($adrotate_config['stats'] == 1) { ?>
		        <th width="10%"><center><?php _e('Max Shown', 'adrotate'); ?></center></th>
		        <th width="10%"><center><?php _e('Max Clicks', 'adrotate'); ?></center></th>
			<?php } ?>
		</tr>
		</thead>
		<tbody>
	<?php
	$schedules = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}adrotate_schedule` WHERE `name` != '' ORDER BY `id` ASC;");
	if($schedules) {
		$tick = '<img src="'.plugins_url('../../images/tick.png', __FILE__).'" width="10" height"10" />';
		$cross = '<img src="'.plugins_url('../../images/cross.png', __FILE__).'" width="10" height"10" />';

		$class = '';
		foreach($schedules as $schedule) {
			$ads_use_schedule = $wpdb->get_results("SELECT `ad` FROM `{$wpdb->prefix}adrotate_linkmeta`, `{$wpdb->prefix}adrotate` WHERE `group` = 0 AND `user` = 0 AND `schedule` = ".$schedule->id." AND `ad` =  `{$wpdb->prefix}adrotate`.`id`;");

			if($adrotate_config['stats'] == 1) {
				if($schedule->maxclicks == 0) $schedule->maxclicks = '&infin;';
				if($schedule->maximpressions == 0) $schedule->maximpressions = '&infin;';
			}

			($class != 'alternate') ? $class = 'alternate' : $class = '';
			if($schedule->stoptime < $in2days) $class = 'row_orange';
			if($schedule->stoptime < $now) $class = 'row_red';

			$sdayhour = substr($schedule->daystarttime, 0, 2);
			$sdayminute = substr($schedule->daystarttime, 2, 2);
			$edayhour = substr($schedule->daystoptime, 0, 2);
			$edayminute = substr($schedule->daystoptime, 2, 2);
			?>
		    <tr id='adrotateindex' class='<?php echo $class; ?>'>
				<th class="check-column"><input type="checkbox" name="schedulecheck[]" value="<?php echo $schedule->id; ?>" disabled="1" /></th>
				<td><center><?php echo $schedule->id;?></center></td>
				<td><?php echo date_i18n("F d, Y H:i", $schedule->starttime);?><br /><span style="color: <?php echo adrotate_prepare_color($schedule->stoptime);?>;"><?php echo date_i18n("F d, Y H:i", $schedule->stoptime);?></span></td>
				<td><?php echo stripslashes(html_entity_decode($schedule->name)); ?><span style="color:#999;"><br /><?php _e('Mon:', 'adrotate'); ?> <?php echo ($schedule->day_mon == 'Y') ? $tick : $cross; ?> <?php _e('Tue:', 'adrotate'); ?> <?php echo ($schedule->day_tue == 'Y') ? $tick : $cross; ?> <?php _e('Wed:', 'adrotate'); ?> <?php echo ($schedule->day_wed == 'Y') ? $tick : $cross; ?> <?php _e('Thu:', 'adrotate'); ?> <?php echo ($schedule->day_thu == 'Y') ? $tick : $cross; ?> <?php _e('Fri:', 'adrotate'); ?> <?php echo ($schedule->day_fri == 'Y') ? $tick : $cross; ?> <?php _e('Sat:', 'adrotate'); ?> <?php echo ($schedule->day_sat == 'Y') ? $tick : $cross; ?> <?php _e('Sun:', 'adrotate'); ?> <?php echo ($schedule->day_sun == 'Y') ? $tick : $cross; ?> <?php if($schedule->daystarttime  > 0) { ?><?php _e('Between:', 'adrotate'); ?> <?php echo $sdayhour; ?>:<?php echo $sdayminute; ?> - <?php echo $edayhour; ?>:<?php echo $edayminute; ?> <?php } ?><br /><?php _e('Impression spread:', 'adrotate'); ?> <?php echo ($schedule->spread == 'Y') ? $tick : $cross; ?>, <?php _e('Auto Delete:', 'adrotate'); ?> <?php echo ($schedule->autodelete == 'Y') ? $tick : $cross; ?></span></td>
		        <td><center><?php echo count($ads_use_schedule); ?></center></td>
		        <?php if($adrotate_config['stats'] == 1) { ?>
			        <td><center><?php echo $schedule->maximpressions; ?></center></td>
			        <td><center><?php echo $schedule->maxclicks; ?></center></td>
				<?php } ?>
			</tr>
			<?php } ?>
		<?php } else { ?>
		<tr id='no-schedules'>
			<th class="check-column">&nbsp;</th>
			<td colspan="<?php echo ($adrotate_config['stats'] == 1) ? '7' : '5'; ?>"><em><?php _e('Nothing here!', 'adrotate'); ?></em></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<p><center>
	<span style="border: 1px solid #c80; height: 12px; width: 12px; background-color: #fdefc3">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Expires soon.", "adrotate"); ?>
	&nbsp;&nbsp;&nbsp;&nbsp;<span style="border: 1px solid #c00; height: 12px; width: 12px; background-color: #ffebe8">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Has expired.", "adrotate"); ?><br />
	<?php _e('Get more features with AdRotate Pro', 'adrotate'); ?> - <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!

</center></p>
</form>
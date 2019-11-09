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
<h3><?php _e('Active Adverts', 'adrotate'); ?></h3>

<form name="banners" id="post" method="post" action="admin.php?page=adrotate-ads">
	<?php wp_nonce_field('adrotate_bulk_ads_active','adrotate_nonce'); ?>

	<div class="tablenav top">
		<div class="alignleft actions">
			<select name="adrotate_action" id="cat" class="postform">
		        <option value=""><?php _e('Bulk Actions', 'adrotate'); ?></option>
		        <option value="deactivate"><?php _e('Deactivate', 'adrotate'); ?></option>
		        <option value="delete"><?php _e('Delete', 'adrotate'); ?></option>
		        <option value="reset"><?php _e('Reset stats', 'adrotate'); ?></option>
		        <option value="export-csv"><?php _e('Export to CSV', 'adrotate'); ?></option>
		        <option value="" disabled><?php _e('-- Renew --', 'adrotate'); ?></option>
		        <option value="renew-31536000"><?php _e('For 1 year', 'adrotate'); ?></option>
		        <option value="renew-5184000"><?php _e('For 180 days', 'adrotate'); ?></option>
		        <option value="renew-2592000"><?php _e('For 30 days', 'adrotate'); ?></option>
		        <option value="renew-604800"><?php _e('For 7 days', 'adrotate'); ?></option>
			</select> <input type="submit" id="post-action-submit" name="adrotate_action_submit" value="<?php _e('Go', 'adrotate'); ?>" class="button-secondary" />
		</div>	
		<br class="clear" />
	</div>

	<table class="widefat tablesorter manage-ads-main" style="margin-top: .5em">
		<thead>
		<tr>
			<td scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></td>
			<th width="2%"><center><?php _e('ID', 'adrotate'); ?></center></th>
			<th width="15%"><?php _e('Start / End', 'adrotate'); ?></th>
			<th><?php _e('Name', 'adrotate'); ?></th>
			<?php if($adrotate_config['stats'] == 1) { ?>
				<th width="5%"><center><?php _e('Shown', 'adrotate'); ?></center></th>
				<th width="5%"><center><?php _e('Today', 'adrotate'); ?></center></th>
				<th width="5%"><center><?php _e('Clicks', 'adrotate'); ?></center></th>
				<th width="5%"><center><?php _e('Today', 'adrotate'); ?></center></th>
				<th width="7%"><center><?php _e('CTR', 'adrotate'); ?></center></th>
			<?php } ?>
		</tr>
		</thead>
		<tbody>
	<?php
	if ($active) {
		$class = '';
		foreach($active as $banner) {
			$stats = adrotate_stats($banner['id']);
			$stats_today = adrotate_stats($banner['id'], false, adrotate_date_start('day'));
			$grouplist = adrotate_ad_is_in_groups($banner['id']);
			$ctr = adrotate_ctr($stats['clicks'], $stats['impressions']);						
			$class = ($class != 'alternate') ? 'alternate' : '';
			?>
		    <tr id='adrotateindex' class='<?php echo $class; ?>'>
				<th class="check-column"><input type="checkbox" name="bannercheck[]" value="<?php echo $banner['id']; ?>" /></th>
				<td><center><?php echo $banner['id'];?></center></td>
				<td><?php echo date_i18n("F d, Y", $banner['firstactive']);?><br /><span style="color: <?php echo adrotate_prepare_color($banner['lastactive']);?>;"><?php echo date_i18n("F d, Y", $banner['lastactive']);?></span></td>
				<td><strong><a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-ads&view=edit&ad='.$banner['id']);?>" title="<?php _e('Edit', 'adrotate'); ?>"><?php echo stripslashes(html_entity_decode($banner['title']));?></a></strong> <?php if($adrotate_config['stats'] == 1) { ?>- <a href="<?php echo admin_url('/admin.php?page=adrotate-statistics&view=advert&id='.$banner['id']);?>" title="<?php _e('Stats', 'adrotate'); ?>"><?php _e('Stats', 'adrotate'); ?></a><?php } ?><span style="color:#999;"><?php if(strlen($grouplist) > 0) echo '<br /><span style="font-weight:bold;">'.__('Groups:', 'adrotate').'</span> '.$grouplist; ?></span></td>
				<?php if($adrotate_config['stats'] == 1) { ?>
					<td><center><?php echo $stats['impressions']; ?></center></td>
					<td><center><?php echo $stats_today['impressions']; ?></center></td>
					<?php if($banner['tracker'] == "Y") { ?>
					<td><center><?php echo $stats['clicks']; ?></center></td>
					<td><center><?php echo $stats_today['clicks']; ?></center></td>
					<td><center><?php echo $ctr; ?> %</center></td>
					<?php } else { ?>
					<td><center>&hellip;</center></td>
					<td><center>&hellip;</center></td>
					<td><center>&hellip;</center></td>
					<?php } ?>
				<?php } ?>
			</tr>
			<?php } ?>
		<?php } else { ?>
		<tr id='no-groups'>
			<th class="check-column">&nbsp;</th>
			<td colspan="<?php echo ($adrotate_config['stats'] == 1) ? '10' : '5'; ?>"><em><?php _e('No adverts created yet!', 'adrotate'); ?></em></td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
	<center><?php _e('Get more features with AdRotate Pro.', 'adrotate'); ?> <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>

</form>

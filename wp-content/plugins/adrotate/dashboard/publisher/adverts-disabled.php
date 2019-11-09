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
<form name="disabled_banners" id="post" method="post" action="admin.php?page=adrotate-ads">
	<?php wp_nonce_field('adrotate_bulk_ads_disable','adrotate_nonce'); ?>
	
	<h3><?php _e('Disabled Adverts', 'adrotate'); ?></h3>
	
	<div class="tablenav">
		<div class="alignleft actions">
			<select name="adrotate_disabled_action" id="cat" class="postform">
		        <option value=""><?php _e('Bulk Actions', 'adrotate'); ?></option>
		        <option value="activate"><?php _e('Activate', 'adrotate'); ?></option>
		        <option value="delete"><?php _e('Delete', 'adrotate'); ?></option>
		        <option value="reset"><?php _e('Reset stats', 'adrotate'); ?></option>
			</select>
			<input type="submit" id="post-action-submit" name="adrotate_disabled_action_submit" value="<?php _e('Go', 'adrotate'); ?>" class="button-secondary" />
		</div>
	
		<br class="clear" />
	</div>
	
		<table class="widefat tablesorter manage-ads-disabled" style="margin-top: .5em">
			<thead>
			<tr>
				<td scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></td>
				<th width="2%"><center><?php _e('ID', 'adrotate'); ?></center></th>
				<th width="15%"><?php _e('Start / End', 'adrotate'); ?></th>
				<th><?php _e('Name', 'adrotate'); ?></th>
				<?php if($adrotate_config['stats'] == 1) { ?>
					<th width="5%"><center><?php _e('Shown', 'adrotate'); ?></center></th>
					<th width="5%"><center><?php _e('Clicks', 'adrotate'); ?></center></th>
					<th width="5%"><center><?php _e('CTR', 'adrotate'); ?></center></th>
				<?php } ?>
			</tr>
			</thead>
			<tbody>
		<?php
		$class = '';
		foreach($disabled as $banner) {
			$stats = adrotate_stats($banner['id']);
			$grouplist = adrotate_ad_is_in_groups($banner['id']);
			$ctr = adrotate_ctr($stats['clicks'], $stats['impressions']);

			$class = ($class != 'alternate') ? 'alternate' : '';
			?>
		    <tr id='adrotateindex' class='<?php echo $class; ?>'>
				<th class="check-column"><input type="checkbox" name="disabledbannercheck[]" value="<?php echo $banner['id']; ?>" /></th>
				<td><center><?php echo $banner['id'];?></center></td>
				<td><?php echo date_i18n("F d, Y", $banner['firstactive']);?><br /><span style="color: <?php echo adrotate_prepare_color($banner['lastactive']);?>;"><?php echo date_i18n("F d, Y", $banner['lastactive']);?></span></td>
				<td><strong><a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-ads&view=edit&ad='.$banner['id']);?>" title="<?php _e('Edit', 'adrotate'); ?>"><?php echo stripslashes(html_entity_decode($banner['title']));?></a></strong> - <a href="<?php echo admin_url('/admin.php?page=adrotate-statistics&view=advert&id='.$banner['id']);?>" title="<?php _e('Stats', 'adrotate'); ?>"><?php _e('Stats', 'adrotate'); ?></a><span style="color:#999;"><?php if(strlen($grouplist) > 0) echo '<br /><span style="font-weight:bold;">'.__('Groups:', 'adrotate').'</span> '.$grouplist; ?></td>
				<td><center><?php echo $stats['impressions']; ?></center></td>
				<?php if($banner['tracker'] == "Y") { ?>
				<td><center><?php echo $stats['clicks']; ?></center></td>
				<td><center><?php echo $ctr; ?> %</center></td>
				<?php } else { ?>
				<td><center>&hellip;</center></td>
				<td><center>&hellip;</center></td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
</form>

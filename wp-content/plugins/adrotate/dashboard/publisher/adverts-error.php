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
<h3><?php _e('Adverts that need attention', 'adrotate'); ?></h3>

<form name="errorbanners" id="post" method="post" action="admin.php?page=adrotate-ads">
	<?php wp_nonce_field('adrotate_bulk_ads_error','adrotate_nonce'); ?>
	<div class="tablenav">
		<div class="alignleft actions">
			<select name="adrotate_error_action" id="cat" class="postform">
		        <option value=""><?php _e('Bulk Actions', 'adrotate'); ?></option>
		        <option value="deactivate"><?php _e('Deactivate', 'adrotate'); ?></option>
		        <option value="delete"><?php _e('Delete', 'adrotate'); ?></option>
		        <option value="reset"><?php _e('Reset stats', 'adrotate'); ?></option>
		        <option value="" disabled><?php _e('-- Renew --', 'adrotate'); ?></option>
		        <option value="renew-31536000"><?php _e('For 1 year', 'adrotate'); ?></option>
		        <option value="renew-5184000"><?php _e('For 180 days', 'adrotate'); ?></option>
		        <option value="renew-2592000"><?php _e('For 30 days', 'adrotate'); ?></option>
		        <option value="renew-604800"><?php _e('For 7 days', 'adrotate'); ?></option>
			</select>
			<input type="submit" id="post-action-submit" name="adrotate_error_action_submit" value="<?php _e('Go', 'adrotate'); ?>" class="button-secondary" />
		</div>
	
		<br class="clear" />
	</div>
	
		<table class="widefat tablesorter manage-ads-error" style="margin-top: .5em">
			<thead>
			<tr>
				<td scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></td>
				<th width="2%"><center><?php _e('ID', 'adrotate'); ?></center></th>
				<th><?php _e('Name', 'adrotate'); ?></th>
				<th width="15%"><?php _e('Start / End', 'adrotate'); ?></th>
			</tr>
			</thead>
			<tbody>
		<?php foreach($error as $banner) {
			$grouplist = adrotate_ad_is_in_groups($banner['id']);
			
			$class = '';
			if($banner['type'] == 'error') $class = ' row_yellow'; 
			if($banner['type'] == 'expired') $class = ' row_red';
			if($banner['type'] == '2days') $class = ' row_orange';
			?>
		    <tr id='adrotateindex' class='<?php echo $class; ?>'>
				<th class="check-column"><input type="checkbox" name="errorbannercheck[]" value="<?php echo $banner['id']; ?>" /></th>
				<td><center><?php echo $banner['id'];?></center></td>
				<td><strong><a class="row-title" href="<?php echo admin_url("/admin.php?page=adrotate-ads&view=edit&ad=".$banner['id']);?>" title="<?php _e('Edit', 'adrotate'); ?>"><?php echo stripslashes(html_entity_decode($banner['title']));?></a></strong> <?php if($adrotate_config['stats'] == 1 AND $banner['type'] != 'error') { ?>- <a href="<?php echo admin_url('/admin.php?page=adrotate-statistics&view=advert&id='.$banner['id']);?>" title="<?php _e('Stats', 'adrotate'); ?>"><?php _e('Stats', 'adrotate'); ?></a><?php } ?><span style="color:#999;"><?php if(strlen($grouplist) > 0) echo '<br /><span style="font-weight:bold;">'.__('Groups:', 'adrotate').'</span> '.$grouplist; ?></span></td>
				<td><?php echo date_i18n("F d, Y", $banner['firstactive']);?><br /><span style="color: <?php echo adrotate_prepare_color($banner['lastactive']);?>;"><?php echo date_i18n("F d, Y", $banner['lastactive']);?></span></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<p><center>
		<span style="border: 1px solid #e6db55; height: 12px; width: 12px; background-color: #ffffe0">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Configuration errors", "adrotate"); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;<span style="border: 1px solid #c80; height: 12px; width: 12px; background-color: #fdefc3">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Expires soon", "adrotate"); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;<span style="border: 1px solid #c00; height: 12px; width: 12px; background-color: #ffebe8">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Expired", "adrotate"); ?>
	</center></p>
</form>

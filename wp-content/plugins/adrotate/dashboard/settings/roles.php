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

<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=roles">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Access Roles', 'adrotate'); ?></h2>
<span class="description"><?php _e('Who has access to what?', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Manage/Add/Edit adverts', 'adrotate'); ?></th>
		<td>
			<select name="adrotate_ad_manage">
				<?php wp_dropdown_roles($adrotate_config['ad_manage']); ?>
			</select> <?php _e('Role to see and add/edit ads.', 'adrotate'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Delete/Reset adverts', 'adrotate'); ?></th>
		<td>
			<select name="adrotate_ad_delete">
				<?php wp_dropdown_roles($adrotate_config['ad_delete']); ?>
			</select> <?php _e('Role to delete ads and reset stats.', 'adrotate'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Manage/Add/Edit groups', 'adrotate'); ?></th>
		<td>
			<select name="adrotate_group_manage">
				<?php wp_dropdown_roles($adrotate_config['group_manage']); ?>
			</select> <?php _e('Role to see and add/edit groups.', 'adrotate'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Delete groups', 'adrotate'); ?></th>
		<td>
			<select name="adrotate_group_delete">
				<?php wp_dropdown_roles($adrotate_config['group_delete']); ?>
			</select> <?php _e('Role to delete groups.', 'adrotate'); ?>
		</td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
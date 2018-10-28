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
<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=advertisers">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Advertisers - Available in AdRotate Pro', 'adrotate'); ?></h2>
<span class="description"><?php _e('Enable advertisers so they can review and manage their own ads.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Enable Advertisers', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_enable_advertisers"><input type="checkbox" name="adrotate_enable_advertisers_disabled" disabled="1" /> <?php _e('Allow adverts to be coupled to users (Advertisers).', 'adrotate'); ?></label>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Edit/update adverts', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_enable_editing"><input type="checkbox" name="adrotate_enable_editing_disabled" disabled="1" /> <?php _e('Allow advertisers to add new or edit their adverts.', 'adrotate'); ?></label>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Mobile adverts', 'adrotate'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_enable_mobile_advertisers_disabled" disabled="1" /> <?php _e('Allow advertisers to specify on which devices their ads will show.', 'adrotate'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Geo Targeting', 'adrotate'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_enable_geo_advertisers_disabled" disabled="1" /> <?php _e('Allow advertisers to specify where their ads will show. Geo Targeting has to be enabled, too.', 'adrotate'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Advertiser role', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_role"><input type="checkbox" name="adrotate_role_disabled" disabled="1" /> <?php _e('Create a seperate user role for your advertisers.', 'adrotate'); ?></label><br />
			<span class="description"><?php _e('Don\'t forget to give these users access to their advertiser dashboard via the Roles tab.', 'adrotate'); ?></span>
		</td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
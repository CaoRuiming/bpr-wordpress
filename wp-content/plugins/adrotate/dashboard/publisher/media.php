<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2019 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */
?>

<?php $assets = adrotate_mediapage_folder_contents(WP_CONTENT_DIR."/".$adrotate_config['banner_folder']); ?>

<form method="post" action="admin.php?page=adrotate-media" enctype="multipart/form-data">
	<?php wp_nonce_field('adrotate_save_media','adrotate_nonce'); ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="512000" />

	<h2><?php _e('Upload new file', 'adrotate'); ?></h2>
	<select tabindex="5" id="adrotate_image_location" name="adrotate_image_location" style="min-width: 200px;">
		<option value="<?php echo $adrotate_config['banner_folder']; ?>"><?php echo $adrotate_config['banner_folder']; ?></option>
	<?php
	if(count($assets) > 0) {
		foreach($assets as $asset) {
			if(array_key_exists("contents", $asset)) {
				echo '<option value="'.$adrotate_config['banner_folder'].'/'.$asset['basename'].'">&mdash; '.$asset['basename'].'</option>';
				foreach($asset['contents'] as $level_one) {
					if(array_key_exists("contents", $level_one)) {
						echo '<option value="'.$adrotate_config['banner_folder'].'/'.$asset['basename'].'/'.$level_one['basename'].'">&mdash; &mdash; '.$level_one['basename'].'</option>';
					}
				}		
			}
		}
	}
	?>
	</select>
	<label for="adrotate_image"><input tabindex="1" type="file" name="adrotate_image" /><br /><em><strong><?php _e('Accepted files:', 'adrotate'); ?></strong> jpg, jpeg, gif, png, svg, html, js and zip. <?php _e('Maximum size is 512Kb per file.', 'adrotate'); ?></em><br /><em><strong><?php _e('Important:', 'adrotate'); ?></strong> <?php _e('Make sure your file has no spaces or special characters in the name. Replace spaces with a - or _.', 'adrotate'); ?><br /><?php _e('Zip files are automatically extracted in the location where they are uploaded and the original zip file will be deleted once extracted.', 'adrotate'); ?><br /><?php _e('You can create top-level folders below. Folder names can between 1 and 100 characters long. Any special characters are stripped out.', 'adrotate'); ?></em></label>

	<p class="submit">
		<input tabindex="2" type="submit" name="adrotate_media_submit" class="button-primary" value="<?php _e('Upload file', 'adrotate'); ?>" /> <em><?php _e('Click only once per file!', 'adrotate'); ?></em>
	</p>

<h2><?php _e('Available files in', 'adrotate'); ?> '<?php echo '/'.$adrotate_config['banner_folder']; ?>'</h2>
<table class="widefat" style="margin-top: .5em">

	<thead>
	<tr>
        <th><?php _e('Name', 'adrotate'); ?></th>
	</tr>
	</thead>

	<tbody>
		<tr>
			<td>
				<input tabindex="3" id="adrotate_folder" name="adrotate_folder" type="text" size="20" class="ajdg-inputfield" value="" autocomplete="off" /> <input tabindex="4" type="submit" name="adrotate_folder_submit" class="button-secondary" value="<?php _e('Create folder', 'adrotate-pro'); ?>" />
			</td>
		</tr>
		
	<?php
	if(count($assets) > 0) {
		$class = '';
		foreach($assets as $asset) {
			$class = ($class != 'alternate') ? 'alternate' : '';
			
			echo "<tr class=\"$class\">";
			echo "<td>";
			echo $asset['basename'];
			echo "<span style=\"float:right;\"><a href=\"".admin_url('/admin.php?page=adrotate-media&file='.$asset['basename'])."&_wpnonce=".wp_create_nonce('adrotate_delete_media_'.$asset['basename'])."\" title=\"".__('Delete', 'adrotate')."\">".__('Delete', 'adrotate')."</a></span>";
			if(array_key_exists("contents", $asset)) {
				echo "<small>";
				foreach($asset['contents'] as $level_one) {
					echo "<br />&mdash; ".$level_one['basename'];
					echo "<span style=\"float:right;\"><a href=\"".admin_url('/admin.php?page=adrotate-media&file='.$asset['basename'].'/'.$level_one['basename'])."&_wpnonce=".wp_create_nonce('adrotate_delete_media_'.$asset['basename'].'/'.$level_one['basename'])."\" title=\"".__('Delete', 'adrotate')."\">".__('Delete', 'adrotate')."</a></span>";
					if(array_key_exists("contents", $level_one)) {
						foreach($level_one['contents'] as $level_two) {
							echo "<br />&mdash;&mdash; ".$level_two['basename'];
							echo "<span style=\"float:right;\"><a href=\"".admin_url('/admin.php?page=adrotate-media&file='.$asset['basename'].'/'.$level_one['basename'].'/'.$level_two['basename'])."&_wpnonce=".wp_create_nonce('adrotate_delete_media_'.$asset['basename'].'/'.$level_one['basename'].'/'.$level_two['basename'])."\" title=\"".__('Delete', 'adrotate')."\">".__('Delete', 'adrotate')."</a></span>";
						}		
					}
				}		
				echo "</small>";
			}
			echo "</td>";
			echo "</tr>";
		}
	} else {
		echo "<tr class=\"alternate\">";
		echo "<td><em>".__('No files found!', 'adrotate')."</em></td>";
		echo "</tr>";
	}
	?>
	</tbody>
</table>
</form>
<p><center><small>
	<?php _e("Make sure the banner images are not in use by adverts when you delete them!", "adrotate-pro"); ?> <?php _e("Deleting a folder deletes everything inside that folder as well!", "adrotate-pro"); ?>
</small></center></p>
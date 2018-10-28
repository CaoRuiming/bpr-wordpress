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

<form method="post" action="admin.php?page=adrotate-media" enctype="multipart/form-data">
	<?php wp_nonce_field('adrotate_save_media','adrotate_nonce'); ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="512000" />

	<h2><?php _e('Upload new file', 'adrotate'); ?></h2>
	<label for="adrotate_image"><input tabindex="1" type="file" name="adrotate_image" disabled="1" /><br /><em><strong><?php _e('Accepted files:', 'adrotate'); ?></strong> jpg, jpeg, gif, png, html, js, swf and flv. <?php _e('Maximum size is 512Kb per file.', 'adrotate'); ?></em><br /><em><strong><?php _e('Important:', 'adrotate'); ?></strong> <?php _e('Make sure your file has no spaces or special characters in the name. Replace spaces with a - or _.', 'adrotate'); ?><br /><?php _e('If you remove spaces from filenames for HTML5 adverts also edit the html file so it knows about the changed name. For example for the javascript file.', 'adrotate'); ?></em></label>

	<p class="submit">
		<input tabindex="2" type="submit" name="adrotate_media_submit" class="button-primary" value="<?php _e('Upload file', 'adrotate'); ?>" disabled="1" /> <em><?php _e('Click only once per file!', 'adrotate'); ?></em>
	</p>
</form>

<h2><?php _e('Available files in', 'adrotate'); ?> '<?php echo '/'.$adrotate_config['banner_folder']; ?>'</h2>
<table class="widefat" style="margin-top: .5em">

	<thead>
	<tr>
        <th><?php _e('Name', 'adrotate'); ?></th>
        <th width="12%"><center><?php _e('Actions', 'adrotate'); ?></center></th>
	</tr>
	</thead>

	<tbody>
	<?php
	$assets = adrotate_subfolder_contents(WP_CONTENT_DIR."/".$adrotate_config['banner_folder']);

	if(count($assets) > 0) {
		$class = '';
		foreach($assets as $asset) {
			$class = ($class != 'alternate') ? 'alternate' : '';
	
			echo "<tr class=\"$class\">";
			echo "<td>";
			echo $asset['basename'];
			if(array_key_exists("contents", $asset) AND !array_key_exists("no_files", $asset['contents']) AND !array_key_exists("no_access", $asset['contents'])) {
				echo "<small>";
				foreach($asset['contents'] as $level_one) {
					echo "<br />&mdash; ".$level_one['basename'];
					if(array_key_exists("contents", $level_one)) {
						foreach($level_one['contents'] as $level_two) {
							echo "<br />&mdash;&mdash; ".$level_two['basename'];
						}		
					}
				}		
				echo "</small>";
			}
			echo "</td>";
			echo "<td><center><strong>".__('Delete', 'adrotate')."</strong></center></td>";
			echo "</tr>";
		}
	} else {
		echo "<tr class=\"alternate\">";
		echo "<td colspan=\"2\"><em>".__('No files found!', 'adrotate')."</em></td>";
		echo "</tr>";
	}
	?>
	</tbody>
</table>
<p><center>
	<?php _e("Make sure the banner images are not in use by adverts when you delete them!", "adrotate"); ?><br />
	<?php _e('Get more features with AdRotate Pro', 'adrotate'); ?> - <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!
</center></p>
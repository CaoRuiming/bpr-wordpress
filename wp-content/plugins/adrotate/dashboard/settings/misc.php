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
<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=misc">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Miscellaneous', 'adrotate'); ?></h2>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Widget alignment', 'adrotate'); ?></th>
		<td><label for="adrotate_widgetalign"><input type="checkbox" name="adrotate_widgetalign" <?php if($adrotate_config['widgetalign'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Check this box if your widgets do not align in your themes sidebar. (Does not always help!)', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Widget padding', 'adrotate'); ?></th>
		<td><label for="adrotate_widgetpadding"><input type="checkbox" name="adrotate_widgetpadding" <?php if($adrotate_config['widgetpadding'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Enable this to remove the padding (blank space) around ads in widgets. (Does not always work!)', 'adrotate'); ?></label></td>
	</tr>
	<?php if($adrotate_config['w3caching'] == "Y" AND !defined('W3TC_DYNAMIC_SECURITY')) { ?>
	<tr>
		<th valign="top"><?php _e('NOTICE:', 'adrotate'); ?></th>
		<td><span style="color:#f00;"><?php _e('You have enabled W3 Total Caching support but not defined the security hash.', 'adrotate'); ?></span><br /><br /><?php _e('AdRotate has generated the following line for you to add to your wp-config.php around line 52 (below the WordPress nonces). If you do not know how to add this line, check out the following guide;', 'adrotate'); ?> <a href="https://ajdg.solutions/manuals/adrotate-manuals/caching-support/"><?php _e('Set up W3 Total Caching', 'adrotate'); ?></a>.<br /><pre>define('W3TC_DYNAMIC_SECURITY', '<?php echo md5(rand(0,999)); ?>');</pre></td>
	</tr>
	<?php } ?>
	<tr>
		<th valign="top"><?php _e('W3 Total Caching', 'adrotate'); ?></th>
		<td><label for="adrotate_w3caching"><input type="checkbox" name="adrotate_w3caching" <?php if($adrotate_config['w3caching'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Check this box if you use W3 Total Caching on your site.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Borlabs Cache', 'adrotate'); ?></th>
		<td><label for="adrotate_borlabscache"><input type="checkbox" name="adrotate_borlabscache" <?php if($adrotate_config['borlabscache'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Check this box if you use Borlabs Caching on your site.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top">&nbsp;</th>
		<td><span class="description"><?php _e('It may take a while for the ad to start rotating. The caching plugin needs to refresh the cache. This can take up to a week if not done manually.', 'adrotate'); ?> <?php _e('Caching support only works for [shortcodes] and the AdRotate Widget. If you use a PHP Snippet you need to wrap your PHP in the exclusion code yourself.', 'adrotate'); ?></span></td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
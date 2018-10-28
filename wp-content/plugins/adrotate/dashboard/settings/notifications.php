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

<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=notifications">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<?php wp_nonce_field('adrotate_email_test','adrotate_nonce'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Notifications', 'adrotate'); ?></h2>
<span class="description"><?php _e('Set up who gets notifications if ads need your attention.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('How to notify', 'adrotate'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_notification_dash" <?php if($adrotate_notifications['notification_dash'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Dashboard banner.', 'adrotate'); ?><br />
			<input type="checkbox" name="adrotate_notification_email_disabled" disabled /> <?php _e('Email message.', 'adrotate'); ?><br />
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><?php _e('Test notification', 'adrotate'); ?></th>
		<td>
			<input type="submit" name="adrotate_notification_test_submit_disabled" class="button-secondary" value="<?php _e('Test', 'adrotate'); ?>" disabled /> <?php _e('Send a test notification to enabled methods. Before you test, save the options first!', 'adrotate'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Dashboard Banner', 'adrotate'); ?></h3>
<span class="description"><?php _e('These go in a dashboard banner visible to all users with access to AdRotate on every WordPress dashboard page.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('What', 'adrotate'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_notification_dash_expired" <?php if($adrotate_notifications['notification_dash_expired'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Expired adverts.', 'adrotate'); ?><br />
			<input type="checkbox" name="adrotate_notification_dash_soon" <?php if($adrotate_notifications['notification_dash_soon'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Almost expired adverts.', 'adrotate'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Email Message', 'adrotate'); ?> - <?php _e('Available in AdRotate Pro', 'adrotate'); ?></h3>
<span class="description"><?php _e('Receive email notifications about what is happening with your AdRotate setup.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('What', 'adrotate'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_notification_mail_status" disabled="1" /> <?php _e('Daily digest of any advert status other than normal.', 'adrotate'); ?><br />
			<input type="checkbox" name="adrotate_notification_mail_geo" disabled="1" /> <?php _e('When you are running out of Geo Targeting Lookups.', 'adrotate'); ?><br />
			<input type="checkbox" name="adrotate_notification_mail_queue" disabled="1" /> <?php _e('Any advertiser saving an advert in your moderation queue.', 'adrotate'); ?><br />
			<input type="checkbox" name="adrotate_notification_mail_approved" disabled="1" /> <?php _e('A moderator approved an advert from the moderation queue.', 'adrotate'); ?><br />
			<input type="checkbox" name="adrotate_notification_mail_rejected" disabled="1" <?php _e('A moderator rejected an advert from the moderation queue.', 'adrotate'); ?><br /><span class="description"><?php _e('If you have a lot of activity with many advertisers adding/changing adverts you may get a lot of messages!', 'adrotate'); ?><br /><br /><strong><?php _e('Note:', 'adrotate'); ?></strong> <?php _e('Sending out a lot of email is sometimes seen as automated mailing and deemed spammy. This may result in automated filters such as those used in services like Google Gmail and Microsoft Hotmail/Outlook.com blocking your server. Make sure you whitelist the sending address in your email account once you start receiving notifications!', 'adrotate'); ?></span>

		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Publishers', 'adrotate'); ?></th>
		<td>
			<textarea name="adrotate_notification_email_publisher" cols="50" rows="2" disabled="1"><?php echo get_option('admin_email'); ?></textarea><br />
			<span class="description"><?php _e('Messages are sent once every 24 hours.  Maximum of 5 addresses. Comma separated. This field may not be empty!', 'adrotate'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Advertisers', 'adrotate'); ?></th>
		<td>
			<textarea name="adrotate_notification_email_advertiser" cols="50" rows="2" disabled="1"><?php echo get_option('admin_email'); ?></textarea><br />
			<span class="description"><?php _e('Who gets email from advertisers. Maximum of 5 addresses. Comma separated. This field may not be empty!', 'adrotate'); ?></span>
		</td>
	</tr>
</table>

<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>
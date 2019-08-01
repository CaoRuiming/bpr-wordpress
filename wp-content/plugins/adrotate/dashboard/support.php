<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2019 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

$banners = $groups = $schedules = $queued = $unpaid = 0;
$banners = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` != 'empty' AND `type` != 'a_empty';");
$groups = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '';");
$schedules = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_schedule` WHERE `name` != '';");
$queued = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'queue' OR `type` = 'reject';");
$data = get_option("adrotate_advert_status");

// Random banner for Media.net
$partner = mt_rand(1,3);
?>

<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">
		<div id="left-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">				
				<h2 class="ajdg-postbox-title"><?php _e('Support Forums', 'adrotate'); ?></h2>
				<div id="news" class="ajdg-postbox-content">
					<p><img src="<?php echo plugins_url('/images/icon-support.png', dirname(__FILE__)); ?>" class="alignleft pro-image" /><?php _e('When you are stuck with AdRotate or AdRotate Pro, check the forums first. Chances are your question has already been asked and answered!', 'adrotate'); ?> <?php _e('Next to the forum there are many manuals and guides available for almost every function and feature in the plugin.', 'adrotate'); ?> <a href="https://ajdg.solutions/support/adrotate-manuals/" target="_blank"><?php _e('Take a look at the AdRotate Manuals', 'adrotate'); ?></a>.</p>

					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/general-support/" target="_blank"><strong>General Support</strong></a><br /><em>Ask anything about AdRotate and AdRotate Pro here. <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/general-support/" target="_blank"><?php _e('View topics', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/installation-and-setup/" target="_blank"><strong>Installation and Setup</strong></a><br /><em>Having trouble installing AdRotate (Pro) or not sure how to get started? <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/installation-and-setup/" target="_blank"><?php _e('View topics', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/adverts-and-banners/" target="_blank"><strong>Adverts and Banners</strong></a><br /><em>The moneymaker! Your adverts. <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/adverts-and-banners/" target="_blank"><?php _e('View topics', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/groups/" target="_blank"><strong>Groups</strong></a><br /><em>All about groups. <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/groups/" target="_blank"><?php _e('View topics', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/advert-statistics/" target="_blank"><strong>Advert Statistics</strong></a><br /><em>Graphs, impressions and clicks! <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/advert-statistics/" target="_blank"><?php _e('View topics', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/bug-reports/" target="_blank"><strong>Bug Reports</strong></a><br /><em>Found a bug? Or something odd? Let me know! <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/bug-reports/" target="_blank"><?php _e('View topics', 'adrotate'); ?> &raquo;</a></em></p>
				</div>
			</div>

			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('Additional Services', 'adrotate'); ?></h2>
				<div id="get-pro" class="ajdg-postbox-content">
					<p><img src="<?php echo plugins_url('/images/icon-services.png', dirname(__FILE__)); ?>" class="alignleft pro-image" /><?php _e('Have stuff done for you, by AJdG Solutions. If you need HTML5 Adverts set up. Or do not know how to update the plugin. Get me to do it for you! These professional services are available for every AdRotate  and AdRotate Pro user and are usually handled in less than 2 business days.', 'adrotate'); ?></p>

					<p><a href="https://ajdg.solutions/product/adrotate-update/" target="_blank"><strong><?php _e('Update AdRotate Pro', 'adrotate'); ?> (&euro; 22.50)</strong></a><br /><em><?php _e('Get a newer version of AdRotate Pro installed.', 'adrotate'); ?> <a href="https://ajdg.solutions/product/adrotate-update/" target="_blank"><?php _e('Order now', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/product/adrotate-html5-setup-service/" target="_blank"><strong><?php _e('HTML5 Advert setup', 'adrotate'); ?> (&euro; 22.50/advert)</strong></strong></a><br /><em><?php _e('Got a HTML5 advert that needs to be set up?', 'adrotate'); ?> <a href="https://ajdg.solutions/product/adrotate-html5-setup-service/" target="_blank"><?php _e('Order now', 'adrotate'); ?> &raquo;</a></em></p>
					<p><strong><?php _e('AdRotate setup', 'adrotate'); ?> (&euro; 45/hr)</strong></strong><br /><em><?php _e('Contact AJdG Solutions and inquire about the possibilities to set up AdRotate for you.', 'adrotate'); ?></em></p>
				</div>
			</div>

		</div>
		<div id="right-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('Premium Support available in AdRotate Pro', 'adrotate'); ?></h2>
				<div id="support" class="ajdg-postbox-content">
					<form name="request" id="post" method="post" action="admin.php?page=adrotate">
						<p><img src="<?php echo plugins_url('/images/icon-contact.png', dirname(__FILE__)); ?>" class="alignleft pro-image" />&raquo; <?php _e('What went wrong? Or what are you trying to do?', 'adrotate'); ?><br />&raquo; <?php _e('Include error messages and/or relevant information.', 'adrotate'); ?><br />&raquo; <?php _e('Try to remember any actions that may cause the problem.', 'adrotate'); ?><br />&raquo; <?php _e('Any code/HTML will be stripped from your message.', 'adrotate'); ?></p>
					
						<p><label for="ajdg_support_username"><strong><?php _e('Your name:', 'adrotate'); ?></strong><br /><input tabindex="1" name="ajdg_support_username" type="text" class="search-input" style="width:100%;" value="<?php echo $current_user->display_name;?>" autocomplete="off" disabled /></label></p>
						<p><label for="ajdg_support_email"><strong><?php _e('Your Email Address:', 'adrotate'); ?></strong><br /><input tabindex="1" name="ajdg_support_email" type="text" class="search-input" style="width:100%;" value="<?php echo $current_user->user_email;?>" autocomplete="off" disabled /></label></p>
						<p><label for="ajdg_support_subject"><strong><?php _e('Subject:', 'adrotate'); ?></strong><br /><input tabindex="2" name="ajdg_support_subject" type="text" class="search-input" style="width:100%;" value="" autocomplete="off" disabled /></label></p>
						<p><label for="ajdg_support_message"><strong><?php _e('Problem description / Question:', 'adrotate'); ?></strong><br /><textarea tabindex="3" name="ajdg_support_message" style="width:100%; height:100px;" disabled></textarea></label></p>
						<p><label for="ajdg_support_account"><input tabindex="4" name="ajdg_support_account" type="checkbox" disabled /> <?php _e('Please log in to my website and take a look.', 'adrotate'); ?> <span class="ajdg-tooltip">What's this?<span class="ajdg-tooltiptext ajdg-tooltip-top">Checking this option will create an account for Arnan to log in and take a look at your setup.</span>
</span></label></p>
					
						<p><strong><?php _e('When you send this form the following data will be submitted:', 'adrotate'); ?></strong><br/>
						<em><?php _e('Your name, Account email address, Your website url and some basic WordPress information will be included with the message.', 'adrotate'); ?><br /><?php _e('This information is treated as confidential and is mandatory.', 'adrotate'); ?></em></p>
					
						<p class="submit">
							<input tabindex="4" type="submit" name="adrotate_support_submit" class="button-primary" value="<?php _e('Get Help', 'adrotate'); ?>" disabled />&nbsp;&nbsp;&nbsp;<em><?php _e('Premium Support is available in AdRotate Pro!', 'adrotate'); ?></em>
						</p>
					
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="clear"></div>
<p><?php echo adrotate_trademark(); ?></p>
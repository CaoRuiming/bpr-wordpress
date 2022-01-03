<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2020 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */

$banners = $groups = $schedules = $queued = $unpaid = 0;
$banners = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` != 'empty' AND `type` != 'a_empty';");
$groups = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '';");
$schedules = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_schedule` WHERE `name` != '';");
$queued = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'queue' OR `type` = 'reject';");
$data = get_option("adrotate_advert_status");
?>

<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">
		<div id="left-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">				
				<h2 class="ajdg-postbox-title">Support Forums</h2>
				<div id="news" class="ajdg-postbox-content">
					<p><img src="<?php echo plugins_url('/images/icon-support.png', dirname(__FILE__)); ?>" class="alignleft pro-image" />When you are stuck with AdRotate or AdRotate Pro, check the forums first. Chances are your question has already been asked and answered! Next to the forum there are many manuals and guides available for almost every function and feature in the plugin. <a href="https://ajdg.solutions/support/adrotate-manuals/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=manuals_link" target="_blank">Take a look at the AdRotate Manuals</a>.</p>

					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/general-support/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_general" target="_blank"><strong>General Support forum</strong></a><br /><em>Ask anything about AdRotate and AdRotate Pro here. <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/general-support/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_general" target="_blank">View topics &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/installation-and-setup/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_installation" target="_blank"><strong>Installation and Setup forum</strong></a><br /><em>Having trouble installing AdRotate (Pro) or not sure how to get started? <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/installation-and-setup/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_installation" target="_blank">View topics &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/adverts-and-banners/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_adverts" target="_blank"><strong>Adverts and Banners forum</strong></a><br /><em>The moneymaker! Your adverts. <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/adverts-and-banners/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_adverts" target="_blank">View topics &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/groups/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_groups" target="_blank"><strong>Groups forum</strong></a><br /><em>All about groups. <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/groups/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_groups" target="_blank">View topics &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/advert-statistics/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_stats" target="_blank"><strong>Advert Statistics forum</strong></a><br /><em>Graphs, impressions and clicks! <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/advert-statistics/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_stats" target="_blank">View topics &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/bug-reports/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_bugs" target="_blank"><strong>Bug Reports forum</strong></a><br /><em>Found a bug? Or something odd? Let me know! <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/bug-reports/?pk_campaign=adrotatefree&pk_keyword=support_page&pk_content=forum_bugs" target="_blank">View topics &raquo;</a></em></p>
				</div>
			</div>

			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title">Plugins and services</h2>
				<div id="services" class="ajdg-postbox-content">
					<p>Check out these and more services in more details on my website. I also make more plugins. If you like AdRotate - Maybe you like some of those as well. Take a look at the <a href="https://ajdg.solutions/plugins/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank">plugins</a> and overall <a href="https://ajdg.solutions/pricing/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank">pricing</a> page for more.</p>
					<table width="100%">
						<tr>
							<td width="33%">
								<div class="ajdg-sales-widget" style="display: inline-block; margin-right:2%;">
									<a href="https://ajdg.solutions/product/adrotate-html5-setup-service/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank"><div class="header"><img src="<?php echo plugins_url("/images/offers/html5-service.jpg", dirname(__FILE__)); ?>" alt="HTML5 Advert setup" width="228" height="120"></div></a>
									<a href="https://ajdg.solutions/product/adrotate-html5-setup-service/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank"><div class="title">HTML5 Advert setup</div></a>
									<div class="sub_title">Professional service</div>
									<div class="cta"><a role="button" class="cta_button" href="https://ajdg.solutions/product/adrotate-html5-setup-service/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank">Learn more</a></div>
									<hr>
									<div class="description">Did you get a HTML5 advert and can’t get it to work in AdRotate? I’ll install and configure it for you.</div>
								</div>							
							</td>
							<td width="33%">
								<div class="ajdg-sales-widget" style="display: inline-block; margin-right:2%;">
									<a href="https://ajdg.solutions/product/wordpress-maintenance-and-updates/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank"><div class="header"><img src="<?php echo plugins_url("/images/offers/wordpress-maintenance.jpg", dirname(__FILE__)); ?>" alt="WordPress Maintenance" width="228" height="120"></div></a>
									<a href="https://ajdg.solutions/product/wordpress-maintenance-and-updates/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank"><div class="title">Maintenance</div></a>
									<div class="sub_title">Professional service</div>
									<div class="cta"><a role="button" class="cta_button" href="https://ajdg.solutions/product/wordpress-maintenance-and-updates/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank">Get started</a></div>
									<hr>								
									<div class="description">Get all the latest updates for WordPress and plugins. Maintenance, delete spam and clean up files.</div>
								</div>
							</td>
							<td>
								<div class="ajdg-sales-widget" style="display: inline-block;">
									<a href="https://ajdg.solutions/product/woocommerce-single-page-checkout/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank"><div class="header"><img src="<?php echo plugins_url("/images/offers/single-page-checkout.jpg", dirname(__FILE__)); ?>" alt="WooCommerce Single Page Checkout" width="228" height="120"></div></a>
									<a href="https://ajdg.solutions/product/woocommerce-single-page-checkout/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank"><div class="title">Single Page Checkout</div></a>
									<div class="sub_title">WooCommerce Plugin</div>
									<div class="cta"><a role="button" class="cta_button" href="https://ajdg.solutions/product/woocommerce-single-page-checkout/?pk_campaign=adrotatefree&pk_keyword=support_page" target="_blank">View product page</a></div>
									<hr>
									<div class="description">Merge your cart and checkout pages into one single page in seconds with no setup required at all.</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>

		</div>
		<div id="right-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('Premium Support available in AdRotate Pro', 'adrotate'); ?></h2>
				<div id="support" class="ajdg-postbox-content">
					<form name="request" id="post" method="post" action="admin.php?page=adrotate">
						<p><img src="<?php echo plugins_url('/images/icon-contact.png', dirname(__FILE__)); ?>" class="alignleft pro-image" />&raquo; <?php _e('Premium support always comes first!', 'adrotate'); ?><br />&raquo; <?php _e('No queuing up on the forum...', 'adrotate'); ?><br />&raquo; <?php _e('Using this form includes essential information for a quick answer.', 'adrotate'); ?><br />&raquo; <?php _e('Available in AdRotate Professional!', 'adrotate'); ?></p>
					
						<p><strong><?php _e('Your name:', 'adrotate'); ?></strong><br /><input tabindex="1" name="ajdg_support_username" type="text" class="search-input" style="width:100%;" value="<?php echo $current_user->display_name;?>" autocomplete="off" disabled /></p>
						<p><strong><?php _e('Your Email Address:', 'adrotate'); ?></strong><br /><input tabindex="1" name="ajdg_support_email" type="text" class="search-input" style="width:100%;" value="<?php echo $current_user->user_email;?>" autocomplete="off" disabled /></p>
						<p><strong><?php _e('Subject:', 'adrotate'); ?></strong><br /><input tabindex="2" name="ajdg_support_subject" type="text" class="search-input" style="width:100%;" value="" autocomplete="off" disabled /></p>
						<p><strong><?php _e('Problem description / Question:', 'adrotate'); ?></strong><br /><textarea tabindex="3" name="ajdg_support_message" style="width:100%; height:100px;" disabled></textarea></p>
						<p><input tabindex="4" name="ajdg_support_account" type="checkbox" disabled /> <?php _e('Please log in to my website and take a look.', 'adrotate'); ?> <span class="ajdg-tooltip">What's this?<span class="ajdg-tooltiptext ajdg-tooltip-top">Checking this option will create an account for Arnan to log in and take a look at your setup.</span></span></p>
					
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
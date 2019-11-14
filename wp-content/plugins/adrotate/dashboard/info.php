<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2018 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

$banners = $groups = 0;
$banners = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` != 'empty' AND `type` != 'a_empty';");
$groups = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '';");
$data = get_option("adrotate_advert_status");
?>
<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">
		<div id="left-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('At a Glance', 'adrotate'); ?></h2>
				<div id="currently" class="ajdg-postbox-content">
					<table width="100%">
						<thead>
						<tr class="first">
							<td width="50%"><strong><?php _e('Your setup', 'adrotate'); ?></strong></td>
							<td width="50%"><strong><?php _e('Adverts that need you', 'adrotate'); ?></strong></td>
						</tr>
						</thead>
						
						<tbody>
						<tr class="first">
							<td class="first b"><a href="admin.php?page=adrotate-ads"><?php echo $banners; ?> <?php _e('Adverts', 'adrotate'); ?></a></td>
							<td class="b"><a href="admin.php?page=adrotate-ads"><?php echo $data['expiressoon'] + $data['expired']; ?> <?php _e('(Almost) Expired', 'adrotate'); ?></a></td>
						</tr>
						<tr>
							<td class="first b"><a href="admin.php?page=adrotate-groups"><?php echo $groups; ?> <?php _e('Groups', 'adrotate'); ?></a></td>
							<td class="b"><a href="admin.php?page=adrotate-ads"><?php echo $data['error']; ?> <?php _e('Have errors', 'adrotate'); ?></a></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('AdRotate Banner Manager', 'adrotate'); ?></h2>
				<div id="services" class="ajdg-postbox-content">
					<p><strong><?php _e('Support AdRotate Banner Manager', 'adrotate'); ?></strong></p>
					<p><?php _e('Consider writing a review or making a donation if you like the plugin or if you find the plugin useful. Thanks for your support!', 'adrotate'); ?></p>
					<center><a class="button-primary" href="https://www.paypal.me/ajdgsolutions/10eur" target="_blank">Donate &euro;10 via Paypal</a> <a class="button" target="_blank" href="https://wordpress.org/support/plugin/adrotate/reviews/?rate=5#new-post">Write review on WordPress.org</a> <a class="button" target="_blank" href="https://translate.wordpress.org/projects/wp-plugins/adrotate/">Help translate</a></center></p>

					<p><strong><?php _e('Plugins and services', 'adrotate'); ?></strong></p>
					<table width="100%">
						<tr>
							<td width="33%">
								<div class="ajdg-sales-widget" style="display: inline-block; margin-right:2%;">
									<a href="https://ajdg.solutions/product/adrotate-html5-setup-service/" target="_blank"><div class="header"><img src="<?php echo plugins_url("/images/offers/html5-service.jpg", dirname(__FILE__)); ?>" alt="HTML5 Advert setup" width="228" height="120"></div></a>
									<a href="https://ajdg.solutions/product/adrotate-html5-setup-service/" target="_blank"><div class="title"><?php _e('HTML5 Advert setup', 'adrotate'); ?></div></a>
									<div class="sub_title"><?php _e('Professional service', 'adrotate'); ?></div>
									<div class="cta"><a role="button" class="cta_button" href="https://ajdg.solutions/product/adrotate-html5-setup-service/" target="_blank">Only &euro; 22,50 p/ad</a></div>
									<hr>
									<div class="description"><?php _e('Did you get a HTML5 advert and can’t get it to work in AdRotate Pro? I’ll install and configure it for you.', 'adrotate'); ?></div>
								</div>							
							</td>
							<td width="33%">
								<div class="ajdg-sales-widget" style="display: inline-block; margin-right:2%;">
									<a href="https://ajdg.solutions/product/wordpress-maintenance-and-updates/" target="_blank"><div class="header"><img src="<?php echo plugins_url("/images/offers/wordpress-maintenance.jpg", dirname(__FILE__)); ?>" alt="WordPress Maintenance" width="228" height="120"></div></a>
									<a href="https://ajdg.solutions/product/wordpress-maintenance-and-updates/" target="_blank"><div class="title"><?php _e('WP Maintenance', 'adrotate'); ?></div></a>
									<div class="sub_title"><?php _e('Professional service', 'adrotate'); ?></div>
									<div class="cta"><a role="button" class="cta_button" href="https://ajdg.solutions/product/wordpress-maintenance-and-updates/" target="_blank">Starting at &euro; 22,50</a></div>
									<hr>								
									<div class="description"><?php _e('Get all the latest updates for WordPress and plugins. Maintenance, delete spam and clean up files.', 'adrotate'); ?></div>
								</div>
							</td>
							<td>
								<div class="ajdg-sales-widget" style="display: inline-block;">
									<a href="https://ajdg.solutions/product/woocommerce-single-page-checkout/" target="_blank"><div class="header"><img src="<?php echo plugins_url("/images/offers/single-page-checkout.jpg", dirname(__FILE__)); ?>" alt="WooCommerce Single Page Checkout" width="228" height="120"></div></a>
									<a href="https://ajdg.solutions/product/woocommerce-single-page-checkout/" target="_blank"><div class="title"><?php _e('Single Page Checkout', 'adrotate'); ?></div></a>
									<div class="sub_title"><?php _e('WooCommerce Plugin', 'adrotate'); ?></div>
									<div class="cta"><a role="button" class="cta_button" href="https://ajdg.solutions/product/woocommerce-single-page-checkout/" target="_blank">Only &euro; 10,-</a></div>
									<hr>
									<div class="description"><?php _e('Merge your cart and checkout pages into one single page in seconds with no setup required at all.', 'adrotate'); ?></div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>

		</div>
		<div id="right-column" class="ajdg-postbox-container">
						
			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('News & Updates', 'adrotate'); ?></h2>
				<div id="news" class="ajdg-postbox-content">
					<p><center><a href="https://www.arnan.me" title="Visit Arnan's website" target="_blank"><img src="<?php echo plugins_url("/images/buttons/1.png", dirname(__FILE__)); ?>" alt="Arnan de Gans website" /></a><a href="https://ajdg.solutions" title="Visit the AJdG Solutions website" target="_blank"><img src="<?php echo plugins_url("/images/buttons/2.png", dirname(__FILE__)); ?>" alt="AJdG Solutions website" /></a><a href="https://www.twitter.com/arnandegans" title="Arnan de Gans on Twitter" target="_blank"><img src="<?php echo plugins_url("/images/buttons/4.png", dirname(__FILE__)); ?>" alt="Arnan de Gans on Twitter" /></a><a href="https://ajdgsolutions.tumblr.com" title="AJdG Solutions on Tumblr" target="_blank"><img src="<?php echo plugins_url("/images/buttons/3.png", dirname(__FILE__)); ?>" alt="AJdG Solutions on Tumblr" /></a></center></p>

					<?php wp_widget_rss_output(array(
						'url' => 'http://ajdg.solutions/feed/', 
						'items' => 2, 
						'show_summary' => 1, 
						'show_author' => 0, 
						'show_date' => 1)
					); ?>
				</div>
			</div>
			
			<div class="ajdg-postbox">
				<h2 class="ajdg-postbox-title"><?php _e('Buy AdRotate Professional', 'adrotate'); ?></h2>
				<div id="get-pro" class="ajdg-postbox-content">
					<p><a href="https://ajdg.solutions/plugins/adrotate-for-wordpress/" target="_blank"><img src="<?php echo plugins_url('/images/logo-60x60.png', dirname(__FILE__)); ?>" class="alignleft pro-image" /></a><?php _e('AdRotate Professional has a lot more functions for even better advertising management. Check out the feature comparison tab on any of the product pages to see what AdRotate Pro has to offer for you!', 'adrotate'); ?></p>
					<a href="https://ajdg.solutions/plugins/adrotate-for-wordpress/"><img src="<?php echo plugins_url('/images/adrotate-product.png', dirname(__FILE__)); ?>" alt="adrotate-product" width="150" height="150" align="right" style="padding: 0 0 10px 10px;" /></a>
					<p><a href="https://ajdg.solutions/product/adrotate-pro-single/" target="_blank"><strong><?php _e('Single License', 'adrotate'); ?> (&euro; 39.00)</strong></a><br /><em><?php _e('Use on ONE WordPress installation.', 'adrotate'); ?> <a href="https://ajdg.solutions/?add-to-cart=1124" target="_blank"><?php _e('Buy now', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/product/adrotate-pro-duo/" target="_blank"><strong><?php _e('Duo License', 'adrotate'); ?> (&euro; 49.00)</strong></a><br /><em><?php _e('Use on TWO WordPress installations.', 'adrotate'); ?> <a href="https://ajdg.solutions/?add-to-cart=1126" target="_blank"><?php _e('Buy now', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/product/adrotate-pro-multi/" target="_blank"><strong><?php _e('Multi License', 'adrotate'); ?> (&euro; 99.00)</strong></a><br /><em><?php _e('Use on up to FIVE WordPress installations.', 'adrotate'); ?> <a href="https://ajdg.solutions/?add-to-cart=1128" target="_blank"><?php _e('Buy now', 'adrotate'); ?> &raquo;</a></em></p>
					<p><a href="https://ajdg.solutions/product/adrotate-pro-developer/" target="_blank"><strong><?php _e('Developer License', 'adrotate'); ?> (&euro; 199.00)</strong></a><br /><em><?php _e('Use on up to a HUNDRED WordPress installations and/or networks.', 'adrotate'); ?> <a href="https://ajdg.solutions/?add-to-cart=1130" target="_blank"><?php _e('Buy now', 'adrotate'); ?> &raquo;</a></em></p>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="clear"></div>

<hr>
<h1><?php _e('Advertising Partners & Affiliates', 'adrotate'); ?></h1>
<em><?php _e('A selection of quality advertiser networks and useful products. If you need adverts or just want more or more diverse adverts. Check out these great options!', 'adrotate'); ?></em>

<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">
		<div id="left-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">				
				<h2 class="ajdg-postbox-title"><?php _e('Join the Media.net advertising network', 'adrotate'); ?></h2>
				<div id="medianet" class="ajdg-postbox-content">
					<center><a href="https://ajdg.solutions/go/medianet/" target="_blank"><img src="<?php echo plugins_url("/images/offers/medianet.jpg", dirname(__FILE__)); ?>" width="440" /></a></center>
					<p><a href="https://ajdg.solutions/go/medianet/" target="_blank">Media.net</a> is the <strong>#2 largest contextual ads platform</strong> in the world that provides its publishers with an <strong>exclusive access to the Yahoo! Bing Network of advertisers and $6bn worth of search demand.</strong></p>

					<p><a href="https://ajdg.solutions/go/medianet/" target="_blank">Media.net</a> <strong>ads are contextual</strong> and hence always relevant to your content. They are also <strong>native by design</strong> and highly customizable, delivering a great user experience and higher CTRs.</p>
					
					<strong><u>Exclusive offer for AdRotate users</u></strong>
					<p>As an AdRotate user, sign up with <a href="https://ajdg.solutions/go/medianet/" target="_blank">Media.net</a> and you'll earn 10% more, over and above your regular earnings for your first 3 months. <strong>Sign up now!</strong></p>
					
					<p><a class="button-primary" href="https://ajdg.solutions/go/medianet/" target="_blank">Sign up with Media.net &raquo;</a>&nbsp;&nbsp;<a class="button" target="_blank" href="https://ajdg.solutions/go/medianet/">Learn more &raquo;</a></p>
				</div>
			</div>

		</div>
		<div id="right-column" class="ajdg-postbox-container">

			<div class="ajdg-postbox">				
				<h2 class="ajdg-postbox-title"><?php _e('Namecheap SSL Certificates', 'adrotate'); ?></h2>
				<div id="namecheap" class="ajdg-postbox-content">
					<p>With the increasing risks on the internet it's smart to earn back the trust of your visitors by installing a SSL certificate on your website. Show them that you care about their privacy with a good and solid certificate. NameCheap has plenty of affordable options for all kinds of protection. I've been a customer of NameCheap for many years - So far no complaints.</p>
					<p><center><a rel="nofollow" href="https://ajdg.solutions/go/namecheap/"><img src="<?php echo plugins_url("/images/offers/namecheap-ssl.jpg", dirname(__FILE__)); ?>" width="440" alt="Namecheap.com"></a></center></p>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="clear"></div>
<p><?php echo adrotate_trademark(); ?></p>
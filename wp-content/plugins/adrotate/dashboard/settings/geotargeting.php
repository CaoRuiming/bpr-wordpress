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

<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=geo">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Geo Targeting - Available in AdRotate Pro', 'adrotate'); ?></h2>
<span class="description"><?php _e('Target certain areas in the world for better advertising oppurtunities.', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Which Geo Service', 'adrotate'); ?></th>
		<td>
			<select name="adrotate_enable_geo_disabled">
				<option value="0"><?php _e('Disabled', 'adrotate'); ?></option>
				<option value="0" disabled="1">AdRotate Geo</option>
				<option value="0" disabled="1">FreegeoIP</option>
				<option value="0" disabled="1">MaxMind City</option>
				<option value="0" disabled="1">MaxMind Country</option>
				<option value="0" disabled="1">CloudFlare</option>
			</select><br />
			<span class="description">
				<p><strong>AdRotate Geo</strong> - <?php _e('30000 free lookups every day, uses GeoLite2 databases from MaxMind!', 'adrotate'); ?><br />
				<em><strong><?php _e('Supports:', 'adrotate'); ?></strong> ipv4/ipv6, Countries, Cities, DMA codes, States and State ISO (3166-2) codes.</em><br />
				<em><strong><?php _e('Scalability:', 'adrotate'); ?></strong> <?php _e('Suitable for small to medium websites.', 'adrotate'); ?></em><br /><br />

				<p><strong>FreegeoIP</strong> - <?php _e('15000 free lookups per hour, uses GeoLite2 databases from MaxMind!', 'adrotate'); ?><br />
				<em><strong><?php _e('Supports:', 'adrotate'); ?></strong> ipv4, Countries, Cities, DMA codes, States and State ISO (3166-2) codes.</em><br />
				<em><strong><?php _e('Scalability:', 'adrotate'); ?></strong> <?php _e('Suitable for medium sized websites.', 'adrotate'); ?></em><br /><br />

				<strong>MaxMind</strong> - <a href="https://www.maxmind.com/en/geoip2-precision-services?rId=ajdgnet" target="_blank">GeoIP2 Precision</a> - <?php _e('The most accurate geo targeting you can get for only $20 USD per 50000 lookups.', 'adrotate'); ?> <a href="https://www.maxmind.com/en/geoip2-precision-city?rId=ajdgnet" target="_blank"><?php _e('Buy now', 'adrotate'); ?>.</a><br />
				<em><strong><?php _e('Supports:', 'adrotate'); ?></strong> ipv4/ipv6, Countries, States, State ISO (3166-2) codes, Cities and DMA codes.</em><br />
				<em><strong><?php _e('Scalability:', 'adrotate'); ?></strong> <?php _e('Suitable for any size website as long as you have lookups.', 'adrotate'); ?></em><br /><br />
				
				<strong>CloudFlare</strong> - <a href="https://support.cloudflare.com/hc/en-us/articles/200168236-What-does-CloudFlare-IP-Geolocation-do-" target="_blank">IP Geolocation</a> - <?php _e('Basic geolocation included in every CloudFlare account.', 'adrotate'); ?><br />
				<em><strong><?php _e('Supports:', 'adrotate'); ?></strong> ipv4/ipv6, Countries.</em><br />
				<em><strong><?php _e('Scalability:', 'adrotate'); ?></strong> <?php _e('Suitable for any size website.', 'adrotate'); ?></em>
			</span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Geo Cookie Lifespan', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_geo_cookie_life"><select name="adrotate_geo_cookie_life_disabled">
				<option value="0" disabled>24 (<?php _e('Default', 'adrotate'); ?>)</option>
				<option value="0" disabled>36</option>
				<option value="0" disabled>48</option>
				<option value="0" disabled>72</option>
				<option value="0" disabled>120</option>
				<option value="0" disabled>168</option>
			</select> <?php _e('Hours.', 'adrotate'); ?></label><br />
			<span class="description"><?php _e('Geo Data is stored in a cookie to reduce lookups. How long should this cookie last? A longer period is less accurate for mobile users but may reduce the usage of your lookups drastically.', 'adrotate'); ?></span>

		</td>
	</tr>
</table>

<h3><?php _e('MaxMind City/Country', 'adrotate'); ?></h3>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Username/Email', 'adrotate'); ?></th>
		<td><label for="adrotate_geo_email"><input name="adrotate_geo_email_disabled" type="text" class="search-input" size="50" value="" disabled /></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Password/License Key', 'adrotate'); ?></th>
		<td><label for="adrotate_geo_pass"><input name="adrotate_geo_pass_disabled" type="text" class="search-input" size="50" value="" disabled /></label></td>
	</tr>
</table>
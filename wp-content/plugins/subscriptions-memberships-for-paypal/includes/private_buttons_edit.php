<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if (isset($_POST['update'])) {


	$post_id = intval($_GET['product']);

	// check nonce for security
	$nonce = $_REQUEST['_wpnonce'];
	if ( ! wp_verify_nonce( $nonce, 'edit_'.$post_id ) ) {
		echo "Nonce verification failed.";
		exit;
	}
	
	

	if ( !current_user_can( "manage_options" ) )  {
		wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
	}
	
	
	if (!$post_id) {
		echo'<script>window.location="admin.php?page=wpeppsub_buttons"; </script>';
		exit;
	}
	
	// Update data
	
	$my_post = array(
	'ID'           => $post_id,
	'post_title'   => sanitize_text_field($_POST['wpeppsub_button_name'])
	);
	wp_update_post($my_post);
	
	// main
	$wpeppsub_button_show = !empty($_POST['wpeppsub_button_show']) ? sanitize_text_field($_POST['wpeppsub_button_show']) : 0;
    update_post_meta($post_id, "wpeppsub_button_show", $wpeppsub_button_show);
	
	update_post_meta($post_id, 'wpeppsub_button_name', sanitize_text_field($_POST['wpeppsub_button_name']));
	
	// id / sku
	$wpeppsub_button_sku = sanitize_text_field($_POST['wpeppsub_button_sku']);
	update_post_meta($post_id, 'wpeppsub_button_sku', $wpeppsub_button_sku);
	
	// language and currency
	$wpeppsub_button_currency =			intval($_POST['wpeppsub_button_currency']);
	if (!$wpeppsub_button_currency) { 	$wpeppsub_button_currency = ""; }
	update_post_meta($post_id, 'wpeppsub_button_currency', $wpeppsub_button_currency);	
	
	$wpeppsub_button_language =			intval($_POST['wpeppsub_button_language']);
	if (!$wpeppsub_button_language) { 	$wpeppsub_button_language = ""; }
	update_post_meta($post_id, 'wpeppsub_button_language', $wpeppsub_button_language);
	
	// other
	$wpeppsub_button_buttonsize =			intval($_POST['wpeppsub_button_buttonsize']);
	if (!$wpeppsub_button_buttonsize && $wpeppsub_button_buttonsize != "0") { 	$wpeppsub_button_buttonsize = ""; }
	update_post_meta($post_id, 'wpeppsub_button_buttonsize', $wpeppsub_button_buttonsize);
	
	// amount
	$wpeppsub_a3 = sanitize_meta( 'currency_wpeppsub', $_POST['wpeppsub_a3'], 'post' );
	update_post_meta($post_id, 'wpeppsub_a3', $wpeppsub_a3);
	
	$wpeppsub_p3 =			intval($_POST['wpeppsub_p3']);
	if (!$wpeppsub_p3 && $wpeppsub_p3 != "0") { 	$wpeppsub_p3 = ""; }
	update_post_meta($post_id, 'wpeppsub_p3', $wpeppsub_p3);
	
	$wpeppsub_t3 =			sanitize_text_field($_POST['wpeppsub_t3']);
	if (!$wpeppsub_t3 && $wpeppsub_t3 != "0") { 	$wpeppsub_t3 = ""; }
	update_post_meta($post_id, 'wpeppsub_t3', $wpeppsub_t3);
	
	$wpeppsub_srt =			intval($_POST['wpeppsub_srt']);
	if (!$wpeppsub_srt && $wpeppsub_srt != "0") { 	$wpeppsub_srt = ""; }
	update_post_meta($post_id, 'wpeppsub_srt', $wpeppsub_srt);
	
	// trial 1
	$wpeppsub_trial_1 = !empty($_POST['wpeppsub_trial_1']) ? sanitize_text_field($_POST['wpeppsub_trial_1']) : 0;
    update_post_meta($post_id, "wpeppsub_trial_1", $wpeppsub_trial_1);
	
	$wpeppsub_a1 = sanitize_meta( 'currency_wpeppsub', $_POST['wpeppsub_a1'], 'post' );
	update_post_meta($post_id, 'wpeppsub_a1', $wpeppsub_a1);
	
	$wpeppsub_p1 =			intval($_POST['wpeppsub_p1']);
	if (!$wpeppsub_p1 && $wpeppsub_p1 != "0") { 	$wpeppsub_p1 = ""; }
	update_post_meta($post_id, 'wpeppsub_p1', $wpeppsub_p1);
	
	$wpeppsub_t1 =			sanitize_text_field($_POST['wpeppsub_t1']);
	if (!$wpeppsub_t1 && $wpeppsub_t1 != "0") { 	$wpeppsub_t1 = ""; }
	update_post_meta($post_id, 'wpeppsub_t1', $wpeppsub_t1);			
	
	
	
	
	// Check for errors
	$message = [];
	if (empty($_POST['wpeppsub_button_name'])) {
		$message[] = "Name Field Required";
		$error = "1";
	}
	if (empty($_POST['wpeppsub_a3'])) {
		$message[] = " Billing amount each cycle Field Required";
		$error = "1";
	}
	
	if (!isset($error)) {
	
		$message[] = "Saved";
	
	}
}


	if ( !current_user_can( "manage_options" ) )  {
		wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
	}

?>

<div style="width:98%;">

	<form method='post' action='<?php echo esc_html($_SERVER["REQUEST_URI"]); ?>'>
	
		<?php
		$post_id = intval($_GET['product']);
		
		if (!$post_id) {
			echo'<script>window.location="admin.php?page=wpeppsub_buttons"; </script>';
			exit;
		}
		
		$post_data = get_post($post_id);
		$title = $post_data->post_title;
		
		$siteurl = get_site_url();
		?>
		
		<table width="100%"><tr><td valign="bottom" width="85%">
			<br />
			<span style="font-size:20pt;">Edit Button</span>
			</td><td valign="bottom">
			<input type="submit" class="button-primary" style="font-size: 14px;height: 30px;float: right;" value="Save Button">
			</td><td valign="bottom">
			<a href="admin.php?page=wpeppsub_buttons" class="button-secondary" style="font-size: 14px;height: 30px;float: right;">View All Buttons</a>
		</td></tr></table>
		
		<?php
		// error
		if (isset($error) && isset($message)) {
			foreach ($message as $messagea) {
				echo "<div class='error'><p>"; echo esc_html($messagea); echo"</p></div>";
			}
			
		}
		// saved
		if (!isset($error) && isset($message)) {
			foreach ($message as $messagea) {
				echo "<div class='updated'><p>"; echo esc_html($messagea); echo"</p></div>";
			}
		}
		?>
		
		<br />
		
		<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br />
		
			<table><tr><td>
			
				<b>Shortcode</b> </td><td></td></td></td></tr><tr><td>
				Shortcode: </td><td><input type="text" readonly="true" value="<?php echo "[wpeppsub id=" . esc_attr($post_id) . "]"; ?>"></td><td>Put this in a page, post, or <a target="_blank" href="https://wpplugin.org/documentation/?document=2314">in your theme</a>, to show the PayPal Button on your site. <br />You can also use the button inserter found above the page or post editor.
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				<b>Main</b> </td><td></td></td></td></tr><tr><td>
				Item Name: </td><td><input type="text" name="wpeppsub_button_name" value="<?php echo esc_attr($title); ?>"></td><td> Required - The name of the item. </td></tr><tr><td>
				Item ID: </td><td><input type="text" name="wpeppsub_button_sku" value="<?php echo esc_attr(get_post_meta($post_id,'wpeppsub_button_sku',true)); ?>"></td><td> Optional - The ID / SKU of the item. </td></tr><tr><td>
				
				<?php
				$wpeppsub_button_show = get_post_meta($post_id, "wpeppsub_button_show", true);
				?>
				
				Show Name: </td><td><input type="checkbox" name="wpeppsub_button_show" value="1" <?php checked($wpeppsub_button_show, '1'); ?>></td><td> Optional - Show the name of the item above the button.
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				<b>Language & Currency</b> </td><td></td></td></td></tr><tr><td>
				
				</td><td><br /></td></td></td></tr><tr><td>
				Language: </td><td>
				<select name="wpeppsub_button_language" style="width: 190px">
                    <?php $wpeppsub_button_language = get_post_meta($post_id,'wpeppsub_button_language',true); ?>
					<option <?php selected($wpeppsub_button_language, '0'); ?> value="0">Default Language</option>
					<option <?php selected($wpeppsub_button_language, '1'); ?> value="1">Danish</option>
					<option <?php selected($wpeppsub_button_language, '2'); ?> value="2">Dutch</option>
					<option <?php selected($wpeppsub_button_language, '3'); ?> value="3">English</option>
					<option <?php selected($wpeppsub_button_language, '20'); ?> value="20">English - UK</option>
					<option <?php selected($wpeppsub_button_language, '4'); ?> value="4">French</option>
					<option <?php selected($wpeppsub_button_language, '5'); ?> value="5">German</option>
					<option <?php selected($wpeppsub_button_language, '6'); ?> value="6">Hebrew</option>
					<option <?php selected($wpeppsub_button_language, '7'); ?> value="7">Italian</option>
					<option <?php selected($wpeppsub_button_language, '8'); ?> value="8">Japanese</option>
					<option <?php selected($wpeppsub_button_language, '9'); ?> value="9">Norwgian</option>
					<option <?php selected($wpeppsub_button_language, '10'); ?> value="10">Polish</option>
					<option <?php selected($wpeppsub_button_language, '11'); ?> value="11">Portuguese</option>
					<option <?php selected($wpeppsub_button_language, '12'); ?> value="12">Russian</option>
					<option <?php selected($wpeppsub_button_language, '13'); ?> value="13">Spanish</option>
					<option <?php selected($wpeppsub_button_language, '14'); ?> value="14">Swedish</option>
					<option <?php selected($wpeppsub_button_language, '15'); ?> value="15">Simplified Chinese -China only</option>
					<option <?php selected($wpeppsub_button_language, '16'); ?> value="16">Traditional Chinese - Hong Kong only</option>
					<option <?php selected($wpeppsub_button_language, '17'); ?> value="17">Traditional Chinese - Taiwan only</option>
					<option <?php selected($wpeppsub_button_language, '18'); ?> value="18">Turkish</option>
					<option <?php selected($wpeppsub_button_language, '19'); ?> value="19">Thai</option>
				</select></td><td>Optional - Will override setttings page value.</td></td></td></tr><tr><td>
				

				Currency: </td><td>
				<select name="wpeppsub_button_currency" style="width: 190px">
                    <?php $wpeppsub_button_currency = get_post_meta($post_id,'wpeppsub_button_currency',true); ?>
					<option <?php selected($wpeppsub_button_currency, '0'); ?> value="0">Default Currency</option>
					<option <?php selected($wpeppsub_button_currency, '1'); ?> value="1">Australian Dollar - AUD</option>
					<option <?php selected($wpeppsub_button_currency, '2'); ?> value="2">Brazilian Real - BRL</option>
					<option <?php selected($wpeppsub_button_currency, '3'); ?> value="3">Canadian Dollar - CAD</option>
					<option <?php selected($wpeppsub_button_currency, '4'); ?> value="4">Czech Koruna - CZK</option>
					<option <?php selected($wpeppsub_button_currency, '5'); ?> value="5">Danish Krone - DKK</option>
					<option <?php selected($wpeppsub_button_currency, '6'); ?> value="6">Euro - EUR</option>
					<option <?php selected($wpeppsub_button_currency, '7'); ?> value="7">Hong Kong Dollar - HKD</option>
					<option <?php selected($wpeppsub_button_currency, '8'); ?> value="8">Hungarian Forint - HUF</option>
					<option <?php selected($wpeppsub_button_currency, '9'); ?> value="9">Israeli New Sheqel - ILS</option>
					<option <?php selected($wpeppsub_button_currency, '10'); ?> value="10">Japanese Yen - JPY</option>
					<option <?php selected($wpeppsub_button_currency, '11'); ?> value="11">Malaysian Ringgit - MYR</option>
					<option <?php selected($wpeppsub_button_currency, '12'); ?> value="12">Mexican Peso - MXN</option>
					<option <?php selected($wpeppsub_button_currency, '13'); ?> value="13">Norwegian Krone - NOK</option>
					<option <?php selected($wpeppsub_button_currency, '14'); ?> value="14">New Zealand Dollar - NZD</option>
					<option <?php selected($wpeppsub_button_currency, '15'); ?> value="15">Philippine Peso - PHP</option>
					<option <?php selected($wpeppsub_button_currency, '16'); ?> value="16">Polish Zloty - PLN</option>
					<option <?php selected($wpeppsub_button_currency, '17'); ?> value="17">Pound Sterling - GBP</option>
					<option <?php selected($wpeppsub_button_currency, '18'); ?> value="18">Russian Ruble - RUB</option>
					<option <?php selected($wpeppsub_button_currency, '19'); ?> value="19">Singapore Dollar - SGD</option>
					<option <?php selected($wpeppsub_button_currency, '20'); ?> value="20">Swedish Krona - SEK</option>
					<option <?php selected($wpeppsub_button_currency, '21'); ?> value="21">Swiss Franc - CHF</option>
					<option <?php selected($wpeppsub_button_currency, '22'); ?> value="22">Taiwan New Dollar - TWD</option>
					<option <?php selected($wpeppsub_button_currency, '23'); ?> value="23">Thai Baht - THB</option>
					<option <?php selected($wpeppsub_button_currency, '24'); ?> value="24">Turkish Lira - TRY</option>
					<option <?php selected($wpeppsub_button_currency, '25'); ?> value="25">U.S. Dollar - USD</option>
				</select></td><td>Optional - Will override setttings page value.
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				
				<b>Other</b> </td><td></td></td></td></tr><tr><td>
				<!--
				PayPal Account: </td><td><input type="text" name="wpeppsub_button_account" value="<?php //echo esc_attr(get_post_meta($post_id,'wpeppsub_button_account',true)); ?>"></td><td> Optional - Will override setttings page value.</td></tr><tr><td>
				Return URL: </td><td><input type="text" name="wpeppsub_button_return" value="<?php //echo esc_attr(get_post_meta($post_id,'wpeppsub_button_return',true)); ?>"></td><td> Optional - Will override setttings page value. <br />Example: <?php //echo esc_url($siteurl); ?>/thankyou</td></tr><tr><td>
				-->
				Button Size: </td><td>
				<select name="wpeppsub_button_buttonsize" style="width:190px;">
                    <?php $wpeppsub_button_buttonsize = get_post_meta($post_id,'wpeppsub_button_buttonsize',true); ?>
					<option value="0" <?php selected($wpeppsub_button_buttonsize, '0'); ?>>Default Button</option>
					<option value="1" <?php selected($wpeppsub_button_buttonsize, '1'); ?>>Small Buy Now</option>
					<option value="2" <?php selected($wpeppsub_button_buttonsize, '2'); ?>>Big Buy Now</option>
					<option value="3" <?php selected($wpeppsub_button_buttonsize, '3'); ?>>Big Buy Now with Credit Cards</option>
					<option value="4" <?php selected($wpeppsub_button_buttonsize, '4'); ?>>Small Pay Now</option>
					<option value="5" <?php selected($wpeppsub_button_buttonsize, '5'); ?>>Big Pay Now</option>
					<option value="6" <?php selected($wpeppsub_button_buttonsize, '6'); ?>>Big Pay Now</option>
					<option value="9" <?php selected($wpeppsub_button_buttonsize, '9'); ?>>Small Subscribe</option>
					<option value="10" <?php selected($wpeppsub_button_buttonsize, '10'); ?>>Big Subscribe</option>
					<option value="11" <?php selected($wpeppsub_button_buttonsize, '11'); ?>>Big Subscribe with Credit Cards</option>
					<option value="7" <?php selected($wpeppsub_button_buttonsize, '7'); ?>>Gold Buy Now (English only)</option>
					<option value="12" <?php selected($wpeppsub_button_buttonsize, '12'); ?>>Gold Check Out (English only)</option>
					
					<!--
					<option value="8" <?php //selected($wpeppsub_button_buttonsize, '8'); ?>>Custom</option>
					-->
				</select></td><td> Optional - Will override setttings page value.
				
				
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				
				<b>Amount</b> </td><td></td></td></td></tr><tr><td valign="top">
				
				Billing amount each cycle: </td><td valign="top"><input type="text" name="wpeppsub_a3" value="<?php echo esc_attr(get_post_meta($post_id,'wpeppsub_a3',true)); ?>" style="width:94px;"></td><td> Required
				
				</td></tr><tr><td valign="top">
				Billing cycle: </td><td valign="top">
				
				<select name="wpeppsub_p3">
                    <?php $wpeppsub_p3 = get_post_meta($post_id,'wpeppsub_p3',true); ?>
					<?php for ($i = 1; $i <= 30; $i++) { ?>
						<option value="<?php echo esc_attr($i); ?>" <?php selected($wpeppsub_p3, $i); ?>><?php echo esc_html($i); ?></option>
					<?php } ?>
				</select>
				
				<select name="wpeppsub_t3">
                    <?php $wpeppsub_t3 = get_post_meta($post_id,'wpeppsub_t3',true); ?>
					<option value="D" <?php selected($wpeppsub_t3, 'D'); ?>>day(s)</option>
					<option value="W" <?php selected($wpeppsub_t3, 'W'); ?>>week(s)</option>
					<option value="M" <?php selected($wpeppsub_t3, 'M'); ?>>month(s)</option>
					<option value="Y" <?php selected($wpeppsub_t3, 'Y'); ?>>year(s)</option>
				</select>
				
				</td></tr><tr><td valign="top">
				
				After how many cycles should billing stop: </td><td>
				
				<select name="wpeppsub_srt">
                    <?php $wpeppsub_srt = get_post_meta($post_id,'wpeppsub_srt',true); ?>
					<option value="0" <?php selected($wpeppsub_srt, '0'); ?>>Never</option>
					<?php for ($i = 1; $i <= 30; $i++) { ?>
						<option value="<?php echo esc_attr($i); ?>" <?php selected($wpeppsub_srt, $i); ?>><?php echo esc_html($i); ?></option>
					<?php } ?>
				</select>
				
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				
				
				
				
				<b>Trial</b> </td><td></td></td></td></tr><tr><td valign="top">
				
				<?php
				$wpeppsub_trial_1 = get_post_meta($post_id, "wpeppsub_trial_1", true);
				?>
				
				I want to offer a trial period: </td><td>
				<input type="checkbox" name="wpeppsub_trial_1" value="1" <?php checked($wpeppsub_trial_1, '1'); ?>></td><td>Optional</td><td>
				
				</td></tr><tr><td valign="top">
				Amount to bill for the trial period: </td><td valign="top"><input type="text" name="wpeppsub_a1" value="<?php echo esc_attr(get_post_meta($post_id,'wpeppsub_a1',true)); ?>" style="width:94px;">

				</td></tr><tr><td valign="top">
				Define the trial period: </td><td>
				
				<select name="wpeppsub_p1">
                    <?php $wpeppsub_p1 = get_post_meta($post_id,'wpeppsub_p1',true); ?>
					<?php for ($i = 1; $i <= 52; $i++) { ?>
						<option value="<?php echo esc_attr($i); ?>" <?php selected($wpeppsub_p1, $i); ?>><?php echo esc_html($i); ?></option>
					<?php } ?>
				</select>
				
				<select name="wpeppsub_t1">
                    <?php $wpeppsub_t1 = get_post_meta($post_id,'wpeppsub_t1',true); ?>
					<option value="D" <?php selected($wpeppsub_t1, 'D'); ?>>day(s)</option>
					<option value="W" <?php selected($wpeppsub_t1, 'W'); ?>>week(s)</option>
					<option value="M" <?php selected($wpeppsub_t1, 'M'); ?>>month(s)</option>
					<option value="Y" <?php selected($wpeppsub_t1, 'Y'); ?>>year(s)</option>
				</select>
				
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				<input type="hidden" name="update" value="1">
					
				</td></tr></table>						
		</div>
		<?php wp_nonce_field('edit_'.$post_id); ?>
	</form>
</div>
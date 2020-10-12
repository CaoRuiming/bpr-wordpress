<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if (isset($_POST['update'])) {

	if ( !current_user_can( "manage_options" ) )  {
		wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
	}
	
	$post_id = intval($_GET['product']);
	
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
	if (!empty($_POST['wpeppsub_button_show'])) {
		$skip = sanitize_text_field($_POST['wpeppsub_button_show']);
		update_post_meta($post_id, "wpeppsub_button_show", $skip);
	} else {
		update_post_meta($post_id, "wpeppsub_button_show", 0);
	}
	
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
	if (!empty($_POST['wpeppsub_trial_1'])) {
		$skip = sanitize_text_field($_POST['wpeppsub_trial_1']);
		update_post_meta($post_id, "wpeppsub_trial_1", $skip);
	} else {
		update_post_meta($post_id, "wpeppsub_trial_1", 0);
	}
	
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

	<form method='post' action='<?php $_SERVER["REQUEST_URI"]; ?>'>
	
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
		if (isset($error) && isset($error) && isset($message)) {
			foreach ($message as $messagea) {
				echo "<div class='error'><p>"; echo $messagea; echo"</p></div>";
			}
			
		}
		// saved
		if (!isset($error)&& !isset($error) && isset($message)) {
			foreach ($message as $messagea) {
				echo "<div class='updated'><p>"; echo $messagea; echo"</p></div>";
			}
		}
		?>
		
		<br />
		
		<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br />
		
			<table><tr><td>
			
				<b>Shortcode</b> </td><td></td></td></td></tr><tr><td>
				Shortcode: </td><td><input type="text" readonly="true" value="<?php echo "[wpeppsub id=$post_id]"; ?>"></td><td>Put this in a page, post, or <a target="_blank" href="https://wpplugin.org/documentation/?document=2314">in your theme</a>, to show the PayPal Button on your site. <br />You can also use the button inserter found above the page or post editor.
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				<b>Main</b> </td><td></td></td></td></tr><tr><td>
				Item Name: </td><td><input type="text" name="wpeppsub_button_name" value="<?php echo esc_attr($title); ?>"></td><td> Required - The name of the item. </td></tr><tr><td>
				Item ID: </td><td><input type="text" name="wpeppsub_button_sku" value="<?php echo esc_attr(get_post_meta($post_id,'wpeppsub_button_sku',true)); ?>"></td><td> Optional - The ID / SKU of the item. </td></tr><tr><td>
				
				<?php
				$wpeppsub_button_show = get_post_meta($post_id, "wpeppsub_button_show", true);
				if ($wpeppsub_button_show == "1") { $show_enable = "CHECKED"; } else { $show_enable = ""; }
				?>
				
				Show Name: </td><td><input type="checkbox" name="wpeppsub_button_show" value="1" <?php echo $show_enable; ?>></td><td> Optional - Show the name of the item above the button.
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				<b>Language & Currency</b> </td><td></td></td></td></tr><tr><td>
				
				</td><td><br /></td></td></td></tr><tr><td>
				Language: </td><td>
				<select name="wpeppsub_button_language" style="width: 190px">
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "0") { echo "SELECTED"; } ?> value="0">Default Language</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "1") { echo "SELECTED"; } ?> value="1">Danish</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "2") { echo "SELECTED"; } ?> value="2">Dutch</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "3") { echo "SELECTED"; } ?> value="3">English</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "20") { echo "SELECTED"; } ?> value="20">English - UK</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "4") { echo "SELECTED"; } ?> value="4">French</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "5") { echo "SELECTED"; } ?> value="5">German</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "6") { echo "SELECTED"; } ?> value="6">Hebrew</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "7") { echo "SELECTED"; } ?> value="7">Italian</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "8") { echo "SELECTED"; } ?> value="8">Japanese</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "9") { echo "SELECTED"; } ?> value="9">Norwgian</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "10") { echo "SELECTED"; } ?> value="10">Polish</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "11") { echo "SELECTED"; } ?> value="11">Portuguese</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "12") { echo "SELECTED"; } ?> value="12">Russian</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "13") { echo "SELECTED"; } ?> value="13">Spanish</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "14") { echo "SELECTED"; } ?> value="14">Swedish</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "15") { echo "SELECTED"; } ?> value="15">Simplified Chinese -China only</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "16") { echo "SELECTED"; } ?> value="16">Traditional Chinese - Hong Kong only</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "17") { echo "SELECTED"; } ?> value="17">Traditional Chinese - Taiwan only</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "18") { echo "SELECTED"; } ?> value="18">Turkish</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true)) == "19") { echo "SELECTED"; } ?> value="19">Thai</option>
				</select></td><td>Optional - Will override setttings page value.</td></td></td></tr><tr><td>
				

				Currency: </td><td>
				<select name="wpeppsub_button_currency" style="width: 190px">
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "0") { echo "SELECTED"; } ?> value="0">Default Currency</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "1") { echo "SELECTED"; } ?> value="1">Australian Dollar - AUD</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "2") { echo "SELECTED"; } ?> value="2">Brazilian Real - BRL</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "3") { echo "SELECTED"; } ?> value="3">Canadian Dollar - CAD</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "4") { echo "SELECTED"; } ?> value="4">Czech Koruna - CZK</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "5") { echo "SELECTED"; } ?> value="5">Danish Krone - DKK</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "6") { echo "SELECTED"; } ?> value="6">Euro - EUR</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "7") { echo "SELECTED"; } ?> value="7">Hong Kong Dollar - HKD</option> 	 
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "8") { echo "SELECTED"; } ?> value="8">Hungarian Forint - HUF</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "9") { echo "SELECTED"; } ?> value="9">Israeli New Sheqel - ILS</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "10") { echo "SELECTED"; } ?> value="10">Japanese Yen - JPY</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "11") { echo "SELECTED"; } ?> value="11">Malaysian Ringgit - MYR</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "12") { echo "SELECTED"; } ?> value="12">Mexican Peso - MXN</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "13") { echo "SELECTED"; } ?> value="13">Norwegian Krone - NOK</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "14") { echo "SELECTED"; } ?> value="14">New Zealand Dollar - NZD</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "15") { echo "SELECTED"; } ?> value="15">Philippine Peso - PHP</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "16") { echo "SELECTED"; } ?> value="16">Polish Zloty - PLN</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "17") { echo "SELECTED"; } ?> value="17">Pound Sterling - GBP</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "18") { echo "SELECTED"; } ?> value="18">Russian Ruble - RUB</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "19") { echo "SELECTED"; } ?> value="19">Singapore Dollar - SGD</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "20") { echo "SELECTED"; } ?> value="20">Swedish Krona - SEK</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "21") { echo "SELECTED"; } ?> value="21">Swiss Franc - CHF</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "22") { echo "SELECTED"; } ?> value="22">Taiwan New Dollar - TWD</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "23") { echo "SELECTED"; } ?> value="23">Thai Baht - THB</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "24") { echo "SELECTED"; } ?> value="24">Turkish Lira - TRY</option>
					<option <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true)) == "25") { echo "SELECTED"; } ?> value="25">U.S. Dollar - USD</option>
				</select></td><td>Optional - Will override setttings page value.
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				
				<b>Other</b> </td><td></td></td></td></tr><tr><td>
				<!--
				PayPal Account: </td><td><input type="text" name="wpeppsub_button_account" value="<?php //echo esc_attr(get_post_meta($post_id,'wpeppsub_button_account',true)); ?>"></td><td> Optional - Will override setttings page value.</td></tr><tr><td>
				Return URL: </td><td><input type="text" name="wpeppsub_button_return" value="<?php //echo esc_attr(get_post_meta($post_id,'wpeppsub_button_return',true)); ?>"></td><td> Optional - Will override setttings page value. <br />Example: <?php echo $siteurl; ?>/thankyou</td></tr><tr><td>
				-->
				Button Size: </td><td>
				<select name="wpeppsub_button_buttonsize" style="width:190px;">
					<option value="0" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "0") { echo "SELECTED"; } ?>>Default Button</option>
					<option value="1" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "1") { echo "SELECTED"; } ?>>Small Buy Now</option>
					<option value="2" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "2") { echo "SELECTED"; } ?>>Big Buy Now</option>
					<option value="3" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "3") { echo "SELECTED"; } ?>>Big Buy Now with Credit Cards</option>
					<option value="4" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "4") { echo "SELECTED"; } ?>>Small Pay Now</option>
					<option value="5" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "5") { echo "SELECTED"; } ?>>Big Pay Now</option>
					<option value="6" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "6") { echo "SELECTED"; } ?>>Big Pay Now</option>
					<option value="9" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "9") { echo "SELECTED"; } ?>>Small Subscribe</option>
					<option value="10" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "10") { echo "SELECTED"; } ?>>Big Subscribe</option>
					<option value="11" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "11") { echo "SELECTED"; } ?>>Big Subscribe with Credit Cards</option>
					<option value="7" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "7") { echo "SELECTED"; } ?>>Gold Buy Now (English only)</option>
					<option value="12" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "12") { echo "SELECTED"; } ?>>Gold Check Out (English only)</option>
					
					<!--
					<option value="8" <?php //if(esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true)) == "8") { echo "SELECTED"; } ?>>Custom</option>
					-->
				</select></td><td> Optional - Will override setttings page value.
				
				
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				
				<b>Amount</b> </td><td></td></td></td></tr><tr><td valign="top">
				
				Billing amount each cycle: </td><td valign="top"><input type="text" name="wpeppsub_a3" value="<?php echo esc_attr(get_post_meta($post_id,'wpeppsub_a3',true)); ?>" style="width:94px;"></td><td> Required
				
				</td></tr><tr><td valign="top">
				Billing cycle: </td><td valign="top">
				
				<select name="wpeppsub_p3">
					<?php for ($i = 1; $i <= 30; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_p3',true)) == $i) { echo "SELECTED"; } ?>><?php echo $i; ?></option>
					<?php } ?>
				</select>
				
				<select name="wpeppsub_t3">
					<option value="D" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t3',true)) == "D") { echo "SELECTED"; } ?>>day(s)</option>
					<option value="W" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t3',true)) == "W") { echo "SELECTED"; } ?>>week(s)</option>
					<option value="M" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t3',true)) == "M") { echo "SELECTED"; } ?>>month(s)</option>
					<option value="Y" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t3',true)) == "Y") { echo "SELECTED"; } ?>>year(s)</option>
				</select>
				
				</td></tr><tr><td valign="top">
				
				After how many cycles should billing stop: </td><td>
				
				<select name="wpeppsub_srt">
					<option value="0" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_srt',true)) == "0") { echo "SELECTED"; } ?>>Never</option>
					<?php for ($i = 1; $i <= 30; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_srt',true)) == $i) { echo "SELECTED"; } ?>><?php echo $i; ?></option>
					<?php } ?>
				</select>
				
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				
				
				
				
				<b>Trial</b> </td><td></td></td></td></tr><tr><td valign="top">
				
				<?php
				$wpeppsub_trial_1 = get_post_meta($post_id, "wpeppsub_trial_1", true);
				if ($wpeppsub_trial_1 == "1") { $wpeppsub_trial_1 = "CHECKED"; } else { $wpeppsub_trial_1 = ""; }
				?>
				
				I want to offer a trial period: </td><td>
				<input type="checkbox" name="wpeppsub_trial_1" value="1" <?php echo $wpeppsub_trial_1; ?>></td><td>Optional</td><td>
				
				</td></tr><tr><td valign="top">
				Amount to bill for the trial period: </td><td valign="top"><input type="text" name="wpeppsub_a1" value="<?php echo esc_attr(get_post_meta($post_id,'wpeppsub_a1',true)); ?>" style="width:94px;">

				</td></tr><tr><td valign="top">
				Define the trial period: </td><td>
				
				<select name="wpeppsub_p1">
					<?php for ($i = 1; $i <= 52; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_p1',true)) == $i) { echo "SELECTED"; } ?>><?php echo $i; ?></option>
					<?php } ?>
				</select>
				
				<select name="wpeppsub_t1">
					<option value="D" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t1',true)) == "D") { echo "SELECTED"; } ?>>day(s)</option>
					<option value="W" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t1',true)) == "W") { echo "SELECTED"; } ?>>week(s)</option>
					<option value="M" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t1',true)) == "M") { echo "SELECTED"; } ?>>month(s)</option>
					<option value="Y" <?php if(esc_attr(get_post_meta($post_id,'wpeppsub_t1',true)) == "Y") { echo "SELECTED"; } ?>>year(s)</option>
				</select>
				
				
				</td></tr><tr><td style="border-bottom: 1px solid #ddd;" colspan=3><br /></td></tr><tr><td><br />
				
				<input type="hidden" name="update" value="1">
					
				</td></tr></table>						
		</div>
	</form>
</div>
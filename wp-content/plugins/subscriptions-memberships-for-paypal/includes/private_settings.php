<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpeppsub_plugin_options() {

	if ( !current_user_can( "manage_options" ) )  {
		wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
	}

	?>
	
	<form method='post' action='<?php $_SERVER["REQUEST_URI"]; ?>'>
		
		<?php
		// save and update options
		if (isset($_POST['update'])) {

			if (!isset($_POST['action_save']) || ! wp_verify_nonce($_POST['action_save'],'nonce_save') ) {
			   print 'Sorry, your nonce did not verify.';
			   exit;
			}
			
			$options['currency'] =			intval($_POST['currency']);
			if (!$options['currency']) { 	$options['currency'] = "25"; }
				
			$options['language'] = 			intval($_POST['language']);
			if (!$options['language']) { 	$options['language'] = "3";	}
				
			$options['mode'] = 				intval($_POST['mode']);
			if (!$options['mode']) { 		$options['mode'] = "1";	}
				
			$options['size'] = 				intval($_POST['size']);
			if (!$options['size']) { 		$options['size'] = "1";	}
				
			$options['opens'] = 			intval($_POST['opens']);
			if (!$options['opens']) { 		$options['opens'] = "1"; }
				
			$options['no_shipping'] = 		intval($_POST['no_shipping']);
			if (!$options['no_shipping']) { $options['no_shipping'] = "0"; }
			
			$options['content'] = 			sanitize_text_field($_POST['content']);
			$options['hideadmin'] = 		sanitize_text_field($_POST['hideadmin']);
			$options['subscriber'] = 		sanitize_text_field($_POST['subscriber']);
			
			$options['liveaccount'] = 		sanitize_text_field($_POST['liveaccount']);
			$options['sandboxaccount'] = 	sanitize_text_field($_POST['sandboxaccount']);
			
			$options['cancelled_text'] = 	sanitize_text_field($_POST['cancelled_text']);
			$options['guest_text'] = 		sanitize_text_field($_POST['guest_text']);
			
			//$options['image_1'] = 		sanitize_text_field($_POST['image_1']);
			$options['cancel'] = 			sanitize_text_field($_POST['cancel']);
			$options['return'] = 			sanitize_text_field($_POST['return']);
			$options['log'] = 				sanitize_text_field($_POST['log']);
			$options['logging_id'] = 		sanitize_text_field($_POST['logging_id']);
			$options['uninstall'] = 		sanitize_text_field($_POST['uninstall']);
			
			update_option("wpeppsub_settingsoptions", $options);
			
			echo "<br /><div class='updated'><p><strong>"; _e("Settings Updated."); echo "</strong></p></div>";
		}
		
		
		if (isset($_GET['wpeppsub_clear_logs']) && $_GET['wpeppsub_clear_logs'] == "1") {
			
			check_admin_referer('clear_log');
			
			wpeppsub_clear_log();
			echo'<script>window.location="?page=wpeppsub_settings&hidden_tab_value=4"; </script>';
			exit;
		}
		if (isset($_GET['wpeppsub_reload_logs']) && $_GET['wpeppsub_reload_logs'] == "1") {
			
			check_admin_referer('reload');
			
			echo'<script>window.location="?page=wpeppsub_settings&hidden_tab_value=4"; </script>';
			exit;
		}
		
		
		$options = get_option('wpeppsub_settingsoptions');
		foreach ($options as $k => $v ) {
			
			$value[$k] =  wp_kses($v, array(
					'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			));	
			
		}
		
		$siteurl = get_site_url();
		
		// tabs menu
		?>
		
		<table width='100%'><tr><td width='75%' valign='top'><br />
	
		<table width="100%"><tr><td>
			<br />
			<span style="font-size:20pt;">Subscriptions & Memberships for PayPal Settings</span>
			</td><td valign="bottom">
			<?php echo wp_nonce_field('nonce_save','action_save'); ?>
			<input type="submit" name='btn2' class='button-primary' style='font-size: 14px;height: 30px;float: right;' value="Save Settings">
		</td></tr></table>
			
			<?php
			if (isset($saved)) {
				echo "<div class='updated'><p>Settings Updated.</p></div>";
			}
			?>
		
		<?php
		
		if (isset($_REQUEST['hidden_tab_value'])) {
			$active_tab =  $_REQUEST['hidden_tab_value'];
		} else {
			$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '1';
		}
		
		
		
		// media uploader
		function wpplugin_paypal_button_load_scripts() {
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
		}
		wpplugin_paypal_button_load_scripts();
		?>

		<script>
			jQuery(document).ready(function() {
				var formfield;
				jQuery('.upload_image_button').click(function() {
					jQuery('html').addClass('Image');
					formfield = jQuery(this).prev().attr('name');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					return false;
				});
				window.original_send_to_editor = window.send_to_editor;
				window.send_to_editor = function(html){
					if (formfield) {
						fileurl = jQuery('img',html).attr('src');
						jQuery('#'+formfield).val(fileurl);
						tb_remove();
						jQuery('html').removeClass('Image');
					} else {
						window.original_send_to_editor(html);
					}
				};
			});
		</script>
		
		<script type="text/javascript">
			function closetabs(ids) {
				var x = ids;
				y = x.split(",");
				
				for(var i = 0; i < y.length; i++) {
					//console.log(y[i]);
					document.getElementById(y[i]).style.display = 'none';
					document.getElementById("id"+y[i]).classList.remove('nav-tab-active');
				}
			}
			
			function newtab(id) {
				var x = id;
				document.getElementById(x).style.display = 'block';
				document.getElementById("id"+x).classList.add('nav-tab-active');
				document.getElementById('hidden_tab_value').value=x;
			}
		</script>
		
		<br />
		
		<?php
		//global $kstatus;
		//if (isset($kstatus) && $kstatus == "true") {
		?>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8");newtab("1");' href="#" id="id1" class="nav-tab <?php echo $active_tab == '1' ? 'nav-tab-active' : ''; ?>">Getting Started</a>
			<!--
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8,9");newtab("9");' href="#" id="id9" class="nav-tab <?php echo $active_tab == '9' ? 'nav-tab-active' : ''; ?>">License</a>
			-->
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8");newtab("3");' href="#" id="id3" class="nav-tab <?php echo $active_tab == '3' ? 'nav-tab-active' : ''; ?>">PayPal</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8");newtab("8");' href="#" id="id8" class="nav-tab <?php echo $active_tab == '8' ? 'nav-tab-active' : ''; ?>">Buttons</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8");newtab("2");' href="#" id="id2" class="nav-tab <?php echo $active_tab == '2' ? 'nav-tab-active' : ''; ?>">Language & Currency</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8");newtab("5");' href="#" id="id5" class="nav-tab <?php echo $active_tab == '5' ? 'nav-tab-active' : ''; ?>">Subscriptions</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8");newtab("4");' href="#" id="id4" class="nav-tab <?php echo $active_tab == '4' ? 'nav-tab-active' : ''; ?>">Advanced</a>
		<?php //} else { ?>
			
			<!--
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,5,8,9");newtab("9");' href="#" id="id9" class="nav-tab <?php echo $active_tab == '9' ? 'nav-tab-active' : ''; ?>">License Key</a>
			-->
			
			<?php
			
			//$active_tab = "9";
			
			//} ?>
			
		
		<br /><br /><br />
		
		<div id="1" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '1' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Getting Started
			</div>
			<div style="background-color:#fff;padding:8px;">
				
				<br />
				This plugin will allow you to sell subscriptions and or Memberships on your website via PayPal.
				<br /><br />
				<b>Here is a quick start guide on how to use this plugin: </b><br />
				1. In this settings page go to the <a href="?page=wpeppsub_settings&tab=3">PayPal tab</a> and enter your PayPal information. After you are done, save your changes by clicking on "Save Settings".<br />
				2. In the Admin menu, naviate to the <a href="?page=wpeppsub_buttons">Buttons page</a>. Click on "New Button". <br />
				3. Fill out the button page, and click "Save Button". You will be directed to main Button page where you can see the button you just created along with its shortcode.<br />
				4. In the Admin menu, nagivate to your <a href="edit.php?post_type=page">Pages</a> page. Make a new page or click to open an existing page.<br />
				5. You should see a new button in the menu beside the "Add Media" button called "PayPal Subscription Button". Click on that.<br />
				6. Find the button you just created in the dropdown menu and click on"Insert Button".<br />
				7. Save or Update the page and click the "View Page" link to view the page live on your site.
				You should now see a button showing on that page.
				<br /><br />
				<b>Purchasing from the customer's perspective: </b><br />
				The customer will click on the button and be redirected to PayPal. They will log into their PayPal account or create a new PayPal account. Then they will complete the transaction.
				<br /><br />
				<b>Cancelling Subscriptions: </b><br />
				Both the customer and you can choose to cancel and subscription at any time. To do this as as a store owner, go to your PayPal account and go to the "Profile and Settings" page. Then choose "My Selling Tools". Find "My automatic payments" and click 
				on the button titled "Update". Find a customer and click on the "Cancel" link.
				<br /><br />
				From the customer's perspective, cancelling is very similar. On the "Profile and Settings" page they will choose "My money", then find on "My preapproved payments" and click on the "Update" link. They will find the name of your business and click "Cancel" in the details profile.
				
				
				
				<br /><br /><br />
				
				<span style="color:#777;float:right;"><i>WP Plugin is an offical PayPal Partner. Various trademarks held by their respective owners.</i></span>
				
				<br />
				
			</div>
		</div>
		
		
		<div id="2" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '2' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Language & Currency Settings
			</div>
			<div style="background-color:#fff;padding:8px;">
			
				<table><tr><td colspan="2">
				<h3>Language Settings</h3></td></tr><tr><td>
				
				<b>Language:</b> </td><td>
				<select name="language" style="width: 280px">
				<option <?php if ($value['language'] == "1") { echo "SELECTED"; } ?> value="1">Danish</option>
				<option <?php if ($value['language'] == "2") { echo "SELECTED"; } ?> value="2">Dutch</option>
				<option <?php if ($value['language'] == "3") { echo "SELECTED"; } ?> value="3">English</option>
				<option <?php if ($value['language'] == "20") { echo "SELECTED"; } ?> value="20">English - UK</option>
				<option <?php if ($value['language'] == "4") { echo "SELECTED"; } ?> value="4">French</option>
				<option <?php if ($value['language'] == "5") { echo "SELECTED"; } ?> value="5">German</option>
				<option <?php if ($value['language'] == "6") { echo "SELECTED"; } ?> value="6">Hebrew</option>
				<option <?php if ($value['language'] == "7") { echo "SELECTED"; } ?> value="7">Italian</option>
				<option <?php if ($value['language'] == "8") { echo "SELECTED"; } ?> value="8">Japanese</option>
				<option <?php if ($value['language'] == "9") { echo "SELECTED"; } ?> value="9">Norwgian</option>
				<option <?php if ($value['language'] == "10") { echo "SELECTED"; } ?> value="10">Polish</option>
				<option <?php if ($value['language'] == "11") { echo "SELECTED"; } ?> value="11">Portuguese</option>
				<option <?php if ($value['language'] == "12") { echo "SELECTED"; } ?> value="12">Russian</option>
				<option <?php if ($value['language'] == "13") { echo "SELECTED"; } ?> value="13">Spanish</option>
				<option <?php if ($value['language'] == "14") { echo "SELECTED"; } ?> value="14">Swedish</option>
				<option <?php if ($value['language'] == "15") { echo "SELECTED"; } ?> value="15">Simplified Chinese -China only</option>
				<option <?php if ($value['language'] == "16") { echo "SELECTED"; } ?> value="16">Traditional Chinese - Hong Kong only</option>
				<option <?php if ($value['language'] == "17") { echo "SELECTED"; } ?> value="17">Traditional Chinese - Taiwan only</option>
				<option <?php if ($value['language'] == "18") { echo "SELECTED"; } ?> value="18">Turkish</option>
				<option <?php if ($value['language'] == "19") { echo "SELECTED"; } ?> value="19">Thai</option>
				</select></td><td>
				
				PayPal currently supports 18 languages.</td></tr><tr><td colspan="2">
				
				<br />
				<h3>Currency Settings</h3></td></tr><tr><td>
				
				<b>Currency:</b> </td><td>
				<select name="currency" style="width: 280px">
				<option <?php if ($value['currency'] == "1") { echo "SELECTED"; } ?> value="1">Australian Dollar - AUD</option>
				<option <?php if ($value['currency'] == "2") { echo "SELECTED"; } ?> value="2">Brazilian Real - BRL</option>
				<option <?php if ($value['currency'] == "3") { echo "SELECTED"; } ?> value="3">Canadian Dollar - CAD</option>
				<option <?php if ($value['currency'] == "4") { echo "SELECTED"; } ?> value="4">Czech Koruna - CZK</option>
				<option <?php if ($value['currency'] == "5") { echo "SELECTED"; } ?> value="5">Danish Krone - DKK</option>
				<option <?php if ($value['currency'] == "6") { echo "SELECTED"; } ?> value="6">Euro - EUR</option>
				<option <?php if ($value['currency'] == "7") { echo "SELECTED"; } ?> value="7">Hong Kong Dollar - HKD</option> 	 
				<option <?php if ($value['currency'] == "8") { echo "SELECTED"; } ?> value="8">Hungarian Forint - HUF</option>
				<option <?php if ($value['currency'] == "9") { echo "SELECTED"; } ?> value="9">Israeli New Sheqel - ILS</option>
				<option <?php if ($value['currency'] == "10") { echo "SELECTED"; } ?> value="10">Japanese Yen - JPY</option>
				<option <?php if ($value['currency'] == "11") { echo "SELECTED"; } ?> value="11">Malaysian Ringgit - MYR</option>
				<option <?php if ($value['currency'] == "12") { echo "SELECTED"; } ?> value="12">Mexican Peso - MXN</option>
				<option <?php if ($value['currency'] == "13") { echo "SELECTED"; } ?> value="13">Norwegian Krone - NOK</option>
				<option <?php if ($value['currency'] == "14") { echo "SELECTED"; } ?> value="14">New Zealand Dollar - NZD</option>
				<option <?php if ($value['currency'] == "15") { echo "SELECTED"; } ?> value="15">Philippine Peso - PHP</option>
				<option <?php if ($value['currency'] == "16") { echo "SELECTED"; } ?> value="16">Polish Zloty - PLN</option>
				<option <?php if ($value['currency'] == "17") { echo "SELECTED"; } ?> value="17">Pound Sterling - GBP</option>
				<option <?php if ($value['currency'] == "18") { echo "SELECTED"; } ?> value="18">Russian Ruble - RUB</option>
				<option <?php if ($value['currency'] == "19") { echo "SELECTED"; } ?> value="19">Singapore Dollar - SGD</option>
				<option <?php if ($value['currency'] == "20") { echo "SELECTED"; } ?> value="20">Swedish Krona - SEK</option>
				<option <?php if ($value['currency'] == "21") { echo "SELECTED"; } ?> value="21">Swiss Franc - CHF</option>
				<option <?php if ($value['currency'] == "22") { echo "SELECTED"; } ?> value="22">Taiwan New Dollar - TWD</option>
				<option <?php if ($value['currency'] == "23") { echo "SELECTED"; } ?> value="23">Thai Baht - THB</option>
				<option <?php if ($value['currency'] == "24") { echo "SELECTED"; } ?> value="24">Turkish Lira - TRY</option>
				<option <?php if ($value['currency'] == "25") { echo "SELECTED"; } ?> value="25">U.S. Dollar - USD</option>
				</select></td><td>
				
				PayPal currently supports 25 currencies.
				
				</td></tr></table>
				
				<br /><br />
			</div>
		</div>
			
			
		<div id="3" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '3' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; PayPal Settings </div>
			<div style="background-color:#fff;padding:8px;">
			
			
			<table><tr><td colspan="2">
				<h3>PayPal Accounts</h3></td></tr><tr><td>
				
				<b>Live Account:</b> </td><td><input type='text' name='liveaccount' value='<?php echo $value['liveaccount']; ?>'> Required </td></tr><tr><td>
				</td><td colspan="2">
				<br />Enter a valid Merchant account ID (strongly recommend) or PayPal account email address. All payments will go to this account.
				<br /><br />You can find your Merchant account ID in your PayPal account under Profile -> My business info -> Merchant account ID
				
				<br /><br />If you don't have a PayPal account, you can sign up for free at <a target='_blank' href='https://paypal.com'>PayPal</a>. <br /><br />
				
				</td></tr><tr><td>
				
				<b>Sandbox Account:</b> </td><td><input type='text' name='sandboxaccount' value='<?php echo $value['sandboxaccount']; ?>'> Optional</td></tr><tr><td>
				</td><td colspan="2">
				<br />Enter a valid sandbox PayPal account email address. A Sandbox account is a PayPal accont with fake money used for testing. <br />This is useful to make sure your PayPal account and settings are working properly being going live.
				<br /><br />To create a Sandbox account, you first need a Developer Account. You can sign up for free at the <a target='_blank' href='https://developer.paypal.com/'>PayPal Developer</a> site. <br /><br />
				
				Once you have made an account, create a Sandbox Business and Personal Account <a target='_blank' href='https://developer.paypal.com/developer/accounts/'>here</a>.<br /><br /> Enter the Business account email on this page and use the Personal account username and password to buy something on your site as a customer.
				<br />
				
				</td></tr><tr><td colspan="2">
				
				<br />
				
				<h3>PayPal Options</h3></td></tr><tr><td>
				
				<b>Sandbox Mode:</b> </td><td colspan="2">
				&nbsp; &nbsp; <input <?php if ($value['mode'] == "1") { echo "checked='checked'"; } ?> type='radio' name='mode' value='1'>On (Sandbox mode)
				&nbsp; &nbsp;  &nbsp;<input <?php if ($value['mode'] == "2") { echo "checked='checked'"; } ?> type='radio' name='mode' value='2'>Off (Live mode)
				
				</td></tr><tr><td>				
				
				<b>Statements Name:</b> </td><td>
				&nbsp; &nbsp; <a target="_blank" href="https://www.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-pref&rc2_eligible=yes&#ccName">Set name that shows on buyer credit card statements<a>
				
				</td></tr></table>
				
				<br /><br />
			</div>
		</div>
		
		
		
		<div id="8" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '8' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
			&nbsp; Button Settings
			</div>
			<div style="background-color:#fff;padding:8px;">
			
				<table><tr><td colspan="2">
				<h3>Button Settings</h3></td></tr><tr><td colspan="2">
				
				<b>Default Button Size and style:</b>
				</td></tr><tr><td valign="top">
				<input <?php if ($value['size'] == "1") { echo "checked='checked'"; } ?> type='radio' name='size' value='1'>Small Buy Now <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "2") { echo "checked='checked'"; } ?> type='radio' name='size' value='2'>Big Buy Now<br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "3") { echo "checked='checked'"; } ?> type='radio' name='size' value='3'>Big Buy Now with Credit Cards <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "7") { echo "checked='checked'"; } ?> type='radio' name='size' value='7'>Gold Buy Now (English only)<br /><img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png'>
				
				</td></tr><tr><td valign="top">
				<input <?php if ($value['size'] == "4") { echo "checked='checked'"; } ?> type='radio' name='size' value='4'>Small Pay Now <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "5") { echo "checked='checked'"; } ?> type='radio' name='size' value='5'>Big Pay Now <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "6") { echo "checked='checked'"; } ?> type='radio' name='size' value='6'>Big Pay Now with Credit Cards <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif'></td><td valign='top' style='text-align: center;'>
				
				<input <?php if ($value['size'] == "12") { echo "checked='checked'"; } ?> type='radio' name='size' value='12'>Gold Check Out (English only)<br /><img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png'>
				
				<!--
				<input <?php //if ($value['size'] == "8") { echo "checked='checked'"; } ?> type='radio' name='size' value='8'>Custom <br />
				<input type="text" id="image_1" name="image_1" size="14" value="<?php //echo $value['image_1']; ?>">
				<input id="_btn" class="upload_image_button" type="button" value="Upload Image"></td></tr>
				-->
				
				</td></tr><tr><td valign="top">
				<input <?php if ($value['size'] == "9") { echo "checked='checked'"; } ?> type='radio' name='size' value='9'>Small Subscribe <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_SM.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "10") { echo "checked='checked'"; } ?> type='radio' name='size' value='10'>Big Subscribe <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php if ($value['size'] == "11") { echo "checked='checked'"; } ?> type='radio' name='size' value='11'>Big Subscribe with Credit Cards <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif'></td><td valign='top' style='text-align: center;'>
				
				
				<tr><td colspan="4">
				(Buttons will automatically change to your language of choice when displayed on site.)</td>
				</tr></table>
				
				<br />
				
				<table><tr><td valign="top">
				
				<b>Button opens in:</b></td><td valign="top">
				<input <?php if ($value['opens'] == "1") { echo "checked='checked'"; } ?>  type='radio' name='opens' value='1'>Same window
				<input <?php if ($value['opens'] == "2") { echo "checked='checked'"; } ?> type='radio' name='opens' value='2'>New window
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Prompt buyers for a shipping address:</b></td><td valign="top">
				<input <?php if ($value['no_shipping'] == "0") { echo "checked='checked'"; } ?> type='radio' name='no_shipping' value='0'>Yes
				<input <?php if ($value['no_shipping'] == "1") { echo "checked='checked'"; } ?> type='radio' name='no_shipping' value='1'>No
				<input <?php if ($value['no_shipping'] == "2") { echo "checked='checked'"; } ?> type='radio' name='no_shipping' value='2'>Yes, and require
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Default Cancel URL: </b></td><td valign="top">
				<input type='text' name='cancel' value='<?php echo $value['cancel']; ?>'> Optional </td></tr><tr><td colspan="2">
				If the customer goes to PayPal and clicks the cancel button, where do they go. <br />Example: <?php echo $siteurl; ?>/cancel. Max length: 1,024.
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Default Return URL: </b></td><td valign="top">
				<input type='text' name='return' value='<?php echo $value['return']; ?>'> Optional </td></tr><tr><td colspan="2">
				If the customer goes to PayPal and successfully pays, where are they redirected to after. <br />Example: <?php echo $siteurl; ?>/thankyou. Max length: 1,024.
				
				</td></tr></table>
				
				<br />
			</div>
		</div>
		
		
		
		
		
		<div id="4" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '4' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Advanced
			</div>
			<div style="background-color:#fff;padding:8px;">
				
				<h3>Logs</h3>
				<table><tr><td valign="top">
				Enable Logging: </td><td>
				
				<input <?php if ($value['log'] == "1") { echo "checked='checked'"; } ?>  type='radio' name='log' value='1'>On
				<input <?php if ($value['log'] == "2") { echo "checked='checked'"; } ?> type='radio' name='log' value='2'>Off
				
				<input type='hidden' name='logging_id' value='<?php echo $value['logging_id']; ?>'>
				
				</td></tr><tr><td valign="top">
				
				<?php				
				$post_data = get_post($value['logging_id']);
				$textarea = $post_data->post_content;
				?>
				
				<br />Logs: </td><td><br /><textarea cols='80' rows='20' name='logs' readonly><?php echo $textarea; ?></textarea>
				
				<br />
				
				
				<?php
				$clear_bare = '?page=wpeppsub_settings&wpeppsub_clear_logs=1';
				$clear_url = wp_nonce_url($clear_bare, 'clear_log');
				
				$reload_bare = '?page=wpeppsub_settings&wpeppsub_reload_logs=1';
				$reload_url = wp_nonce_url($reload_bare, 'reload');
				?>
				
				
				<a href='<?php echo $clear_url; ?>'>Clear Logs</a> &nbsp; &nbsp; &nbsp;  
				<a href='<?php echo $reload_url; ?>'>Reload</a> &nbsp; &nbsp; &nbsp;  
				Logging should be turned off until you are actively debugging a problem.
				
				</td></tr></table>
				
				<h3>Plugin Data</h3>
				<table><tr><td valign="top">
				Remove all plugin data on uninstall: </td><td>
				
				<input <?php if ($value['uninstall'] == "1") { echo "checked='checked'"; } ?>  type='radio' name='uninstall' value='1'>Yes
				<input <?php if ($value['uninstall'] == "2") { echo "checked='checked'"; } ?> type='radio' name='uninstall' value='2'>No
				
				</td><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Note: If you plan on installing the Pro version of this plugin then keep this set to "No".
				
				</td></tr></table>
				
			</div>
		</div>
		
		
		
		
		
		
		<div id="5" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '5' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Subscriptions
			</div>
			<div style="background-color:#fff;padding:8px;">
				
				<h3>Subscription Settings</h3>
				<table><tr><td valign="top">
				
				
				Account creation: </td><td>
				<input <?php if ($value['subscriber'] == "1") { echo "checked='checked'"; } ?>  type='radio' name='subscriber' value='1'>Yes
				<input <?php if ($value['subscriber'] == "2") { echo "checked='checked'"; } ?> type='radio' name='subscriber' value='2'>No
				</td><td> A setting of 'Yes' will automatically create a WordPress user account for subscribers.
				
				</td></tr><tr><td>
				
				Content visibility: </td><td>
				<input <?php if ($value['content'] == "1") { echo "checked='checked'"; } ?>  type='radio' name='content' value='1'>Yes
				<input <?php if ($value['content'] == "2") { echo "checked='checked'"; } ?> type='radio' name='content' value='2'>No
				</td><td> A setting of 'Yes' will allow Admin, Editor, Author and Contributor roles to see content even without an active subscription.
				
				</td></tr><tr><td>
				
				Admin bar: </td><td>
				<input <?php if ($value['hideadmin'] == "1") { echo "checked='checked'"; } ?>  type='radio' name='hideadmin' value='1'>Yes
				<input <?php if ($value['hideadmin'] == "2") { echo "checked='checked'"; } ?> type='radio' name='hideadmin' value='2'>No
				</td><td> A setting of 'Yes' will hide the admin bar if the subscriber is logged in. Note: This will hide the bar only for subscribers, not admins.
				
				</td></tr><tr><td>
				
				Not logged in text: </td><td>
				<input type='text' name='guest_text' value='<?php echo $value['guest_text']; ?>'>
				</td><td> Text to display for guests who are not signed in.
				
				</td></tr><tr><td>
				
				Expired / Cancelled text: </td><td>
				<input type='text' name='cancelled_text' value='<?php echo $value['cancelled_text']; ?>'>
				</td><td> Text to display for users that have an expired or cancelled subscription.
				
				</td></tr></table>
				
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		<input type='hidden' name='update'>
		<input type='hidden' name='hidden_tab_value' id="hidden_tab_value" value="<?php echo $active_tab; ?>">
		
	</form>
	
	
	
	
	
	</td><td width='3%'>
	</td><td width='22%' valign='top'>

	<br /><br />

	<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border: 1px solid #CCCCCC;">
	&nbsp; Like this Free Plugin?
	</div>

	<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;border-top: 1px solid #fff;"><br />

	<center><label style="font-size:14pt;">With the Pro version you'll <br /> be able to: </label></center>
	
	<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Have custom subscription levels<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Admin & customer email notifications<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Offer a second trial period<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Free membership registration<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Free membership level<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Add a price dropdown menu above button<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Add a text dropdown menu above button<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Add up to 2 input boxes above button<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Each button can have a seperate PayPal account<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Limit content by shortcode <br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Return URL per button <br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Button Widget <br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Custom button image<br />
	<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Further plugin development <br />
	<br />

	<center><a target='_blank' href="https://wpplugin.org/downloads/subscriptions-memberships/" class='button-primary' style='font-size: 17px;line-height: 28px;height: 32px;'>Learn More</a></center>
	<br />

	</div>

	<br /><br />

	<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border: 1px solid #CCCCCC;">
	&nbsp; Quick Links
	</div>

	<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;border-top: 1px solid #fff;"><br />

	<div class="dashicons dashicons-arrow-right" style="margin-bottom: 6px;"></div> <a target="_blank" href="https://wordpress.org/support/plugin/subscriptions-memberships-for-paypal">Support Forum</a> <br />

	<div class="dashicons dashicons-arrow-right" style="margin-bottom: 6px;"></div> <a target="_blank" href="https://wpplugin.org/documentation">FAQ</a> <br />

	</div>



	</td><td width='1%'>

	</td></tr></table>
	
	
	
	
	
	
	
	
	<?php
	
}

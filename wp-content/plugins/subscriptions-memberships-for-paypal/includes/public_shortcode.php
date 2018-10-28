<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpeppsub_options($atts) {

	// get shortcode id
		$atts = shortcode_atts(array(
			'id' 		=> '',
			'align' 	=> '',
			'widget' 	=> ''
		), $atts);
			
		$post_id = $atts['id'];
		
	// check to see if post exists
	$check_post = get_post($post_id);
	
	if (empty($check_post)) {
		return;
	}

	// get settings page values
	$options = get_option('wpeppsub_settingsoptions');
	foreach ($options as $k => $v ) { $value[$k] = esc_attr($v); }
	
	
	$wpeppsub_button_name = esc_attr(get_post_meta($post_id,'wpeppsub_button_name',true));
	$wpeppsub_button_sku = esc_attr(get_post_meta($post_id,'wpeppsub_button_sku',true));

	// live of test mode
	if ($value['mode'] == "1") {
		$account = $value['sandboxaccount'];
		$path = "sandbox.paypal";
	} elseif ($value['mode'] == "2")  {
		$account = $value['liveaccount'];
		$path = "paypal";
	}
	
	if (empty($account)) {
		echo "Administrator: Please enter your PayPal Email or Merchant ID on the subscription plugins settings page.";
		return;
	}
	
	// account
	$account_a = esc_attr(get_post_meta($post_id,'wpeppsub_button_account',true));
	if (!empty($account_a)) { $account = $account_a; }

	// currency
	$currency_a = esc_attr(get_post_meta($post_id,'wpeppsub_button_currency',true));
	if (!empty($currency_a)) { $value['currency'] = $currency_a; }
		
	if ($value['currency'] == "1") { $currency = "AUD"; }
	if ($value['currency'] == "2") { $currency = "BRL"; }
	if ($value['currency'] == "3") { $currency = "CAD"; }
	if ($value['currency'] == "4") { $currency = "CZK"; }
	if ($value['currency'] == "5") { $currency = "DKK"; }
	if ($value['currency'] == "6") { $currency = "EUR"; }
	if ($value['currency'] == "7") { $currency = "HKD"; }
	if ($value['currency'] == "8") { $currency = "HUF"; }
	if ($value['currency'] == "9") { $currency = "ILS"; }
	if ($value['currency'] == "10") { $currency = "JPY"; }
	if ($value['currency'] == "11") { $currency = "MYR"; }
	if ($value['currency'] == "12") { $currency = "MXN"; }
	if ($value['currency'] == "13") { $currency = "NOK"; }
	if ($value['currency'] == "14") { $currency = "NZD"; }
	if ($value['currency'] == "15") { $currency = "PHP"; }
	if ($value['currency'] == "16") { $currency = "PLN"; }
	if ($value['currency'] == "17") { $currency = "GBP"; }
	if ($value['currency'] == "18") { $currency = "RUB"; }
	if ($value['currency'] == "19") { $currency = "SGD"; }
	if ($value['currency'] == "20") { $currency = "SEK"; }
	if ($value['currency'] == "21") { $currency = "CHF"; }
	if ($value['currency'] == "22") { $currency = "TWD"; }
	if ($value['currency'] == "23") { $currency = "THB"; }
	if ($value['currency'] == "24") { $currency = "TRY"; }
	if ($value['currency'] == "25") { $currency = "USD"; }
	
	
	// language
	$language_a = esc_attr(get_post_meta($post_id,'wpeppsub_button_language',true));
	if (!empty($language_a)) { $value['language'] = $language_a; }

	if ($value['language'] == "1") {
		$language = "da_DK";
		$image_1 = "https://www.paypalobjects.com/da_DK/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/da_DK/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/da_DK/DK/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/da_DK/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/da_DK/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/da_DK/DK/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/da_DK/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/da_DK/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/da_DK/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Danish
	
	if ($value['language'] == "2") {
	$language = "nl_BE";
		$image_1 = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/nl_NL/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/nl_NL/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/nl_NL/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Dutch
	
	if ($value['language'] == "3") {
	$language = "EN_US";
		$image_1 = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //English
	
	if ($value['language'] == "20") {
	$language = "en_GB";
		$image_1 = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //English - UK
	
	if ($value['language'] == "4") {
		$language = "fr_CA";
		$image_1 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/fr_CA/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //French
	
	if ($value['language'] == "5") {
		$language = "de_DE";
		$image_1 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //German
	
	if ($value['language'] == "6") {
		$language = "he_IL";
		$image_1 = "https://www.paypalobjects.com/he_IL/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/he_IL/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/he_IL/IL/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/he_IL/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/he_IL/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/he_IL/IL/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/he_IL/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/he_IL/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/he_IL/IL/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Hebrew
	
	if ($value['language'] == "7") {
		$language = "it_IT";
		$image_1 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Italian
	
	if ($value['language'] == "8") {
		$language = "ja_JP";
		$image_1 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Japanese
	
	if ($value['language'] == "9") {
		$language = "no_NO";
		$image_1 = "https://www.paypalobjects.com/no_NO/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/no_NO/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/no_NO/NO/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/no_NO/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/no_NO/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/no_NO/NO/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/no_NO/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/no_NO/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/no_NO/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Norwgian
	
	if ($value['language'] == "10") {
		$language = "pl_PL";
		$image_1 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Polish

	if ($value['language'] == "11") {
		$language = "pt_BR";
		$image_1 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Portuguese

	if ($value['language'] == "12") {
		$language = "ru_RU";
		$image_1 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/ru_RU/RU/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/ru_RU/RU/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/ru_RU/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Russian
	
	if ($value['language'] == "13") {
		$language = "es_ES";
		$image_1 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Spanish
	
	if ($value['language'] == "14") {
		$language = "sv_SE";
		$image_1 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/sv_SE/SE/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/sv_SE/SE/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/sv_SE/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Swedish
	
	if ($value['language'] == "15") {
		$language = "zh_CN";
		$image_1 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/zh_XC/C2/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/zh_XC/C2/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/zh_XC/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Simplified Chinese - China
	
	if ($value['language'] == "16") {
		$language = "zh_HK";
		$image_1 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/zh_HK/HK/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/zh_HK/HK/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/zh_HK/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Traditional Chinese - Hong Kong
	
	if ($value['language'] == "17") {
		$language = "zh_TW";
		$image_1 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Traditional Chinese - Taiwan
	
	if ($value['language'] == "18") {
		$language = "tr_TR";
		$image_1 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/tr_TR/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Turkish
	
	if ($value['language'] == "19") {
		$language = "th_TH";
		$image_1 = "https://www.paypalobjects.com/th_TH/i/btn/btn_buynow_SM.gif";
		$image_2 = "https://www.paypalobjects.com/th_TH/i/btn/btn_buynow_LG.gif";
		$image_3 = "https://www.paypalobjects.com/th_TH/TH/i/btn/btn_buynowCC_LG.gif";
		$image_4 = "https://www.paypalobjects.com/th_TH/i/btn/btn_paynow_SM.gif";
		$image_5 = "https://www.paypalobjects.com/th_TH/i/btn/btn_paynow_LG.gif";
		$image_6 = "https://www.paypalobjects.com/th_TH/TH/i/btn/btn_paynowCC_LG.gif";
		$image_7 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
		$image_9 = "https://www.paypalobjects.com/th_TH/i/btn/btn_subscribe_SM.gif";
		$image_10 = "https://www.paypalobjects.com/th_TH/i/btn/btn_subscribe_LG.gif";
		$image_11 = "https://www.paypalobjects.com/th_TH/i/btn/btn_subscribeCC_LG.gif";
		$image_12 = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png";
	} //Thai


	// custom button size
	$wpeppsub_button_buttonsize = esc_attr(get_post_meta($post_id,'wpeppsub_button_buttonsize',true));
	
	if ($wpeppsub_button_buttonsize != "0") {
		$value['size'] = $wpeppsub_button_buttonsize;
	}
	
	// button size	
	$img = ${"image_" . $value['size']};
	
	// return url
	$return = "";
	$return = $value['return'];
	$return_a = esc_attr(get_post_meta($post_id,'wpeppsub_button_return',true));
	if (!empty($return_a)) { $return = $return_a; }
	
	// show name / title
	$wpeppsub_button_show = esc_attr(get_post_meta($post_id,'wpeppsub_button_show',true));

	// window action
	if ($value['opens'] == "1") { $target = ""; }
	if ($value['opens'] == "2") { $target = "_blank"; }

	// alignment
	if ($atts['align'] == "left") { $alignment = "style='float: left;'"; }
	if ($atts['align'] == "right") { $alignment = "style='float: right;'"; }
	if ($atts['align'] == "center") { $alignment = "style='margin-left: auto;margin-right: auto;width:220px'"; }
	if (empty($atts['align'])) { $alignment = ""; }
	
	
	// spacing above buy button
	$spacing = "0";
	
	
	
	if ($atts['widget'] == "true") {
		$alignment = "style='margin-left: auto;margin-right: auto;width:220px'";
	}
	
	
	
	
	$output = "";
	$output .= "<div class='wpeppsub_wrapper' $alignment>";
	
	if ($wpeppsub_button_show == "1") {
		$output .= "$wpeppsub_button_name";
	}




	$output .= "<form target='$target' action='https://www.$path.com/cgi-bin/webscr' method='post'>";
	$output .= "<input type='hidden' name='cmd' value='_xclick-subscriptions'>";
	$output .= "<input type='hidden' name='business' value='$account'>";
	$output .= "<input type='hidden' name='lc' value='$language'>";
	$output .= "<input type='hidden' name='currency_code' value='$currency'>";
	$output .= "<input type='hidden' name='no_shipping' value='". $value['no_shipping'] ."' />";
	$output .= "<input type='hidden' name='no_note' value='1' />";
	$output .= "<input type='hidden' name='custom' value='$post_id' />"; // post_id,
	$output .= "<input type='hidden' name='return' value='". $value['return'] ."' />";
	$output .= "<input type='hidden' name='bn' value='WPPlugin_SP'>";
	$output .= "<input type='hidden' name='cancel_return' value='". $value['cancel'] ."' />";
	$output .= "<input type='hidden' name='item_name' value='$wpeppsub_button_name'>";
	$output .= "<input type='hidden' name='item_number' value='$wpeppsub_button_sku' />";
	
	
	
	// notify url
	//$notify_url = get_admin_url() . "admin-post.php?action=add_wpeppsub_button_ipn";
	$notify_url = add_query_arg( 'wpeppsub-listener', 'IPN', home_url( 'index.php' ) );
	$output .= "<input type='hidden' name='notify_url' value='$notify_url'>";
	//$output .= "<input type='hidden' name='notify' value='$notify_url'>";
	
	
	
	// trial 1
	$wpeppsub_trial_1 = get_post_meta($post_id, "wpeppsub_trial_1", true);
	if ($wpeppsub_trial_1 == "1") {
		$wpeppsub_a1 = esc_attr(get_post_meta($post_id,'wpeppsub_a1',true));
		$wpeppsub_p1 = esc_attr(get_post_meta($post_id,'wpeppsub_p1',true));
		$wpeppsub_t1 = esc_attr(get_post_meta($post_id,'wpeppsub_t1',true));
		
		$output .= "<input type='hidden' name='a1' value='$wpeppsub_a1'>";
		$output .= "<input type='hidden' name='p1' value='$wpeppsub_p1'>";
		$output .= "<input type='hidden' name='t1' value='$wpeppsub_t1'>";
	}
	
	// amount
	$wpeppsub_a3 = esc_attr(get_post_meta($post_id,'wpeppsub_a3',true));
	$wpeppsub_p3 = esc_attr(get_post_meta($post_id,'wpeppsub_p3',true));
	$wpeppsub_t3 = esc_attr(get_post_meta($post_id,'wpeppsub_t3',true));
		
	$output .= "<input type='hidden' name='a3' value='$wpeppsub_a3'>";
	$output .= "<input type='hidden' name='p3' value='$wpeppsub_p3'>";
	$output .= "<input type='hidden' name='t3' value='$wpeppsub_t3'>";
	
	$wpeppsub_srt = esc_attr(get_post_meta($post_id,'wpeppsub_srt',true));
	
	if ($wpeppsub_srt != "0" && $wpeppsub_srt != "1") {
		$output .= "<input type='hidden' name='src' value='1'>";
		$output .= "<input type='hidden' name='srt' value='$wpeppsub_srt'>";
	}
	
	if ($wpeppsub_srt == "0") {
		$output .= "<input type='hidden' name='src' value='1'>";
	}
	
	
	if ($spacing == "1") {
		$output .= "<br />";
	}
	
	$output .= "<input class='wpeppsub_paypalbuttonimage' type='image' src='$img' border='0' name='submit' alt='Make your payments with PayPal. It is free, secure, effective.' style='border: none;'>";
	$output .= "<img alt='' border='0' style='border:none;display:none;' src='https://www.paypal.com/$language/i/scr/pixel.gif' width='1' height='1'>";
	$output .= "</form>";
	$output .= "</div>";

	return $output;
	
}

// shortcode for button
add_shortcode('wpeppsub', 'wpeppsub_options');

















// login shortcode
function wpeppsub_login() {
	if (!is_user_logged_in()) {
		$args = array(
			'echo'           => true,
			'remember'       => true,
			'form_id'        => 'loginform',
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'label_username' => __( 'Email: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;' ),
			'label_password' => __( 'Password: ' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in'   => __( 'Log In' ),
			'value_username' => '',
			'value_remember' => false
		);
		wp_login_form( $args );
	}
}

add_shortcode('wpeppsub_login', 'wpeppsub_login');




// logout shortcode
function wpeppsub_logout() {
	if (is_user_logged_in()) {
		echo '<a href="'; echo wp_logout_url( home_url() ); echo'">Logout</a>';
	}
}

add_shortcode('wpeppsub_logout', 'wpeppsub_logout');
<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2020 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      adrotate_ad
 Purpose:   Show requested ad
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_ad($banner_id, $opt = null) {
	global $wpdb, $adrotate_config;

	$output = '';

	if($banner_id) {			
		$options = wp_parse_args($opt, array());

		$banner = $wpdb->get_row($wpdb->prepare("SELECT `id`, `title`, `bannercode`, `tracker`, `image` FROM `{$wpdb->prefix}adrotate` WHERE `id` = %d AND (`type` = 'active' OR `type` = '2days' OR `type` = '7days');", $banner_id));

		if($banner) {
			$selected = array($banner->id => 0);			
			$selected = adrotate_filter_schedule($selected, $banner);
		} else {
			$selected = false;
		}
		
		if($selected) {
			$image = str_replace('%folder%', $adrotate_config['banner_folder'], $banner->image);

			$output .= '<div class="a-single a-'.$banner->id.'">';
			$output .= adrotate_ad_output($banner->id, 0, $banner->title, $banner->bannercode, $banner->tracker, $image);
			$output .= '</div>';

			if($adrotate_config['stats'] == 1 AND $banner->tracker == "Y") {
				adrotate_count_impression($banner->id, 0, 0);
			}
		} else {
			$output .= adrotate_error('ad_expired', array($banner_id));
		}
		unset($banner);
	} else {
		$output .= adrotate_error('ad_no_id');
	}

	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_group
 Purpose:   Fetch ads in specified group(s) and show a random ad
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_group($group_ids, $opt = null) { 
	global $wpdb, $adrotate_config;

	$output = $group_select = '';
	if($group_ids) {
		$options = wp_parse_args($opt, array());

		$now = current_time('timestamp');

		$group_array = (preg_match('/,/is', $group_ids)) ? explode(",", $group_ids) : array($group_ids);
		$group_array = array_filter($group_array);

		foreach($group_array as $key => $value) {
			$group_select .= " `{$wpdb->prefix}adrotate_linkmeta`.`group` = ".$wpdb->prepare('%d', $value)." OR";
		}
		$group_select = rtrim($group_select, " OR");

		$group = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '' AND `id` = %d;", $group_array[0]));

		if($group) {
			// Get all ads in all selected groups
			$ads = $wpdb->get_results(
				"SELECT 
					`{$wpdb->prefix}adrotate`.`id`, 
					`{$wpdb->prefix}adrotate`.`title`, 
					`{$wpdb->prefix}adrotate`.`bannercode`, 
					`{$wpdb->prefix}adrotate`.`image`, 
					`{$wpdb->prefix}adrotate`.`tracker`, 
					`{$wpdb->prefix}adrotate_linkmeta`.`group`
				FROM 
					`{$wpdb->prefix}adrotate`, 
					`{$wpdb->prefix}adrotate_linkmeta` 
				WHERE 
					({$group_select}) 
					AND `{$wpdb->prefix}adrotate_linkmeta`.`user` = 0 
					AND `{$wpdb->prefix}adrotate`.`id` = `{$wpdb->prefix}adrotate_linkmeta`.`ad` 
					AND (`{$wpdb->prefix}adrotate`.`type` = 'active' 
						OR `{$wpdb->prefix}adrotate`.`type` = '2days'
						OR `{$wpdb->prefix}adrotate`.`type` = '7days')
				GROUP BY `{$wpdb->prefix}adrotate`.`id`
				ORDER BY `{$wpdb->prefix}adrotate`.`id`;");
		
			if($ads) {
				foreach($ads as $ad) {
					$selected[$ad->id] = $ad;
					$selected = adrotate_filter_schedule($selected, $ad);
				}
				unset($ads);
				
				$array_count = count($selected);
				if($array_count > 0) {
					$before = $after = '';
					$before = str_replace('%id%', $group_array[0], stripslashes(html_entity_decode($group->wrapper_before, ENT_QUOTES)));
					$after = str_replace('%id%', $group_array[0], stripslashes(html_entity_decode($group->wrapper_after, ENT_QUOTES)));

					$output .= '<div class="g g-'.$group->id.'">';

					// Kill dynamic mode for mobile users
					if($adrotate_config['mobile_dynamic_mode'] == 'Y' AND $group->modus == 1 AND wp_is_mobile()) {
						$group->modus = 0;
					}

					if($group->modus == 1) { // Dynamic ads
						$i = 1;

						// Limit group to save resources
						$amount = ($group->adspeed >= 10000) ? 10 : 20;
						
						// Randomize and trim output
						$selected = adrotate_shuffle($selected);
						foreach($selected as $key => $banner) {
							if($i <= $amount) {
								$image = str_replace('%folder%', $adrotate_config['banner_folder'], $banner->image);
	
								$output .= '<div class="g-dyn a-'.$banner->id.' c-'.$i.'">';
								$output .= $before.adrotate_ad_output($banner->id, $group->id, $banner->title, $banner->bannercode, $banner->tracker, $image).$after;
								$output .= '</div>';
								$i++;
							}
						}
					} else if($group->modus == 2) { // Block of ads
						$block_count = $group->gridcolumns * $group->gridrows;
						if($array_count < $block_count) $block_count = $array_count;
						$columns = 1;

						for($i=1;$i<=$block_count;$i++) {
							$banner_id = array_rand($selected, 1);

							$image = str_replace('%folder%', $adrotate_config['banner_folder'], $selected[$banner_id]->image);

							$output .= '<div class="g-col b-'.$group->id.' a-'.$selected[$banner_id]->id.'">';
							$output .= $before.adrotate_ad_output($selected[$banner_id]->id, $group->id, $selected[$banner_id]->title, $selected[$banner_id]->bannercode, $selected[$banner_id]->tracker, $image).$after;
							$output .= '</div>';

							if($columns == $group->gridcolumns AND $i != $block_count) {
								$output .= '</div><div class="g g-'.$group->id.'">';
								$columns = 1;
							} else {
								$columns++;
							}

							if($adrotate_config['stats'] == 1 AND $selected[$banner_id]->tracker == "Y") {
								adrotate_count_impression($selected[$banner_id]->id, $group->id, 0);
							}

							unset($selected[$banner_id]);
						}
					} else { // Default (single ad)
						$banner_id = array_rand($selected, 1);

						$image = str_replace('%folder%', $adrotate_config['banner_folder'], $selected[$banner_id]->image);

						$output .= '<div class="g-single a-'.$selected[$banner_id]->id.'">';
						$output .= $before.adrotate_ad_output($selected[$banner_id]->id, $group->id, $selected[$banner_id]->title, $selected[$banner_id]->bannercode, $selected[$banner_id]->tracker, $image).$after;
						$output .= '</div>';

						if($adrotate_config['stats'] == 1 AND $selected[$banner_id]->tracker == "Y") {
							adrotate_count_impression($selected[$banner_id]->id, $group->id, 0);
						}
					}

					$output .= '</div>';

					unset($selected);
				} else {
					$output .= adrotate_error('ad_expired');
				}
			} else { 
				$output .= adrotate_error('ad_unqualified');
			}
		} else {
			$output .= adrotate_error('group_not_found', array($group_array[0]));
		}
	} else {
		$output .= adrotate_error('group_no_id');
	}

	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_shortcode
 Purpose:   Prepare function requests for calls on shortcodes
 Since:		0.7
-------------------------------------------------------------*/
function adrotate_shortcode($atts, $content = null) {
	global $adrotate_config;

	$banner_id = (!empty($atts['banner'])) ? trim($atts['banner'], "\r\t ") : 0;
	$group_ids = (!empty($atts['group'])) ? trim($atts['group'], "\r\t ") : 0;
	if(!empty($atts['fallback'])) $fallback	= 0; // Not supported in free version
	if(!empty($atts['weight']))	$weight	= 0; // Not supported in free version
	if(!empty($atts['site'])) $site = 0; // Not supported in free version
	if(!empty($atts['wrapper'])) $wrapper = 0; // Not supported in free version

	$output = '';
	if($adrotate_config['w3caching'] == "Y") {
		$output .= '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
		if($banner_id > 0 AND ($group_ids == 0 OR $group_ids > 0)) { // Show one Ad
			$output .= 'echo adrotate_ad('.$banner_id.');';
		}	
		if($banner_id == 0 AND $group_ids > 0) { // Show group
			$output .= 'echo adrotate_group('.$group_ids.');';
		}
		$output .= '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
	} else if($adrotate_config['borlabscache'] == "Y" AND function_exists('BorlabsCacheHelper')) {
		if(BorlabsCacheHelper()->willFragmentCachingPerform()) {
			$borlabsphrase = BorlabsCacheHelper()->getFragmentCachingPhrase();
	
			$output .= '<!--[borlabs cache start: '.$borlabsphrase.']--> ';
			if($banner_id > 0 AND ($group_ids == 0 OR $group_ids > 0)) { // Show one Ad
				$output .= 'echo adrotate_ad('.$banner_id.');';
			}		
			if($banner_id == 0 AND $group_ids > 0) { // Show group
				$output .= 'echo adrotate_group('.$group_ids.');';
			}
			$output .= ' <!--[borlabs cache end: '.$borlabsphrase.']-->';
	
			unset($borlabsphrase);
		}
	} else {
		if($banner_id > 0 AND ($group_ids == 0 OR $group_ids > 0)) { // Show one Ad
			$output .= adrotate_ad($banner_id);
		}
	
		if($banner_id == 0 AND $group_ids > 0) { // Show group
			$output .= adrotate_group($group_ids);
		}
	}

	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_inject_posts
 Purpose:   Add an advert to a single post
 Added:		3.7
-------------------------------------------------------------*/
function adrotate_inject_posts($post_content) { 
	global $wpdb, $post, $adrotate_config;

	$group_array = array();
	if(is_page()) {
		// Inject ads into page
		$ids = $wpdb->get_results("SELECT `id`, `page`, `page_loc`, `page_par` FROM `{$wpdb->prefix}adrotate_groups` WHERE `page_loc` > 0 AND  `page_loc` < 5;");
		
		foreach($ids as $id) {
			$pages = explode(",", $id->page);
			if(!is_array($pages)) $pages = array();

			if(in_array($post->ID, $pages)) {
				$group_array[$id->id] = array('location' => $id->page_loc, 'paragraph' => $id->page_par, 'ids' => $pages);
			}
		}
		unset($ids, $pages);
	}
	
	if(is_single()) {
		// Inject ads into posts in specified category
		$ids = $wpdb->get_results("SELECT `id`, `cat`, `cat_loc`, `cat_par` FROM `{$wpdb->prefix}adrotate_groups` WHERE `cat_loc` > 0 AND `cat_loc` < 5;");
		$wp_categories = get_terms('category', array('fields' => 'ids'));

		foreach($ids as $id) {
			$categories = explode(",", $id->cat);
			if(!is_array($categories)) $categories = array();

			foreach($wp_categories as &$value) {
				if(in_array($value, $categories)) {
					$group_array[$id->id] = array('location' => $id->cat_loc, 'paragraph' => $id->cat_par, 'ids' => $categories);
				}
			}
		}
		unset($ids, $wp_categories, $categories);
	}

	$group_array = adrotate_shuffle($group_array);	
	$group_count = count($group_array);

	if($group_count > 0) {
		$before = $after = $inside = 0;
		$advert_output = '';
		foreach($group_array as $group_id => $group) {
			if(is_page($group['ids']) OR has_category($group['ids'])) {
				// Caching or not?
				if($adrotate_config['w3caching'] == 'Y') {
					$advert_output = '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
					$advert_output .= 'echo adrotate_group('.$group_id.');';
					$advert_output .= '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
				} else if($adrotate_config['borlabscache'] == "Y" AND function_exists('BorlabsCacheHelper')) {
					if(BorlabsCacheHelper()->willFragmentCachingPerform()) {
						$borlabsphrase = BorlabsCacheHelper()->getFragmentCachingPhrase();
	
						$advert_output = '<!--[borlabs cache start: '.$borlabsphrase.']-->';
						$advert_output .= 'echo adrotate_group('.$group_id.');';
						$advert_output .= '<!--[borlabs cache end: '.$borlabsphrase.']-->';
	
						unset($borlabsphrase);
					}
				} else {
					$advert_output = adrotate_group($group_id);
				}

				// Advert in front of content
				if(($group['location'] == 1 OR $group['location'] == 3) AND $before == 0) {
					$post_content = $advert_output.$post_content;
					unset($group_array[$group_id]);
					$before = 1;
				}
	
				// Advert behind the content
				if(($group['location'] == 2 OR $group['location'] == 3) AND $after == 0) {
					$post_content = $post_content.$advert_output;
					unset($group_array[$group_id]);
					$after = 1;
				}

				// Adverts inside the content
				if($group['location'] == 4) {
				    $paragraphs = explode('</p>', $post_content);
					$paragraph_count = count($paragraphs);
					$count_p = ($group['paragraph'] == 99) ? ceil($paragraph_count / 2) : $group['paragraph'];

				    foreach($paragraphs as $index => $paragraph) {
				        if(trim($paragraph)) {
				            $paragraphs[$index] .= '</p>';
				        }

				        if($count_p == $index + 1 AND $inside == 0) {
				            $paragraphs[$index] .= $advert_output;
							unset($group_array[$group_id]);
				            $inside = 1;
				        }
				    }

				    $inside = 0; // Reset for the next paragraph
				    $post_content = implode('', $paragraphs);
					unset($paragraphs, $paragraph_count);
				}
			}
		}
		unset($group_array, $before, $after, $inside, $advert_output);
	}

	return $post_content;
}

/*-------------------------------------------------------------
 Name:      adrotate_preview
 Purpose:   Show preview of selected advert (Dashboard)
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_preview($banner_id) {
	global $wpdb;

	if($banner_id) {
		$now = current_time('timestamp');
		
		$banner = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}adrotate` WHERE `id` = %d;", $banner_id));

		if($banner) {
			$image = str_replace('%folder%', '/banners/', $banner->image);		
			$output = adrotate_ad_output($banner->id, 0, $banner->title, $banner->bannercode, $banner->tracker, $image);
		} else {
			$output = adrotate_error('ad_expired');
		}
	} else {
		$output = adrotate_error('ad_no_id');
	}

	return $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_ad_output
 Purpose:   Prepare the output for viewing
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_ad_output($id, $group, $name, $bannercode, $tracker, $image) {
	global $blog_id, $adrotate_config;

	$banner_output = $bannercode;
	$banner_output = stripslashes(htmlspecialchars_decode($banner_output, ENT_QUOTES));

	if($adrotate_config['stats'] > 0 AND $tracker == "Y") {
		if(empty($blog_id) or $blog_id == '') {
			$blog_id = 0;
		}
		
		if($adrotate_config['stats'] == 1) { // Internal tracker
			preg_match_all('/<a[^>](?:.*?)>/i', $banner_output, $matches, PREG_SET_ORDER);
			if(isset($matches[0])) {
				$banner_output = str_ireplace('<a ', '<a data-track="'.adrotate_hash($id, $group, $blog_id).'" ', $banner_output);
				foreach($matches[0] as $value) {
					if(preg_match('/<a[^>]+class=\"(.+?)\"[^>]*>/i', $value, $regs)) {
					    $result = $regs[1]." gofollow";
						$banner_output = str_ireplace('class="'.$regs[1].'"', 'class="'.$result.'"', $banner_output);	    
					} else {
						$banner_output = str_ireplace('<a ', '<a class="gofollow" ', $banner_output);
					}
					unset($value, $regs, $result);
				}
			}
		}
	}

	$image = apply_filters('adrotate_apply_photon', $image);

	$banner_output = str_replace('%title%', $name, $banner_output);		
	$banner_output = str_replace('%random%', rand(100000,999999), $banner_output);
	$banner_output = str_replace('%asset%', $image, $banner_output); // Replaces %image%
	$banner_output = str_replace('%image%', $image, $banner_output); // Depreciated, remove in AdRotate 5.0
	$banner_output = str_replace('%id%', $id, $banner_output);
	$banner_output = do_shortcode($banner_output);

	return $banner_output;
}

/*-------------------------------------------------------------
 Name:      adrotate_header
 Purpose:   Add required CSS to wp_head (action)
 Since:		3.8
-------------------------------------------------------------*/
function adrotate_header() {

	$output = "\n<!-- This site is using AdRotate v".ADROTATE_DISPLAY." to display their advertisements - https://ajdg.solutions/ -->\n";
	echo $output;

	adrotate_custom_css();
}

/*-------------------------------------------------------------
 Name:      adrotate_custom_css
 Purpose:   Add group CSS to adrotate_header()
 Since:		5.1.2
-------------------------------------------------------------*/
function adrotate_custom_css() {
	global $adrotate_config;

	$generated_css = get_option('adrotate_group_css', array());

	$output = "<!-- AdRotate CSS -->\n";
	$output .= "<style type=\"text/css\" media=\"screen\">\n";
	$output .= "\t.g { margin:0px; padding:0px; overflow:hidden; line-height:1; zoom:1; }\n";
	$output .= "\t.g img { height:auto; }\n";
	$output .= "\t.g-col { position:relative; float:left; }\n";
	$output .= "\t.g-col:first-child { margin-left: 0; }\n";
	$output .= "\t.g-col:last-child { margin-right: 0; }\n";
	foreach($generated_css as $group_id => $css) {
		if(strlen($css) > 0) {
			$output .= $css;
		}
	}
	unset($generated_css);
	$output .= "\t@media only screen and (max-width: 480px) {\n";
	$output .= "\t\t.g-col, .g-dyn, .g-single { width:100%; margin-left:0; margin-right:0; }\n";
	$output .= "\t}\n";
	if($adrotate_config['widgetpadding'] == "Y") { 
		$output .= ".adrotate_widgets, .ajdg_bnnrwidgets, .ajdg_grpwidgets { overflow:hidden; padding:0; }\n";
	}
	$output .= "</style>\n";
	$output .= "<!-- /AdRotate CSS -->\n\n";

	echo $output;
}

/*-------------------------------------------------------------
 Name:      adrotate_scripts
 Purpose:   Add required scripts to wp_enqueue_scripts (action)
 Since:		3.6
-------------------------------------------------------------*/
function adrotate_scripts() {
	global $adrotate_config;
	
	$in_footer = false;
	if($adrotate_config['jsfooter'] == "Y") {
		$in_footer = true;
	}
	
	if($adrotate_config['jquery'] == 'Y') wp_enqueue_script('jquery', false, false, false, $in_footer);
	if(get_option('adrotate_dynamic_required') > 0) wp_enqueue_script('jshowoff-adrotate', plugins_url('/library/jquery.adrotate.dyngroup.js', __FILE__), false, null, $in_footer);

	// Make clicktracking and impression tracking a possibility
	if($adrotate_config['stats'] == 1) {
		wp_enqueue_script('clicktrack-adrotate', plugins_url('/library/jquery.adrotate.clicktracker.js', __FILE__), false, null, $in_footer);
		wp_localize_script('jshowoff-adrotate', 'impression_object', array('ajax_url' => admin_url( 'admin-ajax.php')));
		wp_localize_script('clicktrack-adrotate', 'click_object', array('ajax_url' => admin_url('admin-ajax.php')));
	}

	if(!$in_footer) {
		add_action('wp_head', 'adrotate_custom_javascript');
	} else {
		add_action('wp_footer', 'adrotate_custom_javascript', 100);
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_custom_javascript
 Purpose:   Add required JavaScript to adrotate_scripts()
 Since:		3.10.5
-------------------------------------------------------------*/
function adrotate_custom_javascript() {
	global $wpdb, $adrotate_config;

	$groups = $wpdb->get_results("SELECT `id`, `adspeed` FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '' AND `modus` = 1 ORDER BY `id` ASC;");
	if($groups) {
		$output = "<!-- AdRotate JS -->\n";
		$output .= "<script type=\"text/javascript\">\n";
		$output .= "jQuery(document).ready(function(){\n";
		$output .= "if(jQuery.fn.gslider) {\n";
		foreach($groups as $group) {
			$output .= "\tjQuery('.g-".$group->id."').gslider({ groupid: ".$group->id.", speed: ".$group->adspeed." });\n";
		}
		$output .= "}\n";
		$output .= "});\n";
		$output .= "</script>\n";
		$output .= "<!-- /AdRotate JS -->\n\n";
		unset($groups);
		echo $output;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_nonce_error
 Purpose:   Display a formatted error if Nonce fails
 Since:		3.7.4.2
-------------------------------------------------------------*/
function adrotate_nonce_error() {
	echo '	<h2 style="text-align: center;">'.__('Oh no! Something went wrong!', 'adrotate').'</h2>';
	echo '	<p style="text-align: center;">'.__('WordPress was unable to verify the authenticity of the url you have clicked. Verify if the url used is valid or log in via your browser.', 'adrotate').'</p>';
	echo '	<p style="text-align: center;">'.__('If you have received the url you want to visit via email, you are being tricked!', 'adrotate').'</p>';
	echo '	<p style="text-align: center;">'.__('Contact support if the issue persists:', 'adrotate').' <a href="https://ajdg.solutions/forums/" title="AdRotate Support" target="_blank">AJdG Solutions Support</a>.</p>';
}

/*-------------------------------------------------------------
 Name:      adrotate_error
 Purpose:   Show errors for problems in using AdRotate, should they occur
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_error($action, $arg = null) {
	switch($action) {
		// Ads
		case "ad_expired" :
			$result = '<!-- '.__('Error, Advert is not available at this time due to schedule/geolocation restrictions!', 'adrotate').' -->';
			return $result;
		break;
		
		case "ad_unqualified" :
			$result = '<!-- '.__('Either there are no banners, they are disabled or none qualified for this location!', 'adrotate').' -->';
			return $result;
		break;
		
		case "ad_no_id" :
			$result = '<span style="font-weight: bold; color: #f00;">'.__('Error, no Advert ID set! Check your syntax!', 'adrotate').'</span>';
			return $result;
		break;

		// Groups
		case "group_no_id" :
			$result = '<span style="font-weight: bold; color: #f00;">'.__('Error, no group ID set! Check your syntax!', 'adrotate').'</span>';
			return $result;
		break;

		case "group_not_found" :
			$result = '<span style="font-weight: bold; color: #f00;">'.__('Error, group does not exist! Check your syntax!', 'adrotate').' (ID: '.$arg[0].')</span>';
			return $result;
		break;

		// Database
		case "db_error" :
			$result = '<span style="font-weight: bold; color: #f00;">'.__('There was an error locating the database tables for AdRotate. Please deactivate and re-activate AdRotate from the plugin page!!', 'adrotate').'<br />'.__('If this does not solve the issue please seek support at', 'adrotate').' <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/">ajdg.solutions/forums/forum/adrotate-for-wordpress/</a></span>';
			return $result;
		break;

		// Possible XSS or malformed URL
		case "error_loading_item" :
			$result = '<span style="font-weight: bold; color: #f00;">'.__('There was an error loading the page. Please try again by reloading the page via the menu on the left.', 'adrotate').'<br />'.__('If the issue persists please seek help at', 'adrotate').' <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/">ajdg.solutions/forums/forum/adrotate-for-wordpress/</a></span>';
			return $result;
		break;

		// Misc
		default:
			$result = '<span style="font-weight: bold; color: #f00;">'.__('An unknown error occured.', 'adrotate').' (ID: '.$arg[0].')</span>';
			return $result;
		break;
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_dashboard_error
 Purpose:   Show errors for problems in using AdRotate
 Since:		3.19.1
-------------------------------------------------------------*/
function adrotate_dashboard_error() {
	global $adrotate_config;

	// Adverts
	$status = get_option('adrotate_advert_status');
	$adrotate_notifications	= get_option("adrotate_notifications");

	if($adrotate_notifications['notification_dash'] == "Y") {
		if($status['expired'] > 0 AND $adrotate_notifications['notification_dash_expired'] == "Y") {
			$error['advert_expired'] = sprintf(_n('One advert is expired.', '%1$s adverts expired!', $status['expired'], 'adrotate'), $status['expired']).' <a href="'.admin_url('admin.php?page=adrotate').'">'.__('Check adverts', 'adrotate').'</a>!';
		} 
		if($status['expiressoon'] > 0 AND $adrotate_notifications['notification_dash_soon'] == "Y") {
			$error['advert_soon'] = sprintf(_n('One advert expires soon.', '%1$s adverts are almost expiring!', $status['expiressoon'], 'adrotate'), $status['expiressoon']).' <a href="'.admin_url('admin.php?page=adrotate').'">'.__('Check adverts', 'adrotate').'</a>!';
		} 
	}
	if($status['error'] > 0) {
		$error['advert_config'] = sprintf(_n('One advert with configuration errors.', '%1$s adverts have configuration errors!', $status['error'], 'adrotate'), $status['error']).' <a href="'.admin_url('admin.php?page=adrotate').'">'.__('Check adverts', 'adrotate').'</a>!';
	}

	// Caching
	if($adrotate_config['w3caching'] == "Y" AND !is_plugin_active('w3-total-cache/w3-total-cache.php')) {
		$error['w3tc_not_active'] = __('You have enabled caching support but W3 Total Cache is not active on your site!', 'adrotate').' <a href="'.admin_url('/admin.php?page=adrotate-settings&tab=misc').'">'.__('Disable W3 Total Cache Support', 'adrotate').'</a>.';
	}
	if($adrotate_config['w3caching'] == "Y" AND !defined('W3TC_DYNAMIC_SECURITY')) {
		$error['w3tc_no_hash'] = __('You have enable caching support but the W3TC_DYNAMIC_SECURITY definition is not set.', 'adrotate').' <a href="'.admin_url('/admin.php?page=adrotate-settings&tab=misc').'">'.__('How to configure W3 Total Cache', 'adrotate').'</a>.';
	}

	if($adrotate_config['borlabscache'] == "Y" AND !is_plugin_active('borlabs-cache/borlabs-cache.php')) {
		$error['borlabs_not_active'] = __('You have enable caching support but Borlabs Cache is not active on your site!', 'adrotate-pro').' <a href="'.admin_url('/admin.php?page=adrotate-settings&tab=misc').'">'.__('Disable Borlabs Cache Support', 'adrotate-pro').'</a>.';
	}
	if($adrotate_config['borlabscache'] == "Y" AND is_plugin_active('borlabs-cache/borlabs-cache.php')) {
		if(\Borlabs\Factory::get('Cache\Config')->get('cacheActivated') == 'yes') {
			$borlabscache = \Borlabs\Factory::get('Cache\Config')->get('fragmentCaching');
			if(strlen($borlabscache) < 1) {
				$error['borlabs_fragment_error'] = __('You have enabled Borlabs Cache support but Fragment caching is not enabled!', 'adrotate-pro').' <a href="'.admin_url('/admin.php?page=borlabs-cache-fragments').'">'.__('Enable Fragment Caching', 'adrotate-pro').'</a>.';
			}
		}
	}

	// Misc
	if(!is_writable(WP_CONTENT_DIR."/".$adrotate_config['banner_folder'])) {
		$error['banners_folder'] = __('Your AdRotate Banner folder is not writable or does not exist.', 'adrotate').' <a href="https://ajdg.solutions/manuals/adrotate-manuals/manage-banner-images/" target="_blank">'.__('Set up your banner folder', 'adrotate').'</a>.';
	}
	if(is_dir(WP_PLUGIN_DIR."/adrotate-pro/")) {
		$error['adrotate_exists'] = __('You have AdRotate Professional installed. Please switch to AdRotate Pro! You can delete this plugin after AdRotate Pro is activated.', 'adrotate-pro').' <a href="'.admin_url('/plugins.php?s=adrotate&plugin_status=all').'">'.__('Switch plugins', 'adrotate-pro').'</a>.';
	}
	if(basename(__DIR__) != 'adrotate' AND basename(__DIR__) != 'adrotate-pro') {
		$error['adrotate_folder_names'] = __('Something is wrong with your installation of AdRotate. Either the plugin is installed twice or your current installation has the wrong folder name. Please install the plugin properly!', 'adrotate-pro').' <a href="https://ajdg.solutions/support/adrotate-manuals/installing-adrotate-on-your-website/" target="_blank">'.__('Installation instructions', 'adrotate-pro').'</a>.';
	}

	$error = (isset($error) AND is_array($error)) ? $error : false;

	return $error;
}

/*-------------------------------------------------------------
 Name:      adrotate_notifications_dashboard
 Purpose:   Notify user of expired banners in the dashboard
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_notifications_dashboard() {
	global $current_user;

	if(current_user_can('adrotate_ad_manage')) {
		$displayname = (strlen($current_user->user_firstname) > 0) ? $current_user->user_firstname : $current_user->display_name;
		$page = (isset($_GET['page'])) ? $_GET['page'] : '';

		// These only show on AdRotate pages
		if(strpos($page, 'adrotate') !== false) {
			if(isset($_GET['hide']) AND $_GET['hide'] == 0) update_option('adrotate_hide_getpro', current_time('timestamp') + (31 * DAY_IN_SECONDS));
			if(isset($_GET['hide']) AND $_GET['hide'] == 1) update_option('adrotate_hide_review', 1);
			if(isset($_GET['hide']) AND $_GET['hide'] == 2) update_option('adrotate_hide_birthday', current_time('timestamp') + (10 * MONTH_IN_SECONDS));

			// Get AdRotate Pro
			$getpro_banner = get_option('adrotate_hide_getpro');
			if($getpro_banner < current_time('timestamp')) {
				echo '<div class="ajdg-notification notice">';
				echo '	<div class="ajdg-notification-logo" style="background-image: url(\''.plugins_url('/images/notification.png', __FILE__).'\');"><span></span></div>';
				echo '	<div class="ajdg-notification-message">Hello <strong>'.$displayname.'</strong>. Have you considered upgrading to <strong>AdRotate Professional</strong> yet?<br />Get extra features like Geo Targeting, Scheduling, mobile adverts, access to premium support and much more starting at only &euro;39 EUR.<br />';
				if(adrotate_is_classicpress()) {
					echo ' Use coupon code <strong>GOTCLASSICPRESS</strong> and get a 20% special ClassicPress discount on any <strong>AdRotate Professional</strong> license! Thank you for your consideration!</div>';
				} else {
					echo ' Use coupon code <strong>GETADROTATEPRO</strong> and get a 10% discount on any <strong>AdRotate Professional</strong> license! Thank you for your consideration!</div>';
				}
				echo '	<div class="ajdg-notification-cta">';
				echo '		<a href="'.admin_url('admin.php?page=adrotate-pro').'" class="ajdg-notification-act button-primary">Get AdRotate Pro</a>';
				echo '		<a href="'.admin_url('admin.php?page=adrotate').'&hide=0" class="ajdg-notification-dismiss">Maybe later</a>';
				echo '	</div>';
				echo '</div>';
			}
	
			// Write a review
			$review_banner = get_option('adrotate_hide_review');
			if($review_banner != 1 AND $review_banner < (current_time('timestamp') - (8 * DAY_IN_SECONDS))) {
				echo '<div class="ajdg-notification notice">';
				echo '	<div class="ajdg-notification-logo" style="background-image: url(\''.plugins_url('/images/notification.png', __FILE__).'\');"><span></span></div>';
				echo '	<div class="ajdg-notification-message">Hello <strong>'.$displayname.'</strong>! You have been using <strong>AdRotate</strong> for a few days. If you like AdRotate, please share <strong>your experience</strong> and help promote AdRotate.<br />Tell your followers that you use AdRotate. A <a href="https://twitter.com/intent/tweet?hashtags=wordpress%2Cplugin%2Cadvertising&related=arnandegans%2Cwordpress&text=I%20am%20using%20AdRotate%20for%20@WordPress.%20Check%20it%20out.&url=https%3A%2F%2Fwordpress.org/plugins/adrotate/" target="_blank" class="ajdg-notification-act goosebox">Tweet</a> or <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwordpress.org%2Fplugins%2Fadrotate%2F&amp;src=adrotate" target="_blank" class="ajdg-notification-act goosebox">Facebook Share</a> helps a lot and is super awesome!<br />If you have questions, complaints or something else that does not belong in a review, please use the <a href="'.admin_url('admin.php?page=adrotate-support').'">support forum</a>!</div>';
				echo '	<div class="ajdg-notification-cta">';
				echo '		<a href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform" class="ajdg-notification-act button-primary">Write Review</a>';
				echo '		<a href="'.admin_url('admin.php?page=adrotate').'&hide=1" class="ajdg-notification-dismiss">Maybe later</a>';
				echo '	</div>';
				echo '</div>';
			}

			// Birthday
			$birthday_banner = get_option('adrotate_hide_birthday');
			if($birthday_banner < current_time('timestamp') AND date('M', current_time('timestamp')) == 'Feb') {
				echo '<div class="ajdg-notification notice">';
				echo '	<div class="ajdg-notification-logo" style="background-image: url(\''.plugins_url('/images/birthday.png', __FILE__).'\');"><span></span></div>';
				echo '	<div class="ajdg-notification-message">Hey <strong>'.$displayname.'</strong>! Did you know it is Arnan his birtyday this month? February 9th to be exact. Wish him a happy birthday via Twitter!<br />Who is Arnan? He made AdRotate for you - Check out his <a href="http://www.arnan.me/?pk_campaign=adrotatefree&pk_keyword=birthday_banner" target="_blank">website</a> or <a href="http://www.arnan.me/donate.html?pk_campaign=adrotatefree&pk_keyword=birthday_banner" target="_blank">send a gift</a>.</div>';
				echo '	<div class="ajdg-notification-cta">';
				echo '		<a href="https://twitter.com/intent/tweet?text=Happy%20Birthday%20@arnandegans!%20From%20'.$displayname.'%20at%20'.home_url().'&hashtags=birthday,adrotate" target="_blank" class="ajdg-notification-act button-primary goosebox"><i class="icn-t"></i>Wish Happy Birthday</a>';
				echo '		<a href="'.admin_url('admin.php?page=adrotate').'&hide=2" class="ajdg-notification-dismiss">Not now</a>';
				echo '	</div>';
				echo '</div>';
			}
		}

		// Advert notifications, errors, important stuff
		$adrotate_has_error = adrotate_dashboard_error();
		if($adrotate_has_error) {
			echo '<div class="ajdg-notification notice" style="">';
			echo '	<div class="ajdg-notification-logo" style="background-image: url(\''.plugins_url('/images/notification.png', __FILE__).'\');"><span></span></div>';
			echo '	<div class="ajdg-notification-message"><strong>AdRotate</strong> has detected '._n('one issue that requires', 'several issues that require', count($adrotate_has_error), 'adrotate').' '.__('your attention:', 'adrotate').'<br />';
			foreach($adrotate_has_error as $error => $message) {
				echo '&raquo; '.$message.'<br />';				
			}
			echo '	</div>';
			echo '</div>';
		}
	}

	// Finish update
	// Keep for manual updates
	$adrotate_db_version = get_option("adrotate_db_version");
	$adrotate_version = get_option("adrotate_version");
	if($adrotate_db_version['current'] < ADROTATE_DB_VERSION OR $adrotate_version['current'] < ADROTATE_VERSION) {
		echo '<div class="ajdg-notification notice" style="">';
		echo '	<div class="ajdg-notification-logo" style="background-image: url(\''.plugins_url('/images/notification.png', __FILE__).'\');"><span></span></div>';
		echo '	<div class="ajdg-notification-message">Thanks for updating <strong>'.$displayname.'</strong>! You have almost completed updating <strong>AdRotate</strong> to version <strong>'.ADROTATE_DISPLAY.'</strong>!<br />To complete the update <strong>click the button on the right</strong>. This may take a few seconds to complete!<br />For an overview of what has changed take a look at the <a href="https://ajdg.solutions/support/adrotate-development/?pk_campaign=adrotatefree&pk_keyword=finish_update_notification" target="_blank">development page</a> and usually there is an article on <a href="https://ajdg.solutions/blog/" target="_blank">the blog</a> with more information as well.</div>';
		echo '	<div class="ajdg-notification-cta">';
		echo '		<a href="'.admin_url('admin.php?page=adrotate-settings').'&tab=maintenance&action=update-db" class="ajdg-notification-act button-primary update-button">Finish update</a>';
		echo '	</div>';
		echo '</div>';
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_welcome_pointer
 Purpose:   Show dashboard pointers
 Since:		3.9.14
-------------------------------------------------------------*/
function adrotate_welcome_pointer() {
    $pointer_content = '<h3>AdRotate '.ADROTATE_DISPLAY.'</h3>';
    $pointer_content .= '<p>'.__('Thank you for choosing AdRotate. Everything related to AdRotate is in this menu. If you need help getting started take a look at the', 'adrotate').' <a href="http:\/\/ajdg.solutions\/support\/adrotate-manuals\/" target="_blank">'.__('manuals', 'adrotate').'</a> '.__('and', 'adrotate').' <a href="https:\/\/ajdg.solutions\/forums\/forum\/adrotate-for-wordpress\/" target="_blank">'.__('forums', 'adrotate').'</a>. These links are also available in the help tab in the top right.</p>';

    $pointer_content .= '<p><strong>AdRotate Professional - <a href="admin.php?page=adrotate-pro">Learn more &raquo;</a></strong><br />If you like AdRotate please consider upgrading to AdRotate Professional and benefit from many <a href="admin.php?page=adrotate-pro">extra features</a> to make your campaigns more profitable!</p>';

    $pointer_content .= '<p><strong>Ad blockers</strong><br />Disable your ad blocker in your browser so your adverts and dashboard show up correctly. Take a look at this manual to <a href="https://ajdg.solutions/support/adrotate-manuals/configure-adblockers-for-your-own-website/" target="_blank">whitelist your site</a>.</p>';
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#toplevel_page_adrotate').pointer({
				'content':'<?php echo $pointer_content; ?>',
				'position':{ 'edge':'left', 'align':'middle' },
				close: function() {
	                $.post(ajaxurl, {
		                pointer:'adrotatefree_'+<?php echo ADROTATE_VERSION.ADROTATE_DB_VERSION; ?>, 
		                action:'dismiss-wp-pointer'
					});
				}
			}).pointer("open");
		});
	</script>
<?php
}

/*-------------------------------------------------------------
 Name:      adrotate_help_info
 Purpose:   Help tab on all pages
 Since:		3.10.17
-------------------------------------------------------------*/
function adrotate_help_info() {
    $screen = get_current_screen();

    $screen->add_help_tab(array(
        'id' => 'adrotate_thanks',
        'title' => 'Thanks to you',
        'content' => '<h4>Thank you for using AdRotate</h4>'.
        '<p>AdRotate is one of the most popular WordPress plugins for Advertising and is a household name for many companies and websites around the world. AdRotate would not be possible without your support and my life would definitely not be what it is today without your help!</p><p><em>- Arnan</em></p>'.

        '<p>Visit <a href="https://ajdg.solutions/?pk_campaign=adrotatefree&pk_keyword=helptab" target="_blank">ajdg.solutions</a> website for more plugins and services related to WordPress and WooCommerce.<br />'.
        'If you are curious who makes AdRotate please take a look at <a href="http://www.arnan.me/?pk_campaign=adrotatefree&pk_keyword=helptab" target="_blank">arnan.me</a>, my profile website.</p>'
		)
    );
    $screen->add_help_tab(array(
        'id' => 'adrotate_support',
        'title' => 'Getting Support',
        'content' => '<h4>Get help using AdRotate</h4>'.
        '<p>Everyone needs a little help sometimes. I have created guides and manuals for all popular AdRotate features. You can also find many answers on on the Support Forum.<br />'.
		'All the relevant links to getting help and the Professional Services I offer can be found below, and on the <a href="'.admin_url('admin.php?page=adrotate-support').'">Support dashboard</a>.</p>'.

        '<p>Take a look at the <a href="https://ajdg.solutions/support/adrotate-manuals/?pk_campaign=adrotatefree&pk_keyword=helptab" target="_blank">AdRotate Manuals</a> and the <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/?pk_campaign=adrotatefree&pk_keyword=helptab" target="_blank">Support Forum</a>.</p>'.
		'<p>Also check out these <a href="https://ajdg.solutions/recommended-products/?pk_campaign=adrotatefree&pk_keyword=helptab" target="_blank">products and services</a> I love and recommend, if you are in the market for better hosting, a new domain name or SSL certificates and similar products.</p>'
		)
    );
}

/*-------------------------------------------------------------
 Name:      adrotate_action_links
 Purpose:	Plugin page link
 Since:		4.11
-------------------------------------------------------------*/
function adrotate_action_links($links) {
	$custom_actions = array();
	$custom_actions['adrotate-pro'] = sprintf('<a href="%s" target="_blank">%s</a>', 'https://ajdg.solutions/cart/?add-to-cart=1124&pk_campaign=adrotatefree&pk_keyword=action_links&pk_content=buy_single', 'Get Pro');
	$custom_actions['adrotate-help'] = sprintf('<a href="%s" target="_blank">%s</a>', 'https://ajdg.solutions/forums/forum/adrotate-for-wordpress/?pk_campaign=adrotatefree&pk_keyword=action_links&pk_content=support_link', 'Support');
	$custom_actions['adrotate-ajdg'] = sprintf('<a href="%s" target="_blank">%s</a>', 'https://ajdg.solutions/?pk_campaign=adrotatefree&pk_keyword=action_links', 'AJdG Solutions');

	return array_merge($custom_actions, $links);
}

/*-------------------------------------------------------------
 Name:      adrotate_credits
 Purpose:   Promotional stuff shown throughout the plugin
 Since:		3.7
-------------------------------------------------------------*/
function adrotate_credits() {
	echo '<table class="widefat" style="margin-top: 2em">';

	echo '<thead>';
	echo '<tr valign="top">';
	echo '	<th width="35%"><strong>'.__('Need help fast? Or do you have a question?', 'adrotate').'</strong></th>';
	echo '	<th width="35%"><strong>'.__('Help AdRotate Grow', 'adrotate').'</strong></th>';
	echo '	<th><strong>'.__('Get more features with AdRotate Pro', 'adrotate').'</strong></th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';
	echo '<tr>';
	echo '<td><a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/?pk_campaign=adrotatefree&pk_keyword=credits" title="Getting help with AdRotate"><img src="'.plugins_url('/images/icon-support.png', __FILE__).'" alt="AdRotate Logo" width="60" height="60" align="left" style="padding:5px;" /></a><p>'.__('If you need help, or have questions about AdRotate, the best and fastest way to get your answer is via the AdRotate support forum. Usually I answer questions the same day, often with a solution in the first answer.').'</p>
	<p><center><a href="https://ajdg.solutions/support/adrotate-manuals/?pk_campaign=adrotatefree&pk_keyword=credits&pk_content=manuals_link" target="_blank" class="button-primary">'.__('AdRotate Manuals').'</a> <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/?pk_campaign=adrotatefree&pk_keyword=credits&pk_content=forums_link" target="_blank" class="button-primary">'.__('Support Forums').'</a></center></p>
	<p>'.__('When posting on the forum, please include a brief description of the problem, include any errors or symptoms. Often it helps if you try to explain what you are trying to do. Providing some extra information always helps with gettng a better answer or advise.').'</p></td>';

	echo '<td><a href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform" title="Review AdRotate for WordPress"><img src="'.plugins_url('/images/icon-contact.png', __FILE__).'" alt="AdRotate Logo" width="60" height="60" align="left" style="padding:5px;" /></a><p>'.__('Consider writing a review, sharing AdRotate in Social media or making a donation if you like the plugin or if you find it useful. Writing a review and sharing AdRotate on social media costs you nothing but doing so is super helpful as promotion which helps to ensure future development.').'</p>
	<p><center><a href="https://twitter.com/intent/tweet?hashtags=wordpress%2Cplugin%2Cadvertising%2Cadrotate&related=arnandegans%2Cwordpress&text=I%20am%20using%20AdRotate%20for%20WordPress%20by%20@arnandegans.%20Check%20it%20out.&url=https%3A%2F%2Fwordpress.org/plugins/adrotate/" target="_blank" class="button-primary goosebox"><i class="icn-t"></i>'.__('Post Tweet').'</a> <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwordpress.org%2Fplugins%2Fadrotate%2F&hashtag=#adrotate" target="_blank" class="button-primary goosebox"><i class="icn-fb"></i>'.__('Share on Facebook').'</a> <a class="button-primary" target="_blank" href="https://wordpress.org/support/plugin/adrotate/reviews/?rate=5#new-post">'.__('Write review on WordPress.org').'</a></center></p>
	<p><em>- '.__('Thank you very much for your help and support!').'</em></p></td>';


//	echo '<td><a href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform" title="Review AdRotate for WordPress"><img src="'.plugins_url('/images/icon-contact.png', __FILE__).'" alt="AdRotate Logo" width="60" height="60" align="left" style="padding:5px;" /></a>'.__("Many users only think to review AdRotate when something goes wrong while thousands of people happily use AdRotate.", 'adrotate').' <strong>'. __("If you find AdRotate useful please leave your", 'adrotate').' <a href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform" target="_blank">'.__('rating','adrotate').'</a> '.__('on WordPress.org to help AdRotate grow in a positive way', 'adrotate').'!</strong></td>';

	echo '<td><a href="https://ajdg.solutions/plugins/adrotate-for-wordpress/?pk_campaign=adrotatefree&pk_keyword=credits&pk_content=buy_pro" target="_blank"><img src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" class="alignleft pro-image" /></a><p>'.__('AdRotate Professional has a lot more functions for even better advertising management. Check out the feature comparison tab on any of the product pages to see what AdRotate Pro has to offer for you!', 'adrotate').' <a href="https://ajdg.solutions/product-category/adrotate-pro/?pk_campaign=adrotatefree&pk_keyword=credits" target="_blank">'.__('Compare Licenses', 'adrotate').' &raquo;</a></p>
	<p><a href="https://ajdg.solutions/product/adrotate-pro-single/?pk_campaign=adrotatefree&pk_keyword=credits&pk_content=single" target="_blank"><strong>'.__('Single License', 'adrotate').' (&euro; 39.00)</strong></a><br /><em>'.__('Use on ONE WordPress installation.', 'adrotate').' <a href="https://ajdg.solutions/?add-to-cart=1124&pk_campaign=adrotatefree&pk_keyword=credits&pk_content=single" target="_blank">'.__('Buy now', 'adrotate').' &raquo;</a></em></p>
	<p><a href="https://ajdg.solutions/product/adrotate-pro-multi/?pk_campaign=adrotatefree&pk_keyword=credits&pk_content=multi" target="_blank"><strong>'.__('Multi License', 'adrotate').' (&euro; 99.00)</strong></a><br /><em>'.__('Use on up to FIVE WordPress installations.', 'adrotate').' <a href="https://ajdg.solutions/?add-to-cart=1128&pk_campaign=adrotatefree&pk_keyword=credits&pk_content=multi" target="_blank">'.__('Buy now', 'adrotate').' &raquo;</a></em></p></td>';

//	echo '<td><a href="https://ajdg.solutions/cart/?add-to-cart=1124&pk_campaign=adrotatefree&pk_keyword=credits" title="Upgrade to AdRotate Pro"><img src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt="AdRotate Pro for WordPress" width="60" height="60" align="left" style="padding:5px;" /></a>'.__('Get more advanced features such as Geo Targeting, scheduling and much more with AdRotate Pro.', 'adrotate').' '.__('Get access to premium support and free updates for one year!', 'adrotate').' <strong>So why wait? <a href="'.admin_url('admin.php?page=adrotate-pro').'" title="Get AdRotate Pro for WordPress">'.__('Upgrade today', 'adrotate').' &raquo;</a></strong></td>';

	echo '</tr>';
	echo '</tbody>';

	echo '</table>';
	echo adrotate_trademark();
}

/*-------------------------------------------------------------
 Name:      adrotate_trademark
 Purpose:   Trademark notice
 Since:		3.9.14
-------------------------------------------------------------*/
function adrotate_trademark() {
	return '<center><small>AdRotate<sup>&reg;</sup> is a registered trademark.</small></center>';
}
?>
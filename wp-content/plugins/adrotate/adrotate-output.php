<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2019 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      adrotate_ad
 Purpose:   Show requested ad
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_ad($banner_id, $individual = true, $group = null, $site = 0) {
	global $wpdb, $adrotate_config, $adrotate_debug;

	$output = '';

	if($banner_id) {			
		$banner = $wpdb->get_row($wpdb->prepare("SELECT `id`, `title`, `bannercode`, `tracker`, `image` FROM `{$wpdb->prefix}adrotate` WHERE `id` = %d AND (`type` = 'active' OR `type` = '2days' OR `type` = '7days');", $banner_id));

		if($banner) {
			if($adrotate_debug['general'] == true) {
				echo "<p><strong>[DEBUG][adrotate_ad()] Selected Ad ID</strong><pre>";
				print_r($banner->id); 
				echo "</pre></p>"; 
			}
			
			$selected = array($banner->id => 0);			
			$selected = adrotate_filter_schedule($selected, $banner);
		} else {
			$selected = false;
		}
		
		if($selected) {
			$image = str_replace('%folder%', $adrotate_config['banner_folder'], $banner->image);

			if($individual == true) $output .= '<div class="a-single a-'.$banner->id.'">';
			$output .= adrotate_ad_output($banner->id, 0, $banner->title, $banner->bannercode, $banner->tracker, $image);
			if($individual == true) $output .= '</div>';

			if($adrotate_config['stats'] == 1) {
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
function adrotate_group($group_ids, $fallback = 0, $weight = 0, $site = 0) { 
	global $wpdb, $adrotate_config, $adrotate_debug;

	$output = $group_select = '';
	if($group_ids) {
		$now = adrotate_now();

		$group_array = (preg_match('/,/is', $group_ids)) ? explode(",", $group_ids) : array($group_ids);
		$group_array = array_filter($group_array);

		foreach($group_array as $key => $value) {
			$group_select .= " `{$wpdb->prefix}adrotate_linkmeta`.`group` = {$value} OR";
		}
		$group_select = rtrim($group_select, " OR");

		$group = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '' AND `id` = %d;", $group_array[0]));

		if($adrotate_debug['general'] == true) {
			echo "<p><strong>[DEBUG][adrotate_group] Selected group</strong><pre>"; 
			print_r($group);
			echo "</pre></p>";
		}

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
				if($adrotate_debug['general'] == true) {
					echo "<p><strong>[DEBUG][adrotate_group()] All ads in group</strong><pre>"; 
					print_r($ads); 
					echo "</pre></p>"; 
				}			

				foreach($ads as $ad) {
					$selected[$ad->id] = $ad;
					$selected = adrotate_filter_schedule($selected, $ad);
				}
				unset($ads);
				
				if($adrotate_debug['general'] == true) {
					echo "<p><strong>[DEBUG][adrotate_group] Reduced array based on schedule restrictions</strong><pre>"; 
					print_r($selected); 
					echo "</pre></p>"; 
				}			

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

							if($adrotate_config['stats'] == 1){
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

						if($adrotate_config['stats'] == 1){
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

	$banner_id = $group_ids = 0;
	if(!empty($atts['banner'])) $banner_id = trim($atts['banner'], "\r\t ");
	if(!empty($atts['group'])) $group_ids = trim($atts['group'], "\r\t ");
	if(!empty($atts['fallback'])) $fallback	= 0; // Not supported in free version
	if(!empty($atts['weight']))	$weight	= 0; // Not supported in free version
	if(!empty($atts['site'])) $site = 0; // Not supported in free version

	$output = '';
	if($adrotate_config['w3caching'] == "Y") {
		$output .= '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
		if($banner_id > 0 AND ($group_ids == 0 OR $group_ids > 0)) { // Show one Ad
			$output .= 'echo adrotate_ad('.$banner_id.', true);';
		}	
		if($banner_id == 0 AND $group_ids > 0) { // Show group
			$output .= 'echo adrotate_group('.$group_ids.');';
		}
		$output .= '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
	} else if($adrotate_config['borlabscache'] == "Y" AND function_exists('BorlabsCacheHelper') AND BorlabsCacheHelper()->willFragmentCachingPerform()) {
		$borlabsphrase = BorlabsCacheHelper()->getFragmentCachingPhrase();

		$output .= '<!--[borlabs cache start: '.$borlabsphrase.']--> ';
		if($banner_id > 0 AND ($group_ids == 0 OR $group_ids > 0)) { // Show one Ad
			$output .= 'echo adrotate_ad('.$banner_id.', true);';
		}		
		if($banner_id == 0 AND $group_ids > 0) { // Show group
			$output .= 'echo adrotate_group('.$group_ids.');';
		}
		$output .= ' <!--[borlabs cache end: '.$borlabsphrase.']-->';

		unset($borlabsphrase);
	} else {
		if($banner_id > 0 AND ($group_ids == 0 OR $group_ids > 0)) { // Show one Ad
			$output .= adrotate_ad($banner_id, true);
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
	global $wpdb, $post, $adrotate_config, $adrotate_debug;

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

	if($adrotate_debug['general'] == true) {
		echo "<p><strong>[DEBUG][adrotate_inject_posts()] group_array</strong><pre>"; 
		echo "Group count: ".$group_count."</br>";
		print_r($group_array); 
		echo "</pre></p>"; 
	}

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
				} else if($adrotate_config['borlabscache'] == "Y" AND function_exists('BorlabsCacheHelper') AND BorlabsCacheHelper()->willFragmentCachingPerform()) {
					$borlabsphrase = BorlabsCacheHelper()->getFragmentCachingPhrase();

					$advert_output = '<!--[borlabs cache start: '.$borlabsphrase.']-->';
					$advert_output .= 'echo adrotate_group('.$group_id.');';
					$advert_output .= '<!--[borlabs cache end: '.$borlabsphrase.']-->';

					unset($borlabsphrase);
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
 Purpose:   Show preview of selected ad (Dashboard)
 Since:		3.0
-------------------------------------------------------------*/
function adrotate_preview($banner_id) {
	global $wpdb, $adrotate_debug;

	if($banner_id) {
		$now = adrotate_now();
		
		$banner = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}adrotate` WHERE `id` = %d;", $banner_id));

		if($adrotate_debug['general'] == true) {
			echo "<p><strong>[DEBUG][adrotate_preview()] Ad information</strong><pre>"; 
			print_r($banner); 
			echo "</pre></p>"; 
		}			

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
function adrotate_ad_output($id, $group = 0, $name, $bannercode, $tracker, $image) {
	global $blog_id, $adrotate_debug, $adrotate_config;

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
			if($adrotate_debug['timers'] == true) {
				$banner_output = str_ireplace('<a ', '<a data-debug="1" ', $banner_output);
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

	$output = "\n<!-- This site is using AdRotate v".ADROTATE_DISPLAY." to display their advertisements - https://ajdg.solutions/products/adrotate-for-wordpress/ -->\n";
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
	global $adrotate_debug;

	switch($action) {
		// Ads
		case "ad_expired" :
			if($adrotate_debug['general'] == true) {
				$result = '<span style="font-weight: bold; color: #f00;">'.__('Error, Ad is not available at this time due to schedule/geolocation restrictions or does not exist!', 'adrotate').'</span>';
			} else {
				$result = '<!-- '.__('Error, Ad is not available at this time due to schedule/geolocation restrictions!', 'adrotate').' -->';
			}
			return $result;
		break;
		
		case "ad_unqualified" :
			if($adrotate_debug['general'] == true) {
				$result = '<span style="font-weight: bold; color: #f00;">'.__('Either there are no banners, they are disabled or none qualified for this location!', 'adrotate').'</span>';
			} else {
				$result = '<!-- '.__('Either there are no banners, they are disabled or none qualified for this location!', 'adrotate').' -->';
			}
			return $result;
		break;
		
		case "ad_no_id" :
			$result = '<span style="font-weight: bold; color: #f00;">'.__('Error, no Ad ID set! Check your syntax!', 'adrotate').'</span>';
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
			$error['advert_expired'] = sprintf(_n('One advert is expired.', '%1$s adverts expired!', $status['expired'], 'adrotate'), $status['expired']).' <a href="'.admin_url('admin.php?page=adrotate-ads').'">'.__('Check adverts', 'adrotate').'</a>!';
		} 
		if($status['expiressoon'] > 0 AND $adrotate_notifications['notification_dash_soon'] == "Y") {
			$error['advert_soon'] = sprintf(_n('One advert expires soon.', '%1$s adverts are almost expiring!', $status['expiressoon'], 'adrotate'), $status['expiressoon']).' <a href="'.admin_url('admin.php?page=adrotate-ads').'">'.__('Check adverts', 'adrotate').'</a>!';
		} 
	}
	if($status['error'] > 0) {
		$error['advert_config'] = sprintf(_n('One advert with configuration errors.', '%1$s adverts have configuration errors!', $status['error'], 'adrotate'), $status['error']).' <a href="'.admin_url('admin.php?page=adrotate-ads').'">'.__('Check adverts', 'adrotate').'</a>!';
	}

	// Caching
	if($adrotate_config['w3caching'] == "Y" AND !is_plugin_active('w3-total-cache/w3-total-cache.php')) {
		$error['w3tc_not_active'] = __('You have enabled caching support but W3 Total Cache is not active on your site!', 'adrotate').' <a href="'.admin_url('/admin.php?page=adrotate-settings&tab=misc').'">'.__('Disable W3 Total Cache Support', 'adrotate').'</a>.';
	}
	if($adrotate_config['w3caching'] == "Y" AND !defined('W3TC_DYNAMIC_SECURITY')) {
		$error['w3tc_no_hash'] = __('You have enable caching support but the W3TC_DYNAMIC_SECURITY definition is not set.', 'adrotate').' <a href="'.admin_url('/admin.php?page=adrotate-settings&tab=misc').'">'.__('How to configure W3 Total Cache', 'adrotate').'</a>.';
	}

	if($adrotate_config['borlabscache'] == "Y" AND !class_exists('\Borlabs\Factory') AND \Borlabs\Factory::get('Cache\Config')->get('cacheActivated') != 'yes') {
		$error['borlabs_not_active'] = __('You have enable caching support but Borlabs Cache is not active on your site!', 'adrotate-pro').' <a href="'.admin_url('/admin.php?page=adrotate-settings&tab=misc').'">'.__('Disable Borlabs Cache Support', 'adrotate-pro').'</a>.';
	}
	if(class_exists('\Borlabs\Factory') AND \Borlabs\Factory::get('Cache\Config')->get('cacheActivated') == 'yes') {
		$borlabscache = '';
		if(class_exists('\Borlabs\Factory')) {
			$borlabscache = \Borlabs\Factory::get('Cache\Config')->get('fragmentCaching');
		}
		if($adrotate_config['borlabscache'] == "Y" AND $borlabscache == '') {
			$error['borlabs_fragment_error'] = __('You have enabled Borlabs Cache support but Fragment caching is not enabled!', 'adrotate-pro').' <a href="'.admin_url('/admin.php?page=borlabs-cache-fragments').'">'.__('Enable Fragment Caching', 'adrotate-pro').'</a>.';
		}
	}

	// Misc
	if(!is_writable(WP_CONTENT_DIR."/".$adrotate_config['banner_folder'])) {
		$error['banners_folder'] = __('Your AdRotate Banner folder is not writable or does not exist.', 'adrotate').' <a href="https://ajdg.solutions/manuals/adrotate-manuals/manage-banner-images/" target="_blank">'.__('Set up your banner folder', 'adrotate').'</a>.';
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
	if(current_user_can('adrotate_ad_manage')) {
		if(isset($_GET['page'])) { $page = $_GET['page']; } else { $page = ''; }

		if(strpos($page, 'adrotate') !== false) {
			if(isset($_GET['hide']) AND $_GET['hide'] == 1) update_option('adrotate_hide_review', 1);
			if(isset($_GET['hide']) AND $_GET['hide'] == 2) update_option('adrotate_hide_competition', 1);
			if(isset($_GET['hide']) AND $_GET['hide'] == 3) update_option('adrotate_hide_translation', 1);

			// Get AdRotate Pro
			echo '<div class="updated" style="padding: 0; margin: 0;">';
			echo '	<div class="ajdg_notification">';
			echo '		<div class="button_div"><a class="button button_large" target="_blank" href="https://ajdg.solutions/plugins/adrotate-for-wordpress/?add-to-cart=1126">'.__('Get AdRotate Pro', 'adrotate').'</a></div>';
			echo '		<div class="text">'.__("Upgrade to <strong>AdRotate Professional</strong> and get features like Geo Targeting, Scheduling and more...", 'adrotate').'<br /><span>'.__('Use coupon code <b>IWANTADROTATEPRO</b> and get a 20% discount on any AdRotate Professional license!', 'adrotate' ).' '.__('Thank you for your support!', 'adrotate' ).'</span></div>';

			echo '		<div class="icon"><img title="" src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt=""/></div>';
			echo '	</div>';
			echo '</div>';
	
			// Write a review
			$review_banner = get_option('adrotate_hide_review');
			if($review_banner != 1 AND $review_banner < (adrotate_now() - (8 * DAY_IN_SECONDS))) {
				echo '<div class="updated" style="padding: 0; margin: 0;">';
				echo '	<div class="ajdg_notification">';
				echo '		<div class="button_div"><a class="button button_large" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform">Review AdRotate</a></div>';
				echo '		<div class="text">You have been using <strong>AdRotate</strong> for a few days. If you like AdRotate, please share <strong>your experience</strong>!<br /><span>If you have questions, complaints or something else that does not belong in a review, please use the <a href="admin.php?page=adrotate-support">support forum</a>!</span></div>';

				echo '		<a class="close_notification" href="admin.php?page=adrotate&hide=1"><img title="Close" src="'.plugins_url('/images/icon-close.png', __FILE__).'" alt=""/></a>';

				echo '		<div class="icon"><img title="" src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt=""/></div>';
				echo '	</div>';
				echo '</div>';
			}

			// AdRotate Switch
			$competition_banner = get_option('adrotate_hide_competition');
			if($competition_banner != 1) {
				$adrotate_has_competition = adrotate_check_competition();
				if($adrotate_has_competition) {
					echo '<div class="updated" style="padding: 0; margin: 0;">';
					echo '	<div class="ajdg_notification">';
					echo '		<div class="button_div"><a class="button button_large" data-slug="adrotate-switch" href="'.admin_url('plugin-install.php?tab=search&s=adrotate+switch+arnan').'" aria-label="Install AdRotate Switch now" data-name="AdRotate Switch">Install AdRotate Switch</a></div>';
					echo '		<div class="text">AdRotate found '._n('one plugin', 'several plugins', count($adrotate_has_competition), 'adrotate').' that can be imported:<br /><span>';
					foreach($adrotate_has_competition as $plugin) {
						echo '&raquo; '.$plugin.'<br />';				
					}
					echo '		</span>Configured plugins can be imported into AdRotate! What is <a target="_blank" href="https://ajdg.solutions/product/adrotate-switch/">AdRotate Switch</a>?</div>';

					echo '		<a class="close_notification" href="admin.php?page=adrotate&hide=2"><img title="Close" src="'.plugins_url('/images/icon-close.png', __FILE__).'" alt=""/></a>';
					echo '		<div class="icon"><img title="AdRotate Logo" src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt=""/></div>';
					echo '	</div>';
					echo '</div>';
				}
			}

			// Help translate
			$translate_banner = get_option('adrotate_hide_translation');
			if($translate_banner != 1 AND get_bloginfo('language') != "en-US") {
				echo '<div class="updated" style="padding: 0; margin: 0;">';
				echo '	<div class="ajdg_notification">';
				echo '		<div class="button_div"><a class="button button_large" target="_blank" href="https://translate.wordpress.org/projects/wp-plugins/adrotate/">Help Translate</a></div>';
				echo '		<div class="text">If you can spare a few minutes to translate a few words or sentences for <strong>AdRotate</strong> that would be great!<br /><span>Are you a native speaker and your English is very good? Please help translating AdRotate to your language. Thank you for your support!</span></div>';

				echo '		<a class="close_notification" href="admin.php?page=adrotate&hide=3"><img title="Close" src="'.plugins_url('/images/icon-close.png', __FILE__).'" alt=""/></a>';

				echo '		<div class="icon"><img title="" src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt=""/></div>';
				echo '	</div>';
				echo '</div>';
			}

		}

		// Advert notifications, errors, important stuff
		$adrotate_has_error = adrotate_dashboard_error();
		if($adrotate_has_error) {
			echo '<div class="error" style="padding: 0; margin: 0;">';
			echo '	<div class="ajdg_notification">';
			echo '		<div class="text">AdRotate has detected '._n('one issue that requires', 'several issues that require', count($adrotate_has_error), 'adrotate').' '.__('your attention:', 'adrotate').'<br /><span>';
			foreach($adrotate_has_error as $error => $message) {
				echo '&raquo; '.$message.'<br />';				
			}
			echo '		</span></div>';
			echo '		<div class="icon"><img title="AdRotate Logo" src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt=""/></div>';
			echo '	</div>';
			echo '</div>';
		}
	}

	if(isset($_GET['upgrade']) AND $_GET['upgrade'] == 1) adrotate_check_upgrade();
	$adrotate_db_version = get_option("adrotate_db_version");
	$adrotate_version = get_option("adrotate_version");
	if($adrotate_db_version['current'] < ADROTATE_DB_VERSION OR $adrotate_version['current'] < ADROTATE_VERSION) {
		echo '<div class="updated" style="padding: 0; margin: 0; border: 0;">';
		echo '	<div class="ajdg_notification">';
		echo '		<div class="button_div"><a class="button" href="admin.php?page=adrotate&upgrade=1">Finish Update</a></div>';
		echo '		<div class="text text_update">You have almost completed updating <strong>AdRotate</strong> to version <strong>'.ADROTATE_DISPLAY.'</strong>!<br /><span>To complete the update click the button on the left. This may take a few seconds to complete!</span></div>';

		echo '		<div class="icon"><img title="" src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt=""/></div>';
		echo '	</div>';
		echo '</div>';
	}

	if(isset($_GET['tasks']) AND $_GET['tasks'] == 1) adrotate_check_schedules();
}

/*-------------------------------------------------------------
 Name:      adrotate_welcome_pointer
 Purpose:   Show dashboard pointers
 Since:		3.9.14
-------------------------------------------------------------*/
function adrotate_welcome_pointer() {
    $pointer_content = '<h3>AdRotate '.ADROTATE_DISPLAY.'</h3>';
    $pointer_content .= '<p>'.__('Thank you for choosing AdRotate. Everything related to AdRotate is in this menu. If you need help getting started take a look at the', 'adrotate').' <a href="http:\/\/ajdg.solutions\/manuals\/adrotate-manuals\/" target="_blank">'.__('manuals', 'adrotate').'</a> '.__('and', 'adrotate').' <a href="https:\/\/ajdg.solutions\/forums\/forum\/adrotate-for-wordpress\/" target="_blank">'.__('forums', 'adrotate').'</a>. These links are also available in the help tab in the top right.</p>';

    $pointer_content .= '<p><strong>AdRotate Professional - <a href="admin.php?page=adrotate-pro">Learn more &raquo;</a></strong><br />If you like AdRotate, consider upgrading to AdRotate Pro and benefit from many <a href="admin.php?page=adrotate-pro">extra features</a> to make your campaigns more profitable!</p>';

    $pointer_content .= '<p><strong>Ad blockers</strong><br />Disable your ad blocker in your browser so your adverts and dashboard show up correctly. AdRotate Pro has a <a href="admin.php?page=adrotate-pro">disguise feature</a> for adverts to help you avoid ad blockers.</p>';
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
        '<p>AdRotate is becoming one of the most popular WordPress plugins for Advertising and is a household name for many companies and websites around the world. AdRotate wouldn\'t be possible without your support and my life wouldn\'t be what it is today without your help.</p><p><em>- Arnan</em></p>'.

        '<p><strong>Add me on:</strong> <a href="https://www.facebook.com/ajdgsolutions/" target="_blank">Facebook</a>, <a href="https://www.twitter.com/arnandegans/" target="_blank">Twitter</a> and on <a href="https://linkedin.com/in/arnandegans/" target="_blank">LinkedIn</a>. <strong>Visit my websites:</strong> <a href="https://ajdg.solutions/" target="_blank">ajdg.solutions</a> & <a href="https://www.arnan.me" target="_blank">arnan.me</a>.</p>'
		)
    );
    $screen->add_help_tab(array(
        'id' => 'adrotate_partners',
        'title' => 'Advertising Partners',
        'content' => '<h4>Our partners</h4>'.
        '<p>Try these great advertising partners for getting relevant adverts to your site. Increase revenue with their contextual adverts and earn more money with AdRotate!</p>'.

        '<p><strong>Blind Ferret:</strong> <a href="https://ajdg.solutions/go/blindferret/" target="_blank">Sign up with the Blind Ferret Publisher Network</a><br />Industry leader in Header Bidding adverts!'.
        
        '<p><strong>Media.net:</strong> <a href="https://ajdg.solutions/go/medianet/" target="_blank">Sign up for Media.net Contextual Adverts</a><br />Get 10% extra earnings commission for the first 3 months!</p>'.

        '<p><small><em>These are affiliate links, using them costs you nothing but helps with the future of AdRotate!</em></small></p>'
		)
    );
    $screen->add_help_tab(array(
        'id' => 'adrotate_support',
        'title' => 'Getting Support',
        'content' => '<h4>Get help using AdRotate</h4>'.
        '<p>Everyone needs some help sometimes. AdRotate has many guides and manuals as well as a Support Forum on the AdRotate website to get you going.<br />All the relevant links to getting help and the Professional Services I offer can be found on the <a href="'.admin_url('admin.php?page=adrotate-support').'">Support dashboard</a>.</p>'.

        '<p>Take a look at the <a href="https://ajdg.solutions/support/adrotate-manuals/" target="_blank">AdRotate Manuals</a> and the <a href="https://ajdg.solutions/forums/forum/adrotate-for-wordpress/" target="_blank">Support Forum</a> here.</p>'
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
	$custom_actions['adrotate-pro'] = sprintf('<a href="%s" target="_blank">%s</a>', 'https://ajdg.solutions/cart/?add-to-cart=1124', 'Get Pro');
	$custom_actions['adrotate-help'] = sprintf('<a href="%s" target="_blank">%s</a>', 'https://ajdg.solutions/support/', 'Support');
	$custom_actions['adrotate-arnan'] = sprintf('<a href="%s" target="_blank">%s</a>', 'https://www.arnan.me/', 'arnan.me');

	return array_merge($custom_actions, $links);
}

/*-------------------------------------------------------------
 Name:      adrotate_credits
 Purpose:   Promotional stuff shown throughout the plugin
 Since:		3.7
-------------------------------------------------------------*/
function adrotate_credits() {
	echo '<table class="widefat" style="margin-top: .5em">';

	echo '<thead>';
	echo '<tr valign="top">';
	echo '	<th colspan="2"><strong>'.__('Help AdRotate Grow', 'adrotate').'</strong></th>';
	echo '	<th width="45%"><strong>'.__('AdRotate Professional', 'adrotate').'</strong></th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';
	echo '<tr>';
	echo '<td><center><a href="https://ajdg.solutions/products/adrotate-for-wordpress/" title="AdRotate plugin for WordPress"><img src="'.plugins_url('/images/logo-60x60.png', __FILE__).'" alt="AdRotate Logo" width="60" height="60" /></a></center></td>';
	echo '<td>'.__("Many users only think to review AdRotate when something goes wrong while thousands of people happily use AdRotate.", 'adrotate').' <strong>'. __("If you find AdRotate useful please leave your", 'adrotate').' <a href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform" target="_blank">'.__('rating','adrotate').'</a> '.__('and','adrotate').' <a href="https://wordpress.org/support/view/plugin-reviews/adrotate" target="_blank">'.__('review','adrotate').'</a> '.__('on WordPress.org to help AdRotate grow in a positive way', 'adrotate').'!</strong></td>';
	echo '<td><a href="https://ajdg.solutions/cart/?add-to-cart=1124" title="Get AdRotate Pro for WordPress"><img src="'.plugins_url('/images/adrotate-product.png', __FILE__).'" alt="AdRotate Pro for WordPress" width="70" height="70" align="left" /></a>'.__('Get more advanced features like Geo Targeting, scheduling and much more with AdRotate Pro.', 'adrotate').'<br />'.__('Includes premium support and free updates!', 'adrotate').'<br /><strong>So why wait? <a href="https://ajdg.solutions/cart/?add-to-cart=1124" title="Get AdRotate Pro for WordPress">'.__('Get started today', 'adrotate').' &raquo;</a></strong></td>';

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
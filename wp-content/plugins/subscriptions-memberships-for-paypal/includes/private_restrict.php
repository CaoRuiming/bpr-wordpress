<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//custom meta boxes
$prefix = 'wpeppsub_';

$meta_box = array(
    'id' => 'wpeppsub_',
    'title' => 'Subscriptions',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'User Level',
            'id' => $prefix . 'UserLevel',
            'type' => 'select',
            'desc' => 'Who can see this content?',
            'options' => array('Everyone','Members'),
            'std' => 'None'
        )
    )
);

// Add meta box

function wpeppsub_AddMetaBoxes() {
    global $meta_box;
	foreach (array('post','page') as $type)     
    add_meta_box($meta_box['id'], $meta_box['title'], 'wpeppsub_ShowMetaBox', $type, $meta_box['context'], $meta_box['priority']);
}
add_action('admin_menu', 'wpeppsub_AddMetaBoxes');


// Callback function to show fields in meta box
function wpeppsub_ShowMetaBox() {
    global $meta_box, $post;
    
    // Use nonce for verification
	echo '<input type="hidden" name="wpeppsub_MetaNonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<input type="hidden" name="wpeppsub_submit" value="1" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
        }
        echo     '<td>', $field['desc'], '</td><td>',
            '</tr>';
    }
    
    echo '</table>';
}


// Save data from meta box
function wpeppsub_SaveData($post_id) {
	if (isset($_POST['wpeppsub_submit']) && $_POST['wpeppsub_submit'] == "1") {
		global $meta_box;
		
		// verify nonce
		if (!wp_verify_nonce($_POST['wpeppsub_MetaNonce'], basename(__FILE__))) {
			return $post_id;
		}
		
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		
		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		foreach ($meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
add_action('save_post', 'wpeppsub_SaveData');



// check current users permissions
function checkUser() {
	add_filter('the_content', 'wpeppsub_display_content');
}
add_action('loop_start', 'checkUser');





// limit content on page / post
function wpeppsub_display_content($content) {
	global $post;
	$error = ' ';
	// get page / post settings
	$custom_meta = get_post_custom($post->ID);
	
	if (!empty($custom_meta['wpeppsub_UserLevel'][0])) {
		
		$wpeppsub_UserLevel = $custom_meta['wpeppsub_UserLevel'][0];
		
		if ($wpeppsub_UserLevel == "Everyone") {
			return $content;
		}
		
		// get main settings
		$options = get_option('wpeppsub_settingsoptions');
		foreach ($options as $k => $v ) { $value[$k] = esc_attr($v); }
		
		$status = "";
		
		// look to see if the user has an active subscription
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
		
		$args = array(
			'orderby' 			=> 'ID',
			'order' 			=> 'DESC',
			'posts_per_page'	=> -1,
			'post_type' 		=> 'wpplugin_subscr',
			'meta_query' 		=> array(
				'relation'=>'or',
				array(
					'key' 		=> 'wpeppsub_order_data',
					'value' 	=> $user_email,
					'compare' 	=> 'LIKE',
				)
			)
		);
		
		$postsa = get_posts($args);
		
		$active = "";
		foreach ($postsa as $posta) {
			
			// look up the users subscription status
			$status = get_post_meta($posta->ID, 'wpeppsub_order_status', true);
			
			// look to see if the user has an expired subscription, override status if so
			$expires_date = get_post_meta($posta->ID, 'wpeppsub_order_expires_date', true);
			
			if (!empty($expires_date)) {
				if ($expires_date >= time()) {
					$status = "Active";
				}
			}
			
			if ($status == "Active") {
				break;
			}
			
		}
		
		
		if (!current_user_can('upload_files')) {
			if (current_user_can('read') && $wpeppsub_UserLevel == 'Members') {
				if ($status == "Active") {
					// subscriber has an active subscription, so show them the content
					return $content;
				} else {
					// user is logged in as a subscriber, but their subscription is not active
					return $value['cancelled_text'];
				}
			}
		}
		
		// user is logged in and higher then a subscriber but cant see the post
		if (current_user_can('read') && current_user_can('upload_files') && $value['content'] == "2"  && $wpeppsub_UserLevel != 'Everyone') {
			return $value['guest_text'];
		}
		
		// user is logged in and higher then a subscriber but cant see the post
		if (current_user_can('read') && current_user_can('upload_files') && $value['content'] == "1"  && $wpeppsub_UserLevel != 'Everyone') {
			return $content;
		}
		
		// user is not logged in
		if (!current_user_can('read') && $wpeppsub_UserLevel == 'Members') {
			return $value['guest_text'];
		} else {
			$error .= "";
			return $error;
		}		
		
		
	} else {
		return $content;
	}
}

?>
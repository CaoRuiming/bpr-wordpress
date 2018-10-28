<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('init', 'wpeppsub_button_media_buttons_init');

function wpeppsub_button_media_buttons_init() {
	
	
	global $pagenow, $typenow;

	// add media button for editor page
	if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) && $typenow != 'download' ) {
		
		add_action('admin_footer', 'wpeppsub_button_add_inline_popup_content');
		add_action('media_buttons', 'wpeppsub_button_add_my_media_button', 20);
		
		// button
		function wpeppsub_button_add_my_media_button() {
			echo '<a href="#TB_inline?width=600&height=700&inlineId=wpeppsub_popup_container" title="Insert a PayPal Subscription Button" id="insert-my-media" class="button thickbox">Subscription Button</a>';
		}
		
		// popup
		function wpeppsub_button_add_inline_popup_content() {
		?>
		
			
		<script type="text/javascript">
			function wpeppsub_button_InsertShortcode() {
				
				var id = document.getElementById("wpeppsub_button_id").value;
				var wpplugin_paypal_alignmentc = document.getElementById("wpplugin_paypal_align");
				var wpplugin_paypal_alignmentb = wpplugin_paypal_alignmentc.options[wpplugin_paypal_alignmentc.selectedIndex].value;
				
				if(id == "No buttons found.") { alert("Error: Please select an existing button from the dropdown or make a new one."); return false; }
				if(id == "") { alert("Error: Please select an existing button from the dropdown or make a new one."); return false; }
				
				if(wpplugin_paypal_alignmentb == "none") { var wpplugin_paypal_alignment = ""; } else { var wpplugin_paypal_alignment = ' align="' + wpplugin_paypal_alignmentb + '"'; };
				
				window.send_to_editor('[wpeppsub id="' + id + '"' + wpplugin_paypal_alignment + ']');
				
				document.getElementById("wpeppsub_button_id").value = "";
				wpeppsub_alignmentc.selectedIndex = null;
			}
			function wpeppsub_button_InsertLogin() {
				window.send_to_editor('[wpeppsub_login]');
			}
			function wpeppsub_button_InsertLogout() {
				window.send_to_editor('[wpeppsub_logout]');
			}
		</script>

		
		<div id="wpeppsub_popup_container" style="display:none;">
		
		
			<h2>Insert a PayPal Subscription Button</h2>

			<table><tr><td>
			
			Choose an existing Button: </td></tr><tr><td>
			<select id="wpeppsub_button_id" name="wpeppsub_button_id">
				<?php
				$args = array('post_type' => 'wpplugin_sub_button','posts_per_page' => -1);

				$posts = get_posts($args);

				$count = "0";
				
				if (isset($posts)) {
					
					foreach ($posts as $post) {

						$id = $posts[$count]->ID;
						$post_title = $posts[$count]->post_title;
						$price = get_post_meta($id,'wpeppsub_button_price',true);
						$sku = get_post_meta($id,'wpeppsub_button_id',true);

						echo "<option value='$id'>";
						echo "Name: ";
						echo $post_title;
						echo "</option>";

						$count++;
					}
				}
				else {
					echo "<option>No buttons found.</option>";
				}
				
				?>
			</select>
			</td></tr><tr><td>
			Make a new Button: <a target="_blank" href="admin.php?page=wpeppsub_buttons&action=new">here</a><br />
			Manage existing Buttons: <a target="_blank" href="admin.php?page=wpeppsub_buttons">here</a>
			
			</td></tr><tr><td>
			<br />
			</td></tr><tr><td>
			
			Alignment: </td></tr><tr><td>
			<select id="wpplugin_paypal_align" name="wpplugin_paypal_align" style="width:100%;max-width:190px;">
			<option value="none"></option>
			<option value="left">Left</option>
			<option value="center">Center</option>
			<option value="right">Right</option>
			</select> </td></tr><tr><td>Optional
			
			</td></tr><tr><td>
			<br />
			</td></tr><tr><td>
			
			<input type="button" id="wpeppsub-paypal-insert" class="button-primary" onclick="wpeppsub_button_InsertShortcode();" value="Insert Button">
			
			<br />
			<br />
			<hr>
			<h2>Insert a Login Form</h2>
			<input type="button" id="wpeppsub-paypal-insert-login" class="button-secondary" onclick="wpeppsub_button_InsertLogin();" value="Insert Login Form">
			
			<br />
			<br />
			<hr>
			<h2>Insert a Logout Link</h2>
			<input type="button" id="wpeppsub-paypal-insert-logout" class="button-secondary" onclick="wpeppsub_button_InsertLogout();" value="Insert Logout Link">
			
			</td></tr></table>
		</div>
		<?php
		}
	}
}
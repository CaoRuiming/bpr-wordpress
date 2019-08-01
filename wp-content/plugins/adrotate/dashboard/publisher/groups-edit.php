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
<?php if(!$group_edit_id) { 
	$action = "group_new";
	$edit_id = $wpdb->get_var("SELECT `id` FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '' ORDER BY `id` DESC LIMIT 1;");
	if($edit_id == 0) {
		$wpdb->insert($wpdb->prefix.'adrotate_groups', array('name' => '', 'modus' => 0, 'fallback' => '0', 'cat' => '', 'cat_loc' => 0, 'cat_par' => 0, 'page' => '', 'page_loc' => 0, 'page_par' => 0, 'mobile' => 0, 'geo' => 0, 'wrapper_before' => '', 'wrapper_after' => '', 'gridrows' => 2, 'gridcolumns' => 2, 'admargin' => 0, 'admargin_bottom' => 0, 'admargin_left' => 0, 'admargin_right' => 0, 'adwidth' => '125', 'adheight' => '125', 'adspeed' => 6000, 'repeat_impressions' => 'Y'));
	    $edit_id = $wpdb->insert_id;
	}
	$group_edit_id = $edit_id;
	?>
<?php } else { 
	$action = "group_edit";
}

$edit_group = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}adrotate_groups` WHERE `id` = '{$group_edit_id}';");

if($edit_group) {
	$groups	= $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '' ORDER BY `id` ASC;"); 
	$ads = $wpdb->get_results("SELECT `id`, `title`, `tracker`, `weight`, `type` FROM `{$wpdb->prefix}adrotate` WHERE (`type` != 'empty' AND `type` != 'a_empty' AND `type` != 'generator') ORDER BY `id` ASC;");
	$linkmeta = $wpdb->get_results("SELECT `ad` FROM `{$wpdb->prefix}adrotate_linkmeta` WHERE `group` = '{$group_edit_id}' AND `user` = 0;");
	
	$meta_array = array();
	foreach($linkmeta as $meta) {
		$meta_array[] = $meta->ad;
	}
	if(!is_array($meta_array)) $meta_array = array();
	?>
	
	<form name="editgroup" id="post" method="post" action="admin.php?page=adrotate-groups">
		<?php wp_nonce_field('adrotate_save_group','adrotate_nonce'); ?>
		<input type="hidden" name="adrotate_id" value="<?php echo $edit_group->id;?>" />
		<input type="hidden" name="adrotate_action" value="<?php echo $action;?>" />
	
		<?php if($edit_group->name == '') { ?>
			<h3><?php _e('New Group', 'adrotate'); ?></h3>
		<?php } else { ?> 
			<h3><?php _e('Edit Group', 'adrotate'); ?></h3>
		<?php } ?>
	
	   	<table class="widefat" style="margin-top: .5em">
			<tbody>
		    <tr>
				<th width="15%"><?php _e('Name', 'adrotate'); ?></th>
				<td width="35%">
					<label for="adrotate_groupname"><input tabindex="1" name="adrotate_groupname" type="text" class="ajdg-fullwidth ajdg-inputfield" size="70" value="<?php echo $edit_group->name; ?>" autocomplete="off" /></label>
				</td>
				<td>
					&nbsp;
				</td>
			</tr>
		    <tr>
				<th valign="top"><?php _e('Mode', 'adrotate'); ?></strong></th>
				<td>
			       	<select tabindex="2" name="adrotate_modus" class="ajdg-fullwidth">
			        	<option value="0" <?php if($edit_group->modus == 0) { echo 'selected'; } ?>><?php _e('Default - Show one ad at a time', 'adrotate'); ?></option>
			        	<option value="1" <?php if($edit_group->modus == 1) { echo 'selected'; } ?>><?php _e('Dynamic Mode - Show a different ad every few seconds', 'adrotate'); ?></option>
			        	<option value="2" <?php if($edit_group->modus == 2) { echo 'selected'; } ?>><?php _e('Block Mode - Show a block of adverts', 'adrotate'); ?></option>
			        </select> 
				</td>
				<td>
			        <p><em><?php _e('Dynamic mode requires jQuery. You can enable this in AdRotate Settings.', 'adrotate'); ?></em></p>
				</td>
			</tr>
		    <tr>
				<th valign="top"><?php _e('Advert size', 'adrotate'); ?></strong></th>
				<td>
					<label for="adrotate_adwidth"><input tabindex="5" name="adrotate_adwidth" type="text" class="search-input" size="3" value="<?php echo $edit_group->adwidth; ?>" autocomplete="off" /> <?php _e('pixel(s) wide', 'adrotate'); ?>,</label> <label for="adrotate_adheight"><input tabindex="6" name="adrotate_adheight" type="text" class="search-input" size="3" value="<?php echo $edit_group->adheight; ?>" autocomplete="off" /> <?php _e('pixel(s) high.', 'adrotate'); ?></label>
				</td>
				<td>
			        <em><?php _e('Define the maximum size of the adverts in pixels. Size can be \'auto\' (Not recommended).', 'adrotate'); ?></em>
				</td>
			</tr>
			</tbody>
		</table>
	
		<h3><?php _e('Dynamic and Block Mode', 'adrotate'); ?></h3>
	   	<table class="widefat" style="margin-top: .5em">
			<tbody>
		    <tr>
				<th width="15%"><?php _e('Block size', 'adrotate'); ?></strong></th>
				<td width="35%">
			       	<label for="adrotate_gridrows"><select tabindex="3" name="adrotate_gridrows">
				       	<?php for($rows=1;$rows<=32;$rows++) { ?>
			        	<option value="<?php echo $rows; ?>" <?php if($edit_group->gridrows == $rows) { echo 'selected'; } ?>><?php echo $rows; ?></option>
						<?php } ?>			       	
			        </select> <?php _e('rows', 'adrotate'); ?>,</label> <label for="adrotate_gridcolumns"><select tabindex="4" name="adrotate_gridcolumns">
				       	<?php for($columns=1;$columns<=12;$columns++) { ?>
			        	<option value="<?php echo $columns; ?>" <?php if($edit_group->gridcolumns == $columns) { echo 'selected'; } ?>><?php echo $columns; ?></option>
						<?php } ?>			       	
			        </select> <?php _e('columns', 'adrotate'); ?>.</label>
				</td>
				<td colspan="2">
			        <p><em><?php _e('Block Mode', 'adrotate'); ?> - <?php _e('Larger blocks will degrade your sites performance! Default: 2/2.', 'adrotate'); ?></em></p>
				</td>
			</tr>
		    <tr>
				<th valign="top"><?php _e('Automated refresh', 'adrotate'); ?></strong></th>
				<td>
			       	<label for="adrotate_adwidth"><select tabindex="7" name="adrotate_adspeed">
			        	<option value="3000" <?php if($edit_group->adspeed == 3000) { echo 'selected'; } ?>>3</option>
			        	<option value="4000" <?php if($edit_group->adspeed == 4000) { echo 'selected'; } ?>>4</option>
			        	<option value="5000" <?php if($edit_group->adspeed == 5000) { echo 'selected'; } ?>>5</option>
			        	<option value="6000" <?php if($edit_group->adspeed == 6000) { echo 'selected'; } ?>>6</option>
			        	<option value="7000" <?php if($edit_group->adspeed == 7000) { echo 'selected'; } ?>>7</option>
			        	<option value="8000" <?php if($edit_group->adspeed == 8000) { echo 'selected'; } ?>>8</option>
			        	<option value="9000" <?php if($edit_group->adspeed == 9000) { echo 'selected'; } ?>>9</option>
			        	<option value="10000" <?php if($edit_group->adspeed == 10000) { echo 'selected'; } ?>>10</option>
			        	<option value="12000" <?php if($edit_group->adspeed == 12000) { echo 'selected'; } ?>>12</option>
			        	<option value="15000" <?php if($edit_group->adspeed == 15000) { echo 'selected'; } ?>>15</option>
			        	<option value="20000" <?php if($edit_group->adspeed == 20000) { echo 'selected'; } ?>>20</option>
			        	<option value="25000" <?php if($edit_group->adspeed == 25000) { echo 'selected'; } ?>>25</option>
			        	<option value="35000" <?php if($edit_group->adspeed == 35000) { echo 'selected'; } ?>>35</option>
			        	<option value="45000" <?php if($edit_group->adspeed == 45000) { echo 'selected'; } ?>>45</option>
			        	<option value="60000" <?php if($edit_group->adspeed == 60000) { echo 'selected'; } ?>>60</option>
			        	<option value="90000" <?php if($edit_group->adspeed == 90000) { echo 'selected'; } ?>>90</option>
			        </select> <?php _e('seconds.', 'adrotate'); ?></label>
				</td>
				<td colspan="2">
			        <p><em><?php _e('Dynamic Mode', 'adrotate'); ?> - <?php _e('Load a new advert in this interval without reloading the page. Default: 6.', 'adrotate'); ?></em></p>
				</td>
			</tr>
			<tr>
				<th valign="top"><?php _e('Repeat impressions', 'adrotate'); ?></th>
				<td>
					<label for="adrotate_repeat_impressions"><input type="checkbox" name="adrotate_repeat_impressions" checked disabled /> <?php _e('Count impressions for every cycle of adverts?', 'adrotate'); ?></label>
				</td>
				<td>
					<em><?php _e('Dynamic Mode', 'adrotate'); ?> - <?php _e('Uncheck this option to only count impressions for the first cycle of adverts.', 'adrotate'); ?></em>
				</td>
			</tr>
			</tbody>
		</table>
		<center><?php _e('Get access to all features in AdRotate Pro.', 'adrotate'); ?> <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade today', 'adrotate'); ?></a>!</center>
	
		<h3><?php _e('Usage', 'adrotate'); ?></h3>
	   	<table class="widefat" style="margin-top: .5em">
			<tbody>
	      	<tr>
		        <th width="15%"><?php _e('Widget', 'adrotate'); ?></th>
		        <td colspan="3"><?php _e('Drag the AdRotate widget to the sidebar you want it in, select "Group of Adverts" and enter ID', 'adrotate'); ?> "<?php echo $edit_group->id; ?>".</td>
	      	</tr>
	      	<tr>
		        <th width="15%"><?php _e('In a post or page', 'adrotate'); ?></th>
		        <td width="35%">[adrotate group="<?php echo $edit_group->id; ?>"]</td>
		        <th width="15%"><?php _e('Directly in a theme', 'adrotate'); ?></th>
		        <td width="35%">&lt;?php echo adrotate_group(<?php echo $edit_group->id; ?>); ?&gt;</td>
	      	</tr>
	      	</tbody>
		</table>
	
		<p class="submit">
			<input tabindex="8" type="submit" name="adrotate_group_submit" class="button-primary" value="<?php _e('Save Group', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-groups&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
	
		<h3><?php _e('Advanced', 'adrotate'); ?></h3>
	   	<table class="widefat" style="margin-top: .5em">
			<tbody>
		    <tr>
				<th width="15%" valign="top"><?php _e('Advert Margin', 'adrotate'); ?></strong></th>
				<td width="35%">
					<label for="adrotate_admargin"><input tabindex="9" name="adrotate_admargin" type="text" class="ajdg-inputfield" size="5" value="<?php echo $edit_group->admargin; ?>" autocomplete="off" /> <?php _e('pixel(s)', 'adrotate'); ?>.</label>
					</td>
				<td>
			        <p><em><?php _e('A transparent area outside the advert in pixels. Default: 0.', 'adrotate'); ?> <?php _e('Set to 0 to disable.', 'adrotate'); ?> <?php _e('Margins are automatically disabled for blocks where required.', 'adrotate'); ?></em></p>
				</td>
			</tr>
		    <tr>
				<th valign="top"><?php _e('Align the group', 'adrotate'); ?></strong></th>
				<td>
			       	<label for="adrotate_align"><select tabindex="10" name="adrotate_align">
			        	<option value="0" <?php if($edit_group->align == 0) { echo 'selected'; } ?>><?php _e('None (Default)', 'adrotate'); ?></option>
			        	<option value="1" <?php if($edit_group->align == 1) { echo 'selected'; } ?>><?php _e('Left', 'adrotate'); ?></option>
			        	<option value="2" <?php if($edit_group->align == 2) { echo 'selected'; } ?>><?php _e('Right', 'adrotate'); ?></option>
			        	<option value="3" <?php if($edit_group->align == 3) { echo 'selected'; } ?>><?php _e('Center', 'adrotate'); ?></option>
			        </select></label>
					</td>
				<td>
			        <p><em><?php _e('Align the group in your post or page. Using \'center\' may affect your margin setting. Not every theme supports this feature.', 'adrotate'); ?></em></p>
				</td>
			</tr>
		    <tr>
				<th width="15%" valign="top"><?php _e('Geo Targeting', 'adrotate'); ?></th>
				<td width="35%"><label for="adrotate_geo"><input type="checkbox" name="adrotate_geo" value="1" disabled /> <?php _e('Enable Geo Targeting for this group.', 'adrotate'); ?></label></td>
				<td><p><em><?php _e('Do not forget to tell the adverts for which areas they should show.', 'adrotate'); ?></em></p></td>
			</tr>
		    <tr>
				<th width="15%" valign="top"><?php _e('Mobile Support', 'adrotate'); ?></th>
				<td width="35%"><label for="adrotate_mobile"><input type="checkbox" name="adrotate_mobile" value="1" disabled /> <?php _e('Enable mobile support for this group.', 'adrotate'); ?></label></td>
				<td><p><em><?php _e('Do not forget to put at least one mobile advert in this group.', 'adrotate'); ?></em></p></td>
			</tr>
		    <tr>
				<th valign="top"><?php _e('Fallback Group', 'adrotate-pro'); ?></th>
				<td>
					<label for="adrotate_fallback">
					<select tabindex="16" name="adrotate_fallback" disabled>
				        <option value="0"><?php _e('Available in AdRotate Pro', 'adrotate-pro'); ?></option>
					</select>
				</td>
		        <td>
			        <em><?php _e('Select another group to fall back on when all adverts are expired, not in the visitors geographic area or are otherwise unavailable.', 'adrotate-pro'); ?></em>
				</td>
			</tr>
			</tbody>
		</table>
		<center><?php _e('Get access to all features in AdRotate Pro.', 'adrotate'); ?> <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!</center>
		
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
				<div id="left-column" class="postbox-container">
		
					<div class="ajdg-postbox">				
						<h2 class="ajdg-postbox-title"><?php _e('Post Injection', 'adrotate'); ?></h2>
						<div id="postinjection" class="ajdg-postbox-content">
							<p><label for="adrotate_cat_location">
							    <select tabindex="18" name="adrotate_cat_location">
							    	<option value="0" <?php if($edit_group->cat_loc == 0) { echo 'selected'; } ?>><?php _e('Disabled', 'adrotate'); ?></option>
							    	<option value="0" disabled><?php _e('Widget (Pro only)', 'adrotate'); ?></option>
							    	<option value="1" <?php if($edit_group->cat_loc == 1) { echo 'selected'; } ?>><?php _e('Before content', 'adrotate'); ?></option>
							    	<option value="2" <?php if($edit_group->cat_loc == 2) { echo 'selected'; } ?>><?php _e('After content', 'adrotate'); ?></option>
							    	<option value="3" <?php if($edit_group->cat_loc == 3) { echo 'selected'; } ?>><?php _e('Before and after content', 'adrotate'); ?></option>
							    	<option value="4" <?php if($edit_group->cat_loc == 4) { echo 'selected'; } ?>><?php _e('Inside the content...', 'adrotate'); ?></option>
							    </select>
							</label>
							<label for="adrotate_cat_paragraph">
							    <select tabindex="19" name="adrotate_cat_paragraph">
							    	<option value="0" <?php if($edit_group->cat_par == 0) { echo 'selected'; } ?>>...</option>
							    	<option value="99" <?php if($edit_group->cat_par == 99) { echo 'selected'; } ?>><?php _e('after the middle paragraph', 'adrotate'); ?></option>
							    	<option value="1" <?php if($edit_group->cat_par == 1) { echo 'selected'; } ?>><?php _e('after the 1st paragraph', 'adrotate'); ?></option>
							    	<option value="2" <?php if($edit_group->cat_par == 2) { echo 'selected'; } ?>><?php _e('after the 2nd paragraph', 'adrotate'); ?></option>
							    	<option value="3" <?php if($edit_group->cat_par == 3) { echo 'selected'; } ?>><?php _e('after the 3rd paragraph', 'adrotate'); ?></option>
							    	<option value="4" <?php if($edit_group->cat_par == 4) { echo 'selected'; } ?>><?php _e('after the 4th paragraph', 'adrotate'); ?></option>
							    	<option value="5" <?php if($edit_group->cat_par == 5) { echo 'selected'; } ?>><?php _e('after the 5th paragraph', 'adrotate'); ?></option>
							    	<option value="6" <?php if($edit_group->cat_par == 6) { echo 'selected'; } ?>><?php _e('after the 6th paragraph', 'adrotate'); ?></option>
							    	<option value="7" <?php if($edit_group->cat_par == 7) { echo 'selected'; } ?>><?php _e('after the 7th paragraph', 'adrotate'); ?></option>
							    	<option value="8" <?php if($edit_group->cat_par == 8) { echo 'selected'; } ?>><?php _e('after the 8th paragraph', 'adrotate'); ?></option>
							    </select>
							</label></p>
							<p><strong>Select Categories</strong></p>
							<div class="adrotate-select">
								<?php echo adrotate_select_categories($edit_group->cat, 0, 0, 0); ?>
							</div>
						</div>
					</div>
		
				</div>
				<div id="right-column" class="postbox-container">
		
					<div class="ajdg-postbox">
						<h2 class="ajdg-postbox-title"><?php _e('Page Injection', 'adrotate'); ?></h2>
						<div id="pageinjection" class="ajdg-postbox-content">
							<p><label for="adrotate_page_location">
						        <select tabindex="20" name="adrotate_page_location">
						        	<option value="0" <?php if($edit_group->page_loc == 0) { echo 'selected'; } ?>><?php _e('Disabled', 'adrotate'); ?></option>
							    	<option value="0" disabled><?php _e('Widget (Pro only)', 'adrotate'); ?></option>
						        	<option value="1" <?php if($edit_group->page_loc == 1) { echo 'selected'; } ?>><?php _e('Before content', 'adrotate'); ?></option>
						        	<option value="2" <?php if($edit_group->page_loc == 2) { echo 'selected'; } ?>><?php _e('After content', 'adrotate'); ?></option>
						        	<option value="3" <?php if($edit_group->page_loc == 3) { echo 'selected'; } ?>><?php _e('Before and after content', 'adrotate'); ?></option>
						        	<option value="4" <?php if($edit_group->page_loc == 4) { echo 'selected'; } ?>><?php _e('Inside the content...', 'adrotate'); ?></option>
						        </select>
							</label>
					        <label for="adrotate_page_paragraph">
						        <select tabindex="21" name="adrotate_page_paragraph">
						        	<option value="0" <?php if($edit_group->page_par == 0) { echo 'selected'; } ?>>...</option>
						        	<option value="99" <?php if($edit_group->page_par == 99) { echo 'selected'; } ?>><?php _e('after the middle paragraph', 'adrotate'); ?></option>
						        	<option value="1" <?php if($edit_group->page_par == 1) { echo 'selected'; } ?>><?php _e('after the 1st paragraph', 'adrotate'); ?></option>
						        	<option value="2" <?php if($edit_group->page_par == 2) { echo 'selected'; } ?>><?php _e('after the 2nd paragraph', 'adrotate'); ?></option>
						        	<option value="3" <?php if($edit_group->page_par == 3) { echo 'selected'; } ?>><?php _e('after the 3rd paragraph', 'adrotate'); ?></option>
						        	<option value="4" <?php if($edit_group->page_par == 4) { echo 'selected'; } ?>><?php _e('after the 4th paragraph', 'adrotate'); ?></option>
						        	<option value="5" <?php if($edit_group->page_par == 5) { echo 'selected'; } ?>><?php _e('after the 5th paragraph', 'adrotate'); ?></option>
						        	<option value="6" <?php if($edit_group->page_par == 6) { echo 'selected'; } ?>><?php _e('after the 6th paragraph', 'adrotate'); ?></option>
						        	<option value="7" <?php if($edit_group->page_par == 7) { echo 'selected'; } ?>><?php _e('after the 7th paragraph', 'adrotate'); ?></option>
						        	<option value="8" <?php if($edit_group->page_par == 8) { echo 'selected'; } ?>><?php _e('after the 8th paragraph', 'adrotate'); ?></option>
						        </select>
							</label></p>
	
							<p><strong>Select Pages</strong></p>
							<div class="adrotate-select">
								<?php echo adrotate_select_pages($edit_group->page, 0, 0, 0); ?>
							</div>
						</div>
					</div>
		
				</div>
			</div>
		</div>
	   	<div class="clear"></div>
		
		<h3><?php _e('Usage', 'adrotate'); ?></h3>
	   	<table class="widefat" style="margin-top: .5em">
			<tbody>
	      	<tr>
		        <th width="15%"><?php _e('Widget', 'adrotate'); ?></th>
		        <td colspan="3"><?php _e('Drag the AdRotate widget to the sidebar you want it in, select "Group of Adverts" and enter ID', 'adrotate'); ?> "<?php echo $edit_group->id; ?>".</td>
	      	</tr>
	      	<tr>
		        <th width="15%"><?php _e('In a post or page', 'adrotate'); ?></th>
		        <td width="35%">[adrotate group="<?php echo $edit_group->id; ?>"]</td>
		        <th width="15%"><?php _e('Directly in a theme', 'adrotate'); ?></th>
		        <td>&lt;?php echo adrotate_group(<?php echo $edit_group->id; ?>); ?&gt;</td>
	      	</tr>
	      	</tbody>
		</table>
	
		<p class="submit">
			<input tabindex="16" type="submit" name="adrotate_group_submit" class="button-primary" value="<?php _e('Save Group', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-groups&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
	
	   	<h3><?php _e('Wrapper code', 'adrotate'); ?></h3>
	   	<p><em><?php _e('Wraps around each advert. HTML/JavaScript allowed, use with care!', 'adrotate'); ?></em></p>
	   	<table class="widefat" style="margin-top: .5em">
			<tbody>
		    <tr>
				<th width="15%" valign="top"><?php _e('Before advert', 'adrotate'); ?></strong></th>
				<td width="35%"><textarea tabindex="17" name="adrotate_wrapper_before" rows="3" class="ajdg-fullwidth"><?php echo stripslashes($edit_group->wrapper_before); ?></textarea></td>
				<td>
			        <p><strong><?php _e('Example:', 'adrotate'); ?></strong> <em>&lt;span style="background-color:#aaa;"&gt;</em></p>
			        <p><strong><?php _e('Options:', 'adrotate'); ?></strong> <em>%id%</em></p>
				</td>
			</tr>
		    <tr>
				<th valign="top"><?php _e('After advert', 'adrotate'); ?></strong></th>
				<td width="35%"><textarea tabindex="18" name="adrotate_wrapper_after" rows="3" class="ajdg-fullwidth"><?php echo stripslashes($edit_group->wrapper_after); ?></textarea></td>
				<td>
					<p><strong><?php _e('Example:', 'adrotate'); ?></strong> <em>&lt;/span&gt;</em></p>
				</td>
			</tr>
			</tbody>
		</table>
		
		<h3><?php _e('Select adverts', 'adrotate'); ?></h3>
	   	<table class="widefat" style="margin-top: .5em">
			<thead>
			<tr>
				<td width="2%" scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></td>
				<th width="2%"><center><?php _e('ID', 'adrotate'); ?></center></th>
				<th><?php _e('Name', 'adrotate'); ?></th>
				<th width="15%"><?php _e('Visible until', 'adrotate'); ?></th>
				<th width="5%"><center><?php _e('Weight', 'adrotate'); ?></center></th>
		        <?php if($adrotate_config['stats'] == 1) { ?>
					<th width="5%"><center><?php _e('Shown', 'adrotate'); ?></center></th>
					<th width="5%"><center><?php _e('Clicks', 'adrotate'); ?></center></th>
				<?php } ?>
			</tr>
			</thead>
	
			<tbody>
			<?php if($ads) {
				$class = '';
				foreach($ads as $ad) {
					$stoptime = $wpdb->get_var("SELECT `stoptime` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta` WHERE `ad` = '{$ad->id}' AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` ORDER BY `stoptime` DESC LIMIT 1;");
	
					if($adrotate_config['stats'] == 1) {
						$stats = adrotate_stats($ad->id);
					}
	
					$errorclass = '';
					if($ad->type == 'error') $errorclass = ' row_yellow';
					if($stoptime <= $in2days OR $stoptime <= $in7days) $errorclass = ' row_red';
					if($stoptime <= $now) $errorclass = ' row_blue';
	
					$class = ('alternate' != $class) ? 'alternate' : '';
					$class = ($errorclass != '') ? $errorclass : $class;
					?>
				    <tr class='<?php echo $class; ?>'>
						<th class="check-column"><input type="checkbox" name="adselect[]" value="<?php echo $ad->id; ?>" <?php if(in_array($ad->id, $meta_array)) echo "checked"; ?> /></th>
						<td><center><?php echo $ad->id; ?></center></td>
						<td><?php echo stripslashes(html_entity_decode($ad->title)); ?></td>
						<td><span style="color: <?php echo adrotate_prepare_color($stoptime);?>;"><?php echo date_i18n("F d, Y", $stoptime); ?></span></td>
						<td><center><?php echo $ad->weight; ?></center></td>
						<?php if($adrotate_config['stats'] == 1) {
							if($ad->tracker == 'Y') { ?>
								<td><center><?php echo $stats['impressions']; ?></center></td>
								<td><center><?php echo $stats['clicks']; ?></center></td>
							<?php } else { ?>
								<td><center>&hellip;</center></td>
								<td><center>&hellip;</center></td>
							<?php } ?>
						<?php } ?>
					</tr>
				<?php unset($stats);?>
	 			<?php } ?>
			<?php } else { ?>
			<tr>
				<th class="check-column">&nbsp;</th>
				<td colspan="<?php echo ($adrotate_config['stats'] == 1) ? '6' : '4'; ?>"><em><?php _e('No adverts created!', 'adrotate'); ?></em></td>
			</tr>
			<?php } ?>
			</tbody>					
		</table>
	
		<p><center>
			<span style="border: 1px solid #e6db55; height: 12px; width: 12px; background-color: #ffffe0">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Configuration errors.", "adrotate"); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;<span style="border: 1px solid #c00; height: 12px; width: 12px; background-color: #ffebe8">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Expires soon.", "adrotate"); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;<span style="border: 1px solid #466f82; height: 12px; width: 12px; background-color: #8dcede">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Has expired.", "adrotate"); ?>
		</center></p>
	
		<p class="submit">
			<input tabindex="19" type="submit" name="adrotate_group_submit" class="button-primary" value="<?php _e('Save Group', 'adrotate'); ?>" />
			<a href="admin.php?page=adrotate-groups&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
		</p>
	</form>
<?php
} else {
	echo adrotate_error('error_loading_item');
}
?>
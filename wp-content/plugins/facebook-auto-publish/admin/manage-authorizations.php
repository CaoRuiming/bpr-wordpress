<?php if( !defined('ABSPATH') ){ exit();}?>
<style type="text/css">
.widefat {border: 1px solid #eeeeee!important;
margin: 0px !important;
border-bottom: 3px solid #00a0d2 !important;
margin-bottom:5px;}

.widefat th {border:1px solid #ffffff !important; background-color:#00a0d2; color:#ffffff; margin:0px !important;  padding-top: 12px;
padding-bottom: 12px;
text-align: left;}

.widefat td, .widefat th {
	color:#2f2f2f ; 
	padding: 12px 5px;
	margin: 0px;
}

.widefat tr{ border: 1px solid #ddd;}

.widefat tr:nth-child(even){background-color: #dddddd !important;}

.widefat tr:hover {background-color: #cccccc;}


.delete_auth_entry{background-color: #00a0d2;
border: none;
padding: 5px 10px;
color: #fff;
border-radius: 2px;
outline:0;
}

.delete_auth_entry:hover{background-color:#008282;}

.select_box{display: block;
color:#2f2f2f ;
padding: 10px;
background-color: #ddd;
width: 96.8%;
margin-bottom: 1px;}

</style>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#auth_entries_div').show();
	jQuery("#show_all").attr('checked', true);
		
	jQuery("#show_all").click(function(){
		jQuery('#fbap_manage_auth_table tr:has(td.diff_domain)').show();
		jQuery('#fbap_manage_auth_table tr:has(td.same_domain)').show();
	});
	jQuery("#show_same_domain").click(function(){
		jQuery('#fbap_manage_auth_table tr:has(td.diff_domain)').hide();
		jQuery('#fbap_manage_auth_table tr:has(td.same_domain)').show();
	});
	jQuery("#show_diff_domain").click(function(){
		jQuery('#fbap_manage_auth_table tr:has(td.diff_domain)').show();
		jQuery('#fbap_manage_auth_table tr:has(td.same_domain)').hide();
	});

	jQuery(".delete_auth_entry").off('click').on('click', function() {
	    var auth_id=jQuery(this).attr("data-id");
	    jQuery("#show-del-icon_"+auth_id).hide();
		jQuery("#ajax-save_"+auth_id).show();
		var xyzscripts_user_hash=jQuery(this).attr("data-xyzscripts_hash");
		var xyzscripts_id=jQuery(this).attr("data-xyzscriptsid");

	  	var xyz_fbap_del_entries_nonce= '<?php echo wp_create_nonce('xyz_fbap_del_entries_nonce');?>';
  		var dataString = {
		action: 'xyz_fbap_del_entries',
		auth_id: auth_id ,
		xyzscripts_id: xyzscripts_id,
		xyzscripts_user_hash: xyzscripts_user_hash,
		dataType: 'json',
		_wpnonce: xyz_fbap_del_entries_nonce
	};
		jQuery.post(ajaxurl, dataString ,function(data) {
			jQuery("#ajax-save_"+auth_id).hide();
			 if(data==1)
			       	alert("You do not have sufficient permissions");
			else{
			
				var data=jQuery.parseJSON(data);
				if(data.status==1){
 					jQuery(".tr_"+auth_id).remove();

 					if(jQuery('#system_notice_area').length==0)
 			  			jQuery('body').append('<div class="system_notice_area_style1" id="system_notice_area"></div>');
 			  			jQuery("#system_notice_area").html('Account details successfully deleted from SMAPSolutions&nbsp;&nbsp;&nbsp; <span id="system_notice_area_dismiss">Dismiss</span>');
 			  			jQuery("#system_notice_area").show();
 			  			jQuery('#system_notice_area_dismiss').click(function() {
 			  				jQuery('#system_notice_area').animate({
 			  					opacity : 'hide',
 			  					height : 'hide'
 			  				}, 500);
 			  			});

				}
				else if(data.status==0 )
				{
					jQuery("#show_err_"+auth_id).append(data.msg);
				}
		}

			 
	            });
	  	 });
	
});
</script>
<h3>Manage Authorizations</h3>

<?php
if( !defined('ABSPATH') ){ exit();}
global $wpdb;
$free_plugin_source='fbap';
$domain_name=trim(get_option('siteurl'));
$xyzscripts_hash_val=trim(get_option('xyz_fbap_xyzscripts_hash_val'));
$xyzscripts_user_id=trim(get_option('xyz_fbap_xyzscripts_user_id'));
$manage_auth_parameters=array(
					 'xyzscripts_user_id'=>$xyzscripts_user_id,
				     'free_plugin_source'=>$free_plugin_source,
				   );
$url=XYZ_SMAP_SOLUTION_AUTH_URL.'authorize/manage-authorizations.php';
$content=xyz_fbap_post_to_smap_api($manage_auth_parameters,$url,$xyzscripts_hash_val);
 $result=json_decode($content,true);
if(!empty($result) && isset($result['status']))
{
	if($result['status']==0)
	{
	$er_msg=$result['msg'];
	echo "<div>".$er_msg."</div>";
	}
	else if($result['status']==1){
		$auth_entries=$result['msg'];

	?>
		<div id="auth_entries_div" style="margin-bottom: 5px;">
						<span class="select_box">
						<input type="radio" name="domain_selection" value="0" id="show_all">Show all entries
						<input type="radio" name="domain_selection" value="1" id="show_same_domain">Show entries from current wp installation 
						<input type="radio" name="domain_selection" value="2" id="show_diff_domain">Show entries from other wp installations
						</span>
						<table cellpadding="0" cellspacing="0" class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none;" id="fbap_manage_auth_table">
						<thead>
						<tr class="xyz_smap_manage_auth_th">
						
						<th scope="col" width="8%">Facebook username</th>
						<th scope="col" width="10%">Selected pages</th>
						<th scope="col" width="10%">Selected groups</th>
						<th scope="col" width="10%">WP url</th>
						<th scope="col" width="10%">Plugin</th>
						<th scope="col" width="5%">Account ID (SMAP PREMIUM)</th>
						<th scope="col" width="5%">Action</th>
						</tr>
						</thead> <?php
						
						foreach ($auth_entries as $auth_entries_key => $auth_entries_val)
						{
							?>
							 <tr class="tr_<?php echo $auth_entries_val['auth_id'];?>">
							 	
							 <td><?php  echo $auth_entries_val['fb_username'];?>
							 	</td>
							<?php if(isset($auth_entries_val['pages'])&& !empty($auth_entries_val['pages'])){?>
							 	<td> <?php echo $auth_entries_val['pages'];?> </td>
							 	<?php }else echo "<td> NA </td>";?>
						 		<?php if(isset($auth_entries_val['groups'])&& !empty($auth_entries_val['groups'])){?>
							 	<td> <?php echo $auth_entries_val['groups'];?> </td>
							 	<?php }else echo "<td> NA </td>";?>
							 	<?php 	if($auth_entries_val['domain_name']==$domain_name){?>
							 	<td class='same_domain'> <?php echo $auth_entries_val['domain_name'];?> </td>
							 	<?php }
							 	else{?>
							 	<td class='diff_domain'> <?php echo $auth_entries_val['domain_name'];?> </td>
							 	<?php } ?>
							 	<td> <?php
							 	if($auth_entries_val['free_plugin_source']=='fbap')
							 		echo 'WP2SOCIAL AUTO PUBLISH';
							 		elseif ($auth_entries_val['free_plugin_source']=='smap')
							 		echo 'SOCIAL MEDIA AUTO PUBLISH';
							 		elseif ($auth_entries_val['free_plugin_source']=='pls')
							 		echo 'XYZ WP SMAP PREMIUM PLUS';
							 		else echo 'XYZ-SMAP';
							 		?></td>
							 		<td> <?php if($auth_entries_val['smap_pre_account_id']!=0)echo $auth_entries_val['smap_pre_account_id'];
							 		else echo 'Not Applicable';?> </td>
							 		<td>
							 		<?php if ($domain_name==$auth_entries_val['domain_name'] && $free_plugin_source==$auth_entries_val['free_plugin_source'] ) {
// 							 		$md5_encrypt=md5('smapsolutions'.$xyzscripts_user_id.$xyzscripts_hash_val.$auth_entries_val['auth_id']);
							 		?>
							 		<span id='ajax-save_<?php echo $auth_entries_val['auth_id'];?>' style="display:none;"><img	title="Deleting entry"	src="<?php echo plugins_url("images/ajax-loader.gif",XYZ_FBAP_PLUGIN_FILE);?>" style="width:20px;height:20px; "></span>
							 		<span id='show-del-icon_<?php echo $auth_entries_val['auth_id'];?>'>
							 		<input type="button" class="delete_auth_entry" data-id=<?php echo $auth_entries_val['auth_id'];?> data-xyzscriptsid="<?php echo $xyzscripts_user_id;?>" data-xyzscripts_hash="<?php echo $xyzscripts_hash_val;?>" name='del_entry' value="Delete" >
							 		</span>
							 		<span id='show_err_<?php echo $auth_entries_val['auth_id'];?>' style="color:red;" ></span>
							 		<?php //data-encrypt="<?php echo $md5_encrypt;
							 		?></td>
							 		</tr>
							 		<?php
							 		}
							
							
						}///////////////foreach
					?></table></div><?php 
					
}
}
else { 
	echo "<div>Unable to connect. Please check your curl and firewall settings</div>";
}
?>
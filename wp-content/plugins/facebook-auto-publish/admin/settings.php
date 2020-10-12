<?php
if( !defined('ABSPATH') ){ exit();}
global $current_user;
wp_get_current_user();
$imgpath= plugins_url()."/facebook-auto-publish/images/";
$heimg=$imgpath."support.png";
$ms0="";
$ms1="";
$ms2="";
$ms3="";
$appid='';$appsecret='';
$redirecturl=admin_url('admin.php?page=facebook-auto-publish-settings&auth=1');
$domain_name=$xyzscripts_hash_val=$xyz_fbap_smapsoln_userid=$xyzscripts_user_id=$xyz_smap_licence_key='';
require( dirname( __FILE__ ) . '/authorization.php' );
if(!$_POST && isset($_GET['fbap_notice'])&& $_GET['fbap_notice'] == 'hide')
{
	if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'],'fbap-shw')){
		wp_nonce_ays( 'fbap-shw');
		exit;
	}
	update_option('xyz_fbap_dnt_shw_notice', "hide");
	?>
<style type='text/css'>
#fb_notice_td
{
display:none !important;
}
</style>
<div class="system_notice_area_style1" id="system_notice_area">
Thanks again for using the plugin. We will never show the message again.
 &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}

$erf=0;
if(isset($_POST['fb']))
{
	if (! isset( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'xyz_fbap_fb_settings_form_nonce' )
			) {
				wp_nonce_ays( 'xyz_fbap_fb_settings_form_nonce' );
				exit();
			}
	$ss=array();
	if(isset($_POST['fbap_pages_list']))
	$ss=$_POST['fbap_pages_list'];
	
	$fbap_pages_list_ids="";$xyz_fbap_enforce_og_tags=$xyz_fbap_clear_fb_cache=0;


	if(!empty($ss))//$ss!="" && count($ss)>0
	{
		for($i=0;$i<count($ss);$i++)
		{
			$fbap_pages_list_ids.=$ss[$i].",";
		}

	}
	else
		$fbap_pages_list_ids.=-1;

	$fbap_pages_list_ids=rtrim($fbap_pages_list_ids,',');


	update_option('xyz_fbap_pages_ids',$fbap_pages_list_ids);
	$applidold=get_option('xyz_fbap_application_id');
	$applsecretold=get_option('xyz_fbap_application_secret');
	$posting_method=intval($_POST['xyz_fbap_po_method']);
	$posting_permission=intval($_POST['xyz_fbap_post_permission']);
	$app_name=sanitize_text_field($_POST['xyz_fbap_application_name']);
	$xyz_fbap_app_sel_mode=intval($_POST['xyz_fbap_app_sel_mode']);
	$xyz_fbap_app_sel_mode_old=get_option('xyz_fbap_app_sel_mode');
	if ($xyz_fbap_app_sel_mode==0){
	$appid=sanitize_text_field($_POST['xyz_fbap_application_id']);
	$appsecret=sanitize_text_field($_POST['xyz_fbap_application_secret']);
	}
	$xyz_fbap_enforce_og_tags=intval($_POST['xyz_fbap_enforce_og_tags']);
	$xyz_fbap_clear_fb_cache=intval($_POST['xyz_fbap_clear_fb_cache']);
	$messagetopost=$_POST['xyz_fbap_message'];
	if($app_name=="" && $posting_permission==1)
	{
		$ms0="Please fill facebook application name.";
		$erf=1;
	}
	else if($appid=="" && $posting_permission==1 && $xyz_fbap_app_sel_mode==0)
	{
		$ms1="Please fill facebook application id.";
		$erf=1;
	}
	elseif($appsecret=="" && $posting_permission==1 && $xyz_fbap_app_sel_mode==0)
	{
		$ms2="Please fill facebook application secret.";
		$erf=1;
	}
	else
	{
		$erf=0;
		if(($appid!=$applidold || $appsecret!=$applsecretold)&& $xyz_fbap_app_sel_mode==0)
		{
			update_option('xyz_fbap_af',1);
			update_option('xyz_fbap_fb_token','');
		}
		else if ($xyz_fbap_app_sel_mode_old != $xyz_fbap_app_sel_mode)
		{
			update_option('xyz_fbap_af',1);
			update_option('xyz_fbap_fb_token','');
		//	update_option('xyz_fbap_secret_key','');
			update_option('xyz_fbap_page_names','');
		}
		update_option('xyz_fbap_application_name',$app_name);
		if ($xyz_fbap_app_sel_mode==0){
		update_option('xyz_fbap_application_id',$appid);
		update_option('xyz_fbap_application_secret',$appsecret);
		}
		update_option('xyz_fbap_post_permission',$posting_permission);
		update_option('xyz_fbap_app_sel_mode',$xyz_fbap_app_sel_mode);
		update_option('xyz_fbap_po_method',$posting_method);
		update_option('xyz_fbap_message',$messagetopost);
		update_option('xyz_fbap_enforce_og_tags', $xyz_fbap_enforce_og_tags);
		update_option('xyz_fbap_clear_fb_cache', $xyz_fbap_clear_fb_cache);
	}
}
if(isset($_POST['fb']) && $erf==0)
{
	?>
<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php }
if(isset($_GET['msg']) && $_GET['msg']==2)
{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	The state does not match. You may be a victim of CSRF. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
	<?php 
}
if(isset($_GET['msg']) && $_GET['msg']==3)
{
	?>
<div class="system_notice_area_style0" id="system_notice_area">
Unable to authorize the facebook application. Please check your curl/fopen and firewall settings. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>	
<?php 
}
if(isset($_GET['msg']) && $_GET['msg']==4)
{
	?>
<div class="system_notice_area_style1" id="system_notice_area">
Successfully connected to xyzscripts member area. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>	
<?php 
}
if(isset($_GET['msg']) && $_GET['msg']==5)
{
	?>
<div class="system_notice_area_style1" id="system_notice_area">
Selected pages saved successfully. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>	
<?php 
}

if(isset($_POST['fb']) && $erf==1)
{
	?>
<div class="system_notice_area_style0" id="system_notice_area">
	<?php 
	if(isset($_POST['fb']))
	{
		echo esc_html($ms0);echo esc_html($ms1);echo esc_html($ms2);echo esc_html($ms3);
	}
	?>
	&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php } ?>
<script type="text/javascript">
function detdisplay_fbap(id)
{
	document.getElementById(id).style.display='';
}
function dethide_fbap(id)
{
	document.getElementById(id).style.display='none';
}
</script>

<div style="width: 100%">
<div class="xyz_fbap_tab">
  <button class="xyz_fbap_tablinks" onclick="xyz_fbap_open_tab(event, 'xyz_fbap_facebook_settings')" id="xyz_fbap_default_tab_settings">Facebook Settings</button>
   <button class="xyz_fbap_tablinks" onclick="xyz_fbap_open_tab(event, 'xyz_fbap_basic_settings')" id="xyz_fbap_basic_tab_settings">General Settings</button>
</div>
<div id="xyz_fbap_facebook_settings" class="xyz_fbap_tabcontent">

	<?php
	$af=get_option('xyz_fbap_af');
	$appid=get_option('xyz_fbap_application_id');
	$appsecret=get_option('xyz_fbap_application_secret');
	//$fbid=esc_html(get_option('xyz_fbap_fb_id'));
	$posting_method=get_option('xyz_fbap_po_method');
	$posting_message=esc_textarea(get_option('xyz_fbap_message'));
 	if(get_option('xyz_fbap_app_sel_mode')==0)
 	{
	if($af==1 && $appid!="" && $appsecret!="")
	{
		?>
		<span style="color: red;" id="auth_message" >Application needs authorisation</span> <br>
	<form method="post">
     <?php wp_nonce_field( 'xyz_fbap_fb_auth_nonce' );?>
		<input type="submit" class="submit_fbap_new" name="fb_auth"
			value="Authorize" /><br><br>

	</form>
	<?php }
	else if($af==0 && $appid!="" && $appsecret!="")
	{
		?>
	<form method="post">
	<?php wp_nonce_field( 'xyz_fbap_fb_auth_nonce' );?>
	<input type="submit" class="submit_fbap_new" name="fb_auth"
	value="Reauthorize" title="Reauthorize the account" /><br><br>
	
	</form>
	<?php }
 	}
 	elseif (get_option('xyz_fbap_app_sel_mode')==1){//add trim
 		$domain_name=trim(get_option('siteurl'));
 		$xyz_fbap_smapsoln_userid=intval(trim(get_option('xyz_fbap_smapsoln_userid')));
 		$xyzscripts_hash_val=trim(get_option('xyz_fbap_xyzscripts_hash_val'));
 		$xyzscripts_user_id=trim(get_option('xyz_fbap_xyzscripts_user_id'));
 		$xyz_smap_accountId=0;
 		$xyz_smap_licence_key='';
 		$request_hash=md5($xyzscripts_user_id.$xyzscripts_hash_val);
 		$auth_secret_key=md5('smapsolutions'.$domain_name.$xyz_smap_accountId.$xyz_fbap_smapsoln_userid.$xyzscripts_user_id.$request_hash.$xyz_smap_licence_key.'fbap');
 		if($af==1 )
 		{
 			?>
 			<span id='ajax-save' style="display:none;"><img	class="img"  title="Saving details"	src="<?php echo plugins_url('../images/ajax-loader.gif',__FILE__);?>" style="width:65px;height:70px; "></span>
 			<span id="auth_message">
 				<span style="color: red;" >Application needs authorisation</span> <br>
 				<form method="post">
 			     <?php wp_nonce_field( 'xyz_fbap_fb_auth_nonce' );?>
 			     <input type="hidden" value="<?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?>" id="parent_domain">
 					<input type="submit" class="submit_fbap_new" name="fb_auth"
 						value="Authorize" onclick="javascript:return fbap_popup_fb_auth('<?php echo urlencode($domain_name);?>','<?php echo $xyz_fbap_smapsoln_userid;?>','<?php echo $xyzscripts_user_id;?>','<?php echo $xyzscripts_hash_val;?>','<?php echo $auth_secret_key;?>','<?php echo $request_hash;?>');void(0);"/><br><br>
 				</form></span>
 				<?php }
 				else if($af==0 )
 				{
 					?>
 					<span id='ajax-save' style="display:none;"><img	class="img"  title="Saving details"	src="<?php echo plugins_url('../images/ajax-loader.gif',__FILE__);?>" style="width:65px;height:70px; "></span>
 				<form method="post" id="re_auth_message">
 				<?php wp_nonce_field( 'xyz_fbap_fb_auth_nonce' );?>
 				<input type="hidden" value="<?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?>" id="parent_domain">
 				<input type="submit" class="submit_fbap_new" name="fb_auth"
 				value="Reauthorize" title="Reauthorize the account" onclick="javascript:return fbap_popup_fb_auth('<?php echo urlencode($domain_name);?>','<?php echo $xyz_fbap_smapsoln_userid;?>','<?php echo $xyzscripts_user_id;?>','<?php echo $xyzscripts_hash_val;?>','<?php echo $auth_secret_key;?>','<?php echo $request_hash;?>');void(0);"/><br><br>
 				</form>
 				<?php }
 	}
	if(isset($_GET['auth']) && $_GET['auth']==1 && get_option("xyz_fbap_fb_token")!="")
	{
		?>
	<span style="color: green;">Application is authorized, go posting.
	</span><br>

	<?php 	
	}
	?>
	<table class="widefat" style="width: 99%;background-color: #FFFBCC" id="xyz_fbap_app_creation_note">
	<tr>
	<td id="bottomBorderNone" style="border: 1px solid #FCC328;">
	
	<div>
		<b>Note :</b> You have to create a Facebook application before filling the following details.
		<b><a href="https://developers.facebook.com/apps" target="_blank">Click here</a></b> to create new Facebook application. 
		<br>In the application page in facebook, navigate to <b>Apps >Add Product > Facebook Login >Quickstart >Web > Site URL</b>. Set the site url as : 
		<span style="color: red;"><?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?></span>
		<br>And then navigate to <b>Apps > Facebook Login > Settings</b>. Set the Valid OAuth redirect URIs as :<br>
		<span style="color: red;"><?php echo $redirecturl; ?></span>
		<br>For detailed step by step instructions <b><a href="http://help.xyzscripts.com/docs/social-media-auto-publish/faq/how-can-i-create-facebook-application/" target="_blank">Click here</a></b>.
	</div>

	</td>
	</tr>
	</table>
	
	<form method="post">
	<?php wp_nonce_field( 'xyz_fbap_fb_settings_form_nonce' );?>
	
		<input type="hidden" value="config">

			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat xyz_fbap_widefat_table" style="width: 99%">
			<tr valign="top">
				<td>Enable auto publish post to my facebook account
				</td>
				<td  class="switch-field">
					<label id="xyz_fbap_post_permission_yes"><input type="radio" name="xyz_fbap_post_permission" value="1" <?php  if(get_option('xyz_fbap_post_permission')==1) echo 'checked';?>/>Yes</label>
					<label id="xyz_fbap_post_permission_no"><input type="radio" name="xyz_fbap_post_permission" value="0" <?php  if(get_option('xyz_fbap_post_permission')==0) echo 'checked';?>/>No</label>
				</td>
			</tr>
			
			<tr valign="top">
					<td width="50%">Application name
					<br/><span style="color: #0073aa;">[This is for tracking purpose]</span>
					</td>
					<td><input id="xyz_fbap_application_name"
						name="xyz_fbap_application_name" type="text"
						value="<?php if($ms0=="") {echo esc_html(get_option('xyz_fbap_application_name'));}?>" />
					</td>
				</tr>
				<tr valign="top">
			<td width="50%">Application Selection
			</td>
				<td>
				<input type="radio" name="xyz_fbap_app_sel_mode" id="xyz_fbap_app_sel_mode_reviewd" value="0" <?php if(get_option('xyz_fbap_app_sel_mode')==0) echo 'checked';?>>
				<span style="color: #a7a7a7;font-weight: bold;">Own App ( requires app submission and Facebook review -<a href="http://help.xyzscripts.com/docs/social-media-auto-publish/faq/how-can-i-create-facebook-application/" style="color: #a7a7a7;text-decoration: underline; " target="_blank" >Help</a>)</span>
				<br/>
				<div class="xyz_fbap_facebook_settings" style="display: none;" onmouseover="detdisplay_fbap('xyz_fbap_app_review')" onmouseout="dethide_fbap('xyz_fbap_app_review')"><span style="padding-left: 25px;color: #0073aa;">App approval service available for 50 USD
				</span><br/>
				<div id="xyz_fbap_app_review" class="fbap_informationdiv" style="display: none;width: 400px;">
				<b>Expected time frame:</b><br/>30 days<br/>
				<b>Required details:</b><br/>1. WordPress login<br/>
				2. Admin access to Facebook developer app for review submission (temporary).<br/>
				For more details contact <a href="https://xyzscripts.com/support/" target="_blank" >Support Desk</a> .
				</div>
				</div><br/>
				<input type="radio" name="xyz_fbap_app_sel_mode" id="xyz_fbap_app_sel_mode_xyzapp" value="1" <?php if(get_option('xyz_fbap_app_sel_mode')==1) echo 'checked';?>>
				<span style="color: #000000;font-size: 13px;background-color: #f7a676;font-weight: 500;padding: 3px 5px;"><i class="fa fa-star-o" aria-hidden="true" style="margin-right:5px;"></i>SMAPsolution.com's App ( ready to publish )<i class="fa fa-star-o" aria-hidden="true" style="margin-right:5px;"></i></span><br> <span style="padding-left: 25px;">Starts from 10 USD per year</span><br>
				<?php if(get_option('xyz_fbap_smapsoln_userid')==0)
				{?>
				<span style="color: #ff5e00;padding-left: 27px;font-size: small;"><b>30 DAYS FREE TRIAL AVAILABLE *</b></span>
				<br/>
				<?php }?>
				<a target="_blank" href="https://help.xyzscripts.com/docs/social-media-auto-publish/faq/how-can-i-use-the-alternate-solution-for-publishing-posts-to-facebook/" style="padding-left: 30px;">How to use smapsolution.com's application?</a>
				</td>
			</tr>
			<?php 
			if($xyzscripts_user_id =='' || $xyzscripts_hash_val=='' && $xyz_fbap_app_sel_mode==1)
			{  ?>
			<tr valign="top" id="xyz_fbap_conn_to_xyzscripts">
			<td width="50%">	</td>
			<td width="50%">
			<span id='ajax-save-xyzscript_acc' style="display:none;"><img	class="img"  title="Saving details"	src="<?php echo plugins_url('../images/ajax-loader.gif',__FILE__);?>" style="width:65px;height:70px; "></span>
			<span id="connect_to_xyzscripts"style="background-color: #1A87B9;color: white; padding: 4px 5px;text-align: center; text-decoration: none;   display: inline-block;border-radius: 4px;">
			<a href="javascript:fbap_popup_connect_to_xyzscripts();void(0);" style="color:white !important;">Connect your xyzscripts account</a>
			</span>
			</td>
			</tr>
			<?php }?>
				<tr valign="top" class="xyz_fbap_facebook_settings">
					<td width="50%">Application id
					</td>
					<td><input id="xyz_fbap_application_id"
						name="xyz_fbap_application_id" type="text"
						value="<?php if($ms1=="") {echo esc_html(get_option('xyz_fbap_application_id'));}?>" />
					</td>
				</tr>

				<tr valign="top" class="xyz_fbap_facebook_settings">
					<td>Application secret<?php   $apsecret=esc_html(get_option('xyz_fbap_application_secret'));?>
						
					</td>
					<td><input id="xyz_fbap_application_secret"
						name="xyz_fbap_application_secret" type="text"
						value="<?php if($ms2=="") {echo $apsecret; }?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<td>Posting method
					<br/><span style="color: #0073aa;">[Create app album(with <b>Application name</b>) in the Facebook pages,<br/>if you are using the posting method <b>Upload image to app album</b>]</span>
					</td>
					<td>
					<select id="xyz_fbap_po_method" name="xyz_fbap_po_method">
							<option value="3"
				<?php  if(get_option('xyz_fbap_po_method')==3) echo 'selected';?>>Simple text message</option>
				
				<optgroup label="Text message with image">
					<option value="4"
					<?php  if(get_option('xyz_fbap_po_method')==4) echo 'selected';?>>Upload image to app album</option>
					<option value="5"
					<?php  if(get_option('xyz_fbap_po_method')==5) echo 'selected';?>>Upload image to timeline album</option>
				</optgroup>
				
				<optgroup label="Text message with attached link">
					<option value="1"
					<?php  if(get_option('xyz_fbap_po_method')==1) echo 'selected';?>>Attach
						your blog post</option>
					<option value="2"
					<?php  if(get_option('xyz_fbap_po_method')==2) echo 'selected';?>>
						Share a link to your blog post</option>
					</optgroup>
					</select>
					</td>
				</tr>
				<tr valign="top">
					<td>Enforce og tags for Facebook<img src="<?php echo $heimg?>" onmouseover="detdisplay_fbap('xyz_fbap_enforce_og')" onmouseout="dethide_fbap('xyz_fbap_enforce_og')" style="width:13px;height:auto;">
					<div id="xyz_fbap_enforce_og" class="fbap_informationdiv" style="display: none;width: 400px;">
					If you enable, Open Graph tags will be generated while posting to Facebook, when using the posting method <b>Share a link to your blog post</b> or <b>Attach your blog post</b> .
					</div>
					</td>
					<td  class="switch-field">
						<label id="xyz_fbap_enforce_og_tags_yes" class="xyz_fbap_toggle_off"><input type="radio" name="xyz_fbap_enforce_og_tags" value="1" <?php  if(get_option('xyz_fbap_enforce_og_tags')==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_fbap_enforce_og_tags_no" class="xyz_fbap_toggle_on"><input type="radio" name="xyz_fbap_enforce_og_tags" value="0" <?php  if(get_option('xyz_fbap_enforce_og_tags')==0) echo 'checked';?>/>No</label>
					</td>
				</tr>
				
				<tr valign="top">
					<td>Clear facebook cache before publishing to facebook</td>
					<td  class="switch-field">
						<label id="xyz_fbap_clear_fb_cache_yes" class="xyz_fbap_toggle_off"><input type="radio" name="xyz_fbap_clear_fb_cache" value="1" <?php  if(get_option('xyz_fbap_clear_fb_cache')==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_fbap_clear_fb_cache_no" class="xyz_fbap_toggle_on"><input type="radio" name="xyz_fbap_clear_fb_cache" value="0" <?php  if(get_option('xyz_fbap_clear_fb_cache')==0) echo 'checked';?>/>No</label>
					</td>
				</tr>
				<tr valign="top">
					<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay_fbap('xyz_fb')" onmouseout="dethide_fbap('xyz_fb')" style="width:13px;height:auto;">
						<div id="xyz_fb" class="fbap_informationdiv" style="display: none;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.<br />{POST_ID} - Insert the ID of your post.
							<br />{POST_PUBLISH_DATE} - Insert the publish date of your post.
							<br />{USER_DISPLAY_NAME} - Insert the display name of the author.
						</div><br/><span style="color: #0073aa;">[Optional in the case of <b>Text message with attached link</b><br/> or <b>Text message with image</b> posting methods]</span></td>
					<td>
					<select name="xyz_fbap_info" id="xyz_fbap_info" onchange="xyz_fbap_info_insert(this)">
						<option value ="0" selected="selected">--Select--</option>
						<option value ="1">{POST_TITLE}  </option>
						<option value ="2">{PERMALINK} </option>
						<option value ="3">{POST_EXCERPT}  </option>
						<option value ="4">{POST_CONTENT}   </option>
						<option value ="5">{BLOG_TITLE}   </option>
						<option value ="6">{USER_NICENAME}   </option>
						<option value ="7">{POST_ID}   </option>
						<option value ="8">{POST_PUBLISH_DATE}   </option>
						<option value= "9">{USER_DISPLAY_NAME}</option>
						</select> </td></tr><tr><td>&nbsp;</td><td>
						<textarea id="xyz_fbap_message"  name="xyz_fbap_message" style="height:80px !important;" ><?php 
												echo esc_textarea(get_option('xyz_fbap_message'));?></textarea>
					</td></tr>
				<?php 
				$xyz_acces_token=get_option('xyz_fbap_fb_token');
				if($xyz_acces_token!="" && get_option('xyz_fbap_app_sel_mode')==0){

					$offset=0;$limit=100;$data=array();
					do
					{
						$result1="";$pagearray1="";
						$pp=wp_remote_get("https://graph.facebook.com/".XYZ_FBAP_FB_API_VERSION."/me/accounts?access_token=$xyz_acces_token&limit=$limit&offset=$offset",array('sslverify'=> (get_option('xyz_fbap_peer_verification')=='1') ? true : false));
					
						if(is_array($pp))
						{
							$result1=$pp['body'];
							$pagearray1 = json_decode($result1);
							if(is_array($pagearray1->data)) 
							$data = array_merge($data, $pagearray1->data);
						}
						else
							break;
						$offset += $limit;
// 						if(!is_array($pagearray1->paging))
// 							break;
// 					}while(array_key_exists("next", $pagearray1->paging));
					}while(isset($pagearray1->paging->next));
					$count=0;
					if (!empty($data))
					$count=count($data);
						$fbap_pages_ids1=get_option('xyz_fbap_pages_ids');
						$fbap_pages_ids0=array();
						if($fbap_pages_ids1!="")
							$fbap_pages_ids0=explode(",",$fbap_pages_ids1);
						
						$fbap_pages_ids=array();
						if (!empty($fbap_pages_ids0)){
						for($i=0;$i<count($fbap_pages_ids0);$i++)
						{
							if($fbap_pages_ids0[$i]!="-1")
							$fbap_pages_ids[$i]=trim(substr($fbap_pages_ids0[$i],0,strpos($fbap_pages_ids0[$i],"-")));
						    else
							$fbap_pages_ids[$i]=$fbap_pages_ids0[$i];
						}}
						
					//$data[$i]->id."-".$data[$i]->access_token
						?>

<tr valign="top"><td>
		Select facebook pages for auto publish 
	</td>
	<td>
	
	<div class="scroll_checkbox">
	<input type="checkbox" id="select_all_pages" >Select All

	<?php 
	for($i=0;$i<$count;$i++)
	{
          $pgid=$data[$i]->id;
		$page_name[$pgid]=$data[$i]->name;
	?>
	<br><input type="checkbox" class="selpages" name="fbap_pages_list[]"  value="<?php  echo $data[$i]->id."-".$data[$i]->access_token;?>" <?php if(in_array($data[$i]->id, $fbap_pages_ids)) echo "checked" ?>><?php echo $data[$i]->name; ?>
	<?php }
	//	$page_name=base64_encode(serialize($page_name));?>
	</div>
		</td></tr>
				<?php 
				}elseif (get_option('xyz_fbap_app_sel_mode')==1)// &&pagelist frm smap solutions is not empty )
				{
				    $xyz_fbap_page_names=stripslashes(get_option('xyz_fbap_page_names'));
				    $xyz_fbap_secret_key=get_option('xyz_fbap_secret_key');
				    ?>
				<tr id="xyz_fbap_selected_pages_tr" style="<?php if($xyz_fbap_page_names=='')echo "display:none;";?>">
				<td>Selected facebook pages for auto publish</td>
				<td><div>
				<div class="scroll_checkbox" id="xyz_fbap_selected_pages" style="float: left;">
				<?php
				if($xyz_fbap_page_names!=''){
					$xyz_fbap_page_names_array=json_decode($xyz_fbap_page_names);
					foreach ($xyz_fbap_page_names_array as $sel_pageid=>$sel_pagename)
					{
					?>
				 <input type="checkbox" class="selpages" name="fbap_pages_list[]"  value="<?php echo $sel_pageid;?>" disabled checked="checked"><?php echo $sel_pagename; ?><br>
					<?php }}
				?>
				</div>
				<div style="float: left;width: 10px;color: #ce5c19;font-size: 20px;">*</div>
				</div>
			
				</td>
				</tr>
		<?php }
				?>
				<tr><td   id="bottomBorderNone"></td>
					<td  id="bottomBorderNone"><div style="height: 50px;">
							<input type="submit" class="submit_fbap_new"
								style=" margin-top: 10px; "
								name="fb" value="Save" /></div>
					</td>
				</tr>
				<?php if(get_option('xyz_fbap_smapsoln_userid')==0){?>
				<tr><td style='color: #ce5c19;padding-left:0px;'>*Free trial is available only for first time users</td></tr>
				<?php }
				else{?>
				<tr><td style='color: #ce5c19;padding-left:0px;'>*Use reauthorize button to change selected values</td></tr>
				<?php }?>
			</table>
	</form>
	</div>

	<?php 

	if(isset($_POST['bsettngs']))
	{
		if (! isset( $_REQUEST['_wpnonce'] )
				|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'xyz_fbap_basic_settings_form_nonce' )
				) {
					wp_nonce_ays( 'xyz_fbap_basic_settings_form_nonce' );
					exit();
				}
		$xyz_fbap_include_pages=intval($_POST['xyz_fbap_include_pages']);
		$xyz_fbap_include_posts=intval($_POST['xyz_fbap_include_posts']);
		
		if($_POST['xyz_fbap_cat_all']=="All")
			$fbap_category_ids=$_POST['xyz_fbap_cat_all'];//radio btn name
		else if (isset($_POST['xyz_fbap_catlist']))
		{
			$fbap_category_ids=$_POST['xyz_fbap_catlist'];//dropdown
			$fbap_category_ids=implode(',', $fbap_category_ids);
		}
		
		$xyz_customtypes="";
        if(isset($_POST['post_types']))
		$xyz_customtypes=$_POST['post_types'];

        $xyz_fbap_peer_verification=intval($_POST['xyz_fbap_peer_verification']);
        $xyz_fbap_premium_version_ads=intval($_POST['xyz_fbap_premium_version_ads']);
        $xyz_fbap_default_selection_edit=intval($_POST['xyz_fbap_default_selection_edit']);
// 	    $xyz_fbap_utf_decode_enable=intval($_POST['xyz_fbap_utf_decode_enable']);
		$fbap_customtype_ids="";
		$xyz_fbap_applyfilters="";
		if(isset($_POST['xyz_fbap_applyfilters']))
			$xyz_fbap_applyfilters=$_POST['xyz_fbap_applyfilters'];
		
		
		if($xyz_customtypes!="")
		{
			for($i=0;$i<count($xyz_customtypes);$i++)
			{
				$fbap_customtype_ids.=$xyz_customtypes[$i].",";
			}
		}
		$fbap_customtype_ids=rtrim($fbap_customtype_ids,',');

		$xyz_fbap_applyfilters_val="";
		if($xyz_fbap_applyfilters!="")
		{
			for($i=0;$i<count($xyz_fbap_applyfilters);$i++)
			{
				$xyz_fbap_applyfilters_val.=$xyz_fbap_applyfilters[$i].",";
			}
		}
		$xyz_fbap_applyfilters_val=rtrim($xyz_fbap_applyfilters_val,',');
		
		update_option('xyz_fbap_apply_filters',$xyz_fbap_applyfilters_val);
		update_option('xyz_fbap_include_pages',$xyz_fbap_include_pages);
		update_option('xyz_fbap_include_posts',$xyz_fbap_include_posts);
		if($xyz_fbap_include_posts==0)
			update_option('xyz_fbap_include_categories',"All");
		else
			update_option('xyz_fbap_include_categories',$fbap_category_ids);
		update_option('xyz_fbap_include_customposttypes',$fbap_customtype_ids);
		update_option('xyz_fbap_peer_verification',$xyz_fbap_peer_verification);
		update_option('xyz_fbap_premium_version_ads',$xyz_fbap_premium_version_ads);
		update_option('xyz_fbap_default_selection_edit',$xyz_fbap_default_selection_edit);
// 		update_option('xyz_fbap_utf_decode_enable',$xyz_fbap_utf_decode_enable);
	}
	$xyz_credit_link=get_option('xyz_credit_link');
	$xyz_fbap_include_pages=get_option('xyz_fbap_include_pages');
	$xyz_fbap_include_posts=get_option('xyz_fbap_include_posts');
	$xyz_fbap_include_categories=get_option('xyz_fbap_include_categories');
	if ($xyz_fbap_include_categories!='All')
	$xyz_fbap_include_categories=explode(',', $xyz_fbap_include_categories);
	$xyz_fbap_include_customposttypes=get_option('xyz_fbap_include_customposttypes');
	$xyz_fbap_apply_filters=get_option('xyz_fbap_apply_filters');
	$xyz_fbap_peer_verification=get_option('xyz_fbap_peer_verification');
	$xyz_fbap_premium_version_ads=get_option('xyz_fbap_premium_version_ads');
	$xyz_fbap_default_selection_edit=get_option('xyz_fbap_default_selection_edit');
// 	$xyz_fbap_utf_decode_enable=get_option('xyz_fbap_utf_decode_enable');
	?>
<div id="xyz_fbap_basic_settings" class="xyz_fbap_tabcontent">
		<form method="post">
<?php wp_nonce_field( 'xyz_fbap_basic_settings_form_nonce' );?>
			<table class="widefat xyz_fbap_widefat_table" style="width: 99%">
<tr><td><h2>Basic Settings</h2></td></tr>
				<tr valign="top">
					<td  colspan="1">Publish wordpress `posts` to facebook
					</td>
					<td  class="switch-field">
					<label id="xyz_fbap_include_posts_yes"><input type="radio" name="xyz_fbap_include_posts" value="1" <?php  if($xyz_fbap_include_posts==1) echo 'checked';?>/>Yes</label>
					<label id="xyz_fbap_include_posts_no"><input type="radio" name="xyz_fbap_include_posts" value="0" <?php  if($xyz_fbap_include_posts==0) echo 'checked';?>/>No</label>
					</td>				
				</tr>
				
				<tr valign="top">
					<td  colspan="1" width="50%">Publish wordpress `pages` to facebook
					</td>
					<td  class="switch-field">
						<label id="xyz_fbap_include_pages_yes"><input type="radio" name="xyz_fbap_include_pages" value="1" <?php  if($xyz_fbap_include_pages==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_fbap_include_pages_no"><input type="radio" name="xyz_fbap_include_pages" value="0" <?php  if($xyz_fbap_include_pages==0) echo 'checked';?>/>No</label>
					</td>
				</tr>
				
				<?php 
				$xyz_fbap_hide_custompost_settings='';
					$args=array(
							'public'   => true,
							'_builtin' => false
					);
					$output = 'names'; // names or objects, note names is the default
					$operator = 'and'; // 'and' or 'or'
					$post_types=get_post_types($args,$output,$operator);

					$ar1=explode(",",$xyz_fbap_include_customposttypes);
					$cnt=count($post_types);
					if($cnt==0){
						$xyz_fbap_hide_custompost_settings = 'style="display: none;"';//echo 'NA';
					}
					?>
					<tr valign="top" <?php echo $xyz_fbap_hide_custompost_settings;?>>
					<td  colspan="1">Select wordpress custom post types for auto publish</td>
					<td>	<?php 	foreach ($post_types  as $post_type ) {

						echo '<input type="checkbox" name="post_types[]" value="'.$post_type.'" ';
						if(in_array($post_type, $ar1))
						{
							echo 'checked="checked"/>';
						}
						else
							echo '/>';

						echo $post_type.'<br/>';

					}?>
					</td>
				</tr>
				<tr><td><h2>Advanced Settings</h2>	</td></tr>
				<tr valign="top" id="selPostCat">
					<td  colspan="1">Select post categories for auto publish
					</td>
					<td class="switch-field">
	                <input type="hidden" value="<?php echo esc_html($xyz_fbap_include_categories);?>" name="xyz_fbap_sel_cat" id="xyz_fbap_sel_cat"> 
					<label id="xyz_fbap_include_categories_no">
					<input type="radio"	name="xyz_fbap_cat_all" id="xyz_fbap_cat_all" value="All" onchange="rd_cat_chn(1,-1)" <?php if($xyz_fbap_include_categories=="All") echo "checked"?>>All<font style="padding-left: 10px;"></font></label>
					<label id="xyz_fbap_include_categories_yes">
					<input type="radio"	name="xyz_fbap_cat_all" id="xyz_fbap_cat_all" value=""	onchange="rd_cat_chn(1,1)" <?php if($xyz_fbap_include_categories!="All") echo "checked"?>>Specific</label>
					<br /> <br /> <div class="scroll_checkbox"  id="cat_dropdown_span">
					<?php 
					$args = array(
							'show_option_all'    => '',
							'show_option_none'   => '',
							'orderby'            => 'name',
							'order'              => 'ASC',
							'show_last_update'   => 0,
							'show_count'         => 0,
							'hide_empty'         => 0,
							'child_of'           => 0,
							'exclude'            => '',
							'echo'               => 0,
							'selected'           => '1 3',
							'hierarchical'       => 1,
							'id'                 => 'xyz_fbap_catlist',
							'class'              => 'postform',
							'depth'              => 0,
							'tab_index'          => 0,
							'taxonomy'           => 'category' );

					if(count(get_categories($args))>0)
					{
						$fbap_categories=get_categories($args);
						foreach ($fbap_categories as $fbap_cat)
						{
							$cat_id[]=$fbap_cat->cat_ID;
							$cat_name[]=$fbap_cat->cat_name;
							?>
							<input type="checkbox" name="xyz_fbap_catlist[]"  value="<?php  echo $fbap_cat->cat_ID;?>" <?php  if(is_array($xyz_fbap_include_categories)) { if(in_array($fbap_cat->cat_ID, $xyz_fbap_include_categories)) echo "checked";} ?>/><?php echo $fbap_cat->cat_name; ?>
							<br/><?php }
					}
					else
						echo "NIL";
					?><br /> <br /> </div>
				</td>
				</tr>
				<tr valign="top">
					<td scope="row" colspan="1" width="50%">Auto publish on editing posts/pages/custom post types
					</td>
					<td >
						<input type="radio" name="xyz_fbap_default_selection_edit" value="1" <?php  if($xyz_fbap_default_selection_edit==1) echo 'checked';?>/>Enabled<br/>
						<input type="radio" name="xyz_fbap_default_selection_edit" value="0" <?php  if($xyz_fbap_default_selection_edit==0) echo 'checked';?>/>Disabled<br/>
						<input type="radio" name="xyz_fbap_default_selection_edit" value="2" <?php  if($xyz_fbap_default_selection_edit==2) echo 'checked';?>/>Use settings from post creation or post updation
					</td>
				</tr>
					
				<tr valign="top">
				<td scope="row" colspan="1" width="50%">Enable SSL peer verification in remote requests</td>
				<td  class="switch-field">
					<label id="xyz_fbap_peer_verification_yes"><input type="radio" name="xyz_fbap_peer_verification" value="1" <?php  if($xyz_fbap_peer_verification==1) echo 'checked';?>/>Yes</label>
					<label id="xyz_fbap_peer_verification_no"><input type="radio" name="xyz_fbap_peer_verification" value="0" <?php  if($xyz_fbap_peer_verification==0) echo 'checked';?>/>No</label>
				</td>
				</tr>
					
				<tr valign="top">
					<td scope="row" colspan="1">Apply filters during publishing	</td>
					<td>
					<?php 
					$ar2=explode(",",$xyz_fbap_apply_filters);
					for ($i=0;$i<3;$i++ ) {
						$filVal=$i+1;
						
						if($filVal==1)
							$filName='the_content';
						else if($filVal==2)
							$filName='the_excerpt';
						else if($filVal==3)
							$filName='the_title';
						else $filName='';
						
						echo '<input type="checkbox" name="xyz_fbap_applyfilters[]"  value="'.$filVal.'" ';
						if(in_array($filVal, $ar2))
						{
							echo 'checked="checked"/>';
						}
						else
							echo '/>';
					
						echo '<label>'.$filName.'</label><br/>';
					
					}
					?>
					</td>
				</tr>	
			<!--  	<tr valign="top">

					<td scope="row" colspan="1" width="50%">Enable utf-8 decoding before publishing </td>
					<td  class="switch-field">
					<label id="xyz_fbap_utf_decode_enable_yes"><input type="radio" name="xyz_fbap_utf_decode_enable" value="1" <?php  //if($xyz_fbap_utf_decode_enable==1) echo 'checked';?>/>Yes</label>
					<label id="xyz_fbap_utf_decode_enable_no"><input type="radio" name="xyz_fbap_utf_decode_enable" value="0" <?php  //if($xyz_fbap_utf_decode_enable==0) echo 'checked';?>/>No</label>
					</td>
				</tr>	-->
				<tr><td><h2>Other Settings</h2>	</td></tr>
				<tr valign="top">

					<td  colspan="1">Enable credit link to author
					</td>
					<td  class="switch-field">
					<label id="xyz_credit_link_yes"><input type="radio" name="xyz_credit_link" value="fbap" <?php  if($xyz_credit_link=='fbap') echo 'checked';?>/>Yes</label>
					<label id="xyz_credit_link_no"><input type="radio" name="xyz_credit_link" value="<?php echo $xyz_credit_link!='fbap'?$xyz_credit_link:0;?>" <?php  if($xyz_credit_link!='fbap') echo 'checked';?>/>No</label>
					</td>
				</tr>
				
				<tr valign="top">
					<td  colspan="1">Enable premium version ads
					</td>
					<td  class="switch-field">
					<label id="xyz_fbap_premium_version_ads_yes"><input type="radio" name="xyz_fbap_premium_version_ads" value="1" <?php  if($xyz_fbap_premium_version_ads==1) echo 'checked';?>/>Yes</label>
					<label id="xyz_fbap_premium_version_ads_no"><input type="radio" name="xyz_fbap_premium_version_ads" value="0" <?php  if($xyz_fbap_premium_version_ads==0) echo 'checked';?>/>No</label>
			
					</td>
				</tr>
				<tr>
					<td id="bottomBorderNone">
					</td>

					
<td id="bottomBorderNone"><div style="height: 50px;">
<input type="submit" class="submit_fbap_new" style="margin-top: 10px;" value=" Update Settings" name="bsettngs" /></div></td>
				</tr>
				
			</table>
		</form>
		
		</div>	
		
		
		
</div>		
<?php if (is_array($xyz_fbap_include_categories))
$xyz_fbap_include_categories1=implode(',', $xyz_fbap_include_categories);
else 
	$xyz_fbap_include_categories1=$xyz_fbap_include_categories;
	?>
	<script type="text/javascript">
	//drpdisplay(); 
var xyzscripts_userid='';
xyzscripts_userid='<?php echo get_option('xyz_fbap_xyzscripts_user_id');?>';
var catval='<?php echo $xyz_fbap_include_categories1; ?>';
var custtypeval='<?php echo esc_html($xyz_fbap_include_customposttypes); ?>';
var get_opt_cats='<?php echo esc_html(get_option('xyz_fbap_include_posts'));?>';
jQuery(document).ready(function() {

	<?php 
	if(isset($_POST['bsettngs']))
	
	{?>
	document.getElementById("xyz_fbap_basic_tab_settings").click();	
	<?php }
	else {?>
	document.getElementById("xyz_fbap_default_tab_settings").click();
		
	<?php }
	?>

	// Get the element with id="xyz_fbap_default_tab_settings" and click on it
	
	  if(catval=="All")
		  jQuery("#cat_dropdown_span").hide();
	  else
		  jQuery("#cat_dropdown_span").show();

	  if(get_opt_cats==0)
		  jQuery('#selPostCat').hide();
	  else
		  jQuery('#selPostCat').show();

   var xyz_credit_link=jQuery("input[name='xyz_credit_link']:checked").val();
   if(xyz_credit_link=='fbap')
	   xyz_credit_link=1;
   else
	   xyz_credit_link=0;
   XyzFbapToggleRadio(xyz_credit_link,'xyz_credit_link');
   
   var xyz_fbap_cat_all=jQuery("input[name='xyz_fbap_cat_all']:checked").val();
   if (xyz_fbap_cat_all == 'All') 
	   xyz_fbap_cat_all=0;
   else 
	   xyz_fbap_cat_all=1;
   XyzFbapToggleRadio(xyz_fbap_cat_all,'xyz_fbap_include_categories'); 

   var fbap_toggle_element_ids=['xyz_fbap_post_permission','xyz_fbap_include_pages',
	   'xyz_fbap_include_posts',
	   'xyz_fbap_peer_verification','xyz_fbap_premium_version_ads','xyz_fbap_enforce_og_tags','xyz_fbap_clear_fb_cache'];
   jQuery.each(fbap_toggle_element_ids, function( index, value ) {
		   checkedval= jQuery("input[name='"+value+"']:checked").val();
			   XyzFbapToggleRadio(checkedval,value); 
   	});
   var xyz_fbap_app_sel_mode=jQuery("input[name='xyz_fbap_app_sel_mode']:checked").val();
   if(xyz_fbap_app_sel_mode !=0){
	   jQuery('#xyz_fbap_conn_to_xyzscripts').show();
		jQuery('.xyz_fbap_facebook_settings').hide();
		jQuery('#xyz_fbap_app_creation_note').hide();
   }
   else{
	   	jQuery('.xyz_fbap_facebook_settings').show();
	   	jQuery('#xyz_fbap_app_creation_note').show();
	   	jQuery('#xyz_fbap_conn_to_xyzscripts').hide();
	   		}
   jQuery("input[name='xyz_fbap_app_sel_mode']").click(function(){
	   var xyz_fbap_app_sel_mode=jQuery("input[name='xyz_fbap_app_sel_mode']:checked").val();
	   if(xyz_fbap_app_sel_mode !=0){
		    jQuery('#xyz_fbap_app_creation_note').hide();
			jQuery('.xyz_fbap_facebook_settings').hide();
			if(xyzscripts_userid=='')
			jQuery('#xyz_fbap_conn_to_xyzscripts').show();
			}
		   else{
			jQuery('#xyz_fbap_app_creation_note').show(); 
		   	jQuery('.xyz_fbap_facebook_settings').show();
		  	jQuery('#xyz_fbap_conn_to_xyzscripts').hide();
		   	}
	   });
   window.addEventListener('message', function(e) {
	   xyz_fbap_ProcessChildMessage_2(e.data);
	} , false);
}); 

function toggleRadio(value,buttonId)
{
	if (value == '1') {
    	jQuery("#"+buttonId+"_no").css({"background-color": "#dddddd", "color": "#888888", "font-weight": "normal"});
    	jQuery("#"+buttonId+"_yes").css({"background-color": "#28A6A2","color":"#1e1b1b", "font-weight": "bold"});
        }
    else if (value == '0') {
    	jQuery("#"+buttonId+"_yes").css({"background-color": "#dddddd", "color": "#888888", "font-weight": "normal"});
    	jQuery("#"+buttonId+"_no").css({"background-color": "#28A6A2","color":"#1e1b1b", "font-weight": "bold"});
    }
}
	
function setcat(obj)
{
var sel_str="";
for(k=0;k<obj.options.length;k++)
{
if(obj.options[k].selected)
sel_str+=obj.options[k].value+",";
}

var l = sel_str.length; 
var lastChar = sel_str.substring(l-1, l); 
if (lastChar == ",") { 
	sel_str = sel_str.substring(0, l-1);
}
document.getElementById('xyz_fbap_sel_cat').value=sel_str;
}

function rd_cat_chn(val,act)
{
	if(val==1)
	{
		if(act==-1)
		  jQuery("#cat_dropdown_span").hide();
		else
		  jQuery("#cat_dropdown_span").show();
	}
}

function xyz_fbap_info_insert(inf){
	
    var e = document.getElementById("xyz_fbap_info");
    var ins_opt = e.options[e.selectedIndex].text;
    if(ins_opt=="0")
    	ins_opt="";
    var str=jQuery("textarea#xyz_fbap_message").val()+ins_opt;
    jQuery("textarea#xyz_fbap_message").val(str);
    jQuery('#xyz_fbap_info :eq(0)').prop('selected', true);
    jQuery("textarea#xyz_fbap_message").focus();

}
function xyz_fbap_show_postCategory(val)
{
	if(val==0)
		jQuery('#selPostCat').hide();
	else
		jQuery('#selPostCat').show();
}
jQuery("#select_all_pages").click(function(){
	
	jQuery(".selpages").prop("checked",jQuery("#select_all_pages").prop("checked"));
});

var fbap_toggle_element_ids=['xyz_fbap_post_permission','xyz_fbap_include_pages',
	'xyz_fbap_include_posts',
	'xyz_fbap_peer_verification','xyz_credit_link','xyz_fbap_premium_version_ads','xyz_fbap_include_categories','xyz_fbap_enforce_og_tags','xyz_fbap_clear_fb_cache'];

jQuery.each(fbap_toggle_element_ids, function( index, value ) {
	jQuery("#"+value+"_no").click(function(){
		XyzFbapToggleRadio(0,value);
		if(value=='xyz_fbap_include_posts')
			xyz_fbap_show_postCategory(0);
	});
	jQuery("#"+value+"_yes").click(function(){
		XyzFbapToggleRadio(1,value);
		if(value=='xyz_fbap_include_posts')
			xyz_fbap_show_postCategory(1);
	});
	});
function fbap_popup_fb_auth(domain_name,xyz_fbap_smapsoln_userid,xyzscripts_user_id,xyzscripts_hash_val,auth_secret_key,request_hash)
{
	if(xyzscripts_user_id==''|| xyzscripts_hash_val==''){
		if(jQuery('#system_notice_area').length==0)
			jQuery('body').append('<div class="system_notice_area_style0" id="system_notice_area"></div>');
			jQuery("#system_notice_area").html('Please connect your xyzscripts member account  <span id="system_notice_area_dismiss">Dismiss</span>');
			jQuery("#system_notice_area").show();
			jQuery('#system_notice_area_dismiss').click(function() {
				jQuery('#system_notice_area').animate({
					opacity : 'hide',
					height : 'hide'
				}, 500);
			});
			return false;
	}
	else{
	var childWindow = null;
	var fbap_licence_key='';
	var account_id=0;
	var smap_solution_url='<?php echo XYZ_SMAP_SOLUTION_AUTH_URL;?>';
	childWindow = window.open(smap_solution_url+"authorize/facebook.php?smap_id="+xyz_fbap_smapsoln_userid+"&account_id="+account_id+
			"&domain_name="+domain_name+"&xyzscripts_user_id="+xyzscripts_user_id+"&request_hash="+request_hash
			+"&smap_licence_key="+fbap_licence_key+"&auth_secret_key="+auth_secret_key+"&free_plugin_source=fbap", "SmapSolutions Authorization", "toolbar=yes,scrollbars=yes,resizable=yes,left=500,width=600,height=600");
	return false;	}
}

function fbap_popup_connect_to_xyzscripts()
{
	var childWindow = null;
	var smap_xyzscripts_url='<?php echo "https://smap.xyzscripts.com/index.php?page=index/register";?>';
	childWindow = window.open(smap_xyzscripts_url, "Connect to xyzscripts", "toolbar=yes,scrollbars=yes,resizable=yes,left=500,width=600,height=600");
	return false;	
}
function xyz_fbap_ProcessChildMessage_2(message) {
	var messageType = message.slice(0,5);
	if(messageType==="error")
	{
		message=message.substring(6);
		if(jQuery('#system_notice_area').length==0)
		jQuery('body').append('<div class="system_notice_area_style0" id="system_notice_area"></div>');
		jQuery("#system_notice_area").html(message+' <span id="system_notice_area_dismiss">Dismiss</span>');
		jQuery("#system_notice_area").show();
		jQuery('#system_notice_area_dismiss').click(function() {
			jQuery('#system_notice_area').animate({
				opacity : 'hide',
				height : 'hide'
			}, 500);
		});
	}
	var obj1=jQuery.parseJSON(message);
	if(obj1.content &&  obj1.userid && obj1.xyzscripts_user)
	{
		var xyz_userid=obj1.userid;var xyz_user_hash=obj1.content;
		var xyz_fbap_xyzscripts_accinfo_nonce= '<?php echo wp_create_nonce('xyz_fbap_xyzscripts_accinfo_nonce');?>';
		var dataString = { 
				action: 'xyz_fbap_xyzscripts_accinfo_auto_update', 
				xyz_userid: xyz_userid ,
				xyz_user_hash: xyz_user_hash,
				dataType: 'json',
				_wpnonce: xyz_fbap_xyzscripts_accinfo_nonce
			};
		jQuery("#connect_to_xyzscripts").hide();
		jQuery("#ajax-save-xyzscript_acc").show();
		jQuery.post(ajaxurl, dataString ,function(response) {
			 if(response==1)
			       	alert("You do not have sufficient permissions");
			else{	
 		  var base_url = '<?php echo admin_url('admin.php?page=facebook-auto-publish-settings');?>';//msg - 
  		 window.location.href = base_url+'&msg=4';
		}
		});
	}
	else if(obj1.pages && obj1.smapsoln_userid)
	{
	var obj=obj1.pages;
	var secretkey=obj1.secretkey;
	var xyz_fbap_fb_numericid=obj1.xyz_fb_numericid;
	var smapsoln_userid=obj1.smapsoln_userid;
	var list='';
	for (var key in obj) {
	  if (obj.hasOwnProperty(key)) {
	    var val = obj[key];
	    list=list+"<input type='checkbox' value='"+key+"' checked='checked' disabled>"+val+"<br>";
	  }
	}
	jQuery("#xyz_fbap_page_names").val(JSON.stringify(obj));
	jQuery("#xyz_fbap_selected_pages").html(list);
	jQuery("#xyz_fbap_selected_pages_tr").show();
	jQuery("#auth_message").hide();
	jQuery("#re_auth_message").show();
	var xyz_fbap_selected_pages_nonce= '<?php echo wp_create_nonce('xyz_fbap_selected_pages_nonce');?>';
	var pages_obj = JSON.stringify(obj);
	var dataString = { 
			action: 'xyz_fbap_selected_pages_auto_update', 
			pages: pages_obj ,
			smap_secretkey: secretkey,
			xyz_fb_numericid: xyz_fbap_fb_numericid,
			smapsoln_userid:smapsoln_userid,
			dataType: 'json',
			_wpnonce: xyz_fbap_selected_pages_nonce
		};			
		jQuery("#re_auth_message").hide();
		jQuery("#auth_message").hide();
		jQuery("#ajax-save").show();
		jQuery.post(ajaxurl, dataString ,function(response) {
			 if(response==1)
			       	alert("You do not have sufficient permissions");
			else{
		  var base_url = '<?php echo admin_url('admin.php?page=facebook-auto-publish-settings');?>';//msg - 
		 window.location.href = base_url+'&msg=5';
		}
		});
	}
}

function xyz_fbap_open_tab(evt, xyz_fbap_form_div_id) {
    var i, xyz_fbap_tabcontent, xyz_fbap_tablinks;
    tabcontent = document.getElementsByClassName("xyz_fbap_tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("xyz_fbap_tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(xyz_fbap_form_div_id).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
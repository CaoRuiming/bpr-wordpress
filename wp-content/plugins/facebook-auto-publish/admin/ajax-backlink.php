<?php
if( !defined('ABSPATH') ){ exit();}
add_action('wp_ajax_xyz_fbap_ajax_backlink', 'xyz_fbap_ajax_backlink_call');

function xyz_fbap_ajax_backlink_call() {

	global $wpdb;
	if($_POST){
		if (! isset( $_POST['_wpnonce'] )|| ! wp_verify_nonce( $_POST['_wpnonce'],'backlink' ))
		 {
					echo 1;die;
		 }
		 if(current_user_can('administrator')){
		 	if(isset($_POST)){
		 		if(intval($_POST['enable'])==1){
		 			update_option('xyz_credit_link','fbap');
		 			echo "fbap";
		 		}
		 		if(intval($_POST['enable'])==-1){
		 			update_option('xyz_fbap_credit_dismiss', "hide");
		 			echo -1;
		 		}
		 	}
		 }
	}
	die();
}

add_action('wp_ajax_xyz_fbap_selected_pages_auto_update', 'xyz_fbap_selected_pages_auto_update_fn');
function xyz_fbap_selected_pages_auto_update_fn() {
	global $wpdb;
	if(current_user_can('administrator')){
	if($_POST){
		if (! isset( $_POST['_wpnonce'] )|| ! wp_verify_nonce( $_POST['_wpnonce'],'xyz_fbap_selected_pages_nonce' ))
		{
			echo 1;die;
		}
		if(isset($_POST)){
			$pages=stripslashes($_POST['pages']);
			$fbap_sec_key=$_POST['smap_secretkey'];
			$xyz_fbap_fb_numericid=$_POST['xyz_fb_numericid'];
			$xyz_fbap_smapsoln_userid=$_POST['smapsoln_userid'];
			update_option('xyz_fbap_page_names',$pages);
			update_option('xyz_fbap_af', 0);
			update_option('xyz_fbap_secret_key', $fbap_sec_key);
			update_option('xyz_fbap_fb_numericid', $xyz_fbap_fb_numericid);
			update_option('xyz_fbap_smapsoln_userid', $xyz_fbap_smapsoln_userid);
		}
	}
}
	die();
}
add_action('wp_ajax_xyz_fbap_xyzscripts_accinfo_auto_update', 'xyz_fbap_xyzscripts_accinfo_auto_update_fn');
function xyz_fbap_xyzscripts_accinfo_auto_update_fn() {
	global $wpdb;
	if(current_user_can('administrator')){
	if($_POST){
		if (! isset( $_POST['_wpnonce'] )|| ! wp_verify_nonce( $_POST['_wpnonce'],'xyz_fbap_xyzscripts_accinfo_nonce' ))
		{
			echo 1;die;
		}
		if(isset($_POST)){
			$xyzscripts_hash_val=stripslashes($_POST['xyz_user_hash']);
			$xyzscripts_user_id=$_POST['xyz_userid'];
			update_option('xyz_fbap_xyzscripts_user_id', $xyzscripts_user_id);
			update_option('xyz_fbap_xyzscripts_hash_val', $xyzscripts_hash_val);
		}
	}
}
	die();
}
add_action('wp_ajax_xyz_fbap_del_entries', 'xyz_fbap_del_entries_fn');
function xyz_fbap_del_entries_fn() {
	global $wpdb;
	if(current_user_can('administrator')){
	if($_POST){
		if (! isset( $_POST['_wpnonce'] )|| ! wp_verify_nonce( $_POST['_wpnonce'],'xyz_fbap_del_entries_nonce' ))
		{
			echo 1;die;
		}
		$auth_id=$_POST['auth_id'];
		$xyz_fbap_xyzscripts_user_id = $_POST['xyzscripts_id'];
		$xyz_fbap_xyzscripts_hash_val= $_POST['xyzscripts_user_hash'];
		$delete_entry_details=array('smap_id'=>$auth_id,
				'xyzscripts_user_id' =>$xyz_fbap_xyzscripts_user_id,
		);
		
		$url=XYZ_SMAP_SOLUTION_AUTH_URL.'authorize/delete-fb-auth.php';
		$content=xyz_fbap_post_to_smap_api($delete_entry_details, $url,$xyz_fbap_xyzscripts_hash_val);
		echo $content;
		$result=json_decode($content);$delete_flag=0;
		if(!empty($result))
		{
			if (isset($result->status))
				$delete_flag =$result->status;
		}
		if ($delete_flag===1)
		{
			if ($auth_id==get_option('xyz_fbap_smapsoln_userid'))
			{
				update_option('xyz_fbap_page_names','');
				update_option('xyz_fbap_af', 1);
				update_option('xyz_fbap_secret_key', '');
				update_option('xyz_fbap_smapsoln_userid', 0);
				update_option('xyz_fbap_fb_numericid','');
			}
		}
	}
}
	die();
}
add_action('wp_ajax_xyz_fbap_del_fb_entries', 'xyz_fbap_del_fb_entries_fn');
function xyz_fbap_del_fb_entries_fn() {
	global $wpdb;
	if(current_user_can('administrator')){
	if($_POST){
		if (! isset( $_POST['_wpnonce'] )|| ! wp_verify_nonce( $_POST['_wpnonce'],'xyz_fbap_del_fb_entries_nonce' ))
		{
			echo 1;die;
		}
		$fb_userid=$_POST['fb_userid'];
		$xyz_fbap_xyzscripts_user_id = $_POST['xyzscripts_id'];
		$xyz_fbap_xyzscripts_hash_val= $_POST['xyzscripts_user_hash'];
		$tr_iterationid=$_POST['tr_iterationid'];
		$delete_entry_details=array('fb_userid'=>$fb_userid,
				'xyzscripts_user_id' =>$xyz_fbap_xyzscripts_user_id);
		$url=XYZ_SMAP_SOLUTION_AUTH_URL.'authorize/delete-fb-auth.php';//save-selected-pages-test.php
		$content=xyz_fbap_post_to_smap_api($delete_entry_details, $url,$xyz_fbap_xyzscripts_hash_val);
		echo $content;
	}
}
	die();
}
?>
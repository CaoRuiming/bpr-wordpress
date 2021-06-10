<?php
if( !defined('ABSPATH') ){ exit();}
add_action('admin_menu', 'xyz_fbap_menu');

function xyz_fbap_add_admin_scripts()
{
	wp_enqueue_script('jquery');

	wp_register_script( 'xyz_notice_script_fbap', plugins_url('facebook-auto-publish/js/notice.js') );
	wp_enqueue_script( 'xyz_notice_script_fbap' );
	wp_register_style( 'xyz_fbap_font_style',plugins_url("css/font-awesome.min.css",XYZ_FBAP_PLUGIN_FILE));
	
	wp_enqueue_style('xyz_fbap_font_style');
	wp_register_style('xyz_fbap_style', plugins_url('facebook-auto-publish/css/style.css'));
	wp_enqueue_style('xyz_fbap_style');
	
}

add_action("admin_enqueue_scripts","xyz_fbap_add_admin_scripts");



function xyz_fbap_menu()
{
	add_menu_page('Facebook Auto Publish - Manage settings', 'WP2Social Auto Publish', 'manage_options', 'facebook-auto-publish-settings', 'xyz_fbap_settings',plugin_dir_url( XYZ_FBAP_PLUGIN_FILE ) . 'images/fbap.png');
	add_submenu_page('facebook-auto-publish-settings', 'Facebook Auto Publish - Manage settings', ' Settings', 'manage_options', 'facebook-auto-publish-settings' ,'xyz_fbap_settings'); // 8 for admin
	if(get_option('xyz_fbap_xyzscripts_hash_val')!=''&& get_option('xyz_fbap_xyzscripts_user_id')!='')
		add_submenu_page('facebook-auto-publish-settings', 'Facebook Auto Publish - Manage Authorizations', 'Manage Authorizations', 'manage_options', 'facebook-auto-publish-manage-authorizations' ,'xyz_fbap_manage_authorizations');
	add_submenu_page('facebook-auto-publish-settings', 'Facebook Auto Publish - Logs', 'Logs', 'manage_options', 'facebook-auto-publish-log' ,'xyz_fbap_logs');
	add_submenu_page('facebook-auto-publish-settings', 'Facebook Auto Publish - About', 'About', 'manage_options', 'facebook-auto-publish-about' ,'xyz_fbap_about'); // 8 for admin
	add_submenu_page('facebook-auto-publish-settings', 'Facebook Auto Publish - Suggest Feature', 'Suggest a Feature', 'manage_options', 'facebook-auto-publish-suggest-feature' ,'xyz_fbap_suggest_feature');
}


function xyz_fbap_settings()
{
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);	
	$_POST = xyz_trim_deep($_POST);
	$_GET = xyz_trim_deep($_GET);
	
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}



function xyz_fbap_about()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/about.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}


function xyz_fbap_logs()
{
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
	$_POST = xyz_trim_deep($_POST);
	$_GET = xyz_trim_deep($_GET);

	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/logs.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}
function xyz_fbap_suggest_feature()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/fbap-suggest-feature.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}
function xyz_fbap_manage_authorizations()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/manage-authorizations.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}
add_action('wp_head', 'xyz_fbap_insert_og_image_for_fb');
function xyz_fbap_insert_og_image_for_fb(){

 	global $post;
 	if (empty($post))
 		$post=get_post();
 		if (!empty($post) &&  get_option('xyz_fbap_enforce_og_tags')==1){
	$postid= $post->ID;
	if(isset($postid ) && $postid>0)
	{
		$xyz_fbap_apply_filters=get_option('xyz_fbap_apply_filters');
		$get_post_meta_insert_og=0;
  		$get_post_meta_insert_og=get_post_meta($postid,"xyz_fbap_insert_og",true);
			if (($get_post_meta_insert_og==1)&&(strpos($_SERVER["HTTP_USER_AGENT"], "facebookexternalhit/") !== false || strpos($_SERVER["HTTP_USER_AGENT"], "Facebot") !== false))
				{
					$ar2=explode(",",$xyz_fbap_apply_filters);
					$excerpt = $post->post_excerpt;
					if(in_array(2, $ar2))
						$excerpt = apply_filters('the_excerpt', $excerpt);
						$excerpt = html_entity_decode($excerpt, ENT_QUOTES, get_bloginfo('charset'));
						$excerpt = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $excerpt);
						if($excerpt=="")
						{
							$content = $post->post_content;
							if(in_array(1, $ar2))
								$content = apply_filters('the_content', $content);
								if($content!="")
								{
									$content1=$content;
									$content1=strip_tags($content1);
									$content1=strip_shortcodes($content1);
									$content1 = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content1);
									$content1=  preg_replace("/\\[caption.*?\\].*?\\[.caption\\]/is", "", $content1);
									$content1 = preg_replace('/\[.+?\]/', '', $content1);
									$excerpt=implode(' ', array_slice(explode(' ', $content1), 0, 50));
								}
						}
						else
						{
							$excerpt=strip_tags($excerpt);
							$excerpt=strip_shortcodes($excerpt);
						}
						$excerpt=str_replace("&nbsp;","",$excerpt);
						$name = $post->post_title;
						if(in_array(3, $ar2))
							$name = apply_filters('the_title', $name,$postid);
							$name = html_entity_decode($name, ENT_QUOTES, get_bloginfo('charset'));
							$name=strip_tags($name);
							$name=strip_shortcodes($name);
					$attachmenturl=xyz_fbap_getimage($postid, $post->post_content);
					if(!empty( $name ))
						echo '<meta property="og:title" content="'.$name.'" />';
					if (!empty($excerpt))
						echo '<meta property="og:description" content="'.$excerpt.'" />';
						if(!empty($attachmenturl))
							echo '<meta property="og:image" content="'.$attachmenturl.'" />';
							update_post_meta($postid, "xyz_fbap_insert_og", "0");
		}
	}
}
}

?>
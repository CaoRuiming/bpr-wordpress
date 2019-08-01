<?php 
if( !defined('ABSPATH') ){ exit();}
/*add_action('publish_post', 'xyz_fbap_link_publish');
add_action('publish_page', 'xyz_fbap_link_publish');
$xyz_fbap_future_to_publish=get_option('xyz_fbap_future_to_publish');

if($xyz_fbap_future_to_publish==1)
	add_action('future_to_publish', 'xyz_link_fbap_future_to_publish');

function xyz_link_fbap_future_to_publish($post){
	$postid =$post->ID;
	xyz_fbap_link_publish($postid);
}*/
//////////////
add_action(  'transition_post_status',  'xyz_link_fbap_future_to_publish', 10, 3 );

function xyz_link_fbap_future_to_publish($new_status, $old_status, $post){
	
	if (isset($_GET['_locale']) && empty($_POST))
		return ;
	
	if(!isset($GLOBALS['fbap_dup_publish']))
		$GLOBALS['fbap_dup_publish']=array();
	$postid =$post->ID;
	$get_post_meta=get_post_meta($postid,"xyz_fbap",true);
	$post_permissin=get_option('xyz_fbap_post_permission');
	if(isset($_POST['xyz_fbap_post_permission']))
	{
		$post_permissin=intval($_POST['xyz_fbap_post_permission']);
	    if ( (isset($_POST['xyz_fbap_post_permission']) && isset($_POST['xyz_fbap_po_method'])) )
	    {
    	 $futToPubDataArray=array( 'post_fb_permission'	=>	$post_permissin,
    			'xyz_fbap_po_method'	=>	$_POST['xyz_fbap_po_method'],
    			'xyz_fbap_message'	=>	$_POST['xyz_fbap_message']);
    	 update_post_meta($postid, "xyz_fbap_future_to_publish", $futToPubDataArray);
	    }
	}
	else 
	{
		if ($post_permissin == 1) {
			if($new_status == 'publish')
			{
			if ($get_post_meta == 1 ) {
					return;
			}
			}
			else return;
		}	
	}
	if($post_permissin == 1)
	{
		if($new_status == 'publish')
		{
		if(!in_array($postid,$GLOBALS['fbap_dup_publish'])) {
			  $GLOBALS['fbap_dup_publish'][]=$postid;
	       xyz_fbap_link_publish($postid);
	      
		   }
	      
		}
	}
	
}

function xyz_fbap_link_publish($post_ID) {
	$_POST_CPY=$_POST;
	$_POST=stripslashes_deep($_POST);
	$get_post_meta_future_data=get_post_meta($post_ID,"xyz_fbap_future_to_publish",true);
	$xyz_fbap_po_method=$xyz_fbap_message='';
	$post_permissin=get_option('xyz_fbap_post_permission');
	if(isset($_POST['xyz_fbap_post_permission']))
		$post_permissin=intval($_POST['xyz_fbap_post_permission']);
	elseif(!empty($get_post_meta_future_data) && get_option('xyz_fbap_default_selection_edit')==2 )///select values from post meta
	{
		$post_permissin=$get_post_meta_future_data['post_fb_permission'];
		$xyz_fbap_po_method=$get_post_meta_future_data['xyz_fbap_po_method'];
		$xyz_fbap_message=$get_post_meta_future_data['xyz_fbap_message'];
	}
		
	if ($post_permissin != 1) {
		$_POST=$_POST_CPY;
		return ;
	
	}elseif(( (isset($_POST['_inline_edit'])) || (isset($_REQUEST['bulk_edit'])) ) && (get_option('xyz_fbap_default_selection_edit') == 0) ) {
		$_POST=$_POST_CPY;
		return;
	}


	global $current_user;
	wp_get_current_user();
	
	////////////fb///////////
	$appid=get_option('xyz_fbap_application_id');
	$appsecret=get_option('xyz_fbap_application_secret');
	$useracces_token=get_option('xyz_fbap_fb_token');
	$app_name=get_option('xyz_fbap_application_name');

	$message=get_option('xyz_fbap_message');
	if(isset($_POST['xyz_fbap_message']))
		$message=$_POST['xyz_fbap_message'];
	elseif($xyz_fbap_message !='')
		$message=$xyz_fbap_message;
	
	//$fbid=get_option('xyz_fbap_fb_id');
	
	$posting_method=get_option('xyz_fbap_po_method');
	if(isset($_POST['xyz_fbap_po_method']))
		$posting_method=intval($_POST['xyz_fbap_po_method']);
	elseif($xyz_fbap_po_method !='')
		$posting_method=$xyz_fbap_po_method;
	
	$af=get_option('xyz_fbap_af');
	
	$postpp= get_post($post_ID);global $wpdb;
	$entries0 = $wpdb->get_results($wpdb->prepare( 'SELECT user_nicename,display_name FROM '.$wpdb->base_prefix.'users WHERE ID=%d',$postpp->post_author));
	foreach( $entries0 as $entry ) {			
	$user_nicename=$entry->user_nicename;
	$user_displayname=$entry->display_name;
	}
	if ($postpp->post_status == 'publish')
	{
		$posttype=$postpp->post_type;
		$fb_publish_status=array();
			
		if ($posttype=="page")
		{

			$xyz_fbap_include_pages=get_option('xyz_fbap_include_pages');
			if($xyz_fbap_include_pages==0)
			{
				$_POST=$_POST_CPY;
				return;
			}
		}
			
		else if($posttype=="post")
		{
			$xyz_fbap_include_posts=get_option('xyz_fbap_include_posts');
			if($xyz_fbap_include_posts==0)
			{
				$_POST=$_POST_CPY;return;
			}
			
			$xyz_fbap_include_categories=get_option('xyz_fbap_include_categories');
			if($xyz_fbap_include_categories!="All")
			{
				$carr1=explode(',', $xyz_fbap_include_categories);
					
				$defaults = array('fields' => 'ids');
				$carr2=wp_get_post_categories( $post_ID, $defaults );
				$retflag=1;
				foreach ($carr2 as $key=>$catg_ids)
				{
					if(in_array($catg_ids, $carr1))
						$retflag=0;
				}
					
					
				if($retflag==1)
				{
					$_POST=$_POST_CPY;
					return;
				}
			}
		}
		else
		{
					
			$xyz_fbap_include_customposttypes=get_option('xyz_fbap_include_customposttypes');
			if($xyz_fbap_include_customposttypes!='')
			{		
				$carr=explode(',', $xyz_fbap_include_customposttypes);

				if(!in_array($posttype, $carr))
				{
					$_POST=$_POST_CPY;return;
				}
	
			}
			else
			{
				$_POST=$_POST_CPY;return;
			}
		
		}
		$get_post_meta=get_post_meta($post_ID,"xyz_fbap",true);
		if($get_post_meta!=1)
			add_post_meta($post_ID, "xyz_fbap", "1");
		
		include_once ABSPATH.'wp-admin/includes/plugin.php';
		
		$pluginName = 'bitly/bitly.php';
		
		if (is_plugin_active($pluginName)) {
			remove_all_filters('post_link');
		}
		$link = get_permalink($postpp->ID);

		
		$xyz_fbap_apply_filters=get_option('xyz_fbap_apply_filters');
		$ar2=explode(",",$xyz_fbap_apply_filters);
		$con_flag=$exc_flag=$tit_flag=0;
		if(isset($ar2))
		{
			if(in_array(1, $ar2)) $con_flag=1;
			if(in_array(2, $ar2)) $exc_flag=1;
			if(in_array(3, $ar2)) $tit_flag=1;
		}
		
		$content = $postpp->post_content;
		if($con_flag==1)
			$content = apply_filters('the_content', $content);
		$content = html_entity_decode($content, ENT_QUOTES, get_bloginfo('charset'));
		$excerpt = $postpp->post_excerpt;
		if($exc_flag==1)
			$excerpt = apply_filters('the_excerpt', $excerpt);
		$excerpt = html_entity_decode($excerpt, ENT_QUOTES, get_bloginfo('charset'));
		$content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);
		$content=  preg_replace("/\\[caption.*?\\].*?\\[.caption\\]/is", '', $content);
		$content = preg_replace('/\[.+?\]/', '', $content);
		$excerpt = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $excerpt);

		if($excerpt=="")
		{
			if($content!="")
			{
				$content1=$content;
				$content1=strip_tags($content1);
				$content1=strip_shortcodes($content1);
				
				$excerpt=implode(' ', array_slice(explode(' ', $content1), 0, 50));
			}
		}
		else
		{
			$excerpt=strip_tags($excerpt);
			$excerpt=strip_shortcodes($excerpt);
		}
		$description = $content;
		$description_org=$description;
		
		$attachmenturl=xyz_fbap_getimage($post_ID, $postpp->post_content);
		if($attachmenturl!="")
			$image_found=1;
		else
			$image_found=0;
		
		$name = $postpp->post_title;
			
		$xyz_fbap_caption_for_fb_attachment=get_option('xyz_fbap_caption_for_fb_attachment');
		
		$caption=get_bloginfo('title');
		$caption = html_entity_decode($caption, ENT_QUOTES, get_bloginfo('charset'));
		
		if($tit_flag==1)
		$name = apply_filters('the_title', $name);
		$name = html_entity_decode($name, ENT_QUOTES, get_bloginfo('charset'));

		$name=strip_tags($name);
		$name=strip_shortcodes($name);
		$description=strip_tags($description);
		$description=strip_shortcodes($description);
	   	$description=str_replace("&nbsp;","",$description);
	
		$excerpt=str_replace("&nbsp;","",$excerpt);
		$xyz_fbap_app_sel_mode=get_option('xyz_fbap_app_sel_mode');
		$fbap_secretkey=get_option('xyz_fbap_secret_key');
		
		if((($xyz_fbap_app_sel_mode==0 && $useracces_token!="" && $appsecret!="" && $appid!="")|| $xyz_fbap_app_sel_mode==1)  && $post_permissin==1 && $af==0 )
		{
			$description_li=xyz_fbap_string_limit($description, 10000);
			if ($xyz_fbap_app_sel_mode==1){
			    $xyz_fbap_page_names=json_decode(stripslashes(get_option('xyz_fbap_page_names')));
				foreach ($xyz_fbap_page_names as $xyz_fbap_page_id => $xyz_fbap_page_name)
				{
					$xyz_fbap_pages_ids1[]=$xyz_fbap_page_id;
				}
			}
			else{
			$xyz_fbap_pages_ids=get_option('xyz_fbap_pages_ids');

			$xyz_fbap_pages_ids1=explode(",",$xyz_fbap_pages_ids);
			}

			foreach ($xyz_fbap_pages_ids1 as $key=>$value)
			{
				
				if ($xyz_fbap_app_sel_mode==0){
					$value1=explode("-",$value);
					$acces_token=$value1[1];$page_id=$value1[0];
				}
				else
					$page_id=$value;

				if ($xyz_fbap_app_sel_mode==0){
				$fb=new Facebook\Facebook(array(
						'app_id'  => $appid,
						'app_secret' => $appsecret,
						'cookie' => true
				));
				}
				$message1=str_replace('{POST_TITLE}', $name, $message);
				$message2=str_replace('{BLOG_TITLE}', $caption,$message1);
				$message3=str_replace('{PERMALINK}', $link, $message2);
				$message4=str_replace('{POST_EXCERPT}', $excerpt, $message3);
				$message5=str_replace('{POST_CONTENT}', $description, $message4);
				$message5=str_replace('{USER_NICENAME}', $user_nicename, $message5);
				$message5=str_replace('{USER_DISPLAY_NAME}', $user_displayname, $message5);
				$publish_time=get_the_time(get_option('date_format'),$post_ID );
				$message5=str_replace('{POST_PUBLISH_DATE}', $publish_time, $message5);
				$message5=str_replace('{POST_ID}', $post_ID, $message5);
				$message5=str_replace("&nbsp;","",$message5);

               $disp_type="feed";
				if($posting_method==1) //attach
				{
					$attachment = array('message' => $message5,
							'link' => $link,
							'actions' => json_encode(array('name' => $name,
							'link' => $link))

					);
				}
				else if($posting_method==2)  //share link
				{
					$attachment = array('message' => $message5,
							'link' => $link

					);
				}
				else if($posting_method==3) //simple text message
				{
					$attachment = array('message' => $message5);
					
					
				}
				else if($posting_method==4 || $posting_method==5) //text message with image 4 - app album, 5-timeline
				{
					if($attachmenturl!="")
					{
						if($xyz_fbap_app_sel_mode==0)
						{
						if($posting_method==5)
						{
							try{
								$album_fount=0;
								
								$albums = $fb->get("/$page_id/albums", $acces_token);
								$arrayResults = $albums->getGraphEdge()->asArray();
								
														
							}
							catch (Exception $e)
							{
								$fb_publish_status[$page_id."/albums"]=$e->getMessage();
									}
							if(isset($arrayResults))
							{
								foreach ($arrayResults as $album) {
									if (isset($album["name"]) && $album["name"] == "Timeline Photos") {
										$album_fount=1;$timeline_album = $album; break;
									}
								}
							}
							if (isset($timeline_album) && isset($timeline_album["id"])) $page_id = $timeline_album["id"];
							if($album_fount==0)
							{
								$attachment = array('name' => "Timeline Photos"
								);
								$attachment['access_token']=$acces_token;
								try{
									$album_create=$fb->post('/'.$page_id.'/albums', $attachment);
									$album_node=$album_create->getGraphNode();
									if (isset($album_node) && isset($album_node["id"]))
										$page_id = $album_node["id"];
								}
								catch (Exception $e)
								{
									$fb_publish_status[$page_id."/albums"]=$e->getMessage();
										
								}
									
							}
						}
						else
						{
							try{
								$album_fount=0;
								
								$albums = $fb->get("/$page_id/albums", $acces_token);
								$arrayResults = $albums->getGraphEdge()->asArray();
								
							}
							catch (Exception $e)
							{
								$fb_publish_status[$page_id."/albums"]=$e->getMessage();					
							}
							if(isset($arrayResults))
							{
								foreach ($arrayResults as $album)
								{
									if (isset($album["name"]) && $album["name"] == $app_name) {
										$album_fount=1;
										$app_album = $album; break;
									}
								}
						
							}
							if (isset($app_album) && isset($app_album["id"])) $page_id = $app_album["id"];
							if($album_fount==0)
							{
								$attachment = array('name' => $app_name,
								);
								$attachment['access_token']=$acces_token;
								try{
									$album_create=$fb->post('/'.$page_id.'/albums', $attachment);
									$album_node=$album_create->getGraphNode();
									if (isset($album_node) && isset($album_node["id"]))
										$page_id = $album_node["id"];
								}
								catch (Exception $e)
								{
									$fb_publish_status[$page_id."/albums"]=$e->getMessage();
								}
									
							}
						}
					}
						
						$disp_type="photos";
						$attachment = array('message' => $message5,
								'url' => $attachmenturl	
						
						);
					}
					else
					{
						$attachment = array('message' => $message5);
						
					}
					
				}
				if($posting_method==1 || $posting_method==2)
				{
					
						//$attachment=xyz_wp_fbap_attachment_metas($attachment,$link);
						update_post_meta($post_ID, "xyz_fbap_insert_og", "1");
				}
				try{
					
					if($xyz_fbap_app_sel_mode==1)	
					{
						$post_id_string="";
						$fbap_smapsoln_userid=get_option('xyz_fbap_smapsoln_userid');
						$xyz_fbap_secret_key=get_option('xyz_fbap_secret_key');
						$xyz_fbap_fb_numericid=get_option('xyz_fbap_fb_numericid');
						$xyz_fbap_xyzscripts_userid=get_option('xyz_fbap_xyzscripts_user_id');
					    $post_details=array('xyz_smap_userid'=>$fbap_smapsoln_userid,//smap_id
											'xyz_smap_attachment'=>$attachment,
											'xyz_smap_disp_type'=>$disp_type,
											'xyz_smap_posting_method'=>$posting_method,
											'xyz_smap_page_id'=>$page_id,
											'xyz_smap_app_name'=>$app_name,
								    		//'xyz_smap_secret_key' =>$xyz_fbap_secret_key,
								    		'xyz_fb_numericid' => $xyz_fbap_fb_numericid,
					    					'xyz_smap_xyzscripts_userid'=>$xyz_fbap_xyzscripts_userid
						);
					    $url=XYZ_SMAP_SOLUTION_PUBLISH_URL.'api/facebook.php';
						$result_smap_solns=xyz_fbap_post_to_smap_api($post_details,$url,$xyz_fbap_secret_key);
						$result_smap_solns=json_decode($result_smap_solns);
							if(!empty($result_smap_solns))
							{
									$fb_api_count_returned=$result_smap_solns->fb_api_count;
									if($result_smap_solns->status==0)
										$fb_publish_status[].="<span style=\"color:red\">  ".$page_id."/".$disp_type."/".$result_smap_solns->msg."</span><br/><span style=\"color:#21759B\">No. of api calls used: ".$fb_api_count_returned."</span><br/>";
									elseif ($result_smap_solns->status==1){
										
										if (isset($result_smap_solns->postid) && !empty($result_smap_solns->postid)){
										
											$fb_postid =$result_smap_solns->postid;
											if (strpos($fb_postid, '_') !== false) {
												$fb_post_id_explode=explode('_', $fb_postid);
												$link_to_fb_post='https://www.facebook.com/'.$fb_post_id_explode[0].'/posts/'.$fb_post_id_explode[1];
											}
											else {
												$link_to_fb_post='https://www.facebook.com/'.$page_id.'/posts/'.$fb_postid;
											}
											$post_id_string="<span style=\"color:#21759B;text-decoration:underline;\"><a  target=\"_blank\" href=".$link_to_fb_post.">View Post</a></span>";
										}
										
										$fb_publish_status[].="<span style=\"color:green\"> ".$page_id."/".$disp_type."/".$result_smap_solns->msg."</span><br/><span style=\"color:#21759B\">No. of api calls used: ".$fb_api_count_returned."</span><br/>".$post_id_string;
									}
										
							}
					}
					else
					{
					$attachment['access_token']=$acces_token;
				$result = $fb->post('/'.$page_id.'/'.$disp_type.'/', $attachment);
				$post_id_string_from_ownApp='';
				if($result!='')
				{
					$graphNode = $result->getGraphNode();
					$fb_postid=$graphNode['id'];
					if (!empty($fb_postid)){
						if (strpos($fb_postid, '_') !== false) {
							$fb_post_id_explode=explode('_', $fb_postid);
							$link_to_fb_post='https://www.facebook.com/'.$fb_post_id_explode[0].'/posts/'.$fb_post_id_explode[1];
						}
						else {
							$link_to_fb_post='https://www.facebook.com/'.$page_id.'/posts/'.$fb_postid;
						}
						$post_id_string_from_ownApp="<span style=\"color:#21759B;text-decoration:underline;\"><a target=\"_blank\" href=".$link_to_fb_post."> View Post</a></span>";
						$fb_publish_status[]="<span style=\"color:green\">Success</span><br/>".$post_id_string_from_ownApp;
					}
				}
					}
				}
							catch(Exception $e)
							{
					$fb_publish_status[]="<span style=\"color:red\">  ".$page_id."/".$disp_type."/".$e->getMessage()."</span><br/>";
							}

			}

			
			if(count($fb_publish_status)>0)
			    $fb_publish_status_insert=serialize($fb_publish_status);
			else{
				$fb_publish_status[]="<span style=\"color:green\">Success</span><br/>".$post_id_string_from_ownApp;
				$fb_publish_status_insert=serialize($fb_publish_status);
			}
			
			$time=time();
			$post_fb_options=array(
					'postid'	=>	$post_ID,
					'acc_type'	=>	"Facebook",
					'publishtime'	=>	$time,
					'status'	=>	$fb_publish_status_insert,
			);
			
			$update_opt_array=array();
			
			$arr_retrive=(get_option('xyz_fbap_post_logs'));
			
			$update_opt_array[0]=isset($arr_retrive[0]) ? $arr_retrive[0] : '';
			$update_opt_array[1]=isset($arr_retrive[1]) ? $arr_retrive[1] : '';
			$update_opt_array[2]=isset($arr_retrive[2]) ? $arr_retrive[2] : '';
			$update_opt_array[3]=isset($arr_retrive[3]) ? $arr_retrive[3] : '';
			$update_opt_array[4]=isset($arr_retrive[4]) ? $arr_retrive[4] : '';
			
			$update_opt_array[5]=isset($arr_retrive[5]) ? $arr_retrive[5] : '';
			$update_opt_array[6]=isset($arr_retrive[6]) ? $arr_retrive[6] : '';
			$update_opt_array[7]=isset($arr_retrive[7]) ? $arr_retrive[7] : '';
			$update_opt_array[8]=isset($arr_retrive[8]) ? $arr_retrive[8] : '';
			$update_opt_array[9]=isset($arr_retrive[9]) ? $arr_retrive[9] : '';
			array_shift($update_opt_array);
			array_push($update_opt_array,$post_fb_options);
			update_option('xyz_fbap_post_logs', $update_opt_array);
			
			
		}
		
	}
	
	$_POST=$_POST_CPY;
}
?>
<?php 
if( !defined('ABSPATH') ){ exit();}
?>
<div >


	<form method="post" name="xyz_fbap_logs_form">
		<fieldset
			style="width: 99%; border: 1px solid #F7F7F7; padding: 10px 0px;">
			


<div style="text-align: left;padding-left: 7px;"><h3>Auto Publish Logs</h3></div>
		<span>Last ten logs</span>
		   <table class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none;">
				<thead>
					<tr class="xyz_fbap_log_tr">
						<th scope="col" width="1%">&nbsp;</th>
						<th scope="col" width="12%">Post Id</th>
						<th scope="col" width="12%">Post Title</th>
						<th scope="col" width="18%">Published On</th>
						<th scope="col" width="15%">Status</th>
					</tr>
					</thead>
					<?php 
					
					$post_fb_logsmain = get_option('xyz_fbap_post_logs' );

					if(is_array($post_fb_logsmain))
					{
					$post_fb_logsmain_array = array();
           				foreach ($post_fb_logsmain as $logkey => $logval)
					{
						$post_fb_logsmain_array[]=$logval;
						
					}
                                        
                                         					
					if($post_fb_logsmain=='')
					{
						?>
						<tr><td colspan="4" style="padding: 5px;">No logs Found</td></tr>
						<?php 
					}
									
					if(is_array($post_fb_logsmain_array))
					{
						for($i=9;$i>=0;$i--)
						{
							if(array_key_exists($i,$post_fb_logsmain_array)){
							if(($post_fb_logsmain_array[$i])!='')//if(array_key_exists($i,$post_fb_logsmain_array))
							{
								$post_fb_logs=$post_fb_logsmain_array[$i];
								$postid=$post_fb_logs['postid'];
								$publishtime=$post_fb_logs['publishtime'];
								if($publishtime!="")
									$publishtime=xyz_fbap_local_date_time('Y/m/d g:i:s A',$publishtime);
								$status=$post_fb_logs['status'];
							
								?>
								<tr>
									<td>&nbsp;</td>
									<td  style="vertical-align: middle !important;padding: 5px;">
									<?php echo $postid;	?>
									</td>
									<td  style="vertical-align: middle !important;padding: 5px;">
									<?php echo get_the_title($postid);	?>
									</td>
										
									<td style="vertical-align: middle !important;padding: 5px;">
									<?php echo $publishtime;?>
									</td>
									
									<td class='xyz_fbap_td_custom' style="vertical-align: middle !important;padding: 5px;">
									<?php
									
								  	if($status=="1"){
										echo "<span style=\"color:green\">Success</span>";
								  	}
									else if($status=="0")
										echo '';
									else
									{
										$arrval=unserialize($status);
										foreach ($arrval as $a=>$b)
											echo $b;
									}
									?>
									</td>
								</tr>
								<?php  
								}}
						  }								
					}
}
					?>
				
           </table>
			
		</fieldset>

	</form>
<div style="padding: 5px;color: #e67939;font-size: 14px;">For publishing a simple text message, it will take 1 API call,
	 Upload image option will take 2-3 API calls and attach link option take 1 API call(2 api calls, if enabled option for clearing cache).</div>
</div>
				
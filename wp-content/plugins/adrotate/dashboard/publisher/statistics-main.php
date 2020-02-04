<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

$stats = adrotate_prepare_fullreport();
$stats_graph_month = $wpdb->get_row("SELECT SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `{$wpdb->prefix}adrotate_stats` WHERE `thetime` >= '{$monthstart}' AND `thetime` <= '{$monthend}';", ARRAY_A);
if(empty($stats_graph_month['impressions'])) $stats_graph_month['impressions'] = 0;
if(empty($stats_graph_month['clicks'])) $stats_graph_month['clicks'] = 0;

// Get Click Through Rate
$ctr_alltime = adrotate_ctr($stats['overall_clicks'], $stats['overall_impressions']);
$ctr_last_month = adrotate_ctr($stats['last_month_clicks'], $stats['last_month_impressions']);
$ctr_this_month = adrotate_ctr($stats['this_month_clicks'], $stats['this_month_impressions']);
$ctr_graph_month = adrotate_ctr($stats_graph_month['clicks'], $stats_graph_month['impressions']);
?>
<h2><?php _e('Statistics', 'adrotate'); ?></h2>

<table class="widefat" style="margin-top: .5em">
	<thead>
 	<tr>
        <th colspan="3"><center><strong><?php _e('General', 'adrotate'); ?></strong></center></th>
        <th>&nbsp;</th>
        <th colspan="3"><center><strong><?php _e('All time', 'adrotate'); ?></strong></center></th>
  	</tr>
	</thead>
	<tbody>
	<tr>
        <td width="16%"><div class="stats_large"><?php _e('Adverts', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['banners']; ?></div></div></td>
        <td width="16%">&nbsp;</td>
        <td width="16%"><div class="stats_large"><?php _e('Adverts counting stats', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['tracker']; ?></div></div></td>
        <td>&nbsp;</td>
        <td width="16%"><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['overall_impressions']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['overall_clicks']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_alltime; ?> %</div></div></td>
	</tr>
 	</tbody>
	<thead>
 	<tr>
        <th colspan="3"><center><strong><?php _e('Last month', 'adrotate'); ?></strong></center></th>
        <th>&nbsp;</th>
        <th colspan="3"><center><strong><?php _e('This month', 'adrotate'); ?></strong></center></th>
  	</tr>
	</thead>
	<tbody>
  	<tr>
        <td><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['last_month_impressions']; ?></div></div></td>
        <td><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['last_month_clicks']; ?></div></div></td>
        <td><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_last_month.' %'; ?></div></div></td>
        <td>&nbsp;</td>
        <td><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['this_month_impressions']; ?></div></div></td>
        <td><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['this_month_clicks']; ?></div></div></td>
        <td><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_this_month.' %'; ?></div></div></td>
  	</tr>
	</tbody>
</table>

<h2><?php _e('Monthly overview of clicks and impressions', 'adrotate'); ?></h2>
<table class="widefat" style="margin-top: .5em">
	<tbody>
	<tr>
        <th colspan="3">
        	<div style="text-align:center;"><?php echo adrotate_stats_nav('fullreport', 0, $month, $year); ?></div>
        	<?php echo adrotate_stats_graph('fullreport', false, 0, 1, $monthstart, $monthend); ?>
        </th>
	</tr>
	<tr>
        <td width="33%"><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_graph_month['impressions']; ?></div></div></td>
        <td width="33%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_graph_month['clicks']; ?></div></div></td>
        <td width="34%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_graph_month; ?> %</div></div></td>
	</tr>
	</tbody>
</table>

<p><center>
	<em><small><strong><?php _e('Note:', 'adrotate'); ?></strong> <?php _e('All statistics are indicative. They do not nessesarily reflect results counted by other parties.', 'adrotate'); ?></small></em>
	<br /><?php _e('Get more features with AdRotate Pro', 'adrotate'); ?> - <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!
</center></p>
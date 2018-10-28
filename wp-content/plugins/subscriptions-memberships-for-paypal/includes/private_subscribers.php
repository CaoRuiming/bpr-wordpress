<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpeppsub_plugin_subscribers() {

	if ( !current_user_can( "manage_options" ) )  {
		wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
	}


	if (!isset($_GET['action']) || $_GET['action'] == "delete" || isset($_GET['action2']) && $_GET['action2'] == "delete" || ($_GET['action'] == "-1" && isset($_GET['s'])) ) {
	
		class wpeppsub_button_orders_table extends WP_List_Table {
			
			
			function get_data() {
				global $wp_query;
				
				
				// search
				if (isset($_GET['s'])) {
					$s = $_GET['s'];
				} else {
					$s = "";
				}
				
				
				$args = array(
					'orderby' 			=> 'ID',
					'order' 			=> 'DESC',
					'posts_per_page'	=> -1,
					'post_type' 		=> 'wpplugin_subscr',
					'meta_query' 		=> array(
						'relation'=>'or',
						array(
							'key' 		=> 'wpeppsub_order_data',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   )
					)
				);
				
				$posts = get_posts($args);
				
				
				
				$count = "0";
				foreach ($posts as $post) {
					
					$id = 				esc_attr($posts[$count]->ID);
					
					$order_data_pre = 	get_post_meta($id,'wpeppsub_order_data',true);
					
					//print_r($order_data_pre);
					
					foreach ($order_data_pre as $k => $v ) { $order_data[$k] = esc_attr($v); }
					
					if (isset($order_data['payer_email'])) {
						$payer_email = 		$order_data['payer_email'];
					} else {
						$payer_email = "";
					}
					
					$status = get_post_meta($id, 'wpeppsub_order_status',true);
					
					
					
					if ($status == "Expired") {
						$expires_date = get_post_meta($post->ID, 'wpeppsub_order_expires_date', true);
						$expires_date = date("m/d/Y", $expires_date);
						$status .= " - (Member until: ". $expires_date . ")";
					}
					
					
					
					
					
					$order = $id;
					
					$data[] = array(
						'ID' => $id,
						'order' => $order,
						'payer' => $payer_email,
						'status' => $status
					);
					
					$count++;
				}
				
				if (empty($data)) {
					$data = array();
				}
				
				return $data;
			}
			
			
			
			function __construct() {
				global $status, $page;
				
				parent::__construct( array(
					'singular'  => 'order',
					'plural'    => 'orders',
					'ajax'      => false
				) );
			}


			function column_default($item, $column_name) {
				switch($column_name){
					case 'payer':
					case 'status':
						return $item[$column_name];
					default:
						return print_r($item,true);
				}
			}
			
			function column_payer($item){
			
				// view
				$view_bare = '?page=wpeppsub_subscribers&action=view&order='.$item['ID'];
				$view_url = wp_nonce_url($view_bare, 'view_'.$item['ID']);
				
				return "<a href='$view_url'>".$item['payer']."</a>";
			}
			
			
			function column_cb($item) {
				return sprintf(
					'<input type="checkbox" name="%1$s[]" value="%2$s" />',
					$this->_args['singular'],
					$item['ID']
				);
			}


			function get_columns() {
				$columns = array(
					'cb'        => '<input type="checkbox" />',
					'payer'     => 'Payer Email',
					'status'     => 'Status'
				);
				return $columns;
			}


			function get_sortable_columns() {
				$sortable_columns = array(
					'id'     => array('id',false),
					'order' => array('order',false)
				);
				return $sortable_columns;
			}
			
						
			function no_items() {
				_e( 'No subscribers found.' );
			}
			
			function get_bulk_actions() {
					$actions = array(
						'delete'    => 'Delete'
					);
					return $actions;
			}
			
			public function process_bulk_action() {
				if ( isset( $_GET['_wpnonce'] ) && ! empty( $_GET['_wpnonce'] ) ) {
					$nonce  = $_GET['_wpnonce'];
					$action = 'bulk-' . $this->_args['plural'];
					
					if ( ! wp_verify_nonce( $nonce, $action ) ) {
						wp_die('Security check fail');
					}
				}
			}
			
			function prepare_items() {
				global $wpdb;
				
				$per_page = 10;
				
				$columns = $this->get_columns();
				$hidden = array();
				$sortable = $this->get_sortable_columns();
				
				$this->_column_headers = array($columns, $hidden, $sortable);
				
				$this->process_bulk_action();
				
				$data = $this->get_data();
				
				if (isset($_REQUEST['orderby'])) {
					function usort_reorder($a,$b) {
						$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'order';
						$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc';
						$result = strcmp($a[$orderby], $b[$orderby]);
						return ($order==='asc') ? $result : -$result;
					}
					usort($data, 'usort_reorder');
				}

				$current_page = $this->get_pagenum();
				
				

				$total_items = count($data);

				$data = array_slice($data,(($current_page-1)*$per_page),$per_page);




				$this->items = $data;

				$this->set_pagination_args( array(
					'total_items' => $total_items,
					'per_page'    => $per_page,
					'total_pages' => ceil($total_items/$per_page)
				) );
			}
		}
		
		
		function wpeppsub_tt_render_list_pagea() {
			
			$testListTable = new wpeppsub_button_orders_table();
			$testListTable->prepare_items();
			
			?>
			
			<style>
			.check-column {
				width: 2% !important;
			}
			.column-order {
				width: 10%;
			}
			.column-status {
				width: 70%;
			}
			</style>			
			
			<div style="width:98%">
			
				<table width="100%"><tr><td>
				<br />
				<span style="font-size:20pt;">Subscribers</span>
				</td><td valign="bottom">
				</td></tr></table>
				
				<?php
				if (isset($_GET['message']) && $_GET['message'] == "deleted") {
					echo "<div class='updated'><p>Order entry(s) deleted.</p></div>";
				}
				if (isset($_GET['message']) && $_GET['message'] == "nothing") {
					echo "<div class='updated'><p>No action selected.</p></div>";
				}
				if (isset($_GET['message']) && $_GET['message'] == "nothing_deleted") {
					echo "<div class='updated'><p>Nothing selected to delete.</p></div>";
				}
				if (isset($_GET['message']) && $_GET['message'] == "error") {
					echo "<div class='updated'><p>An error occured while processing the query. Please try again.</p></div>";
				}
				?>
				
				<form id="products-filter" method="get">
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
					<?php
					$testListTable->search_box( 'search', 'search_id' );
					$testListTable->display() ?>
				</form>
			
			</div>

			<?php
		}
		
		wpeppsub_tt_render_list_pagea();
	}
	

	// end admin orders page view orders
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// admin orders page view order
	if (isset($_GET['action']) && $_GET['action'] == "view") {
	
		if ( !current_user_can( "manage_options" ) )  {
			wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
		}
		
		?>
		
		<div style="width:98%;">
		
			<?php
			$post_id = intval($_GET['order']);
			
			if (!$post_id) {
				echo'<script>window.location="admin.php?page=wpeppsub_subscribers"; </script>';
				exit;
			}
			
			check_admin_referer('view_'.$post_id);
			
			$order_data_pre = 	get_post_meta($post_id,'wpeppsub_order_data',true);
			
			foreach ($order_data_pre as $k => $v ) { $order_data[$k] = esc_attr($v); }
			
			if (isset($order_data['last_name'])) { $last_name = $order_data['last_name']; } else { $last_name = "";	}
			
			if (isset($order_data['first_name'])) {	$first_name = $order_data['first_name']; } else { $first_name = "";	}
			
			if (isset($order_data['payer_email'])) { $payer_email = $order_data['payer_email']; } else { $payer_email = ""; }
			
			if (isset($order_data['mc_currency'])) { $mc_currency = $order_data['mc_currency']; } else { $mc_currency = "";	}
			
			if (isset($order_data['subscr_id'])) { $subscr_id = $order_data['subscr_id']; } else { $subscr_id = ""; }
			
			// payment details
			if (isset($order_data['amount3'])) { $amount3 = $order_data['amount3'];	} else { $amount3 = "";	}
			if (isset($order_data['period3'])) { $period3 = $order_data['period3'];	} else { $period3 = "";	}
			if (isset($order_data['recur_times'])) { $recur_times = $order_data['recur_times'];	} else { $recur_times = "";	}
			
			if (isset($order_data['period1'])) { $period1 = $order_data['period1'];	} else { $period1 = "";	}
			if (isset($order_data['mc_amount1'])) { $mc_amount1 = $order_data['mc_amount1'];	} else { $mc_amount1 = "";	}
			
			
			if (isset($order_data['custom'])) {	$custom = $order_data['custom']; } else { $custom = ""; }
			if (isset($order_data['item_name'])) { $item_name = $order_data['item_name']; } else { $item_name = ""; }
			if (isset($order_data['item_number'])) { $item_number = $order_data['item_number']; } else { $item_number = ""; }
			
			
			$status = get_post_meta($post_id, 'wpeppsub_order_status',true);
			
			
			?>
			
			<table width="100%"><tr><td valign="bottom" width="85%">
			<br />
			<span style="font-size:20pt;">View Subscriber</span>
			</td><td valign="bottom">
			<a href="?page=wpeppsub_subscribers" class="button-secondary" style="font-size: 14px;height: 30px;float: right;">View All Subscribers</a>
			</td></tr></table>
			
			<?php
			// error
			if (isset($error) && isset($error) && isset($message)) {
				echo "<div class='error'><p>"; echo $message; echo"</p></div>";
			}
			// saved
			if (!isset($error)&& !isset($error) && isset($message)) {
				echo "<div class='updated'><p>"; echo $message; echo"</p></div>";
			}
			?>
			
			<br />
			
			<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br />
			
				<span style="font-size:16pt;">Subscriber: <?php echo $payer_email; ?></span>
				<br /><br />
				
				<table width="430px"><tr><td>
					
					<b>Transaction</b></td></tr><tr><td>
					PayPal Subscriber ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-recurring-payments&encrypted_profile_id=<?php echo $subscr_id; ?>"><?php echo $subscr_id; ?></a></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Status</b></td></tr><tr><td>
					Subscriber Status: </td><td><?php echo $status; ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Subscription Details</b></td></tr><tr><td>
					Trial Amount: </td><td><?php echo $mc_amount1; ?></td></tr><tr><td>
					Trial Cycle Period: </td><td><?php echo $period1; ?></td></tr><tr><td>
					<br />
					Amount: </td><td><br /><?php echo $amount3; ?></td></tr><tr><td>
					Cycle Period: </td><td><?php echo $period3; ?></td></tr><tr><td>
					Cycle Length: </td><td><?php echo $recur_times; ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Payer</b></td></tr><tr><td>
					Payer Name: </td><td><?php echo $first_name; echo " "; echo $last_name; ?></td></tr><tr><td>
					Payer Email: </td><td><?php echo $payer_email; ?></td></tr><tr><td>
					Payer Currency: </td><td><?php echo $mc_currency; ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Button</b></td></tr><tr><td>
					
					<?php
					$edit_bare = '?page=wpeppsub_buttons&action=edit&product='.$custom;
					$edit_url = wp_nonce_url($edit_bare, 'edit_'.$custom);
					?>
					
					
					Button Name: </td><td><a href="<?php echo $edit_url; ?>"><?php echo $item_name; ?></a></td></tr><tr><td>
					Button ID/SKU: </td><td><?php echo $item_number; ?></td></tr><tr><td>
					
					
					<br /></td><td></td></tr><tr><td>
					<b>Payment History</b></td></tr><tr><td colspan=2>
					
					<?php
					
					$args = array(
						'orderby' 			=> 'ID',
						'order' 			=> 'DESC',
						'posts_per_page'	=> -1,
						'post_type' 		=> 'wpplugin_sub_order',
						'meta_query' 		=> array(
							'relation'=>'or',
							array(
								'key' 		=> 'wpeppsub_order_data',
								'value' 	=> $subscr_id,
								'compare' 	=> 'LIKE',
						   )
						)
					);
					
					$posts = get_posts($args);
					
					
					$count = "0";
					foreach ($posts as $post) {
					
						$id = esc_attr($posts[$count]->ID);
						
						$order_data_pre = 	get_post_meta($id,'wpeppsub_order_data',true);
						
						foreach ($order_data_pre as $k => $v ) { $order_data[$k] = esc_attr($v); }
						
						if (isset($order_data['payment_date'])) {
							$payment_date = 		$order_data['payment_date'];
						} else {
							$payment_date = "";
						}
						
						$view_bare = '?page=wpeppsub_menu&action=view&order='.$id;
						$view_url = wp_nonce_url($view_bare, 'view_'.$id);
						
						echo "<a href='?page=wpeppsub_menu&action=view&order=$id&wpnonce=$view_url'>$id - $payment_date</a><br />";
						$count++;
					}
					
					?>
					
					
					
					</form>
					</td>					
					
				</tr></table>
				
				
				<br /><br />
				
			</div>
		</div>
		
		<?php	
		
	}
	// end admin orders page view order
	
	
	
	
	
	
	
	
	
	
	
	
	
	// admin orders page delete order
	if (isset($_GET['action']) && $_GET['action'] == "delete" || isset($_GET['action2']) && $_GET['action2'] == "delete") {

		if ( !current_user_can( "manage_options" ) )  {
			wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
		}
		
		if(isset($_GET['inline'])) {
			if ($_GET['inline'] == "true") {
				$post_id = array($_GET['order']);
			} else {
				$post_id = $_GET['order'];
			}
		} else {
			$post_id = $_GET['order'];
		}
		
		if (empty($post_id)) {
			echo'<script>window.location="?page=wpeppsub_subscribers&message=nothing_deleted"; </script>';
		}
		
		foreach ($post_id as $to_delete) {
			
			$to_delete = intval($to_delete);
			
			if (!$to_delete) {
				echo'<script>window.location="?page=wpeppsub_buttons&message=error"; </script>';
				exit;
			}
			
			wp_delete_post($to_delete,1);
			delete_post_meta($to_delete,'wpeppsub_order_data');
			
		}
		
		echo'<script>window.location="?page=wpeppsub_subscribers&message=deleted"; </script>';
		exit;
	}
	// end admin orders page delete order
	
	
	
	
	
	
	
	
	
	
	
	// admin orders page no action taken
	if (isset($_GET['action']) && $_GET['action'] == "-1" && !isset($_GET['s']) ) {
		
		if ( !current_user_can( "manage_options" ) )  {
			wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
		}
		
		echo'<script>window.location="?page=wpeppsub_subscribers&message=nothing"; </script>';
		
	}
	// end admin orders page no action taken
	
}
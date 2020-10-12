<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpeppsub_plugin_orders() {

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
					'post_type' 		=> 'wpplugin_sub_order',
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
					
					
					if (isset($order_data['custom'])) {
						$custom = 		$order_data['custom'];
					} else {
						$custom = "";
					}
					$item_name = esc_attr(get_post_meta($custom,'wpeppsub_button_name',true));
					
					if (isset($order_data['mc_gross'])) {
						$mc_gross = 		$order_data['mc_gross'];
					} else {
						$mc_gross = "";
					}
					if (isset($order_data['payment_date'])) {
						$order_date = 		$order_data['payment_date'];
					} else {
						$order_date = "";
					}
					if (isset($order_data['payer_email'])) {
						$payer_email = $order_data['payer_email'];
					} else {
						$payer_email = "";
					}
					if (isset($order_data['payment_status'])) {
						$payment_status = 	$order_data['payment_status'];
					} else {
						$payment_status = "";
					}			
					
					
					$order = $id;
					
					$data[] = array(
						'ID' => $id,
						'order' => $order,
						'items' => $item_name,
						'email' => $payer_email,
						'amount' => $mc_gross,
						'status' => $payment_status,
						'date' => $order_date
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
					case 'order':
					case 'items':
					case 'email':
					case 'amount':
					case 'status':
					case 'date':
						return $item[$column_name];
					default:
						return print_r($item,true);
				}
			}
			
			function column_order($item){
			
				// view
				$view_bare = '?page=wpeppsub_menu&action=view&order='.$item['ID'];
				$view_url = wp_nonce_url($view_bare, 'view_'.$item['ID']);
				
				// delete
				$delete_bare = '?page=wpeppsub_menu&action=delete&inline=true&order='.$item['ID'];
				$delete_url = wp_nonce_url($delete_bare, 'bulk-'.$this->_args['plural']);
				
				$actions = array(
					'edit'      => "<a href=$view_url>View</a>",
					'delete'      => "<a href=$delete_url>Delete</a>"
				);
				
				return sprintf('%1$s %2$s',
					"<a href='$view_url'>".$item['order']."</a>",
					$this->row_actions($actions)
				);
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
					'order'     => 'Payment #',
					'items'     => 'Button Name',
					'email'     => 'Payer Email',
					'amount'	=> 'Total Amount',
					'status'	=> 'Status',
					'date'		=> 'Date'
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
				_e( 'No payments found.' );
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
				width: 5%;
			}
			.column-items {
				width: 13%;
			}
			.column-amount {
				width: 12%;
			}
			.column-event {
				width: 16%;
			}
			.column-status {
				width: 7%;
			}
			.column-scanned {
				width: 7%;
			}
			.column-email {
				width: 16%;
			}
			.column-date {
				width: 12%;
			}
			</style>			
			
			<div style="width:98%">
			
				<table width="100%"><tr><td>
				<br />
				<span style="font-size:20pt;">Payments</span>
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
				echo'<script>window.location="admin.php?page=wpeppsub_menu"; </script>';
				exit;
			}
			
			check_admin_referer('view_'.$post_id);
			
			$order_data_pre = 	get_post_meta($post_id,'wpeppsub_order_data',true);
			
			foreach ($order_data_pre as $k => $v ) { $order_data[$k] = esc_attr($v); }
			
			if (isset($order_data['payment_date'])) {
				$date = $order_data['payment_date'];
			} else {
				$date = "";
			}
			
			if (isset($order_data['mc_gross'])) {
				$mc_gross = $order_data['mc_gross'];
			} else {
				$mc_gross = "";
			}
			
			if (isset($order_data['mc_fee'])) {
				$mc_fee = $order_data['mc_fee'];
			} else {
				$mc_fee = "";
			}
			
			if (isset($order_data['payment_status'])) {
				$payment_status = $order_data['payment_status'];
			} else {
				$payment_status = "";
			}
			
			if (isset($order_data['txn_id'])) {
				$txn_id = $order_data['txn_id'];
			} else {
				$txn_id = "";
			}
			
			if (isset($order_data['payer_email'])) {
				$payer_email = $order_data['payer_email'];
			} else {
				$payer_email = "";
			}
			
			if (isset($order_data['mc_currency'])) {
				$mc_currency = $order_data['mc_currency'];
			} else {
				$mc_currency = "";
			}
			
			if (isset($order_data['subscr_id'])) {
				$subscr_id = $order_data['subscr_id'];
			} else {
				$subscr_id = "";
			}
			
			if (isset($order_data['custom'])) {
				$custom = $order_data['custom'];
				$wpeppsub_button_name = esc_attr(get_post_meta($custom,'wpeppsub_button_name',true));
				$wpeppsub_button_sku = esc_attr(get_post_meta($custom,'wpeppsub_button_sku',true));
			} else {
				$wpeppsub_button_name = "";
				$wpeppsub_button_sku = "";
			}
			
			
			?>
			
			<table width="100%"><tr><td valign="bottom" width="85%">
			<br />
			<span style="font-size:20pt;">View Payment</span>
			</td><td valign="bottom">
			<a href="?page=wpeppsub_menu" class="button-secondary" style="font-size: 14px;height: 30px;float: right;">View All Payments</a>
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
			
				<span style="font-size:16pt;">Payment #<?php echo $post_id; ?> Details</span>
				<br /><br />
				
				<table width="430px"><tr><td>
					
					<b>Transaction</b></td></tr><tr><td>
					PayPal Transaction ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id=<?php echo $txn_id; ?>"><?php echo $txn_id; ?></a></td></tr><tr><td>
					PayPal Subscriber ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-recurring-payments&encrypted_profile_id=<?php echo $subscr_id; ?>"><?php echo $subscr_id; ?></a></td></tr><tr><td>
					Order Date: </td><td><?php echo $date; ?></td></tr><tr><td>
					Order Status: </td><td><?php echo $payment_status; ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Payment Amount</b></td></tr><tr><td>
					Order Amount: </td><td><?php echo $mc_gross; ?></td></tr><tr><td>
					Fee: </td><td><?php echo $mc_fee; ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Payer</b></td></tr><tr><td>
					Payer Email: </td><td><?php echo $payer_email; ?></td></tr><tr><td>
					Payer Currency: </td><td><?php echo $mc_currency; ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Button</b></td></tr><tr><td>
					
					<?php
					$edit_bare = '?page=wpeppsub_buttons&action=edit&product='.$custom;
					$edit_url = wp_nonce_url($edit_bare, 'edit_'.$custom);
					?>
					
					
					Button Name: </td><td><a href="<?php echo $edit_url; ?>"><?php echo $wpeppsub_button_name; ?></a></td></tr><tr><td>
					Button ID/SKU: </td><td><?php echo $wpeppsub_button_sku; ?></td></tr><tr><td>
					
					
					<br /></td><td></td></tr><tr><td>
					<b>Subscriber Details</b></td></tr><tr><td>
					
					<?php
					
					$args = array(
						'orderby' 			=> 'ID',
						'order' 			=> 'DESC',
						'posts_per_page'	=> -1,
						'post_type' 		=> 'wpplugin_subscr',
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
						
						$id = 				esc_attr($posts[$count]->ID);
						
						$order_data_pre = 	get_post_meta($id,'wpeppsub_order_data',true);
						
						foreach ($order_data_pre as $k => $v ) { $order_data[$k] = esc_attr($v); }
						
						if (isset($order_data['payer_email'])) {
							$payer_email = 		$order_data['payer_email'];
						} else {
							$payer_email = "";
						}
						
						$view_bare = '?page=wpeppsub_subscribers&action=view&order='.$id;
						$view_url = wp_nonce_url($view_bare, 'view_'.$id);
						
						echo "<a href='?page=wpeppsub_subscribers&action=view&order=$id&wpnonce=$view_url'>$payer_email</a>";
						
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
			echo'<script>window.location="?page=wpeppsub_menu&message=nothing_deleted"; </script>';
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
		
		echo'<script>window.location="?page=wpeppsub_menu&message=deleted"; </script>';
		exit;
	}
	// end admin orders page delete order
	
	
	
	
	
	
	
	
	
	
	
	// admin orders page no action taken
	if (isset($_GET['action']) && $_GET['action'] == "-1" && !isset($_GET['s']) ) {
		
		if ( !current_user_can( "manage_options" ) )  {
			wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
		}
		
		echo'<script>window.location="?page=wpeppsub_menu&message=nothing"; </script>';
		
	}
	// end admin orders page no action taken
	
}
<?php
$message = '';
$massages = array();
$messages[1] = __( 'Settings saved', 'otw_dcsw' );

if( isset( $_GET['message'] ) && isset( $messages[ $_GET['message'] ] ) ){
	$message .= $messages[ $_GET['message'] ];
}
?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php _e('Plugin Settings', 'otw_dcsw') ?>
	</h2>
	<div class="form-wrap otw_dcsw_options" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_dcsw_action" value="otw_dcsw_settings_action" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-dcsw-settings'); ?>
			<div id="post-body">
				<div id="post-body-content">
					<?php include_once( 'otw_dcsw_help.php' );?>
				</div>
			</div>
		</form>
	</div>
</div>


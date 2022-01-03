<div class="wrap">
	<h1><?php the_issuu_message('Create new folder'); ?></h1>
	<div id="issuu-panel-ajax-result">
		<p></p>
	</div>
	<form action="" id="add-folder" method="post" accept-charset="utf-8">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="folderName"><?php the_issuu_message("Folder's name"); ?></label></th>
					<td><input type="text" name="folderName" id="folderName" class="regular-text code"></td>
				</tr>
				<tr>
					<th><label for="folderDescription"><?php the_issuu_message('Description'); ?></label></th>
					<td><textarea name="folderDescription" id="folderDescription" cols="45" rows="6"></textarea></td>
				</tr>
				<tr>
					<th>
						<input type="submit" value="<?php the_issuu_message('Save'); ?>" class="button-primary">
						<h3>
							<a href="admin.php?page=issuu-folder-admin" style="text-decoration: none;">
								<?php the_issuu_message('Back'); ?>
							</a>
						</h3>
					</th>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<script type="text/javascript" charset="utf-8">
	(function($){
		$('#add-folder').submit(function(e){
			e.preventDefault();
			var $form = $(this);
			var $ajaxResult = $('#issuu-panel-ajax-result > p');
			var formData;

			if ($form.find('#folderName').val().trim() == "") {
				alert('<?php the_issuu_message("Insert folder\'s name"); ?>');
			} else {
				$('html, body').scrollTop(0);
				formData = new FormData($form[0]);
				formData.append('action', 'issuu-panel-add-folder');
				$.ajax(ajaxurl, {
					method : "POST",
					data : formData,
					contentType : false,
					processData : false
				}).done(function(data){
					$ajaxResult.html(data.message);

					if (data.status == 'success') {
						$form[0].reset();
					}
				}).fail(function(x, y, z){
					console.log(x);
					console.log(y);
					console.log(z);
				});
			}
		});
	})(jQuery);
</script>
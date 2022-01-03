<div class="wrap">
	<h1><?php the_issuu_message("Update folder"); ?></h1>
	<div id="issuu-panel-ajax-result">
		<p></p>
	</div>
	<form action="" id="update-folder" method="post" accept-charset="utf-8">
		<input type="hidden" name="folderId" value="<?php echo $folder->folderId; ?>">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="folderName"><?php the_issuu_message("Folder's name"); ?></label></th>
					<td>
						<input type="text" name="folderName" id="folderName" class="regular-text code"
							value="<?php echo $folder->name; ?>">
					</td>
				</tr>
				<tr>
					<th><label for="folderDescription"><?php the_issuu_message('Description'); ?></label></th>
					<td>
						<textarea name="folderDescription" id="folderDescription"
							cols="45" rows="6"><?php echo $folder->description; ?></textarea>
					</td>
				</tr>
				<tr>
					<th>
						<input type="submit" value="<?php the_issuu_message('Update'); ?>" class="button-primary">
						<h3>
							<a href="admin.php?page=issuu-folder-admin" style="text-decoration: none;">
								<?php the_issuu_message('Back'); ?>
							</a>
						</h3>
					</th>
				</tr>
			</tbody>
		</table>
		<?php if (isset($folders_documents['documentsId']) && !empty($folders_documents['documentsId'])) : ?>
			<h3>Shortcode</h3>
			<input type="text" class="code shortcode" disabled size="70"
				value='[issuu-panel-folder-list id="<?php echo $folder->folderId; ?>"]'>
		<?php endif; ?>
		<div id="document-list">
			<?php if (isset($folders_documents['documentsId']) && !empty($folders_documents['documentsId'])) : ?>
			<h3><?php the_issuu_message("Folder's documents"); ?></h3>
				<?php foreach ($folders_documents['documentsId'] as $doc) : ?>
					<div class="document complete">
						<div class="document-box">
							<img src="<?php echo sprintf($image, $doc->documentId) ?>" alt="">
						</div>
						<p class="description"><?php echo $doc->title ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</form>
</div>
<script type="text/javascript" charset="utf-8">
	(function($){
		$('#update-folder').submit(function(e){
			e.preventDefault();
			var $form = $(this);
			var $ajaxResult = $('#issuu-panel-ajax-result > p');
			var formData;

			if ($form.find('#folderName').val().trim() == "") {
				alert('<?php the_issuu_message("Insert folder\'s name"); ?>');
			} else {
				$('html, body').scrollTop(0);
				formData = new FormData($form[0]);
				formData.append('action', 'issuu-panel-update-folder');
				$.ajax(ajaxurl, {
					method : "POST",
					data : formData,
					contentType : false,
					processData : false
				}).done(function(data){
					$ajaxResult.html(data.message);
				}).fail(function(x, y, z){
					console.log(x);
					console.log(y);
					console.log(z);
				});
			}
		});
	})(jQuery);
</script>
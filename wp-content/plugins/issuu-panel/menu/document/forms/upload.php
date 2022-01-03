<div class="wrap">
	<h1><?php the_issuu_message('Document'); ?></h1>
	<div id="issuu-panel-ajax-result">
		<p></p>
	</div>
	<form action="" method="post" id="document-upload" enctype="multipart/form-data">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="file"><?php the_issuu_message('File'); ?></label></th>
					<td>
						<input type="file" name="file" id="file">
					</td>
				</tr>
				<tr>
					<th><label for="title"><?php the_issuu_message('Title'); ?></label></th>
					<td><input type="text" name="title" id="title" class="regular-text code"></td>
				</tr>
				<tr>
					<th><label for="name"><?php the_issuu_message('Name in URL'); ?></label></th>
					<td>
						<input type="text" name="name" id="name" class="regular-text code">
						<p class="description">
							<?php the_issuu_message('Name that is entered in the URL: http://issuu.com/(username)/docs/(name).<br>Use only lowercase letters [a-z], numbers [0-9] and/or other characters [_.-]. Do not use spaces.<br><strong>NOTE:</strong> If you do not enter a value, it will automatically be generated'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th><label for="description"><?php the_issuu_message('Description'); ?></label></th>
					<td>
						<textarea name="description" id="description" cols="45" rows="6"></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="tags">Tags</label></th>
					<td>
						<textarea name="tags" id="tags" cols="45" rows="6"></textarea>
						<p class="description">
							<?php the_issuu_message('Use commas to separate tags. Do not use spaces.'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th><label><?php the_issuu_message('Publish date'); ?></label></th>
					<td>
						<input type="text" name="pub[day]" id="dia" placeholder="<?php the_issuu_message('Day'); ?>" class="small-text"
							maxlength="2"> /
						<input type="text" name="pub[month]" id="mes" placeholder="<?php the_issuu_message('Month'); ?>" class="small-text"
							maxlength="2"> /
						<input type="text" name="pub[year]" id="ano" placeholder="<?php the_issuu_message('Year'); ?>" class="small-text"
							maxlength="4">
						<p class="description">
							<?php the_issuu_message('Date of publication of the document.<br><strong>NOTE:</strong> If you do not enter a value, the current date will be used'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th><label><?php the_issuu_message('Folders'); ?></label></th>
					<td>
						<?php if (isset($folders['folder']) && !empty($folders['folder'])) : ?>
							<fieldset>
								<?php for ($i = 0; $i < $cnt_f; $i++) : ?>
									<label for="folder<?php echo $i + 1; ?>">
										<input id="folder<?php echo $i + 1; ?>" type="checkbox" name="folder[]" value="<?php echo $folders['folder'][$i]->folderId; ?>">
										<?php echo $folders['folder'][$i]->name; ?> (<?php echo $folders['folder'][$i]->items; ?>)
									</label><br>
								<?php endfor; ?>
							</fieldset>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th><label for="commentsAllowed"><?php the_issuu_message('Allow comments'); ?></label></th>
					<td><input type="checkbox" name="commentsAllowed" id="commentsAllowed" value="true"></td>
				</tr>
				<tr>
					<th><label for="downloadable"><?php the_issuu_message('Allow file download'); ?></label></th>
					<td><input type="checkbox" name="downloadable" id="downloadable" value="true"></td>
				</tr>
				<tr>
					<th><label><?php the_issuu_message('Access'); ?></label></th>
					<td>
						<fieldset>
							<label for="acesso1">
								<input type="radio" name="access" id="acesso1" value="public">
								<?php the_issuu_message('Public'); ?>
							</label><br>
							<label for="acesso2">
								<input type="radio" name="access" id="acesso2" value="private">
								<?php the_issuu_message('Private'); ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>
						<button type="submit" class="button-primary">
							<?php the_issuu_message('Save'); ?>
						</button>
						<h3>
							<a href="admin.php?page=issuu-document-admin" style="text-decoration: none;">
								<?php the_issuu_message('Back'); ?>
							</a>
						</h3>
					</th>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<script type="text/javascript">
	(function($){
		$('#document-upload').submit(function(e){
			e.preventDefault();
			var $form = $(this);
			var $ajaxResult = $('#issuu-panel-ajax-result > p');
			var formData = new FormData($form[0]);
			formData.append('action', 'issuu-panel-upload-document');
			$('html, body').scrollTop(0);
			$.ajax(ajaxurl, {
				data : formData,
				type : "POST",
				xhr : function(){
					var xhr = $.ajaxSettings.xhr();

					if (xhr.upload) {
						xhr.upload.addEventListener(
							'progress', 
							function(evt){
								var total = evt.total;
								var evtLoaded = evt.loaded || evt.position;

								if (evt.lengthComputable) {
									$ajaxResult.html(
										issuuPanelObject.loadingText + " " + Math.ceil(evtLoaded / total * 100) + "%"
									);
								}
							}, 
							false
						);
					}
					return xhr;
				},
				contentType : false,
				processData : false
			}).done(function(data){
				console.log(data);
				$ajaxResult.html(data.message);

				if (data.status == 'success') {
					$form[0].reset();
				}
			}).fail(function(x, y, z){
				console.log(x);
				console.log(y);
				console.log(z);
			})
		});
	})(jQuery);
</script>
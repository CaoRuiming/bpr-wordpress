<div class="wrap">
	<h1><?php the_issuu_message('Documents list'); ?></h1>
	<div id="issuu-panel-ajax-result">
		<p></p>
	</div>
	<form action="" method="post" id="delete-documents">
		<a href="admin.php?page=issuu-document-admin&issuu-panel-subpage=upload" class="buttons-top button-primary" title="">
			<?php the_issuu_message('Upload file'); ?>
		</a>
		<a href="admin.php?page=issuu-document-admin&issuu-panel-subpage=url-upload" class="buttons-top button-primary" title="">
			<?php the_issuu_message('Upload file by URL'); ?>
		</a>
		<button type="submit" class="buttons-top button-secondary button-danger">
			<?php the_issuu_message('Delete'); ?>
		</button>
		<?php if (isset($docs['totalCount']) && $docs['totalCount'] > $docs['pageSize']) : ?>
			<div id="issuu-painel-pagination">
				<?php for ($i = 1; $i <= $number_pages; $i++) : ?>
					<?php if ($page == $i) : ?>
						<span class="issuu-painel-number-page"><?php echo $i; ?></span>
					<?php else : ?>
						<a class="issuu-painel-number-page" href="?page=issuu-document-admin&pn=<?php echo $i; ?>"><?php echo $i; ?></a>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
		<?php endif; ?>
		<div id="document-list">
			<?php if (isset($docs['document']) && !empty($docs['document'])) : ?>
				<?php foreach ($docs['document'] as $doc) : ?>
					<?php if (empty($doc->coverWidth) && empty($doc->coverHeight)) : ?>
						<div id="<?php echo $doc->orgDocName; ?>" class="document converting">
							<input type="checkbox" name="name[]" class="issuu-checkbox" value="<?php echo $doc->name; ?>">
							<div class="document-box">
								<div class="loading-issuu"></div>
					<?php else: ?>
						<div class="document complete">
							<input type="checkbox" name="name[]" class="issuu-checkbox" value="<?php echo $doc->name; ?>">
							<div class="document-box">
								<img src="<?php echo sprintf($image, $doc->documentId) ?>" alt="">
								<div class="update-document">
									<a href="admin.php?page=issuu-document-admin&issuu-panel-subpage=update&document=<?php echo $doc->name; ?>">
										<?php the_issuu_message('Edit'); ?>
									</a>
								</div>
					<?php endif; ?>
						</div>
						<p class="description"><?php echo $doc->title ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</form>
	<?php if (isset($docs['document']) && !empty($docs['document'])) : ?>
		<h3>Shortcode</h3>
		<input type="text" value="[issuu-painel-document-list]" disabled size="28" class="code shortcode">
	<?php endif; ?>
</div>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			var ua = navigator.userAgent.toLowerCase();
			if (ua.indexOf('chrome') <= -1) {
				$('.update-document a').each(function(){
					var p = $(this).parent();
					var width = (p.width() / 2) - 26;
					var height = (p.height() / 2) - 17;

					$(this).css({
						top: height + 'px',
						left: width + 'px'
					});
				});
			}
		});

		$('#delete-documents').submit(function(e){
			e.preventDefault();
			var $form = $(this);
			var $ajaxResult = $('#issuu-panel-ajax-result > p');
			var formData = new FormData($form[0]);
			formData.append('action', 'issuu-panel-delete-document');
			$('html, body').scrollTop(0);
			$.ajax(ajaxurl, {
				method : "POST",
				data : formData,
				contentType : false,
				processData : false
			}).done(function(data) {
				console.log(data);
				$ajaxResult.html(data.message);

				if (data.status == 'success') {
					$.each(data.documents, function(i, doc) {
						$('[value="' + doc + '"]').parents('.document').remove();
					});
				}
			}).fail(function(x,y,z) {
				console.log(x);
				console.log(y);
				console.log(z);
			})
		});

		function updateDocs() {
			var converting = $('.converting');

			if (converting.length > 0) {
				var $con = $(converting.get(0));
				$.ajax(ajaxurl, {
					method : 'POST',
					data : {
						name : $con.attr('id'),
						action : 'issuu-panel-ajax-docs'
					}
				}).done(function(data){
					console.log(data);
					if (data.status != "fail") {
						$con.html(data.html);
						$con.removeAttr('id');
						$con.addClass('complete').removeClass('converting');
					}
				});
			} else {
				window.clearInterval(idInt);
			}
		}

		var idInt = window.setInterval(updateDocs, 5000);
	})(jQuery);
</script>
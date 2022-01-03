<style type="text/css" media="screen">
	.form-table thead th{
		padding: 0;
		
	}
	.form-table tbody th{
		vertical-align: middle;
	}
	.form-table h3{
		margin: 0;
	}

	.form-table tr > td:last-child{
		max-width: 300px;
	}
</style>
<div class="wrap">
	<h1><?php the_issuu_message('About'); ?></h1>
	<div style="margin-top: 30px;">
		<h2>Shortcodes</h2>
		<table class="form-table">
			<thead>
				<tr>
					<th colspan="3"><h3>[issuu-panel-document-list]</h3></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>order_by</th>
					<td>
						<p class="description">
							<?php the_issuu_message("Parameter ordering of documents"); ?>
						</p>
					</td>
					<td>title, publishDate, description, documentId</td>
				</tr>

				<tr>
					<th>result_order</th>
					<td>
						<p class="description">
							<?php the_issuu_message("End result of ordination"); ?>
						</p>
					</td>
					<td>
						<?php the_issuu_message("'asc' or 'desc'"); ?>
					</td>
				</tr>

				<tr>
					<th>per_page</th>
					<td>
						<p class="description">
							<?php the_issuu_message("Number of documents per page"); ?>
						</p>
					</td>
					<td>
						<?php the_issuu_message("Integer"); ?>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th colspan="3"><h3>[issuu-panel-folder-list]</h3></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>id</th>
					<td colspan="2">
						<p class="description">
							<?php the_issuu_message("Folder's ID"); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th>order_by</th>
					<td>
						<p class="description">
							<?php the_issuu_message("Parameter ordering of documents"); ?>
						</p>
					</td>
					<td>title, publishDate, description, documentId</td>
				</tr>
				<tr>
					<th>result_order</th>
					<td>
						<p class="description">
							<?php the_issuu_message("End result of ordination"); ?>
						</p>
					</td>
					<td>
						<?php the_issuu_message("'asc' or 'desc'"); ?>
					</td>
				</tr>

				<tr>
					<th>per_page</th>
					<td>
						<p class="description">
							<?php the_issuu_message("Number of documents per page"); ?>
						</p>
					</td>
					<td>
						<?php the_issuu_message("Integer"); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
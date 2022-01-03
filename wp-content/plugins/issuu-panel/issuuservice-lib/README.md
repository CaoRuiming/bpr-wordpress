IssuuService lib
================

Biblioteca para API de dados do Issuu. Abaixo serão listados as classes que compõem a biblioteca, seus métodos e as
seções da API do Issuu usadas.

<strong>OBS1:</strong> Os métodos <em>delete</em> (issuu.\<seção\>.delete) e <em>issuuList</em> (issuu.\<seção\>.list)
estão presente em todas as classes.

<strong>OBS2:</strong> Os parâmetros obrigatórios <em>apiKey</em> e <em>signature</em> devem ser omitidos na passagem
de parâmetros de todos os métodos (exceto no caso em que a <em>apiKey</em> que deve ser passada no construtor da classe).
A inserção desses parâmetros é feita internamente.

<h1>Seções</h1>
<a href="#document">Document</a><br>
<a href="#bookmark">Bookmark</a><br>
<a href="#folder">Folder</a><br>
<a href="#document-embed">Document Embed</a><br>

<hr>
<h2>Document</h2>
<strong>Classe:</strong> IssuuDocument

<table>
	<thead>
		<tr>
			<th colspan="4"><h2>IssuuDocument</h2></th>
		</tr>
		<tr>
			<th>Método da classe</th>
			<th>Método da API</th>
			<th>Descrição</th>
			<th>Parâmetros</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>__construct</td>
			<td>N/A</td>
			<td>Construtor da classe</td>
			<td>
				<ul>
					<li>$api_key</li>
					<li>$api_secret</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>upload</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document.upload.html">
					issuu.document.upload
				</a>
			</td>
			<td>Carrega um arquivo para o usuário</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>urlUpload</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document.url_upload.html">
					issuu.document.url_upload
				</a>
			</td>
			<td>Carrega um arquivo para o usuário pela URL</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>issuuList</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document.list.html">
					issuu.documents.list
				</a>
			</td>
			<td>Lista todos os documentos do usuário</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>update</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document.update.html">
					issuu.document.update
				</a>
			</td>
			<td>Atualiza os dados de um documento</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>delete</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document.delete.html">
					issuu.document.delete
				</a>
			</td>
			<td>Exclui um ou mais documentos do usuário pelos respectivos names</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
	</tbody>
</table>

<h2>Bookmark</h2>
<strong>Classe:</strong> IssuuBookmark

<table>
	<thead>
		<tr>
			<th colspan="4">
				<h2>IssuuBookmark</h2>
			</th>
		</tr>
		<tr>
			<th>Método da classe</th>
			<th>Método da API</th>
			<th>Descrição</th>
			<th>Parâmetros</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>__construct</td>
			<td>N/A</td>
			<td>Construtor da classe</td>
			<td>
				<ul>
					<li>$api_key</li>
					<li>$api_secret</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>add</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.bookmark.add.html">
					issuu.bookmark.add
				</a>
			</td>
			<td>Cria um marcador em um documento</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>issuuList</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.bookmarks.list.html">
					issuu.bookmarks.list
				</a>
			</td>
			<td>Lista todos os maracadores do usuário</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>delete</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.bookmark.delete.html">
					issuu.bookmark.delete
				</a>
			</td>
			<td>Exclui um ou mais marcadores pelos respectivos IDs</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
	</tbody>
</table>

<h2>Folder</h2>
<strong>Classe:</strong> IssuuFolder
<table>
	<thead>
		<tr>
			<th colspan="4">
				<h2>IssuuFolder</h2>
			</th>
		</tr>
		<tr>
			<th>Método da classe</th>
			<th>Método da API</th>
			<th>Descrição</th>
			<th>Parâmetros</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>__construct</td>
			<td>N/A</td>
			<td>Construtor da classe</td>
			<td>
				<ul>
					<li>$api_key</li>
					<li>$api_secret</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>add</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.folder.add.html">
					issuu.folder.add
				</a>
			</td>
			<td>Cria uma pasta para armazenamento de documentos e/ou marcadores para o usuário</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>issuuList</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.folder.list.html">
					issuu.folders.list
				</a>
			</td>
			<td>Lista todas as pastas do usuário</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>update</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.folder.update.html">
					issuu.folder.update
				</a>
			</td>
			<td>Atualiza os dados de uma pasta</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>delete</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.folder.delete.html">
					issuu.folder.delete
				</a>
			</td>
			<td>Exclui uma ou mais pastas pelos respectivos IDs</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
	</tbody>
</table>

<h2>Document Embed</h2>
<strong>Classe:</strong> IssuuDocumentEmbed

<table>
	<thead>
		<tr>
			<th colspan="4">
				<h2>IssuuDocumentEmbed</h2>
			</th>
		</tr>
		<tr>
			<th>Método da classe</th>
			<th>Método da API</th>
			<th>Descrição</th>
			<th>Parâmetros</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>__construct</td>
			<td>N/A</td>
			<td>Construtor da classe</td>
			<td>
				<ul>
					<li>$api_key</li>
					<li>$api_secret</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>add</td>
			<td>
				<a href="https://developers.issuu.com/api/issuu.document_embed.add.html">
					issuu.document_embed.add
					</a>
				</td>
			<td>Cria um embed de um documento para ser inserido em uma página</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>issuuList</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document_embeds.list.html">
					issuu.document_embeds.list
				</a>
			</td>
			<td>Lista todos os embeds de um usuário</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>update</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document_embed.update.html">
					issuu.document_embed.update
				</a>
			</td>
			<td>Atualiza os dados de um embed criado</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>getHtmlCode</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document_embed.get_html_code.html">
					issuu.document_embed.<br>get_html_code
				</a>
			</td>
			<td>Retorna um código HTML de um determinado embed buscando-o pelo seu ID</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>delete</td>
			<td>
				<a target="_blank" href="https://developers.issuu.com/api/issuu.document_embed.delete.html">
					issuu.document_embed.delete
				</a>
			</td>
			<td>Exclui um ou mais embeds pelo seus respectivos IDs</td>
			<td>
				<ul>
					<li>$params</li>
				</ul>
			</td>
		</tr>
	</tbody>
</table>

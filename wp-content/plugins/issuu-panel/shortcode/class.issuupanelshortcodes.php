<?php

class IssuuPanelShortcodes implements IssuuPanelService
{
	private $config;

	private $shortcodeGenerator;

	public function __construct(IssuuPanelShortcodeGenerator $shortcodeGenerator)
	{
		$this->shortcodeGenerator = $shortcodeGenerator;
		add_shortcode('issuu-painel-document-list', array($this, 'deprecatedDocumentsList'));
		add_shortcode('issuu-painel-folder-list', array($this, 'deprecatedFolderList'));
		add_shortcode('issuu-panel-document-list', array($this, 'documentsList'));
		add_shortcode('issuu-panel-folder-list', array($this, 'folderList'));
		add_shortcode('issuu-panel-last-document', array($this, 'lastDocument'));
	}

	public function deprecatedDocumentsList($atts)
	{
		$content = '';
		$content .= $this->documentsList($atts);
		$content = "<p><em>" .
			get_issuu_message(
				"The [issuu-painel-document-list] shortcode is deprecated. Please, use [issuu-panel-document-list]" .
				" using the same parameters."
			) .
			"</em></p>" . $content;
		return $content;
	}

	public function deprecatedFolderList($atts)
	{
		$content = '';
		$content .= $this->folderList($atts);
		$content = "<p><em>" .
			get_issuu_message(
				"The [issuu-painel-folder-list] shortcode is deprecated. Please, use [issuu-panel-folder-list]" .
				" using the same parameters."
			) .
			"</em></p>" . $content;
		return $content;
	}

	public function documentsList($atts)
	{
		$content = '';
		$shortcodeData = $this->getShortcodeData('issuu-panel-document-list');
		$atts = shortcode_atts(array(
			'order_by' => 'publishDate',
			'result_order' => 'desc',
			'per_page' => '12',
		), $atts);
		$params = array(
			'pageSize' => $atts['per_page'],
			'startIndex' => ($atts['per_page'] * ($shortcodeData['page'] - 1)),
			'resultOrder' => $atts['result_order'],
			'documentSortBy' => $atts['order_by']
		);
		$content .= $this->shortcodeGenerator->getFromCache($shortcodeData['shortcode'], $atts, $shortcodeData['page']);

		if (empty($content))
		{
			try {
				$issuuDocument = $this->getConfig()->getIssuuServiceApi('IssuuDocument');
				$result = $issuuDocument->issuuList($params);
				$requestData = $issuuDocument->getParams();
				unset($requestData['apiKey']);
				$this->getConfig()->getIssuuPanelDebug()->appendMessage(
					"Shortcode [issuu-panel-document-list]: Request Data - " . json_encode($requestData)
				);

				if ($result['stat'] == 'ok')
				{
					$docs = $this->getDocs($result);
					$content = $this->shortcodeGenerator->getFromRequest($shortcodeData, $atts, $result, $docs);
				}
				else
				{
					$content = $this->getErroApiMessage('issuu-panel-document-list', $result);
				}
			} catch (Exception $e) {
				$content = $this->getExceptionMessage('issuu-panel-document-list', $e);
			}
		}
		return $content;
	}

	public function folderList($atts)
	{
		$content = '';
		$shortcodeData = $this->getShortcodeData('issuu-panel-folder-list');
		$atts = shortcode_atts(array(
			'id' => '',
			'order_by' => 'publishDate',
			'result_order' => 'desc',
			'per_page' => '12',
		), $atts);
		$params = array(
			'folderId' => $atts['id'],
			'pageSize' => $atts['per_page'],
			'startIndex' => ($atts['per_page'] * ($shortcodeData['page'] - 1)),
			'resultOrder' => $atts['result_order'],
			'bookmarkSortBy' => $atts['order_by']
		);
		$content .= $this->shortcodeGenerator->getFromCache($shortcodeData['shortcode'], $atts, $shortcodeData['page']);

		if (empty($content))
		{
			if ($atts['order_by'] == 'publishDate')
			{
				unset($params['resultOrder']);
				unset($params['bookmarkSortBy']);
				$content .= $this->listOrderedByDate($params, $shortcodeData, $atts);
			}
			else
			{
				$content .= $this->listNotOrderedByDate($params, $shortcodeData, $atts);
			}
		}
		return $content;
	}

	public function lastDocument($atts)
	{
		$content = '';
		$shortcodeData = $this->getShortcodeData('issuu-panel-last-document');
		$atts = shortcode_atts(array(
			'id' => '',
			'link' => '',
			'order_by' => 'publishDate',
			'result_order' => 'desc',
			'per_page' => '12'
		), $atts);
		$content .= $this->shortcodeGenerator->getFromCache($shortcodeData['shortcode'], $atts, 1);

		if (empty($content))
		{
			try {
				if ($atts['id'] == '')
				{
					$issuuDocument = $this->getConfig()->getIssuuServiceApi('IssuuDocument');
					$params = array(
						'pageSize' => 1,
						'startIndex' => 0,
						'resultOrder' => 'desc',
						'documentSortBy' => $atts['order_by']
					);
					$result = $issuuDocument->issuuList($params);

					if ($result['stat'] == 'ok')
					{
						if (!empty($result['document']))
						{
							$document = $result['document'][0];
							$doc = array(
								'id' => $document->documentId,
								'thumbnail' => 'https://image.issuu.com/' . $document->documentId . '/jpg/page_1_thumb_large.jpg',
								'url' => 'https://issuu.com/' . $document->username . '/docs/' . $document->name,
								'title' => $document->title
							);
						}
						else
						{
							$doc = array();
						}

						$content = $this->shortcodeGenerator->getLastDocument($doc, $shortcodeData, $atts);
					}
					else
					{
						$content = $this->getErroApiMessage('issuu-panel-last-document', $result);
					}
				}
				else if ($atts['order_by'] == 'publishDate')
				{
					$content = $this->getDocumentOrderedByDate($shortcodeData, $atts);
				}
				else
				{
					$content = $this->getDocumentNotOrderedByDate($shortcodeData, $atts);
				}
			} catch (Exception $e) {
				$content = $this->getExceptionMessage('issuu-panel-last-document', $e);
			}
		}
		return $content;
	}

	public function setConfig(IssuuPanelConfig $config)
	{
		$this->config = $config;
	}

	public function getConfig()
	{
		return $this->config;
	}

	private function getShortcodeData($shortcode)
	{
		$post = get_post();
		$postID = (!is_null($post) && $this->getConfig()->getIssuuPanelCatcher()->inContent())? $post->ID : 0;
		$issuu_shortcode_index = $this->getConfig()->getNextIteratorByTemplate();
		$inHook = $this->getConfig()->getIssuuPanelCatcher()->getCurrentHookIs();
		$page_query_name = 'ip_shortcode' . $issuu_shortcode_index . '_page';
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [$shortcode]: Init");
		$this->getConfig()->getIssuuPanelDebug()->appendMessage(
			"Shortcode [$shortcode]: Index " . $issuu_shortcode_index . ' in hook ' . $inHook
		);
		$shortcode = $shortcode . $issuu_shortcode_index . $inHook . $postID;
		return array(
			'shortcode' => $shortcode,
			'page_query_name' => $page_query_name,
			'in_hook' => $inHook,
			'issuu_shortcode_index' => $issuu_shortcode_index,
			'post' => $post,
			'page' => (isset($_GET[$page_query_name]) && is_numeric($_GET[$page_query_name]))?
				intval($_GET[$page_query_name]) : 1,
		);
	}

	private function getDocs($result)
	{
		$docs = array();
		foreach ($result['document'] as $doc) {
			$docs[] = array(
				'id' => $doc->documentId,
				'thumbnail' => 'https://image.issuu.com/' . $doc->documentId . '/jpg/page_1_thumb_large.jpg',
				'url' => 'https://issuu.com/' . $doc->username . '/docs/' . $doc->name,
				'title' => $doc->title,
				'date' => date_i18n('d/F/Y', strtotime($doc->publishDate)),
				'pubTime' => strtotime($doc->publishDate),
				'pageCount' => $doc->pageCount
			);
		}
		return $docs;
	}

	private function getDocsFolder($result)
	{
		$docs = array();
		$issuuDocument = $this->getConfig()->getIssuuServiceApi('IssuuDocument');
		foreach ($result['bookmark'] as $book) {
			try {
				$document = $issuuDocument->update(array('name' => $book->name));

				if (isset($document['document']))
				{
					$docs[] = array(
						'id' => $book->documentId,
						'thumbnail' => 'https://image.issuu.com/' . $book->documentId . '/jpg/page_1_thumb_large.jpg',
						'url' => 'https://issuu.com/' . $book->username . '/docs/' . $book->name,
						'title' => $book->title,
						'date' => date_i18n('d/F/Y', strtotime($document['document']->publishDate)),
						'pubTime' => strtotime($document['document']->publishDate),
						'pageCount' => $document['document']->pageCount
					);
				}
			} catch (Exception $e) {
				$this->getConfig()->getIssuuPanelDebug()->appendMessage(
					"IssuuDocument->update Exception - " . $e->getMessage()
				);
			}
		}
		return $docs;
	}

	private function listOrderedByDate($params, $shortcodeData, $atts)
	{
		$content = '';
		try {
			$issuuBookmark = $this->getConfig()->getIssuuServiceApi('IssuuBookmark');
			$result = $issuuBookmark->issuuList($params);
			$requestData = $issuuBookmark->getParams();
			unset($requestData['apiKey']);
			$this->getConfig()->getIssuuPanelDebug()->appendMessage(
				"Shortcode [issuu-panel-folder-list]: Request Data - " . json_encode($requestData)
			);

			if ($result['stat'] == 'ok')
			{
				$docs = $this->getConfig()->getFolderCacheEntity()->getFolder($atts['id']);

				if (empty($docs) && !empty($result['bookmark']))
				{
					$docs = $this->getDocsFolder($result);
				}
				$docs = issuu_panel_quick_sort($docs, $atts['result_order']);
				$content = $this->shortcodeGenerator->getFromRequest(
					$shortcodeData,
					$atts,
					$result,
					$docs
				);
			}
			else
			{
				$content = $this->getErroApiMessage('issuu-panel-folder-list', $result);
			}
		} catch (Exception $e) {
			$content = $this->getExceptionMessage('issuu-panel-folder-list', $e);
		}
		return $content;
	}

	private function listNotOrderedByDate($params, $shortcodeData, $atts)
	{
		$content = '';
		try {
			$issuuBookmark = $this->getConfig()->getIssuuServiceApi('IssuuBookmark');
			$result = $issuuBookmark->issuuList($params);
			$requestData = $issuuBookmark->getParams();
			unset($requestData['apiKey']);
			$this->getConfig()->getIssuuPanelDebug()->appendMessage(
				"Shortcode [issuu-panel-folder-list]: Request Data - " . json_encode($requestData)
			);

			if ($result['stat'] == 'ok')
			{
				$docs = $this->getConfig()->getFolderCacheEntity()->getFolder($atts['id']);

				if (empty($docs) && !empty($result['bookmark']))
				{
					$docs = $this->getDocsFolder($result);
				}
				$content = $this->shortcodeGenerator->getFromRequest(
					$shortcodeData,
					$atts,
					$result,
					$docs
				);
			}
			else
			{
				$content = $this->getErroApiMessage('issuu-panel-folder-list', $result);
			}
		} catch (Exception $e) {
			$content = $this->getExceptionMessage('issuu-panel-folder-list', $e);
		}
		return $content;
	}

	private function getDocumentOrderedByDate($params, $shortcodeData, $atts)
	{
		$content = '';
		$docs = $this->getConfig()->getFolderCacheEntity()->getFolder($atts['id']);

		if (!empty($docs))
		{
			$docs = issuu_panel_quick_sort($docs, 'desc');
			$doc = $docs[0];
		}
		else
		{
			$doc = array();
		}

		$content = $this->shortcodeGenerator->getLastDocument($doc, $shortcodeData, $atts);
		return $content;
	}

	public function getDocumentNotOrderedByDate($shortcodeData, $atts)
	{
		$content = '';
		$params = array(
			'folderId' => $atts['id'],
			'pageSize' => 1,
			'startIndex' => 0,
			'resultOrder' => $atts['result_order'],
			'bookmarkSortBy' => 'desc'
		);
		$params = array(
			'pageSize' => '1',
			'resultOrder' => 'desc',
			'startIndex' => '0',
			'documentSortBy' => $atts['order_by'],
		);
		$issuuBookmark = $this->getConfig()->getIssuuServiceApi('IssuuBookmark');
		$result = $issuuBookmark->issuuList($params);

		if ($result['stat'] == 'ok')
		{
			if (!empty($result['bookmark']))
			{
				$book = $result['bookmark'][0];
				$doc = array(
					'id' => $book->documentId,
					'thumbnail' => 'https://image.issuu.com/' . $book->documentId . '/jpg/page_1_thumb_large.jpg',
					'url' => 'https://issuu.com/' . $book->username . '/docs/' . $book->name,
					'title' => $book->title
				);
			}
			else
			{
				$doc = array();
			}
			$content = $this->shortcodeGenerator->getLastDocument($doc, $shortcodeData, $atts);
		}
		else
		{
			$content = $this->getErroApiMessage('issuu-panel-last-document', $result);
		}
		return $content;
	}

	private function getExceptionMessage($shortcode, $exception)
	{
		$content = "<p><em><strong>Issuu Panel:</strong> ";
		$content .= get_issuu_message("An error occurred while we try list your publications");
		$content .= "</em></p>";
		$this->getConfig()->getIssuuPanelDebug()->appendMessage(
			"Shortcode [$shortcode]: Exception - " . $exception->getMessage()
		);
		return $content;
	}

	private function getErroApiMessage($shortcode, $result)
	{
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [$shortcode]: " . $result['message']);
		$content = sprintf(
			'<p><em><strong>Issuu Panel:</strong> E%s %s</em></p>',
			$result['code'],
			get_issuu_message($result['message'])
		);
		return $content;
	}
}
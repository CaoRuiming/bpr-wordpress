<?php

function issuu_painel_embed_documents_shortcode($atts)
{
	$post = get_post();
	$postID = (!is_null($post) && IssuuPanelConfig::inContent())? $post->ID : 0;
	$issuuPanelConfig = IssuuPanelConfig::getInstance();
	$issuu_panel_api_key = IssuuPanelConfig::getVariable('issuu_panel_api_key');
	$issuu_panel_api_secret = IssuuPanelConfig::getVariable('issuu_panel_api_secret');
	$issuu_panel_reader = IssuuPanelConfig::getVariable('issuu_panel_reader');
	$issuu_shortcode_index = IssuuPanelConfig::getNextIteratorByTemplate();
	$inHook = IssuuPanelConfig::getIssuuPanelCatcher()->getCurrentHookIs();
	$page_query_name = 'ip_shortcode' . $issuu_shortcode_index . '_page';
	issuu_panel_debug("Shortcode [issuu-painel-document-list]: Init");
	issuu_panel_debug("Shortcode [issuu-painel-document-list]: Index " . $issuu_shortcode_index . ' in hook ' . $inHook);
	$shortcode = 'issuu-painel-document-list' . $issuu_shortcode_index . $inHook . $postID;

	$atts = shortcode_atts(
		array(
			'order_by' => 'publishDate',
			'result_order' => 'desc',
			'per_page' => '12'
		),
		$atts
	);

	$page = (isset($_GET[$page_query_name]) && is_numeric($_GET[$page_query_name]))?
		intval($_GET[$page_query_name]) : 1;

	if (IssuuPanelConfig::cacheIsActive() && !$issuuPanelConfig->isBot())
	{
		$cache = IssuuPanelConfig::getCache($shortcode, $atts, $page);
		issuu_panel_debug("Shortcode [issuu-painel-document-list]: Cache active");
		if (!empty($cache))
		{
			issuu_panel_debug("Shortcode [issuu-painel-document-list]: Cache used");
			return $cache;
		}
	}

	$params = array(
		'pageSize' => $atts['per_page'],
		'startIndex' => ($atts['per_page'] * ($page - 1)),
		'resultOrder' => $atts['result_order'],
		'documentSortBy' => $atts['order_by']
	);

	try {
		$issuu_document = new IssuuDocument($issuu_panel_api_key, $issuu_panel_api_secret);
		$documents = $issuu_document->issuuList($params);
		issuu_panel_debug("Shortcode [issuu-painel-document-list]: URL - " . $issuu_document->buildUrl());
	} catch (Exception $e) {
		issuu_panel_debug("Shortcode [issuu-painel-document-list]: IssuuDocument->issuuList Exception - " .
			$e->getMessage());
		return "";
	}

	if (isset($documents['stat']) && $documents['stat'] == 'ok')
	{
		if (isset($documents['document']) && !empty($documents['document']))
		{
			$docs = array();
			$pagination = array(
				'pageSize' => $documents['pageSize'],
				'totalCount' => $documents['totalCount']
			);

			foreach ($documents['document'] as $doc) {
				$docs[] = array(
					'id' => $doc->documentId,
					'thumbnail' => 'https://image.issuu.com/' . $doc->documentId . '/jpg/page_1_thumb_large.jpg',
					'url' => 'https://issuu.com/' . $doc->username . '/docs/' . $doc->name,
					'title' => $doc->title,
					'date' => date_i18n('d/F/Y', strtotime($doc->publishDate)),
					'pageCount' => $doc->pageCount
				);
			}
			
			include(ISSUU_PANEL_DIR . 'shortcode/generator.php');

			issuu_panel_debug("Shortcode [issuu-painel-document-list]: List of documents successfully displayed");

			if (IssuuPanelConfig::cacheIsActive() && !$issuuPanelConfig->isBot())
			{
				IssuuPanelConfig::updateCache($shortcode, $content, $atts, $page);
				issuu_panel_debug("Shortcode [issuu-painel-document-list]: Cache updated");
			}
			return $content;
		}
		else
		{
			issuu_panel_debug("Shortcode [issuu-painel-document-list]: No documents in list");
			$content = '<h3>' . get_issuu_message('No documents in list') . '</h3>';
			if (IssuuPanelConfig::cacheIsActive() && !$issuuPanelConfig->isBot())
			{
				IssuuPanelConfig::updateCache($shortcode, $content, $atts, $page);
				issuu_panel_debug("Shortcode [issuu-painel-document-list]: Cache updated");
			}
			return $content;
		}
	}
	else
	{
		issuu_panel_debug("Shortcode [issuu-painel-document-list]: " . $documents['message']);
		$content = '<h3>' . get_issuu_message($documents['message']) . '</h3>';
		if (IssuuPanelConfig::cacheIsActive() && !$issuuPanelConfig->isBot())
		{
			IssuuPanelConfig::updateCache($shortcode, $content, $atts, $page);
			issuu_panel_debug("Shortcode [issuu-painel-document-list]: Cache updated");
		}
		return $content;
	}

}

add_shortcode('issuu-painel-document-list', 'issuu_painel_embed_documents_shortcode');
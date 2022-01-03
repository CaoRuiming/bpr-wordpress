<?php

function issuu_panel_the_last_document($atts)
{
	$post = get_post();
	$postID = (!is_null($post) && IssuuPanelConfig::inContent())? $post->ID : 0;
	$issuuPanelConfig = IssuuPanelConfig::getInstance();
	$issuu_panel_api_key = IssuuPanelConfig::getVariable('issuu_panel_api_key');
	$issuu_panel_api_secret = IssuuPanelConfig::getVariable('issuu_panel_api_secret');
	$issuu_shortcode_index = IssuuPanelConfig::getNextIteratorByTemplate();
	$inHook = IssuuPanelConfig::getIssuuPanelCatcher()->getCurrentHookIs();
	issuu_panel_debug("Shortcode [issuu-panel-last-document]: Init");
	issuu_panel_debug("Shortcode [issuu-panel-last-document]: Index " . $issuu_shortcode_index . ' in hook ' . $inHook);
	$shortcode = 'issuu-panel-last-document' . $issuu_shortcode_index . $inHook . $postID;

	$doc = array();

	$atts = shortcode_atts(
		array(
			'id' => '',
			'link' => '',
			'order_by' => 'publishDate',
			'result_order' => 'desc',
			'per_page' => '12'
		),
		$atts
	);

	if (IssuuPanelConfig::cacheIsActive() && !$issuuPanelConfig->isBot())
	{
		$cache = IssuuPanelConfig::getCache($shortcode, $atts, 1);
		issuu_panel_debug("Shortcode [issuu-panel-last-document]: Cache active");
		if (!empty($cache))
		{
			issuu_panel_debug("Shortcode [issuu-panel-last-document]: Cache used");
			return $cache;
		}
	}

	if (trim($atts['id']) != '')
	{
		try {
			$issuu_bookmark = new IssuuBookmark($issuu_panel_api_key, $issuu_panel_api_secret);
		} catch (Exception $e) {
			issuu_panel_debug("Shortcode [issuu-panel-last-document]: Exception - " . $e->getMessage());
		}
		include(ISSUU_PANEL_DIR . 'shortcode/the-last-document-folder.php');
	}
	else
	{
		try {
			$issuu_document = new IssuuDocument($issuu_panel_api_key, $issuu_panel_api_secret);
			$params = array(
				'resultOrder' => 'desc',
				'startIndex' => '0',
				'documentSortBy' => $atts['order_by'],
				'pageSize' => '1'
			);
			$docs = $issuu_document->issuuList($params);
			$docs = isset($docs['document'])? $docs['document'] : array();

			if (!empty($docs))
			{
				$doc = array(
					'thumbnail' => 'https://image.issuu.com/' . $docs[0]->documentId . '/jpg/page_1_thumb_large.jpg',
					'title' => $docs[0]->title,
					'url' => 'https://issuu.com/' . $docs[0]->username . '/docs/' . $docs[0]->name
				);
			}
			else
			{
				$doc = array();
			}
		} catch (Exception $e) {
			issuu_panel_debug("Shortcode [issuu-panel-last-document]: Exception - " . $e->getMessage());
		}
	}

	$content = '';

	if (!empty($doc))
	{
		if ($atts['link'] != '')
		{
			$content .= '<a href="' . $atts['link'] . '">';
		}
		else
		{
			$content .= '<a href="' . $doc['url'] . '" target="_blank">';
		}

		$content .= '<img id="issuu-panel-last-document" src="' . $doc['thumbnail'] . '" alt="' . $doc['title'] . '"">';

		if ($atts['link'] != '')
		{
			$content .= '</a>';
		}
		issuu_panel_debug("Shortcode [issuu-panel-last-document]: Document displayed");
	}
	else
	{
		$content = '<p>';
		$content .= get_issuu_message('No documents');
		$content .= '</p>';
		issuu_panel_debug("Shortcode [issuu-panel-last-document]: No documents");
	}

	$content .= '<!-- Issuu Panel | Developed by Pedro Marcelo de Sá Alves -->';

	if (IssuuPanelConfig::cacheIsActive() && !$issuuPanelConfig->isBot())
	{
		IssuuPanelConfig::updateCache($shortcode, $content, $atts, 1);
		issuu_panel_debug("Shortcode [issuu-panel-last-document]: Cache updated");
	}

	return $content;
}

add_shortcode('issuu-panel-last-document', 'issuu_panel_the_last_document');
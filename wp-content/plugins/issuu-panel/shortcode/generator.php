<?php

$isMobile = $issuuPanelConfig->getMobileDetect()->isMobile();
$isBot = $issuuPanelConfig->isBot();

$i = 1;
$max = count($docs);
$content = '<div class="issuupainel">';

if ($issuu_panel_reader == 'issuu_embed')
{
	$content .= '<div class="issuu-iframe">';
	$content .= '<div data-document-id="' . $docs[0]['id'] . '" data-issuu-viewer="issuu-viewer-'
		. $issuu_shortcode_index . '" id="issuu-viewer-'
		. $issuu_shortcode_index . '"></div>';
	$content .= '</div><!-- /.issuu-iframe -->';
}

$content .= '<div class="issuu-painel-list">';

foreach ($docs as $doc) {
	if ($i % 3 == 1)
	{
		$content .= '<div class="issuu-document-row">';
	}

	$content .= '<div class="document-cell">';

	if ($isBot == true)
	{
		$content .= '<a href="' . $doc['url'] . '" data-target="issuu-viewer-' . $issuu_shortcode_index . '">';
	}
	else if ($isMobile == true && $issuu_panel_reader != 'issuu_panel_simple_reader')
	{
		$content .= '<a href="' . $doc['url'] . '" data-target="issuu-viewer-' . $issuu_shortcode_index . '" target="_blank">';
	}
	else
	{
		$toggle = ($issuu_panel_reader == 'issuu_panel_simple_reader')? 'issuu-panel-reader' : 'issuu-embed';
		$content .= '<a href="' . $doc['id'] . '" class="link-issuu-document" data-target="issuu-viewer-'
			. $issuu_shortcode_index . '" rel="nofollow" data-toggle="' . $toggle . '" data-count-pages="'
			. $doc['pageCount'] . '">';
	}

	$content .= '<img src="' . $doc['thumbnail'] . '" alt="' . $doc['title'] . '">';
	$content .= '</a><br>';
	$content .= '<span>' . $doc['title'] . '</span>';
	$content .= '</div>';

	if ($i % 3 == 0 || $i == $max)
	{
		$content .= '</div><!-- /.issuu-document-row -->';
	}

	$i++;
}

$content .= '</div><!-- /.issuu-painel-list -->';
$content .= '</div><!-- /.issuupainel -->';

if ($pagination['pageSize'] < $pagination['totalCount'])
{
	$number_pages = ceil($pagination['totalCount'] / $pagination['pageSize']);
	$permalink = get_permalink();

	$content .= '<div class="issuu-painel-paginate">';

	if ($page != 1)
	{
		$content .= '<a href="' . issuu_panel_link_page(1, $permalink, $page_query_name) . '" class="issuu-painel-number-text">'
			. get_issuu_message('« First page') . '</a>';
	}

	$content .= '<div class="issuu-painel-page-numbers">';
	
	$issuu_panel_paginate = new IssuuPanelPaginate($permalink, $page_query_name, $number_pages, $page);
	$content .= $issuu_panel_paginate->paginate('span', 'issuu-painel-number-page', 'issuu-painel-continue');

	$content .= '</div><!-- /.issuu-painel-page-numbers -->';

	if ($page != $number_pages)
	{
		$content .= '<a href="' . issuu_panel_link_page($number_pages, $permalink, $page_query_name) . '" class="issuu-painel-number-text">'
			. get_issuu_message('Last Page »') . '</a>';
	}
	$content .= '</div><!-- /.issuu-painel-paginate -->';
	$content .= '<!-- Issuu Panel | Developed by Pedro Marcelo de Sá Alves -->';
}
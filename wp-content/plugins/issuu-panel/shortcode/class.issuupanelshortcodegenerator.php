<?php

class IssuuPanelShortcodeGenerator implements IssuuPanelService
{
	private $config;

	public function showReader($docs, $shortcodeData)
	{
		$content = '';

		if ($this->getConfig()->getOptionEntity()->getReader() == 'issuu_embed')
		{
			$content .= '<div class="issuu-iframe">';
			$content .= '<div data-document-id="' . $docs[0]['id'] . '" data-issuu-viewer="issuu-viewer-'
				. $shortcodeData['issuu_shortcode_index'] . '" id="issuu-viewer-'
				. $shortcodeData['issuu_shortcode_index'] . '"></div>';
			$content .= '</div><!-- /.issuu-iframe -->';
		}

		return $content;
	}

	public function showDocuments($docs, $shortcodeData)
	{
		$i = 1;
		$max = count($docs);
		$shortcodeIndex = $shortcodeData['issuu_shortcode_index'];
		$isMobile = $this->getConfig()->getMobileDetect()->isMobile();
		$isBot = $this->getConfig()->isBot();
		$reader = $this->getConfig()->getOptionEntity()->getReader();
		$toggle = ($reader == 'issuu_panel_simple_reader')? 'issuu-panel-reader' : 'issuu-embed';
		$content = '<div class="issuu-painel-list">';
		foreach ($docs as $doc) {
			if ($i % 3 == 1)
			{
				$content .= '<div class="issuu-document-row">';
			}

			$content .= '<div class="document-cell">';

			if ($isBot == true)
			{
				$content .= '<a href="' . $doc['url'] . '" data-target="issuu-viewer-' . $shortcodeIndex . '">';
			}
			else if ($isMobile == true && $reader != 'issuu_panel_simple_reader')
			{
				$content .= '<a href="' . $doc['url'] . '" data-target="issuu-viewer-' . $shortcodeIndex . '" target="_blank">';
			}
			else
			{
				$content .= '<a href="' . $doc['id'] . '" class="link-issuu-document" data-target="issuu-viewer-'
					. $shortcodeIndex . '" rel="nofollow" data-toggle="' . $toggle . '" data-count-pages="'
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
		return $content;
	}

	public function showPagination($results, $shortcodeData)
	{
		$content = '';
		$pagination = array(
			'pageSize' => $results['pageSize'],
			'totalCount' => $results['totalCount']
		);
		$pageQueryName = $shortcodeData['page_query_name'];
		$page = $shortcodeData['page'];

		if ($pagination['pageSize'] < $pagination['totalCount'])
		{
			$numberPages = ceil($pagination['totalCount'] / $pagination['pageSize']);
			$permalink = get_permalink();

			$content .= '<div class="issuu-painel-paginate">';

			if ($page != 1)
			{
				$content .= '<a href="' . issuu_panel_link_page(1, $permalink, $pageQueryName)
					. '" class="issuu-painel-number-text">'
					. get_issuu_message('« First page') . '</a>';
			}

			$content .= '<div class="issuu-painel-page-numbers">';
			
			$issuu_panel_paginate = new IssuuPanelPaginate($permalink, $pageQueryName, $numberPages, $page);
			$content .= $issuu_panel_paginate->paginate('span', 'issuu-painel-number-page', 'issuu-painel-continue');

			$content .= '</div><!-- /.issuu-painel-page-numbers -->';

			if ($page != $numberPages)
			{
				$content .= '<a href="' . issuu_panel_link_page($numberPages, $permalink, $pageQueryName)
					. '" class="issuu-painel-number-text">'
					. get_issuu_message('Last Page »') . '</a>';
			}
			$content .= '</div><!-- /.issuu-painel-paginate -->';
		}
		return $content;
	}

	public function getFromRequest($shortcodeData, $atts, $results, $docs)
	{
		$sc = preg_replace("/^([\D]+)(.*)$/", "$1", $shortcodeData['shortcode']);
		$cacheManager = $this->getConfig()->getCacheManager();

		if (!empty($docs))
		{
			$content = '<div class="issuupainel">';
			$content .= $this->showReader($docs, $shortcodeData);
			$content .= $this->showDocuments($docs, $shortcodeData);
			$content .= '</div><!-- /.issuupainel -->';
			$content .= $this->showPagination($results, $shortcodeData);
			$content .= '<!-- Issuu Panel | Developed by Pedro Marcelo de Sá Alves -->';
			$this->getConfig()->getIssuuPanelDebug()->appendMessage(
				"Shortcode [$sc]: List of documents successfully displayed"
			);
		}
		else
		{
			$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [$sc]: No documents in list");
			$content = '<em><strong>Issuu Panel:</strong> ' . get_issuu_message('No documents in list') . '</em>';
		}
		
		if ($cacheManager->cacheIsActive() && !$this->getConfig()->isBot())
		{
			$cacheManager = $this->getConfig()->getCacheManager();
			$cacheManager->updateCache($shortcodeData['shortcode'], $content, $atts, $shortcodeData['page']);
			$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [$sc]: Cache updated");
		}
		return $content;
	}

	public function getFromCache($shortcode, $atts, $page)
	{
		$cacheManager = $this->getConfig()->getCacheManager();
		$cache = '';
		$sc = preg_replace("/^([\D]+)(.*)$/", "$1", $shortcode);

		if ($cacheManager->cacheIsActive() && !$this->getConfig()->isBot())
		{
			$cache = $cacheManager->getCache($shortcode, $atts, $page);
			$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [$sc]: Cache active");

			if (!empty($cache))
			{
				$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [$sc]: Cache used");
			}
		}
		
		return $cache;
	}

	public function getLastDocument($doc, $shortcodeData, $atts)
	{
		$cacheManager = $this->getConfig()->getCacheManager();
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

			$content .= sprintf(
				'<img id="issuu-panel-last-document" src="%s" alt="%s">',
				$doc['thumbnail'],
				$doc['title']
			);
			$content .= '</a>';
			$this->getConfig()->getIssuuPanelDebug()->appendMessage(
				"Shortcode [issuu-panel-last-document]: Document displayed"
			);
		}
		else
		{
			$content = '<p>';
			$content .= get_issuu_message('No documents');
			$content .= '</p>';
			$this->getConfig()->getIssuuPanelDebug()->appendMessage(
				"Shortcode [issuu-panel-last-document]: No documents"
			);
		}

		if ($cacheManager->cacheIsActive() && !$this->getConfig()->isBot())
		{
			$cacheManager = $this->getConfig()->getCacheManager();
			$cacheManager->updateCache($shortcodeData['shortcode'], $content, $atts, 1);
			$this->getConfig()->getIssuuPanelDebug()->appendMessage("Shortcode [issuu-panel-last-document]: Cache updated");
		}
	}

	public function setConfig(IssuuPanelConfig $config)
	{
		$this->config = $config;
	}

	public function getConfig()
	{
		return $this->config;
	}
}
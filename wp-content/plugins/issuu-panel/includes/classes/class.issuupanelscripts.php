<?php

class IssuuPanelScripts implements IssuuPanelService
{
	private $config;

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'wpScripts'));
		add_action('admin_enqueue_scripts', array($this, 'adminScripts'));
	}

	public function wpScripts()
	{
		$jsDependences = array('jquery');
		wp_enqueue_style('issuu-painel-documents', ISSUU_PANEL_URL . 'assets/css/issuu-painel-documents.min.css');

		switch ($this->getConfig()->getOptionEntity()->getReader()) {
			case 'issuu_embed':
				wp_enqueue_script(
					'issuu-panel-swfobject',
					ISSUU_PANEL_URL . 'assets/js/swfobject/swfobject.js',
					array('jquery'),
					null,
					true
				);
				$jsDependences[] = 'issuu-panel-swfobject';
				break;
			case 'issuu_panel_simple_reader':
				wp_enqueue_script(
					'issuu-panel-simple-reader',
					ISSUU_PANEL_URL . 'includes/reader/js/jquery.issuupanelreader.min.js',
					array('jquery'),
					null,
					true
				);
				$jsDependences[] = 'issuu-panel-simple-reader';
				break;
		}
		
		wp_enqueue_script(
			'issuu-panel-reader',
			ISSUU_PANEL_URL . 'assets/js/issuu-panel-reader.min.js',
			$jsDependences,
			null,
			true
		);

		wp_localize_script(
			'issuu-panel-reader',
			'issuuPanelReaderObject',
			array(
				'adminAjax' => admin_url('admin-ajax.php')
			)
		);
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Hook wp_enqueue_scripts");
	}

	public function adminScripts()
	{
		wp_enqueue_style(
			'issuu-painel-pagination',
			ISSUU_PANEL_URL . 'assets/css/issuu-painel-pagination.min.css',
			array(),
			null,
			'screen, print'
		);
		wp_enqueue_style('document-list', ISSUU_PANEL_URL . 'assets/css/document-list.min.css', array(), null, 'screen, print');
		wp_enqueue_style('folder-list', ISSUU_PANEL_URL . 'assets/css/folder-list.min.css', array('dashicons'), null, 'screen, print');
		wp_enqueue_script('json2');
		wp_enqueue_script('jquery');

		wp_localize_script(
			'jquery',
			'issuuPanelObject',
			array(
				'loadingText' => get_issuu_message('Loading')
			)
		);

		if (filter_input(INPUT_GET, 'page') == 'issuu-document-admin')
		{
			if (!is_null(filter_input(INPUT_GET, 'upload')))
			{
				wp_enqueue_script(
					'issuu-painel-document-upload-js',
					ISSUU_PANEL_URL . 'assets/js/document-upload.min.js',
					array('jquery'),
					null,
					true
				);
			}
			else if (!is_null(filter_input(INPUT_GET, 'update')))
			{
				wp_enqueue_script(
					'issuu-painel-document-update-js',
					ISSUU_PANEL_URL . 'assets/js/document-update.min.js',
					array('jquery'),
					null,
					true
				);
			}
			else if (!is_null(filter_input(INPUT_GET, 'url_upload')))
			{
				wp_enqueue_script(
					'issuu-painel-document-url-upload-js',
					ISSUU_PANEL_URL . 'assets/js/document-url-upload.min.js',
					array('jquery'),
					null,
					true
				);
			}
		}
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Hook admin_enqueue_scripts");
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
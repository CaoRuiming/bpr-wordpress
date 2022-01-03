<?php

class IssuuPanelSimpleReader
{
	public function __construct()
	{
		add_action('wp_ajax_nopriv_open_issuu_panel_reader', array($this, 'reader'));
		add_action('wp_ajax_open_issuu_panel_reader', array($this, 'reader'));
	}

	public function reader()
	{
		$docId = filter_input(INPUT_GET, 'docId');
		$pageCount = filter_input(INPUT_GET, 'pageCount');
		include(ISSUU_PANEL_DIR . 'includes/reader/reader.phtml');
		die();
	}
}
<?php

class IssuuPanelMenu implements IssuuPanelPage
{
	private $config = null;

	public function __construct()
	{
		add_action(ISSUU_PANEL_PREFIX . 'menu_page', array($this, 'init'));
	}

	public function init()
	{
		add_menu_page(
			'Issuu Panel',
			'Issuu Panel',
			$this->getConfig()->getCapability(),
			ISSUU_PANEL_MENU,
			array($this, 'page'),
			ISSUU_PANEL_URL . 'assets/images/icon2.png'
		);
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Issuu Panel Page (Main)");
	}

	public function page()
	{
		$issuu_panel_api_key = $this->getConfig()->getOptionEntity()->getApiKey();
		$issuu_panel_api_secret = $this->getConfig()->getOptionEntity()->getApiSecret();
		$issuu_panel_capacity = $this->getConfig()->getCapability();
		$issuu_panel_reader = $this->getConfig()->getOptionEntity()->getReader();
		$issuu_embed = ($issuu_panel_reader == 'issuu_embed')? 'checked' : '';
		$issuu_panel_simple_reader = ($issuu_panel_reader == 'issuu_panel_simple_reader')? 'checked' : '';
		$capabilities = $this->getConfig()->getCapabilities();

		$link_api_service = '<a target="_blank" href="https://issuu.com/home/settings/apikey">click here</a>';
		$issuu_panel_debug = ($this->getConfig()->getOptionEntity()->getDebug() == 'active')? 'checked' : '';
		$issuu_panel_cache_status = ($this->getConfig()->getOptionEntity()->getCacheStatus() == 'active')? 'checked' : '';

		require(ISSUU_PANEL_DIR . 'menu/main/page.phtml');
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
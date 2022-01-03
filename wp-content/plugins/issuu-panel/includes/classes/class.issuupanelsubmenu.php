<?php

abstract class IssuuPanelSubmenu implements IssuuPanelPage
{
	protected $slug;

	protected $menu_title;

	protected $page_title;

	protected $priority = 1;

	private $config = null;

	public function __construct()
	{
		add_action(ISSUU_PANEL_PREFIX . 'submenu_pages', array($this, 'init'), $this->priority);
	}

	public function init()
	{
		add_submenu_page(
			ISSUU_PANEL_MENU,
			get_issuu_message($this->page_title),
			get_issuu_message($this->menu_title),
			$this->getConfig()->getCapability(),
			$this->slug,
			array($this, 'page')
		);	
	}

	public function setConfig(IssuuPanelConfig $config)
	{
		$this->config = $config;
	}

	public function getConfig()
	{
		return $this->config;
	}

	protected function getErrorMessage($message)
	{
		echo "<div class=\"wrap\">";
		echo "<h1>";
		echo "<strong>Issuu Panel:</strong> ";
		echo $message;
		echo "</h1>";
		echo "</div>";
	}
}
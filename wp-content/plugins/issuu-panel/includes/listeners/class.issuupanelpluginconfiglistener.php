<?php

class IssuuPanelPluginConfigListener
{
	public function __construct()
	{
		add_action('on-active-issuu-panel', array($this, 'initPluginOptions'));
		add_action('on-uninstall-issuu-panel', array($this, 'uninstallPluginOptions'));
	}

	public function initPluginOptions(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getOptionEntityManager()->addOptionEntity($config->getOptionEntity());
		$config->getIssuuPanelDebug()->appendMessage("Issuu Panel options initialized");
	}

	public function uninstallPluginOptions(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getOptionEntityManager()->deleteOptionEntity($config->getOptionEntity());
	}
}
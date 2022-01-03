<?php

class IssuuPanel
{
	private static $issuuPanelPluginManager;

	public static function init()
	{
		self::$issuuPanelPluginManager = new IssuuPanelPluginManager();
		register_activation_hook(ISSUU_PANEL_PLUGIN_FILE, array('IssuuPanel', 'activePlugin'));
		register_uninstall_hook(ISSUU_PANEL_PLUGIN_FILE, array('IssuuPanel', 'uninstallPlugin'));
	}

	public static function activePlugin()
	{
		self::$issuuPanelPluginManager->getHookManager()->triggerAction('issuu-panel-active-plugin-action');
	}

	public static function uninstallPlugin()
	{
		self::$issuuPanelPluginManager->getHookManager()->triggerAction('issuu-panel-uninstall-plugin-action');
	}
}
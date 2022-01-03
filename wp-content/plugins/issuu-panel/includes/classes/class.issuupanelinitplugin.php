<?php

class IssuuPanelInitPlugin implements IssuuPanelService
{
	private $config;

	public function __construct()
	{
		add_action('plugins_loaded', array($this, 'loadTextdomain'));
		add_action('dynamic_sidebar', array($this, 'dependencyInjectorSidebar'), -600);
		add_filter('widget_form_callback', array($this, 'dependencyInjectorWidget'), -600, 2);
		add_action('admin_menu', array($this, 'adminMenu'));
		add_action('init', array($this, 'initHook'));
		add_action('shutdown', array($this, 'shutdownHook'));
		add_action('issuu-panel-active-plugin-action', array($this, 'activePlugin'));
		add_action('issuu-panel-uninstall-plugin-action', array($this, 'uninstallPlugin'));
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain(ISSUU_PANEL_DOMAIN_LANG, false, ISSUU_PANEL_PLUGIN_FILE_LANG);
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Text domain loaded");
	}

	public function dependencyInjectorSidebar($params)
	{
		$obj = $params['callback'][0];

		if (is_object($obj) && $obj instanceof IssuuPanelService)
		{
			$obj->setConfig($this->getConfig());
		}
	}

	public function dependencyInjectorWidget($instance, $widget)
	{
		if (is_object($widget) && $widget instanceof IssuuPanelService)
		{
			$widget->setConfig($this->getConfig());
		}
		return $instance;
	}

	public function adminMenu()
	{
		$apiKey = $this->getConfig()->getOptionEntity()->getApiKey();
		$apiSecret = $this->getConfig()->getOptionEntity()->getApiSecret();
		$this->getConfig()->getHookManager()->triggerAction(ISSUU_PANEL_PREFIX . 'menu_page');
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Issuu Panel menu loaded");

		if (!empty($apiKey) && !empty($apiSecret))
		{
			$this->getConfig()->getHookManager()->triggerAction(ISSUU_PANEL_PREFIX . 'submenu_pages');
			$this->getConfig()->getIssuuPanelDebug()->appendMessage("Issuu Panel submenus loaded");
		}
	}
	
	public function initHook()
	{
		if (!is_null(filter_input(INPUT_GET, 'issuu_panel_flush_cache')))
		{
			$this->getConfig()->getHookManager()->triggerAction(
				'pre-flush-issuu-panel-cache',
				null,
				array(
					'config' => $this->getConfig(),
				)
			);
			$this->getConfig()->getHookManager()->triggerAction(
				'on-flush-issuu-panel-cache',
				null,
				array(
					'config' => $this->getConfig(),
				)
			);
			$this->getConfig()->getHookManager()->triggerAction(
				'pos-flush-issuu-panel-cache',
				null,
				array(
					'config' => $this->getConfig(),
				)
			);
		}

		if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' &&
			(filter_input(INPUT_GET, 'page') == ISSUU_PANEL_MENU))
		{
			$this->getConfig()->getHookManager()->triggerAction(
				'post-issuu-panel-config',
				null,
				array(
					'config' => $this->getConfig(),
					'postData' => filter_input_array(INPUT_POST),
				)
			);
		}
	}

	public function shutdownHook()
	{
		$this->getConfig()->getHookManager()->triggerAction(
			'on-shutdown-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
		);
	}

	public function activePlugin()
	{
		$this->getConfig()->getHookManager()->triggerAction(
			'pre-active-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
		);
		$this->getConfig()->getHookManager()->triggerAction(
			'on-active-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
		);
		$this->getConfig()->getHookManager()->triggerAction(
			'pos-active-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
		);
	}

	public function uninstallPlugin()
	{
		$this->getConfig()->getHookManager()->triggerAction(
			'pre-uninstall-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
		);
		$this->getConfig()->getHookManager()->triggerAction(
			'on-uninstall-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
		);
		$this->getConfig()->getHookManager()->triggerAction(
			'pos-uninstall-issuu-panel',
			null,
			array(
				'config' => $this->getConfig(),
			)
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
}
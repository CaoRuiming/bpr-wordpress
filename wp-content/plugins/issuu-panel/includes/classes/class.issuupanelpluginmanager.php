<?php

class IssuuPanelPluginManager
{
	private $issuuPanelHookManager;

	private $issuuPanelOptionEntity;

	private $issuuPanelConfig;

	private $issuuPanelOptionEntityManager;

	public function __construct()
	{
		$this->issuuPanelOptionEntityManager = new IssuuPanelOptionEntityManager();
		$this->issuuPanelOptionEntity = $this->getOptionEntityManager()->getOptionEntity();
		$this->issuuPanelConfig = new IssuuPanelConfig(
			$this->issuuPanelOptionEntity,
			$this->issuuPanelOptionEntityManager
		);
		$this->issuuPanelHookManager = $this->issuuPanelConfig->getHookManager();
		$this->initListeners();
		$this->initPlugin();
		$this->initMenus();
		$this->initShortcodes();
		add_action('widgets_init', array($this, 'initWidgets'));
		$this->getHookManager()->triggerAction(
			'on-construct-issuu-panel-plugin-manager',
			$this,
			array(
				'entity' => $this->issuuPanelOptionEntity,
				'config' => $this->issuuPanelConfig,
			)
		);
	}
	
	public function getOptionEntityManager()
	{
		return $this->issuuPanelOptionEntityManager;
	}

	public function getHookManager()
	{
		return $this->issuuPanelHookManager;
	}

	public function initPlugin()
	{
		$initPlugin = new IssuuPanelInitPlugin();
		$initPlugin->setConfig($this->issuuPanelConfig);
		$scripts = new IssuuPanelScripts();
		$scripts->setConfig($this->issuuPanelConfig);
		$tinymce = new IssuuPanelTinyMCEButton();
		$tinymce->setConfig($this->issuuPanelConfig);
	}

	private function initListeners()
	{
		new IssuuPanelLogListener();
		$ajaxRequestListener = new IssuuPanelAjaxRequestListener();
		$ajaxRequestListener->setConfig($this->issuuPanelConfig);
		new IssuuPanelDocumentListener();
		new IssuuPanelFolderListener();
		new IssuuPanelUpdateDataListener();
		new IssuuPanelPluginConfigListener();
		new IssuuPanelFolderCacheListener();
	}

	private function initMenus()
	{
		$main = new IssuuPanelMenu();
		$main->setConfig($this->issuuPanelConfig);

		$document = new IssuuPanelPageDocuments();
		$document->setConfig($this->issuuPanelConfig);

		$folder = new IssuuPanelPageFolders();
		$folder->setConfig($this->issuuPanelConfig);

		$about = new IssuuPanelPageAbout();
		$about->setConfig($this->issuuPanelConfig);
	}

	private function initShortcodes()
	{
		$shortcodeGenerator = new IssuuPanelShortcodeGenerator();
		$shortcodeGenerator->setConfig($this->issuuPanelConfig);
		$shortcode = new IssuuPanelShortcodes($shortcodeGenerator);
		$shortcode->setConfig($this->issuuPanelConfig);
	}

	public function initWidgets()
	{
		register_widget('IssuuPanelWidget');
	}
}
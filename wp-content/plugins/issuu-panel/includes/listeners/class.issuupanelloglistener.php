<?php

class IssuuPanelLogListener
{
	public function __construct()
	{
		add_action('on-construct-issuu-panel-plugin-manager', array($this, 'registerHookInLog'), -1000);

		add_action('pre-flush-issuu-panel-cache', array($this, 'registerHookInLog'), -1000);
		add_action('on-flush-issuu-panel-cache', array($this, 'registerHookInLog'), -1000);
		add_action('pos-flush-issuu-panel-cache', array($this, 'registerHookInLog'), -1000);

		add_action('post-issuu-panel-config', array($this, 'registerHookInLog'), -1000);

		add_action('on-shutdown-issuu-panel', array($this, 'registerHookInLog'), -1000);

		add_action('pre-active-issuu-panel', array($this, 'registerHookInLog'), -1000);
		add_action('on-active-issuu-panel', array($this, 'registerHookInLog'), -1000);
		add_action('pos-active-issuu-panel', array($this, 'registerHookInLog'), -1000);

		add_action('pre-uninstall-issuu-panel', array($this, 'registerHookInLog'), -1000);
		add_action('on-uninstall-issuu-panel', array($this, 'registerHookInLog'), -1000);
		add_action('pos-uninstall-issuu-panel', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-upload-document', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-upload-document', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-upload-document', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-url-upload-document', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-url-upload-document', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-url-upload-document', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-update-document', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-update-document', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-update-document', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-delete-document', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-delete-document', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-delete-document', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-ajax-docs', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-ajax-docs', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-ajax-docs', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-add-folder', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-add-folder', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-add-folder', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-update-folder', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-update-folder', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-update-folder', array($this, 'registerHookInLog'), -1000);

		add_action('pre-issuu-panel-delete-folder', array($this, 'registerHookInLog'), -1000);
		add_action('on-issuu-panel-delete-folder', array($this, 'registerHookInLog'), -1000);
		add_action('pos-issuu-panel-delete-folder', array($this, 'registerHookInLog'), -1000);
	}

	public function registerHookInLog(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getIssuuPanelDebug()->appendMessage(sprintf(
			"On '%s' hook",
			$hook->getName()
		));
	}
}
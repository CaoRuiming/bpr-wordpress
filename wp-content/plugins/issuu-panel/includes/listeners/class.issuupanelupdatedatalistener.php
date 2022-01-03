<?php

class IssuuPanelUpdateDataListener
{
	public function __construct()
	{
		add_action('post-issuu-panel-config', array($this, 'postConfigData'));
		add_action('on-flush-issuu-panel-cache', array($this, 'onFlushCache'));
		add_action('on-cron-flush-issuu-panel-cache', array($this, 'onFlushCache'));
		add_action('on-construct-issuu-panel-plugin-manager', array($this, 'initListener'));
		add_action('on-shutdown-issuu-panel', array($this, 'persistConfigData'));
	}

	public function postConfigData(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$postData = $hook->getParam('postData');

		$config->getOptionEntity()->setApiKey($postData['api_key']);
		$config->getOptionEntity()->setApiSecret($postData['api_secret']);
		$config->getOptionEntity()->setReader($postData['issuu_panel_reader']);
		$config->getOptionEntity()->setEnabledUser($postData['enabled_user']);

		if (isset($postData['issuu_panel_debug']) && $postData['issuu_panel_debug'] == 'active')
		{
			$config->getOptionEntity()->setDebug('active');
		}
		else
		{
			$postData['issuu_panel_debug'] = 'disable';
			$config->getOptionEntity()->setDebug('disable');
		}

		if (isset($postData['issuu_panel_cache_status']) && $postData['issuu_panel_cache_status'] == 'active')
		{
			$config->getOptionEntity()->setCacheStatus('active');
		}
		else
		{
			$postData['issuu_panel_cache_status'] = 'disable';
			$config->getOptionEntity()->setCacheStatus('disable');
		}
		$config->getIssuuPanelDebug()->appendMessage("Issuu Panel options updated in init hook");
		$hook->setParam('postData', $postData);
	}

	public function initListener(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getIssuuPanelCron()->addScheduledAction('on-cron-flush-issuu-panel-cache', 'hour');
	}

	public function persistConfigData(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getOptionEntityManager()->updateOptionEntity(
			$config->getOptionEntity()
		);
	}

	public function onFlushCache(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getOptionEntity()->setShortcodeCache(array());
	}
}
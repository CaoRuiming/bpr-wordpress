<?php

class IssuuPanelCron
{
	/**
	*	Hour in seconds
	*
	*	@var integer
	*	@access protected
	*/
	protected static $HOUR = 3600;

	/**
	*	Day in seconds
	*
	*	@var integer
	*	@access protected
	*/
	protected static $DAY = 86400;

	/**
	*	Week in seconds
	*
	*	@var integer
	*	@access protected
	*/
	protected static $WEEK = 604800;

	/**
	*	Month in seconds
	*
	*	@var integer
	*	@access protected
	*/
	protected static $MONTH = 2592000;

	/**
	*	Array of scheduled actions
	*
	*	@var array
	*	@access private
	*/
	private $scheduledActions = array();

	/**
	*	Issuu Panel config
	*
	*	@var IssuuPanelConfig
	*	@access private
	*/
	private $config;

	public function __construct($config)
	{
		$this->config = $config;
		$this->scheduledActions = $this->config->getOptionEntity()->getCron();
		add_action('init', array($this, 'trigger'));
	}

	public function trigger()
	{
		foreach ($this->scheduledActions as $key => $action) {
			if ($action['init'] + $action['next_trigger'] <= current_time('timestamp'))
			{
				if (has_action($key) === false)
				{
					unset($this->scheduledActions[$key]);
				}
				else
				{
					$this->config->getIssuuPanelDebug()->appendMessage(sprintf(
						"CRON - '%s' hook triggered",
						$key
					));
					$this->config->getHookManager()->triggerAction($key, null, array('config' => $this->config));
					$this->updateAction($key);
				}
			}
		}

		$this->config->getOptionEntity()->setCron($this->scheduledActions);
	}

	public function addScheduledAction($key, $interval = 'week')
	{
		if (is_int($interval) && $interval > 0)
		{
			$time = $interval;
		}
		else
		{
			switch ($interval) {
				case 'hour':
					$time = self::$HOUR;
					break;
				case 'day':
					$time = self::$DAY;
					break;
				case 'week':
					$time = self::$WEEK;
					break;
				case 'month':
					$time = self::$MONTH;
					break;
				default:
					$time = self::$WEEK;
					break;
			}
		}


		if (!isset($this->scheduledActions[$key]))
		{
			$this->scheduledActions[$key] = array(
				'init' => current_time('timestamp'),
				'next_trigger' => $time,
			);
		}
		else
		{
			if ($this->scheduledActions[$key]['next_trigger'] != $time)
			{
				$this->scheduledActions[$key]['next_trigger'] = $time;
			}
		}

		return $this;
	}

	public function getActionsKeys()
	{
		return array_keys($this->scheduledActions);
	}

	protected function updateAction($key)
	{
		if (isset($this->scheduledActions[$key]))
		{
			$this->scheduledActions[$key]['init'] = current_time('timestamp');
		}
	}

	// public function setActions($actions)
	// {
	// 	if (is_string($actions))
	// 	{
	// 		$this->scheduledActions = unserialize($actions);
	// 	}
	// 	else if (is_array($actions))
	// 	{
	// 		$this->scheduledActions = $actions;
	// 	}
	// 	else
	// 	{
	// 		$this->scheduledActions = array();
	// 	}

	// 	return $this;
	// }
}
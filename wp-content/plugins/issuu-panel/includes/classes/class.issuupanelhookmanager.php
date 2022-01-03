<?php

class IssuuPanelHookManager
{
	public function addAction($name, $callback, $priority = 10, $acceptedArgs = 1)
	{
		if (!is_callable($callback))
			return false;
		return add_action($name, $callback, $priority, $acceptedArgs);
	}

	public function addAjaxAction($name, $callback, $priority = 10, $acceptedArgs = 1, $isPublic = false)
	{
		if (!is_callable($callback))
			return false;
		$action = new IssuuPanelAction();

		if ($isPublic === true)
		{
			$action->setPublicAjaxName($name);
		}
		else
		{
			$action->setAjaxName($name);
		}
		return add_action($action->getName(), $callback, $priority, $acceptedArgs);
	}

	public function triggerAction($name, $target = null, array $data = array())
	{
		$action = new IssuuPanelAction();
		$action->setName($name);
		$action->setTarget($target);
		$action->setParams($data);
		do_action($name, $action);
		return $action;
	}

	public function addFilter($name, $callback, $priority = 10, $acceptedArgs = 1)
	{
		if (!is_callable($callback))
			return false;
		return add_filter($name, $callback, $priority, $acceptedArgs);
	}

	public function triggerFilter($name, $target = null, array $data = array())
	{
		$filter = new IssuuPanelFilter();
		$filter->setName($name);
		$filter->setParams($data);
		$filter->setTarget($target);
		return apply_filter($name, $filter);
	}

}
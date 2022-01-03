<?php

class IssuuPanelAction implements IssuuPanelHook
{
	const WP_AJAX_PREFIX = 'wp_ajax_';

	const WP_AJAX_NOPRIV_PREFIX = 'wp_ajax_nopriv_';

	private $name;

	private $params = array();

	private $target;

	/**
	*	{@inheritDoc}
	*/
	public function setName($name)
	{
		if (is_string($name))
		{
			$this->name = $name;
		}
	}

	/**
	*	{@inheritDoc}
	*/
	public function getName()
	{
		return $this->name;
	}

	/**
	*	Set ajax hook name
	*
	*	@param string $name
	*/
	public function setAjaxName($name)
	{
		$this->setName(self::WP_AJAX_PREFIX . $name);
	}

	/**
	*	Set public ajax hook name
	*
	*	@param string $name
	*/
	public function setPublicAjaxName($name)
	{
		$this->setName(self::WP_AJAX_NOPRIV_PREFIX . $name);
	}

	/**
	*	{@inheritDoc}
	*/
	public function setParam($name, $value)
	{
		if (is_string($name))
		{
			$this->params[$name] = $value;
		}
	}

	/**
	*	{@inheritDoc}
	*/
	public function getParam($name, $default = null)
	{
		return (isset($this->params[$name]))? $this->params[$name] : $default;
	}

	/**
	*	{@inheritDoc}
	*/
	public function setParams(array $params, $clearParams = false)
	{
		if ($clearParams == true)
			$this->params = array();
		
		foreach ($params as $key => $value) {
			$this->setParam($key, $value);
		}
	}

	/**
	*	{@inheritDoc}
	*/
	public function getParams()
	{
		return $this->params;
	}

	/**
	*	{@inheritDoc}
	*/
	public function setTarget($target)
	{
		$this->target = $target;
	}

	/**
	*	{@inheritDoc}
	*/
	public function getTarget()
	{
		return $this->target;
	}
}
<?php

class IssuuPanelFilter implements IssuuPanelHook
{
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
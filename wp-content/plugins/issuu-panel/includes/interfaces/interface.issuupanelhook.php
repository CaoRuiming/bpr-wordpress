<?php

interface IssuuPanelHook
{
	/**
	*	Set hook name
	*
	*	@param string $name
	*/
	public function setName($name);

	/**
	*	Get hook name
	*
	*	@return string
	*/
	public function getName();

	/**
	*	Set hook param
	*
	*	@param string $name
	*	@param mixed $value
	*/
	public function setParam($name, $value);

	/**
	*	Get hook param
	*
	*	@param string $name
	*	@param mixed $default
	*	@return mixed
	*/
	public function getParam($name, $default = null);

	/**
	*	Set hook params
	*
	*	@param array $params
	*	@param bool $clearParams
	*/
	public function setParams(array $params, $clearParams = false);

	/**
	*	Get hook params
	*
	*	@return array
	*/
	public function getParams();

	/**
	*	Set hook target
	*
	*	@return mixed $target
	*/
	public function setTarget($target);

	/**
	*	Get hook target
	*
	*	@return mixed
	*/
	public function getTarget();
}
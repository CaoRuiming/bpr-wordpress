<?php

class IssuuPanelFolderCacheEntity
{
	private $folders = array();

	public function __construct($folders = array())
	{
		$this->setFolders($folders);
	}

	public function toString()
	{
		return serialize($this->folders);
	}

	public function setFolder($key, array $documents = array(), $cleanIfExists = false)
	{
		if (isset($this->folders[$key]))
		{
			if ($cleanIfExists === true)
			{
				$this->folders[$key] = $documents;
			}
			else
			{
				$this->folders[$key] = array_merge($this->folders[$key], $documents);
			}
		}
		else
		{
			$this->folders[$key] = $documents;
		}
	}

	public function getFolder($key)
	{
		return (isset($this->folders[$key]))? $this->folders[$key] : array();
	}

	public function getFolders()
	{
		return $this->folders;
	}

	private function setFolders($folders)
	{
		if (is_array($folders))
		{
			$this->folders = $folders;
		}
		else if (is_string($folders))
		{
			$this->folders = unserialize($folders);
		}
	}
}
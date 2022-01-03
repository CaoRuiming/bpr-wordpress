<?php

class IssuuPanelFolderCacheEntityManager
{
	/**
	*
	*	@var string
	*/
	private $filepath;

	public function __construct($dir)
	{
		$this->filepath = $dir . 'folder-documents.txt';
		$this->createFileIfNotExists();
	}

	public function updateCache(IssuuPanelFolderCacheEntity $entity)
	{
		file_put_contents($this->filepath, $entity->toString());
		chmod($this->filepath, 0644);
	}

	public function getCache()
	{
		$cache = file_get_contents($this->filepath);
		$entity = new IssuuPanelFolderCacheEntity($cache);
		return $entity;
	}

	public function deleteFolder($folder, IssuuPanelFolderCacheEntity $entity)
	{
		$folders = $entity->getFolders();

		if (isset($folders[$folder]))
		{
			unset($folders[$folder]);
			$entity = new IssuuPanelFolderCacheEntity($folders);
		}
	}

	public function createFileIfNotExists()
	{
		if (!is_file($this->filepath))
		{
			file_put_contents($this->filepath, serialize(array()));
		}
	}
}
<?php

class IssuuPanelOptionEntityManager
{
	public function addOptionEntity($entity)
	{
		$data = $entity->toArray(true);
		foreach ($data as $key => $value) {
			add_option($key, $value);
		}
	}

	public function updateOptionEntity($entity)
	{
		$data = $entity->toArray(true);
		foreach ($data as $key => $value) {
			update_option($key, $value);
		}
	}

	public function getOptionEntity()
	{
		$entity = new IssuuPanelOptionEntity();
		$keys = array_keys($entity->toArray());
		$values = array();
		foreach ($keys as $key) {
			$values[$key] = get_option($key);
		}
		$entity->exchangeArray($values);
		return $entity;
	}

	public function deleteOptionEntity($entity)
	{
		$keys = array_keys($entity->toArray());
		foreach ($keys as $key) {
			delete_option($key);
		}
	}
}
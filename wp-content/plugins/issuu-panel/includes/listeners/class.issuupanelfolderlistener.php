<?php

class IssuuPanelFolderListener
{
	public function __construct()
	{
		add_action('on-issuu-panel-add-folder', array($this, 'addFolder'));
		add_action('on-issuu-panel-update-folder', array($this, 'updateFolder'));
		add_action('on-issuu-panel-delete-folder', array($this, 'deleteFolder'));
	}

	public function addFolder(IssuuPanelHook $hook)
	{
		$postData = $hook->getParam('postData');
		$config = $hook->getParam('config');
		foreach ($postData as $key => $value) {
			if (($postData[$key] = trim($value)) == "")
			{
				unset($postData[$key]);
			}
		}
		$response = $config->getIssuuServiceApi('IssuuFolder')->add($postData);

		if ($response['stat'] == 'ok')
		{
			$hook->setParam('status', 'success');
			$message = sprintf(
				'<div class="updated"><p>%s - <a href="/wp-admin/admin.php?page=issuu-folder-admin">%s</a></p></div>',
				get_issuu_message('Folder created successfully'),
				get_issuu_message('Back')
			);
		}
		else
		{
			$hook->setParam('status', 'fail');
			$message = sprintf('<div class="error"><p>%s - %s%s</p></div>',
				get_issuu_message('Error while creating the folder'),
				$response['message'],
				(($response['field'] != '')? ' :' . $response['field'] : '')
			);
		}
		$hook->setParam('message', $message);
	}

	public function updateFolder(IssuuPanelHook $hook)
	{
		$postData = $hook->getParam('postData');
		$config = $hook->getParam('config');
		foreach ($postData as $key => $value) {
			$postData[$key] = trim($value);
		}
		$response = $config->getIssuuServiceApi('IssuuFolder')->update($postData);

		if ($response['stat'] == 'ok')
		{
			$hook->setParam('status', 'success');
			$message = sprintf(
				'<div class="updated"><p>%s - <a href="/wp-admin/admin.php?page=issuu-folder-admin">%s</a></p></div>',
				get_issuu_message('Folder updated successfully'),
				get_issuu_message('Back')
			);
		}
		else
		{
			$hook->setParam('status', 'fail');
			$message = sprintf(
				'<div class="error"><p>%s - %s</p></div>',
				get_issuu_message('Error while updating the folder'),
				$response['message']
			);
		}
		$hook->setParam('message', $message);
	}

	public function deleteFolder(IssuuPanelHook $hook)
	{
		$postData = $hook->getParam('postData');
		$config = $hook->getParam('config');
		$postData['folderId'] = (isset($postData['folderId']))? $postData['folderId'] : array();
		$count = count($postData['folderId']);

		if ($count > 0)
		{
			$result = $config->getIssuuServiceApi('IssuuFolder')->delete(array(
				'folderIds' => implode(',', $postData['folderId'])
			));

			if ($result['stat'] == 'ok')
			{
				$hook->setParam('status', 'success');
				$hook->setParam('folders', $postData['folderId']);

				if ($count > 1)
				{
					$message = sprintf(
						'<div class="updated"><p>%s</p></div>',
						get_issuu_message('Folders deleted successfully')
					);
				}
				else
				{
					$message = sprintf(
						'<div class="updated"><p>%s</p></div>',
						get_issuu_message('Folder deleted successfully')
					);
				}
			}
			else if ($result['stat'] == 'fail')
			{
				$hook->setParam('status', 'fail');
				$message = sprintf(
					'<div class="error"><p>%s</p></div>',
					$result['message']
				);
			}
		}
		else
		{
			$hook->setParam('status', 'warning');
			$message = sprintf(
				'<div class="update-nag">%s</div>',
				get_issuu_message('Nothing was excluded')
			);
		}
		$hook->setParam('message', $message);
	}
}
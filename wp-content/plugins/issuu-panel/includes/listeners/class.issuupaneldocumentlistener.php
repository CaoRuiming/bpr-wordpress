<?php

class IssuuPanelDocumentListener
{
	public function __construct()
	{
		add_action('on-issuu-panel-upload-document', array($this, 'uploadDocument'));
		add_action('on-issuu-panel-url-upload-document', array($this, 'urlUploadDocument'));
		add_action('on-issuu-panel-update-document', array($this, 'updateDocument'));
		add_action('on-issuu-panel-delete-document', array($this, 'deleteDocument'));
		add_action('on-issuu-panel-ajax-docs', array($this, 'ajaxDocs'));
	}

	public function uploadDocument(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$issuuDocument = $config->getIssuuServiceApi('IssuuDocument');
		$postData = $hook->getParam('postData');

		if (is_null($issuuDocument))
			return;

		$message = $hook->getParam('message', '');
		$this->createDatetime($postData);

		try {
			$result = $issuuDocument->upload($postData);
		} catch (Exception $e) {
			$config->getIssuuPanelDebug()->appendMessage("Upload Document Exception - " . $e->getMessage());
			$result = array('stat' => '');
		}

		if ($result['stat'] == 'ok')
		{
			$hook->setParam('status', 'success');
			$message .= sprintf(
				'<div class="updated"><p>%s - <a href="/wp-admin/admin.php?page=issuu-document-admin">%s</a></p></div>',
				get_issuu_message('Document sent successfully'),
				get_issuu_message('Back')
			);
		}
		else if ($result['stat'] == 'fail')
		{
			$hook->setParam('status', 'fail');
			$message .= '<div class="error"><p>' . get_issuu_message($result['message'])
				. ((isset($result['field']))? ': ' . $result['field'] : '') . '</p></div>';
		}

		$hook->setParam('message', $message);
	}

	public function urlUploadDocument(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$issuuDocument = $config->getIssuuServiceApi('IssuuDocument');
		$postData = $hook->getParam('postData');

		if (is_null($issuuDocument))
			return;

		$message = $hook->getParam('message', '');
		$this->createDatetime($postData);

		try {
			$result = $issuuDocument->urlUpload($postData);
		} catch (Exception $e) {
			$config->getIssuuPanelDebug()->appendMessage("URL Upload Document Exception - " . $e->getMessage());
			$result = array('stat' => '');
		}

		if ($result['stat'] == 'ok')
		{
			$hook->setParam('status', 'success');
			$message .= sprintf(
				'<div class="updated"><p>%s - <a href="/wp-admin/admin.php?page=issuu-document-admin">%s</a></p></div>',
				get_issuu_message('Document sent successfully'),
				get_issuu_message('Back')
			);
		}
		else if ($result['stat'] == 'fail')
		{
			$hook->setParam('status', 'fail');
			$message .= '<div class="error"><p>' . get_issuu_message($result['message'])
				. ((isset($result['field']))? ': ' . $result['field'] : '') . '</p></div>';
		}

		$hook->setParam('message', $message);
	}

	public function updateDocument(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$issuuDocument = $config->getIssuuServiceApi('IssuuDocument');
		$postData = $hook->getParam('postData');

		if (is_null($issuuDocument))
			return;

		$message = $hook->getParam('message', '');
		$date = date_i18n('Y-m-d') . 'T';
		$time = date_i18n('H:i:s') . 'Z';
		$datetime = $date . $time;
		$data = true;

		foreach ($postData['pub'] as $key => $value) {
			if ($value != '')
			{
				$data = false;
				break;
			}
		}

		if ($data)
		{
			$postData['publishDate'] = $datetime;
		}
		else
		{
			if ($postData['pub']['day'] == '' || $postData['pub']['month'] == '' || $postData['pub']['year'] == '')
			{
				$postData['publishDate'] = $date;
			}
			else
			{
				$postData['publishDate'] = $postData['pub']['year'] . '-' . $postData['pub']['month'] . '-' . $postData['pub']['day'] . 'T';
			}

			$postData['publishDate'] .= $time;
		}

		unset($postData['pub']);

		if (trim($postData['name']) != '')
		{
			$postData['name'] = str_replace(" ", "", $postData['name']);
		}

		if (!isset($postData['commentsAllowed']) || trim($postData['commentsAllowed']) != 'true')
		{
			$postData['commentsAllowed'] = 'false';
		}

		if (!isset($postData['downloadable']) || trim($postData['downloadable']) != 'true')
		{
			$postData['downloadable'] = 'false';
		}

		foreach ($postData as $key => $value) {
			$postData[$key] = trim($value);
		}

		$result = array('stat' => '');

		try {
			$result = $issuuDocument->update($postData);
		} catch (Exception $e) {
			$config->getIssuuPanelDebug()->appendMessage("Update Document Exception - " . $e->getMessage());
			$result = array('stat' => '');
		}

		if ($result['stat'] == 'ok')
		{
			$hook->setParam('status', 'success');
			$message .= sprintf(
				'<div class="updated"><p>%s - <a href="/wp-admin/admin.php?page=issuu-document-admin">%s</a></p></div>',
				get_issuu_message('Document sent successfully'),
				get_issuu_message('Back')
			);
		}
		else if ($result['stat'] == 'fail')
		{
			$hook->setParam('status', 'fail');
			$message .= '<div class="error"><p>' . get_issuu_message($result['message'])
				. ((isset($result['field']))? ': ' . $result['field'] : '') . '</p></div>';
		}

		$hook->setParam('message', $message);
		$hook->setParam('result', $result);
	}

	public function deleteDocument(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$postData = $hook->getParam('postData');
		$params = array(
			'names' => (isset($postData['name']))? $postData['name'] : array()
		);
		$count = count($params['names']);
		$message = $hook->getParam('message', '');

		if ($count > 0)
		{
			$result = $config->getIssuuServiceApi('IssuuDocument')->delete(array(
				'names' => implode(',', $params['names'])
			));

			if ($result['stat'] == 'ok')
			{
				if ($count > 1)
				{
					$message .= sprintf(
						'<div class="updated"><p>%s</p></div>',
						get_issuu_message('Documents deleted successfully')
					);
				}
				else
				{
					$message .= sprintf(
						'<div class="updated"><p>%s</p></div>',
						get_issuu_message('Document deleted successfully')
					);
				}
				$hook->setParam('status', 'success');
				$hook->setParam('documents', $params['names']);
			}
			else if ($result['stat'] == 'fail')
			{
				$message .= sprintf('<div class="error"><p>%s%s</p></div>',
					get_issuu_message($result['message']),
					(($result['field'] != '')? ': ' . $result['field'] : '')
				);
			}
		}
		else
		{
			$message .= sprintf(
				'<div class="update-nag">%s</div>',
				get_issuu_message('Nothing was excluded')
			);
		}
		$hook->setParam('message', $message);
	}

	public function ajaxDocs(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$postData = $hook->getParam('postData');

		$doc = $config->getIssuuServiceApi('IssuuDocument')->issuuList(array(
			'orgDocName' => $postData['name']
		));

		if ($doc['stat'] == 'ok' && !empty($doc['document']))
		{
			$doc = $doc['document'][0];

			if (intval($doc->coverWidth) != 0 && intval($doc->coverHeight) != 0)
			{
				$image = 'https://image.issuu.com/%s/jpg/page_1_thumb_large.jpg';
				$response = '<input type="checkbox" name="name[]" class="issuu-checkbox" value="' . $doc->name . '">' .
					'<div class="document-box">' .
						'<img src="' . sprintf($image, $doc->documentId) . '">' .
						'<div class="update-document">' .
							'<a href="admin.php?page=issuu-document-admin&issuu-panel-subpage=update&document=' .
								$doc->orgDocName . '">Editar</a>' .
						'</div>' .
					'</div>' .
					'<p class="description">' . $doc->title . '</p>';
				$hook->setParam('status', 'success');
				$hook->setParam('html', $response);
			}
			else
			{
				$hook->setParam('status', 'fail');
			}
		}
		else
		{
			$hook->setParam('status', 'fail');
			$params = $config->getIssuuServiceApi('IssuuDocument')->getParams();
			unset($params['apiKey']);
			$config->getIssuuPanelDebug()->appendMessage(sprintf(
				"Fail on file request. Message: %s. Request data - %s",
				$doc['message'],
				json_encode($params)
			));
		}
	}

	private function createDatetime(array &$postData)
	{
		$date = date_i18n('Y-m-d') . 'T';
		$time = date_i18n('H:i:s') . 'Z';
		$datetime = $date . $time;
		$data = true;

		foreach ($postData['pub'] as $key => $value) {
			if ($value != '')
			{
				$data = false;
				break;
			}
		}

		if ($data)
		{
			$postData['publishDate'] = $datetime;	
		}
		else
		{
			if ($postData['pub']['day'] == '' || $postData['pub']['month'] == '' || $postData['pub']['year'] == '')
			{
				$postData['publishDate'] = $date;
			}
			else
			{
				$postData['publishDate'] = $postData['pub']['year'] . '-' . $postData['pub']['month'] . '-' . $postData['pub']['day'] . 'T';
			}

			if ($postData['pub']['hour'] == '' || $postData['pub']['min'] == '')
			{
				$postData['publishDate'] .= $time;
			}
			else
			{
				if ($postData['pub']['sec'] == '')
				{
					$postData['pub']['sec'] = '00';
				}
				else
				{
					if (strlen($postData['pub']['sec']) == 1)
					{
						$postData['pub']['sec'] = '0' . $postData['pub']['sec'];
					}

					$postData['pub']['sec'] = ':' . $postData['pub']['sec'];

					if ($postData['pub']['sec'] == ':00')
					{
						$postData['pub']['sec'] = '';
					}

					$postData['pub']['sec'] = $postData['pub']['sec'];
				}

				if ($postData['pub']['hour'] == '')
				{
					$postData['pub']['hour'] = '00';
				}
				else
				{
					if (strlen($postData['pub']['hour']) == 1)
					{
						$postData['pub']['hour'] = '0' . $postData['pub']['hour'];
					}
				}

				if ($postData['pub']['hour'] == '')
				{
					$postData['pub']['hour'] = '00';
				}
				else
				{
					if (strlen($postData['pub']['min']) == 1)
					{
						$postData['pub']['min'] = '0' . $postData['pub']['min'];
					}
				}
				
				$postData['publishDate'] .= $postData['pub']['hour'] . ':' . $postData['pub']['min'] . ':' . $postData['pub']['sec'] . 'Z';
			}

		}

		unset($postData['pub']);

		if (isset($postData['folder']) && !empty($postData['folder']))
		{
			$count = count($postData['folder']);
			for ($i = 0; $i < $count; $i++) {
				if ($i == ($count - 1))
				{
					$postData['folderIds'] .= $postData['folder'][$i];
				}
				else
				{
					$postData['folderIds'] .= $postData['folder'][$i] . ',';
				}
			}
		}

		unset($postData['folder']);

		if (trim($postData['name']) != '')
		{
			$postData['name'] = str_replace(" ", "", $postData['name']);
		}

		if (!isset($postData['commentsAllowed']) || trim($postData['commentsAllowed']) != 'true')
		{
			$postData['commentsAllowed'] = 'false';
		}

		if (!isset($postData['downloadable']) || trim($postData['downloadable']) != 'true')
		{
			$postData['downloadable'] = 'false';
		}

		foreach ($postData as $key => $value) {
			if (($postData[$key] = trim($value)) == '')
			{
				unset($postData[$key]);
			}
		}
	}
}
<?php

class IssuuPanelFolderCacheListener
{
	public function __construct()
	{
		add_action('on-construct-issuu-panel-plugin-manager', array($this, 'initListener'));
		// add_action('on-cron-update-folder-documents', array($this, 'onUpdateFolderDocuments'));
		add_action('on-shutdown-issuu-panel', array($this, 'persistData'));
	}

	public function initListener(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		// $config->getIssuuPanelCron()->addScheduledAction('on-cron-update-folder-documents', 600);
	}

	public function onUpdateFolderDocuments(IssuuPanelHook $hook)
	{
		$documents = array();
		$config = $hook->getParam('config');
		$debug = $config->getIssuuPanelDebug();
		$issuuFolder = $config->getIssuuServiceApi('IssuuFolder');
		$issuuBookmark = $config->getIssuuServiceApi('IssuuBookmark');
		$issuuDocument = $config->getIssuuServiceApi('IssuuDocument');
		$pageFolder = 1;
		$pageBookmark = 1;
		$perPage = 25;
		do {
			try {
				$folders = $issuuFolder->issuuList(array(
					'pageSize' => $perPage,
					'startIndex' => $perPage * ($pageFolder - 1),
				));

				if ($folders['stat'] == 'ok')
				{
					foreach ($folders['folder'] as $folder) {
						$docs = array();
						do {
							$bookmarks = $issuuBookmark->issuuList(array(
								'folderId' => $folder->folderId,
								'pageSize' => $perPage,
								'startIndex' => $perPage * ($pageBookmark - 1),
							));

							if ($bookmarks['stat'] == 'ok')
							{
								foreach ($bookmarks['bookmark'] as $bookmark) {
									$document = $issuuDocument->update(array('name' => $bookmark->name));

									if ($document['stat'] == 'ok')
									{
										$docs[] = array(
											'id' => $bookmark->documentId,
											'thumbnail' => 'https://image.issuu.com/' . $bookmark->documentId .
												'/jpg/page_1_thumb_large.jpg',
											'url' => 'https://issuu.com/' . $bookmark->username . '/docs/' . $bookmark->name,
											'title' => $bookmark->title,
											'date' => date_i18n('d/F/Y', strtotime($document['document']->publishDate)),
											'pubTime' => strtotime($document['document']->publishDate),
											'pageCount' => $document['document']->pageCount
										);
									}
								}
							}
							$pageBookmark++;
						} while (isset($bookmarks['more']) && $bookmarks['more']);
						$config->getFolderCacheEntity()->setFolder($folder->folderId, $docs, true);
					}
				}
			} catch (Exception $e) {
				$debug->appendMessage(
					'Exception on IssuuPanelUpdateDataListener->onUpdateFolderDocuments - ' . $e->getMessage()
				);
			}
			$pageFolder++;
		} while (isset($folders['more']) && $folders['more']);
	}

	public function persistData(IssuuPanelHook $hook)
	{
		$config = $hook->getParam('config');
		$config->getFolderCacheEntityManager($config->getFolderCacheEntity());
	}
}
<?php

class IssuuPanelAjaxRequestListener implements IssuuPanelService
{
	private $config;

	public function __construct()
	{
		// Documents
		add_action('wp_ajax_issuu-panel-upload-document', array($this, 'uploadDocument'), 600);
		add_action('wp_ajax_issuu-panel-url-upload-document', array($this, 'urlUploadDocument'), 600);
		add_action('wp_ajax_issuu-panel-update-document', array($this, 'updateDocument'), 600);
		add_action('wp_ajax_issuu-panel-delete-document', array($this, 'deleteDocument'), 600);
		add_action('wp_ajax_issuu-panel-ajax-docs', array($this, 'ajaxDocs'), 600);
		// Folders
		add_action('wp_ajax_issuu-panel-add-folder', array($this, 'addFolder'), 600);
		add_action('wp_ajax_issuu-panel-update-folder', array($this, 'updateFolder'), 600);
		add_action('wp_ajax_issuu-panel-delete-folder', array($this, 'deleteFolder'), 600);
	}

	/*
	*	Documents
	*/

	public function uploadDocument()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-upload-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-upload-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-upload-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'default'),
			'message' => $onAction->getParam('message', '')
		));
	}

	public function urlUploadDocument()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-url-upload-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-url-upload-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-url-upload-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'default'),
			'message' => $onAction->getParam('message', '')
		));
	}

	public function updateDocument()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-update-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-update-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-update-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'default'),
			'message' => $onAction->getParam('message', '')
		));
	}

	public function deleteDocument()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-delete-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-delete-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-delete-document',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'default'),
			'documents' => $onAction->getParam('documents', array()),
			'message' => $onAction->getParam('message', '')
		));
	}

	public function ajaxDocs()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-ajax-docs',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-ajax-docs',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-ajax-docs',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'success'),
			'html' => $onAction->getParam('html', '')
		));
	}

	/*
	*	Folders
	*/

	public function addFolder()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-add-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-add-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-add-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'success'),
			'message' => $onAction->getParam('message', ''),
		));
	}

	public function updateFolder()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-update-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-update-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-update-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'success'),
			'message' => $onAction->getParam('message', ''),
		));
	}

	public function deleteFolder()
	{
		$postData = filter_input_array(INPUT_POST);
		unset($postData['action']);
		try {
			$preAction = $this->getConfig()->getHookManager()->triggerAction(
				'pre-issuu-panel-delete-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$onAction = $this->getConfig()->getHookManager()->triggerAction(
				'on-issuu-panel-delete-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
			$posAction = $this->getConfig()->getHookManager()->triggerAction(
				'pos-issuu-panel-delete-folder',
				null,
				array(
					'postData' => $postData,
					'config' => $this->getConfig(),
				)
			);
		} catch (Exception $e) {
			$onAction->setParam('status', 'fail');
			$onAction->setParam('message', sprintf('<div class="error"><p>%s</p></div>', $e->getMessage()));
		}

		$this->jsonResponse(array(
			'status' => $onAction->getParam('status', 'success'),
			'message' => $onAction->getParam('message', ''),
			'folders' => $onAction->getParam('folders', array()),
		));
	}

	public function setConfig(IssuuPanelConfig $config)
	{
		$this->config = $config;
	}

	public function getConfig()
	{
		return $this->config;
	}

	private function jsonResponse(array $data = array())
	{
		header('Content-Type: application/json');
		print json_encode($data);
		exit;
	}
}
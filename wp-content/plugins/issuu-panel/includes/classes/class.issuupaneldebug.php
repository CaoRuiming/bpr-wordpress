<?php

class IssuuPanelDebug
{
	/**
	*
	*	@var string $status
	*/
	private $status;

	/**
	*
	*	@var string $dir
	*/
	private $dir;

	/**
	*
	*	@var string $logDir
	*/
	private $logDir;

	/**
	*
	*	@var string $htaccessFile
	*/
	private $htaccessFile;

	/**
	*
	*	@var string $nginxConfigFile
	*/
	private $nginxConfigFile;

	/**
	*
	*	@var string $debugFile
	*/
	private $debugFile;

	/**
	*
	*	@var string $message
	*/
	private $message;

	public function __construct($status = 'disable')
	{
		add_action('pre-active-issuu-panel', array($this, 'createFiles') ,-600);
		add_action('pos-uninstall-issuu-panel', array($this, 'deleteFiles'), 600);

		$this->status = $status;
		$upload = wp_upload_dir();
		$this->dir = $upload['basedir'];
		$this->logDir = $this->dir . '/issuu-panel-folder/';
		$this->htaccessFile = $this->logDir . '.htaccess';
		$this->nginxConfigFile = $this->logDir . 'nginx.conf';
		$this->debugFile = $this->logDir . 'issuu-panel-debug.txt';
		$this->message = '';

		if (!$this->status) $this->status = 'disable';
	}

	public function __destruct()
	{
		file_put_contents($this->debugFile, $this->message, FILE_APPEND);
	}

	public function appendMessage($message, $insertDate = true)
	{
		if ($this->status == 'active')
		{
			if ($insertDate === true)
			{
				$message = date_i18n('[Y-m-d H:i:s] - ') . $message;
			}

			$this->message .= $message . "\n";
		}
	}

    /**
     * Gets the value of dir.
     *
     * @return string $dir
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Gets the value of logDir.
     *
     * @return string $logDir
     */
    public function getLogDir()
    {
        return $this->logDir;
    }

    /**
     * Gets the value of debugFile.
     *
     * @return string $debugFile
     */
    public function getDebugFile()
    {
        return $this->debugFile;
    }

    /**
     * Gets the value of message.
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function createFiles()
    {
    	if (!is_dir(WP_CONTENT_DIR . '/uploads'))
    		mkdir(WP_CONTENT_DIR . '/uploads');

    	$htaccessContent = "deny from all";
		$nginxConfigContent = "location ~ (issuu-panel-debug)\.(txt)$ {\n\tdeny all;\n\treturn 403;\n}";

		if (!is_dir($this->logDir))
		{
			mkdir($this->logDir);
		}

		if (!is_file($this->htaccessFile) || file_get_contents($this->htaccessFile) == $htaccessContent)
		{
			file_put_contents($this->htaccessFile, $htaccessContent);
			chmod($this->htaccessFile, 0644);
		}

		if (!is_file($this->nginxConfigFile) || file_get_contents($this->nginxConfigFile) == $nginxConfigContent)
		{
			file_put_contents($this->nginxConfigFile, $nginxConfigContent);
			chmod($this->nginxConfigFile, 0644);
		}

		if (!is_file($this->debugFile))
		{
			file_put_contents($this->debugFile, "");
		}
    }

    public function deleteFiles()
    {
    	unlink($this->logDir);
    }
}
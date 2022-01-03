<?php

class IssuuPanelCacheManager
{
	private $issuuPanelOptionEntity;

	private $issuuPanelShortcodeCache;

	public function __construct($issuuPanelOptionEntity)
	{
		$this->setOptionEntity($issuuPanelOptionEntity);
		$this->issuuPanelShortcodeCache = $this->getOptionEntity()->getShortcodeCache();
	}

	public function cacheIsActive()
    {
        return ($this->getOptionEntity()->getCacheStatus() == 'active');
    }
    
    public function generateShortcodeKey($shortcode, $params = array())
    {
        return md5($shortcode . http_build_query($params));
    }

	public function setCache($shortcode, $content = '', $params = array(), $page = 1)
    {
        $key = $this->generateShortcodeKey($shortcode, $params);

        if (!isset($this->issuuPanelShortcodeCache[$key]))
        {
            $this->issuuPanelShortcodeCache[$key] = array();
        }

        $this->issuuPanelShortcodeCache[$key][$page] = $content;
    }

    public function getCache($shortcode, $params = array(), $page = 1)
    {
        $key = $this->generateShortcodeKey($shortcode, $params);

        if (isset($this->issuuPanelShortcodeCache[$key]))
        {
            if (isset($this->issuuPanelShortcodeCache[$key][$page]))
            {
                return $this->issuuPanelShortcodeCache[$key][$page];
            }
        }

        return '';
    }

    public function updateCache($shortcode = null, $content = '', $params = array(), $page = 1)
    {
        if (!is_null($shortcode))
        {
            $this->setCache($shortcode, $content, $params, $page);
        }
        $this->getOptionEntity()->setShortcodeCache($this->issuuPanelShortcodeCache);
        // update_option(ISSUU_PANEL_PREFIX . 'shortcode_cache', $this->serializeCache());
    }

    public function serializeCache()
    {
        return serialize($this->issuuPanelShortcodeCache);
    }

    public function flushCache()
    {
        $this->issuuPanelShortcodeCache = array();
        $this->getOptionEntity()->setShortcodeCache($this->issuuPanelShortcodeCache);
        // update_option(ISSUU_PANEL_PREFIX . 'shortcode_cache', $this->serializeCache());
    }

	private function setOptionEntity(IssuuPanelOptionEntity $issuuPanelOptionEntity)
	{
		$this->issuuPanelOptionEntity = $issuuPanelOptionEntity;
	}

	public function getOptionEntity()
	{
		return $this->issuuPanelOptionEntity;
	}
}
<?php

interface IssuuPanelService
{
	public function setConfig(IssuuPanelConfig $config);

	public function getConfig();
}
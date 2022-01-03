<?php

interface IssuuPanelPage extends IssuuPanelService
{
	public function __construct();

	public function init();

	public function page();
}
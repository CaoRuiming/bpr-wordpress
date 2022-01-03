<?php

class IssuuPanelPageAbout extends IssuuPanelSubmenu
{
	protected $slug = 'issuu-panel-about';

	protected $page_title = 'About';

	protected $menu_title = 'About';

	protected $priority = 3;

	public function page()
	{
		include(ISSUU_PANEL_DIR . 'menu/about/page.php');
		$this->getConfig()->getIssuuPanelDebug()->appendMessage("Issuu Panel page (About)");
	}
}
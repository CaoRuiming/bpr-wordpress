<?php
/*
Plugin Name: Issuu Panel
Plugin URI: https://github.com/Issuu-Panel-WordPress-Plugin/issuu-panel
Description: Admin panel for Issuu. You can upload your documents, create folders and embed documents in posts.
Version: 1.6.8
Author: Pedro Marcelo
Author URI: https://www.linkedin.com/profile/view?id=265534858
License: GPL3
*/

if (defined('ISSUU_PANEL_VERSION'))
{
	switch (version_compare(ISSUU_PANEL_VERSION, '1.6.8')) {
		case -1:
			wp_die("A lower version of Issuu Panel plugin is already installed");
			break;
		case 0:
			wp_die("Issuu Panel plugin is already installed");
			break;
		case 1:
			wp_die("An upper version of Issuu Panel plugin is already installed");
			break;
	}
}

/*
|--------------------------------------
|  CONSTANTS
|--------------------------------------
*/

define('ISSUU_PANEL_VERSION', '1.6.8');
define('ISSUU_PANEL_DIR', plugin_dir_path(__FILE__));
define('ISSUU_PANEL_URL', plugin_dir_url(__FILE__));
define('ISSUU_PANEL_PREFIX', 'issuu_painel_');
define('ISSUU_PANEL_DOMAIN_LANG', 'issuu-panel-domain-lang');
define('ISSUU_PANEL_MENU', 'issuu-panel-admin');
define('ISSUU_PANEL_PLUGIN_FILE', __FILE__);
define('ISSUU_PANEL_PLUGIN_FILE_LANG', dirname(plugin_basename(__FILE__)) . '/lang/');


/*
|--------------------------------------
|  INCLUDES
|--------------------------------------
*/

require(ISSUU_PANEL_DIR . 'includes/interfaces/interface.issuupanelhook.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelaction.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelfilter.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelhookmanager.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupaneloptionentity.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupaneloptionentitymanager.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelfoldercacheentity.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelfoldercacheentitymanager.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelcachemanager.php');
require(ISSUU_PANEL_DIR . 'includes/reader/class.issuupanelsimplereader.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelcatcher.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupaneldebug.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelcron.php');
if (!class_exists('Mobile_Detect')) { require(ISSUU_PANEL_DIR . 'includes/mobile-detect/Mobile_Detect.php'); }
require(ISSUU_PANEL_DIR . 'issuuservice-lib/bootstrap.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelconfig.php');
require(ISSUU_PANEL_DIR . 'includes/interfaces/interface.issuupanelservice.php');
require(ISSUU_PANEL_DIR . 'includes/interfaces/interface.issuupanelpage.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelinitplugin.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelscripts.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupaneltinymcebutton.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelpaginate.php');
require(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelsubmenu.php');
require(ISSUU_PANEL_DIR . 'includes/functions.php');

/*
|--------------------------------------
|  LISTENER
|--------------------------------------
*/

require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupanelloglistener.php');
require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupanelajaxrequestlistener.php');
require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupanelupdatedatalistener.php');
require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupaneldocumentlistener.php');
require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupanelfolderlistener.php');
require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupanelpluginconfiglistener.php');
require(ISSUU_PANEL_DIR . 'includes/listeners/class.issuupanelfoldercachelistener.php');

/*
|--------------------------------------
|  MENU
|--------------------------------------
*/

include(ISSUU_PANEL_DIR . 'menu/main/config.php');
include(ISSUU_PANEL_DIR . 'menu/document/config.php');
include(ISSUU_PANEL_DIR . 'menu/folder/config.php');
include(ISSUU_PANEL_DIR . 'menu/about/config.php');

/*
|--------------------------------------
|  SHORTCODES
|--------------------------------------
*/

include(ISSUU_PANEL_DIR . 'shortcode/class.issuupanelshortcodegenerator.php');
include(ISSUU_PANEL_DIR . 'shortcode/class.issuupanelshortcodes.php');
// include(ISSUU_PANEL_DIR . 'shortcode/document-list.php');
// include(ISSUU_PANEL_DIR . 'shortcode/folder-list.php');
// include(ISSUU_PANEL_DIR . 'shortcode/the-last-document.php');

/*
|--------------------------------------
|  WIDGET
|--------------------------------------
*/

include(ISSUU_PANEL_DIR . 'widget/class.issuupanelwidget.php');

/*
|--------------------------------------
|  PLUGIN MANAGER
|--------------------------------------
*/

include(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanelpluginmanager.php');
include(ISSUU_PANEL_DIR . 'includes/classes/class.issuupanel.php');

/*
|--------------------------------------
|  THAT'S ALL!
|--------------------------------------
*/

IssuuPanel::init();

=== Issuu Panel ===
Contributors: pedromjava
Tags: issuu, shortcode, embed, documents, folders, panel, admin, widget
Requires at least: 3.5
Tested up to: 4.7.3
Stable tag: 1.6.8

Upload documents, create folders, embed documents in the posts by the WordPress admin panel.

== Description ==

<p>Issuu Panel is a WordPress plugin that allow to you upload your documents, create folders and embed documents in posts.</p>
<h3>Keys</h3>
<p>
	In this menu, you have to insert your keys which you generated in your Issuu account.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-1.png?raw=true">Screenshot 1</a>
</p>
<p>
	After the insert, other	sub menus will be unlocked.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-2.png?raw=true">Screenshot 2</a>
</p>
<h3>Documents</h3>
<p>
	In this sub menu, you can upload documents from your directories, upload documents from a URL, edit them and delete them.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-3.png?raw=true">Screenshot 3</a>
</p>
<h3>Folders</h3>
<p>
	In this sub menu, you can create folders to add your documents in them, edit them and delete them.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-4.png?raw=true">Screenshot 4</a>
</p>
<h3>TinyMCE button</h3>
<p>
	You can insert shortcodes in your posts or pages using the TinyMCE button.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-5.png?raw=true">Screenshot 5</a><br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-6.png?raw=true">Screenshot 6</a>
</p>
<h3>Widget</h3>
<p>
	With this widget you can display the last document from your account or the last document in a folder.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-7.png?raw=true">Screenshot 7</a><br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-8.png?raw=true">Screenshot 8</a>
</p>
<h3>Readers</h3>
<p>
	There are 2 options: Issuu embed and Issuu Panel Simple Reader.<br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-9.png?raw=true">Screenshot 9</a><br>
	<a href="https://github.com/pedromarcelojava/Issuu-Painel/blob/master/screenshot-10.png?raw=true">Screenshot 10</a>
</p>
<h3>Issuu Panel Simple Reader - Hotkeys</h3>
<p>
	<ul>
		<li>Next page - Ctrl(left) + Arrow right</li>
		<li>Previous page - Ctrl(left) + Arrow left</li>
		<li>Zoom more - Ctrl(left) + Arrow up</li>
		<li>Zoom minus - Ctrl(left) + Arrow down</li>
		<li>Zoom max - Ctrl(left) + Shift(left) + Arrow up</li>
		<li>Zoom minimun - Ctrl(left) + Shift(left) + Arrow down</li>
	</ul>
</p>
<h3>Collaborators</h3>
<h4>Translators</h4>
<ul>
	<li>
		<a href="http://www.sniezek.eu/" target="_blank">Arkadiusz Śnieżek</a> - Polish
	</li>
	<li>
		Fredrik Pettersson - Swedish
	</li>
</ul>

== Installation ==

1.Extract the plugin's folder in /wp-content/plugins/<br>
2.Active plugin<br>
3.Insert your keys in Issuu Panel menu<br>

== License ==

This file is part of Issuu Panel.
Issuu Panel is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published
by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Issuu Panel is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Issuu Panel. If not, see <http://www.gnu.org/licenses/>.

== Screenshots ==

1. This is the first menu available. Insert your API key here.
2. Other menus will be released after the registration of the keys.
3. In this menu you can upload, list, update and delete documents of your Issuu account.
4. In this menu you can create, list, update, and delete folders to insert documents in them.
5. This is the button to insert a shortcode in post content.
6. This is the screen to insert a shortcode in post content.
7. This widget displays the last document in accordance with the options
8. This widget displays the last document in accordance with the options
9. You can use the Issuu embed or Issuu Panel Simple Reader for showing your documents
10. Issuu Panel Simple Reader is compatible with mobile devices

== Frequently Asked Questions ==

= How can I help with the translation of the plugin? =

You can send the translation by e-mail. Send for pedromarcelodesaalves@gmail.com.

== Changelog ==

= 1.6.8 =
* Updated: changing links from HTTP to HTTPS

= 1.6.7 =
* Fixed: Conflict in Mobile_Detect inclusion

= 1.6.6 =
* Fixed: If's condition would never be true
* Fixed: Compatibility with versions lower than PHP 5.4

= 1.6.4 =
* Fixed: Check API key and API secret values with strlen function

= 1.6.3 =
* Updated: Plugin structure is event-based now
* Fixed: Upload documents on PHP 5.5 version or upper
* Fixed: Security failure

= 1.6 =
* Added: Swedish translate by Fredrik Pettersson
* Created: Issuu Panel Simple Reader - HTML5
* Created: IssuuPanelCron for scheduled actions
* Created: Shortcode cache
* Updated: The log file directory was changed - /wp-content/uploads/issuu-panel-folder/
* Updated: The document URL on Issuu is default value in My Last Document

= 1.4.6.1 =
* Updated: Adding static methods in IssuuPanelConfig class

= 1.4.6 =
* Added: Debug mode for log file
* Fixed: Issuu Viewer isn't displayed on mobile devices. Now the links go to document page on Issuu

= 1.4.4.3 =
* Fixed: SEO issue - Image Alt Test and No Follow Broken Links Test

= 1.4.4.2 =
* Fixed: In Issuu Panel page, the button text was not translated
* Added: Title field in widget
* Updated: Issuu Panel uses OOP now
* Updated: The pagination of documents was shortened

= 1.3.3 =
* Fixed: TinyMCE lightbox was not displayed
* Fixed: PDF list was not displayed on some websites
* Added: Activation and uninstall hooks
* Added: Polish translation by Arkadiusz Śnieżek

= 1.1.1 =
* Fixed: TinyMCE button did not work in WordPress 4.1
* Added: My Last Document widget

= 1.0 =
* First release

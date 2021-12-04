=== Add New Default Avatar ===
Contributors: trepmal
Donate link: http://kaileylampert.com/donate
Tags: avatar, gravatar
Requires at least: 2.8
Tested up to: 4.4
Stable tag: 1.4

Add new option to the Default Avatar list.

== Description ==

Add new option to the Default Avatar list. Supply a name and URL for an image you'd like to use and it will appear in your Default Avatar list on the Discussion page (under Settings).

== Installation ==

1. Upload `kl_addnewdefaultavatar.php` to the `/wp-content/plugins/`
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Settings > Discussion > Avatars
1. Supply the name and URL for the avatar you'd rather use. Save. (Some themes won't resize your image to fit, so it's best to use an image that's already the right size.)
1. Your avatar will now be available in the list, select it and save.

== Screenshots ==

1. Plugin's admin screen

== Changelog ==

= 1.4 =
* Behind the scenes clean up

= 1.3.1 =
* Quick fix a few errors on fresh installs

= 1.3 =
* Fixed plugin URI
* Special exception to work along with the Simple Local Avatar plugin
* Fixed donate link
* Made it possible to add more than 1 additional default avatar option.
* On deactivation, will restore to last known default *not created* by the plugin

= 1.2 =
* Removed 'Go Pro' links
* Fixed URL matching so active avatar will be better indicated in admin.
* Added 'size' placeholder. Pass '%size%' in url, and it will be replaced with appropriate numerical value.

= 1.1 =
* Removed admin page, options now in Settings > Discussion > Avatars

= 1.0 =
* Initial Release.

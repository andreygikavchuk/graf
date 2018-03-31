=== Frontier Buttons ===
Contributors: finnj
Donate link: 
Tags: frontend, frontier, wp-editor, tinymce, buttons, tinymce, editor
Requires at least: 4.0
Tested up to: 4.6
Stable tag: 2.2.0
License: GPL v3 or later
 
Full control of your WP editor toolbars. Adds Table, Search/Replace, Preview & Code sample tinymce plugins. Enable visual editor for comments.

== Description ==

Frontier Buttons is intentionally made simple :)


= Main Features =
* Drag and drop design your own toolbar setup for your site.
* Enable visual editor for comments
* 5 different editor layouts
 * Standard
 * Advanced
 * Basic
 * Teeny
 * Comment
* 6 Different roles supported (each role can be assigned a editor layout)
 * Administrators
 * Editors
 * Authors
 * Contributors
 * Subscribers
 * Guests
* Auto detection of new buttons (from other plugins or themes)
* The following tinyMCE moduls added to Wordpresss 
 * Table Control
 * Search & Replace
 * Preview 
 * Code (preview raw html)
 * Code Sample (code styling)


> Version 2.0 and later versions does not support Wordpress versions below Wordpress 3.9 - For earlier wordpress versions please download Frontier Buttons version 1.4.0 from the developers tab.

= Frontier plugins =
* [Frontier Post](http://wordpress.org/plugins/frontier-post/)  - Complete frontend management of posts
* [Frontier Query](http://wordpress.org/plugins/frontier-query/)  - Display lists and groupings of posts in post/pages and widgets.
* [Frontier Buttons](http://wordpress.org/plugins/frontier-buttons/)  - Control TinyMCE buttons
* [Frontier Set Featured ](http://wordpress.org/plugins/frontier-set-featured/)  - Set featured image aut. based on post images 
* [Frontier Restrict Media ](http://wordpress.org/plugins/frontier-restrict-media/)  - Restrict media access to users own media
* [Frontier Restrict Backend ](http://wordpress.org/plugins/frontier-restrict-backend/)  - Restrict access to the backend (wp-admin)


= Translations =
* Danish
* 

Let me know what you think, and if you have enhancement requests or problems let me know through support area

== Installation ==

1. Upload `frontier-buttons` to the `/wp-content/plugins/`  directory or search for Frontier Editor Buttons from add plugin.
2. Activate the plugin through the 'Plugins' menu in WordPress
3: Update Frontier Editor Buttons settings (settings menu)

== Frequently Asked Questions ==

= Known Issues and limitations =
* Drag and drop button on toolbars does not work on monile devices, and requires a newer browser.


= Translations =
* Please post a link in support to translation files and I will include them in next release.

 = Cleanup =
* On deactivation: no cleanup.
* On deletion options are deleted, and role capabilities are removed.
* If you accidental delete the frontier-post plugin folder, you should:
 * Delete all options starting with frontier_buttons



== Screenshots ==

1. Editor layout 
2. Main Settings 
3. Extra buttons


== Changelog ==

= 2.2.0 =
* Fixed problem when not using role editors - Editor was nit initialized correctly
* Tested with WP version 4.6
* Tinymce plugins upgraded to version 4.4.0 (aligned with WP 4.6)

= 2.1.0 =
* Tinymce upgraded to version 4.3.12

= 2.0.7 =
* Complete re-write
* Drag and drop of buttons to toolbars
* Role Based Editors.
* Multiple editor layouts
* Auto detection of buttons (from other plugins or themes)


= 1.5.1 =
* Updated table, searchreplace and preview modules to tinyMCE version 4.2.5
* Fixed problem with load of tinyMCE plugins
* Tested up to wp version 4.4.1 
* Plugin will only support Wordpress version 4.2 and later
* tinyMCE plugin emoticons removed, as Wordpress implemented native support for emoji in Wordpress version 4.2


= 1.4.0 =
* Tested up to: 4.1.1

= 1.3.9 =
* Only enable comment reply fix if Frontier Buttons is enabled for comments.

= 1.3.6 =
* Added fix for visual editor not working on comments reply
* Select editor layout for comments

= 1.3.5 =
* Fixed issues with saving settings

= 1.3.4 =
* Disabled media button for comments editor

= 1.3.2 =
* Tested and works with Wordpres version 4.1

= 1.3.1 =
* New function: frontier_buttons_full_buttons() - Will return array with theme_advanced_buttons1-4, can be called from themes and other plugins 

= 1.3.0 =
* Support for Wordpress versions before 3.9

= 1.2.1 =
* Removed error message - frontier-buttons.php line 160


= 1.2.0 =
* Will respect buttons inserted by other plugins (they will be added at the end of toolbar they were placed)
* Show unused buttons on settings page

= 1.1.0 =
* Use WP editor for comments (optional)
* Change Teeny buttons (the simple editor)

= 1.0.3 =
* Danish translation added

= 1.0.1 =
* Wrong name for settings menu - Collission with Frontier Post plugin

= 1.0.0 =
* Initial Version
* Editor buttons moved from plugin Frontier Post to separate tinyMCE functions in separate plugin



== Upgrade Notice ==
None
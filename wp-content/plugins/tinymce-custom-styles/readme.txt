=== TinyMCE Custom Styles ===
Contributors: blackbam, Tim Reeves
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NBW9FDZHW42GY
Tags: tinymce, advanced, visual, editor, style, custom
Requires at least: 3.0.1
Tested up to: 4.6.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Improve TinyMCE visual editor by adding custom editor stylesheets and a configurable styles dropdown.

== Description ==

Clients and colleagues tend to get crazy if they have to edit HTML code on their own or if little things are not working as expected. Make your editing experience as simple and good as possible!

This Plugin does two things for you:

A. Installs two files - editor-style.css and editor-style-shared.css - into your chosen location (so you can still do updates of the Plugin), which can be edited in the backend of your site.

- editor-style.css is used for styling your TinyMCE Editor
- editor-style-shared.css is used for styles to be used in your theme AND in your TinyMCE editor (so you do not have to copy)

Note: To use this feature, you have to write your own CSS code into these files, which is the only professional way to do it.

B. The main feature of this Plugin is to offer a GUI to create custom style formats for TinyMCE dynamically.

- Easy to add, change and delete
- No editing of source code required

Current Languages:

- en_US
- de_DE (David Stöckl and Tim Reeves)
- es_ES (outdated; Andrew Kurtis, webhostinghub.com)
- sr_RS (outdated; Ognjen Djuraskovic, firstsiteguide.com)

This plugin is compatible with a number of others which also enhance TinyMCE in different ways, in particular:

- Preserved HTML Editor Markup Plus
- Visual Editor Custom Buttons
- tinyWYM Editor
- Advanced TinyMCE Config
- WP Editor (enhances the "Text" tab)

Here is a detailed description of how to <a href="https://timreeves.de/internet-technologie/wordpress-editor-mit-html-blockelementen-nutzen/" target="_blank">put all these plugins together</a> (in german).

This plugin is a fork of <a href="https://wordpress.org/plugins/tinymce-and-tinymce-advanced-professsional-formats-and-styles/" target="_blank">TinyMCE Advanced Professsional Formats and Styles</a> which has been abandoned by the original author. Initially I just fixed a JavaScript bug so that it worked again, and cleaned up the code and messages a bit. In the current version 1.0.2 I did a lot more work on the settings page, see the changelog. If anyone wants to help me keep this great plugin alive and further improve it, please do! Especially translations are very welcome.

Credits

- <a href="http://blog.blackbam.at/" target="_blank">David Stöckl</a>, Vienna, the original author. Many thanks!
- The plugin icon (<a href="https://timreeves.de/kompetenz/" target="_blank">Der Bitkönig</a>) was painted by <a href="http://meischner.world/" target="_blank">Gabriele Meischner</a>, muchas Gracias!

== Installation ==

1. Upload the Plugin to your wp-content/plugins/ folder
2. Activate the Plugin
3. Go to Settings -> TinyMCE Custom Styles
4. Follow the instructions on the screen - write your CSS and create your custom formats

Important: Some Settings of TinyMCE or certain TinyMCE Plugins require you to do some manual settings for the Plugin to work. The Plugin WILL work, if you configure it correctly - check the FAQ for help.

== Frequently Asked Questions ==

= I cannot edit editor-style.css and editor-style-shared.css. What is wrong? =

The Plugin was probably not able to create the files, due to problems with your server filesystem settings. Please create these files in the selected directory manually, and make sure the directory read/write access is set to 777.

= I have edited the files editor-style.css and editor-style-shared.css, but my visual editor is not styled. What is the problem? =

1. You should empty the cache of your Web Browser, this is often the reason for the styles being applied with some delay.
2. Check this with simple styles like body { background-color:black; } to see if it basically works.
3. Maybe there are some functions inside of your Theme / other Plugin, which overwrite the settings of this Plugin. Please check this out as it seems to work in most cases.

= The file editor-style.css is not working in the frontend of my website, but it is applied to the backend editor. Why? =

Make sure that your Theme calls the function wp_head(); inside the header of your template.

= I have created styles, but I do not see the styles dropdown. Is something broken? =

- If you are using TinyMCE Basic Plugin, be sure that the second row of your TinyMCE is visible. You can usually show / hide this row by clicking a button in the right-top row of Tinymce Standard.
- If you are using TinyMCE Advanced (by Andrew Ozz, or similar), make sure to add the Dropdown called "Styles" on the "Tinymce Advanced" Settings Page. I try to add the styles dropdown automatically inside of this Plugin, but it will not always work as it may be overwritten.

= I have created some custom formats/styles, I can see the dropdown, but the formats/styles which I have created on the settings Page just do not work. What is wrong? =

You have to be careful when creating custom styles/formats if you are doing it for the first time. If you make a row with an HTML blockquote element and you choose "Inline" from the radio buttons, this style will NOT work, as blockquote is not an HTML inline element.

Try something easy like:
- Name: My red text
- Type: inline
- Type value: span
- CSS style: color / #f00

Check if this style works. If so, proceed to other styles. They will only work if you use correct semantics.

== Screenshots ==

1. /assets/screenshot-1.png
2. /assets/screenshot-2.png

== Changelog ==

= ToDos =
* HELP HELP: Get more translations / update outdated es_ES + sr_RS
* A bug report says not working on WordPress MultiSite - test and fix
* Warn admin user when leaving changed settings page
* Add a JS function to insert a row after another row
* OR better: Make style rows sortable by drag and drop
* Nice to have: Rewrite the code from procedural to OOP

= 1.0.3 =
* Updated german translation
* Made some table header names translatable
* Shortened some table input fields for better layout

= 1.0.2 =
* This update improves the settings page as follows
* Added second save button
* Complete rework of admin notices
* Many minor layout and message improvements
* Corrected several loop counter irritations
* Improved how missing style files are tested
* Improved logic and messages around custom directory
* Added more explanation and sample content in auto-created editor-style-shared.css
* Reduced PHP Warnings and Notices to zero

= 1.0.1 =
* Initial release as fork.

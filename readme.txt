=== SDAC Translate ===
Tags: translation, translate, widget, sidebar widget, Google Translate
Contributors: jenz
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 1.2.3
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4761649

Simple lightweight translation sidebar widget that uses Google Translation.

== Description ==
The SDAC Translate plugin uses Google Translate to translate your site's content in multiple languages using a simple sidebar widget that is fully customizable.

== Installation ==
1. Unzip into your plugins directory (usually `/wp-content/plugins/`). 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the SDAC Translate Options (in Settings Menu)
4. Place the widget into the sidebar.

How to use:
1. Use the admin to select what languages you would like available to your readers.
2. Add the widget (Appearance > Widgets) to your sidebar of choice: 

Enjoy!

== Frequently Asked Questions ==

= Where can I get support for this plugin?
You can submit any issues/feedback: http://sandboxdev.com/forums/forum/sdac-translate

== Screenshots ==
1. Admin options

== Changelog ==
= 1.2.3 = 
* Added site language option

= 1.2.2 = 
* Moved from wp_cache to using to using transients
* Fixed undefined index ($styles)

= 1.2.1 = 
* Added a clear div to take care of any float issues.

= 1.2 = 
* Added English as a new language option (as requested)
* Removed some un-used images (admin)

= 1.1 = 
* Code clean up, new admin style

= 1.03 = 
* Condensed CSS

= 1.02 = 
* Fixed index issue

= 1.01 = 
* Changed admin JS code
* Added in additional validation

= 1.0 =
*  Initial release 

== Upgrade Notice ==
= 1.2.3 = 
Upgrade includes user defined beginning language (translate from).

= 1.2.2 = 
Upgrade includes undefined index fix and new caching method.

= 1.2.1 = 
Upgrade includes clear div for any float issues.

= 1.2 = 
Upgrade includes English as a new language option

= 1.1 = 
Upgrade includes updates to admin functions and CSS.

= 1.03 = 
Upgrade includes minor change to CSS output.

= 1.02 = 
Upgrade includes minor fix to the data array.

= 1.01 = 
Upgrade to use more efficient JS in the admin and validation on all fields

= 1.0 =
Initial release

== Notes ==
1. I wanted to keep this plugin as lightweight as possible so the widget output is cached and the images are all in one image.
2. If you have non-standard plugin directory - see line 24 on how to add that into the plugin to make the images appear correctly.

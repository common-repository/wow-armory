=== WoW Armory ===
Contributors: seifertim, ginchen
Tags: widget, world of warcraft, wow, armory, character, warcraft, blizzard, site, toon, gear, achievements, professions
Requires at least: 2.8
Tested up to: 2.8.4
Stable tag: 8.4.3

Easily displays your character's stats from the Armory.

== Description ==

Grabs your character from the Armory and displays their basic info.   Allows multiple widgets with different character information.  Works for US and EU realms.  You can choose to hide or display equipment, professions, and achievements.

You can optionally show a 3D model of your character using Wowhead's model viewer.

Caches data for 15 minutes to reduce the number of requests.

NOTE: Currently this plugin requires cURL and PHP5 to work.

== Installation ==

1. Upload 'wow-armory' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Adjust your settings on the 'Settings' Tab

== Screenshots ==

1. Configuration Screen (Widgets)
2. Widget in Sidebar (showing Wowhead tooltips)

== FAQ ==

See website

== Changelog ==

= 8.4.3 = 

* Fixed an issue where the language seemed to be trying to use your default language instead of your defined language.

= 8.4.2 = 

* Thanks to Ginchen, Image Cache should work a lot better using cURL.

= 8.4.1 = 

* Fixed Image Cache and Talent Tree icons.

= 8.4 = 

* More image cache fixed... should be finally fixed!

= 8.1 =

* Fixed some issues with the image cache...

= 8.0 =

* Added Guild name display

* Changed progress bars to look better

* Added image cache for off-site images.

= 7.4.3 =

* Fixed issue with some chest items not displaying properly in the 3d model.

= 7.4.2 =

* Fixed shortcodes to use all lowercase

= 7.4.1 =

* More image fixes...

= 7.4 =

* Blizzard changed their path to images in the armory. Fixed.

= 7.3 =

* Added option to choose which weapons to show.

= 7.0 =

 Actual 2.8 Release with many changes. Special Thanks to Ginchen for making tons of changes to get it working!
* Improved logic for grabbing and caching data from the Armory.
* Sorted Equipment Lists
* Improved Widget control screen:
** Option to customize Widget Title - use %NAME% to display Character's name.
** Option to show Professions and/or Achievement Points as Progress Bars or Text.
** 3D Model Preview can be refreshed while changing appearence so you can see what you're changes are.

= 5.5 =

* Sorry to all the EU peoples, but the 'Armory Unavailable' issue should FINALLY be resolved for you...

= 5.4 =

* Minor bug fixes to try and help with 'armory unavailable' messages and incorrect Achievements.
* Changed Professions to work better with other languages.
* Changed Professions to show one of the profressions if one is blank.
* Changed image display to show <level 60, <level 70 and <level 80 now. (Thanks Ginchen !)

= 5.3 =

* Cache screen should now work properly with a different databse prefix.
* Better Talents, and Dual-specs work now. (Thanks Stop!)

= 5.1 =

* Forgot to renable Profession Icons - shh... don't tell anyone!

= 5.0 =

* Completely redesigned how caching and display works. Documentation to be updated shortly.
* You can now choose to show/hide the "top" section of the widget, this means you can just show your gear, just show your achievments, just show your 3D model, or some combination of all of those options, without your name, class, etc showing up - if you want.

= 4.1 = 

* Fixed an issue with shortcodes not working after the last update.
* Added parameters for shortcodes to show/modify 3D model.

= 4.0 =

* Added options to display 3D model of your character using Wowhead's Model Viewer.

= 3.0 =

* Fixed an issue where cached characters with similar names were not seen as different characters.
* Added ''wow-armory Cache Administration'' screen under ''Settings'' in the Admin dashboard. You can choose to clear any or all of your caches, as well as view the cached data of any character.

= 2.9 =

* Changed cache time to 15 minutes.
* Switched from cURL to Snoopy.

= 2.8 = 

* Bugfix

= 2.7 =

* Removed call to now non-existant js file.

= 2.6 =

* Bugfix

= 2.5 =

* Bugfix

= 2.4 =

* Removed AJAX and Javascript from the plugin.
* Added Caching - widgets should only update in 20-minute intervals.  If armory is unavailable, widgets will try to use last cached data.

= 2.3 = 

* Fixed problem with leading space in some fields.

= 2.2 = 

* Bugfix

= 2.1 = 

* Minor behind-the-scenes tweaks.

= 2.0 =

* Added option to display Talents
* Added option to show Linkback to my site (disabled by default)
* Added shortcode: [wowarmory char="Character Name" realm="Realm Name" realmtype="US or EU"]

= 1.9 = 

* Minor formatting tweaks.

= 1.8 = 

* International!  Added an option to set the language for each of your Widgets - this will only effect the Wowhead tooltips.  You can choose from any of the languages available on Wowhead: English, Spanish, German, French, and Russian.

= 1.7.2 = 

* Added timeout to AJAX call.

= 1.7.1 = 

* Fixing Maintenance Day errors.

= 1.7 =

* Fixed a bug that was preventing this plugin from displaying properly on some browsers.
* Cleaned up CSS, and added more coherant classes to elements.

= 1.6.1 =

* Added support for level conversions - should have added this to begin with

= 1.6 = 

* Added support for gems, enchants, and random item types.  I can't get set bonuses working just yet...

= 1.5 =

* Finally fixed the quote issue in Realm name... I hope.

= 1.4 =

* Fixed some bugs with multiple instances.
* Realm Type (US/EU) is now saved properly.
* Widget will now say if the character cannot be found, instead of showing a bunch of errors.
* Choosing to not show certain items works properly (again).

= 1.3 =

* Multiple Instances!

= 1.2 =

* Show Gear, Show Professions, and Show Achievements options should now actually work.
* Fixed typos.

= 1.1 = 

* Fixed apostraphes in Realm names.

= 1.0 =

* Initial Release


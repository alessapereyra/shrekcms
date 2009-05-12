=== Plugin Name ===
Contributors: Eric Schulz
Donate link: http://www.cancer.org/docroot/DON/DON_1_Donate_Online_Now.asp?from=hpglobal
Tags: profile, profiles, profiler, directory, members, member, users, widget, widgets
Requires at least: 2.*
Tested up to: 2.6.1
Stable tag: 1.2.8

Profiler is a plugin for generating and displaying profiles for the registered users on a WordPress site.

== Description ==

Profiler is a plugin for generating and displaying profiles for the registered users on a WordPress site. It is intended to be a "set it and forget it" plugin. You do not have to have any programming knowledge to use this plugin.

Features:

* Profiles for each registered user
* A members directory
* Gravatars for every profile
* A sidebar widget that displays the total number of users, posts, pages, and comments
* Supports the <a href="http://wordpress.org/extend/plugins/user-photo/">User Photo</a> plugin
* Supports the <a href="http://lordchaos.dominatus.net/wordpress-plugin-whisper">Whisper</a> plugin

== Installation ==

1. Extract the folder "profiler" from the zip file and upload it to the "/wp-content/plugins/" directory
2. Activate the plugin through the 'Plugins' menu in the WordPress admin interface
3. Create a page using the form in the "Profiler" menu located under "Settings" This page will serve as your members directory

== Screenshots ==

<a href="http://www.visualguides.org/wp-content/uploads/screenshot3.png">Member Directory</a> <br />
<a href="http://www.visualguides.org/wp-content/uploads/screenshot01.png">Options Interface</a> <br />
<a href="http://www.visualguides.org/wp-content/uploads/screenshot1.png">A user's profile</a> <br />

== Frequently Asked Questions ==

= When I go to browse the directory, I get a "page not found" error message =
Try adding "/index.php/" to your permalink structure. For example, if your current permalink structure is "/%postname%/", change it to "/index.php/%postname%/ From what I have read, this occurs due when WordPress is unable to write to the .htaccess file.

= I get an "Warning: array_keys() [function.array-keys]: The first argument should be an array in /wp-content/plugins/profiler/profiler.php on line xxx" error in the directory =
Uncheck "show roles" in the Profiler admin menu. A fix is in the works... :)

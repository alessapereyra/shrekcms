Plugin Name: WP-Ustream
Plugin URI: http://www.pcmech.com/wp-ustream/
Description: WP Ustream is a down-and-dirty plug-in to make it easy to embed a Ustream feed into a Wordpress post or page. It also allows for multiple feeds with option to select which one is active on your website.
Author: David Risley
Author URI: http://www.pcmech.com
Version: 1.1

--------------------------
Installation
--------------------------
1. Upload all files to wp-content/plugins/ustream/
2. Activate the plugin on the plugin screen
3. Go to Options -> Ustream and update the fields with your information
4. Create a post or a page and press the .TV quicktag where you want the live feed to be. If you don't see the .TV quicktag, you can alternatively copy and paste <!--ustream feed--> where you want it to appear. To insert the chatroom, enter <!--ustream chat-->

--------------------------
Usage
--------------------------
You can enter multiple Ustream feeds. Where it specifies to add the feed, enter the name of the feed (your choice here) and the embed code provided by Ustream.TV for your show. You can add additional feeds the same way.

The embed code provided by Ustream can be modified if you know HTML. You can change the formatting or change the width and height of your live feed by simply editing the embed code.

Likewise, copy and paste the embed code UStream provides for your chatroom feed and paste that where specified inside of Wordpress.

To select which feed is active, use the dropdown selection to choose which feed should be primary. 

Frequently Asked Questions
--------------------------
How come I don't see the `.TV` quicktag?

* You have the `Show quicktag` checkbox on Options -> Ustream turned off
* You're not using the default set of quicktags for the editor
* Its a Glitch

Solution: Copy and paste "<!--ustream feed-->" minus the quotes where you want the feed to appear.


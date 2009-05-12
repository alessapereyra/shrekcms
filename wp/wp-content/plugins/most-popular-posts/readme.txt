=== Most Popular Posts ===
Contributors: wesg
Tags: widget, most popular, comments, sidebar
Requires at least: 2.0
Tested up to: 2.7
Stable tag: 1.2.1

This is a very simple widget that displays a link to the top commented posts on your blog.

== Description ==

Most Popular Posts is a basic widget for your sidebar that creates a list of links to the top posts on your blog according to the number of comments on the post. You can customize the widget title, number of links to show and whether or not you want to display the comment count.

For a complete list of the changes from each version, please visit <a href="http://www.wesg.ca/2008/08/wordpress-widget-most-popular/#changelog">the plugin homepage</a>.

For examples and tips on using the plugin, please check <a href="http://www.wesg.ca/2008/08/wordpress-widget-most-popular/#examples">the examples</a> on the plugin homepage.

Be sure to check out my other plugins at <a href="http://wordpress.org/extend/plugins/profile/wesg">my Wordpress profile</a>.

= Usage =

Use as either a widget with the standard installation procedure, or use the function itself in a post by adding `<?php most_popular(1); ?>` to your template. The argument 1 ensures the list is self contained instead of as part of the sidebar.

== Installation ==

1. Upload the folder most-popular-posts to your Wordpress plugin directory.
1. Activate the plugin from the plugin panel.
1. Navigate to the widget configuration panel and customize the widget.
1. If you wish to simply display the data as a list outside the sidebar, use `<?php most_popular(1); ?>` inside your template.

== FAQ ==

= What is the purpose of this widget? =

While I thought a widget like this was very common, I had trouble finding one for my blog. That led me to create this basic widget that simply displays a link to the top commented posts. You can customize the title, number of posts, and whether you want to display the comment count.

= Is it configurable? =

Sure. Have a look at the options in the widget configuration panel.
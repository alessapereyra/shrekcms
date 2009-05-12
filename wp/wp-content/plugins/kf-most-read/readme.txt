=== KF most read ===
Contributors: kilotto, fulippo
Donate link: http://www.kifulab.net/
Tags: posts, hits
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: 1.1

Retrieve the most viewed posts list in a custom period of time

== Description ==

This plugin provides a function to register/output/return a list of the most viewed posts. 


== Installation ==

 As always:
    	1. Upload the file under your wp-content/plugins directory
    	1. Activate the plugin


== Usage ==

You can use the function kf_get_posts_by_hits() anywhere in the template.
    Examples:
    	<!-- Echo mode, retrieve the 10 most read posts in 7 days -->
    	<h3>Most read</h3>
    	<ul>
    		<?php kf_get_posts_by_hits(7,10); ?>
    	</ul>
    	
    	
    	<!-- Return mode (no output), retrieve the 5 most read posts in 31 days -->
    	<?php 
    		
    		$my_posts = kf_get_posts_by_hits(31,5);
    		// .. do some magic with $my_posts
    	
    	?>

== Changelog ==

1.1  Fixed some minor bugs.

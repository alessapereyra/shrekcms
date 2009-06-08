<?php
class Wpcookies
{
	function __construct()
	{		
		include('/var/local/www/wordpress-mu2/mulapress/wp/wp-config.php');
		//include('../wp/wp-defines.php');
		
		/*
		include('../wp/wp-includes/cache.php');
		include('../wp/wp-includes/formatting.php');
		include('../wp/wp-includes/plugin.php');
		include('../wp/wp-includes/functions.php');
		*/
		include('/var/local/www/wordpress-mu2/mulapress/wp/wp-config.php');		
	}
	
	function set($user)
	{
		wp_setcookie($user);
	}
	
	function un_set()
	{
		wp_clearcookie();
	}
}
?>
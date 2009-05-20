<?php

/*
 Plugin Name: Session Manager
 Description: Plugin to store simple live session data about the site visitors.
 Author: Sean Barton, Cambridge New Media Services
 Version: 2.0

 Changelog:
 1.0b:	Basic functionality.
 1.0:	Improved bot checking and added IP address to the database table for future improved bot checking.
 1.1:	Added viewing stats per page and it's sub-page where you can view exactly when each hit was grouped by url.
 Separated out the admin pages and provided a very simple menu to help navigate around.
 2.0:	Added two new tables, blacklist and excludes so that the user can now exclude certain pages themselves and mark things as robot hits so we can better exclude robot stats. Also reworked the layout completely and updated for Wordpress 2.7
 */

$sm_dir = str_replace('\\', '/', dirname(__FILE__));
$sm_file = str_replace('\\', '/', __FILE__);

define('SM_PLUGIN_DIR_PATH', trailingslashit($sm_dir));
define('SM_PLUGIN_DIR_URL', trailingslashit(str_replace(str_replace('\\', '/', ABSPATH), get_bloginfo('wpurl').'/', $sm_dir)));
define('SM_PLUGIN_DIRNAME', str_replace('/plugins/','',strstr(SM_PLUGIN_DIR_URL, '/plugins/')));
define('SM_ADMIN_DIR', SM_PLUGIN_DIR_PATH . 'admin/');
define('SM_INCLUDES_DIR', SM_PLUGIN_DIR_PATH . 'includes/');
define('SM_SQL_IMPORT_FILE', SM_INCLUDES_DIR . 'sm_tables.sql');
define('SM_RELATIVE_ROOT', str_replace(trailingslashit($_SERVER['DOCUMENT_ROOT']), '/', str_replace('\\', '/', ABSPATH)));

require_once(SM_INCLUDES_DIR . 'sm_functions.include.php');

$validity_period = false;
$table_name = $user_excludes_table = $excludes_table = false;
$bg = '#FFFFFF';

register_activation_hook(str_replace('\\', '/', $sm_file), 'sm_activate');
register_deactivation_hook(str_replace('\\', '/', $sm_file), 'sm_deactivate');

function sm_loaded() {
	//actions
	add_action('admin_menu', 'sm_admin_page');
	add_action('init', 'sm_init');

	//add_action('init', 'sm_store_session_data');
	add_action('init', 'sm_clear_expired_data');

	add_action('admin_menu', 'sm_admin_page');	
}

// It all starts here
add_action('plugins_loaded', 'sm_loaded');

?>
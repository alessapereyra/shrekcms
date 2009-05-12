<?php
/*  Copyright 2007 - 2008 Eric Schulz. All Rights Reserved.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details:
    http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
Plugin Name: Profiler
Plugin URI: http://www.visualguides.org/profiler/
Description: An enhanced version of the Profiler plugin with support for multiple users. It allows you to display the information of every registered user on your site in a special members area. Each user has their own profile which can be modified from the WordPress admin interface by either the user or an administrator.
Author: Eric Schulz
Version: 1.2.8
Author URI: http://www.visualguides.org/
*/

//hooks for the actions and filters
//calls the add_menu_page function to add a menu
add_action('admin_menu', 'pf_admin_menu');
//inserts the stylesheet for formatting the directory and profiles
add_action('wp_head', 'pf_insert_style');
//hook the directory page to display it
add_filter('the_content', 'pf_start_train', 1);
//register a widget only after all of the plugins have been loaded
add_action('plugins_loaded', 'pf_stats_widget_init');
//==========================================================================================

//adds the admin menu
function pf_admin_menu()
{
	//options page hook
	add_options_page('Profiler Options', 'Profiler', 10, basename(__FILE__), 'pf_options');
}

//returns an array with the requested users' IDs
//takes order arguments for sorting purposes
function pf_uids($start, $records, $order, $ordertype)
{
	global $wpdb;
	
	$roles = pf_get_enabledroles();
	
	$uids = $wpdb->get_col("SELECT ID FROM $wpdb->users
	WHERE ID = ANY 
	(SELECT user_id FROM $wpdb->usermeta 
	WHERE meta_value IN ($roles)) ORDER BY $order $ordertype
	LIMIT $start, $records
	");
	
	foreach($uids as $key=>$value)
	{
		$uids[$key] = $value;
	}
	
	return $uids;
}

//returns an array with a user's profile information
function pf_get_vars($id)
{
	$uinfo = get_userdata($id);
	
	foreach($uinfo as $key=>$value)
	{
		$vars[$key] = $value;
	}
	
	//let's see if this works any better than strictly using $vars['wp_capabilities']
	$vars['wp_capabilities'] = get_usermeta($id, 'wp_capabilities');
	
	return $vars;
}

//returns a list of the roles that have been selected from the options menu
function pf_get_enabledroles()
{
	$administrator = get_option('pf_show_roles_admin');
	$subscriber = get_option('pf_show_roles_subscriber');
	$author = get_option('pf_show_roles_author');
	$editor = get_option('pf_show_roles_editor');
	$contributor = get_option('pf_show_roles_contributor');
	$none = get_option('pf_show_roles_none');
	
	$roleslist = array('\'a:1:{s:13:\"administrator\";b:1;}\''=>$administrator, '\'a:1:{s:10:\"subscriber\";b:1;}\''=>$subscriber, '\'a:1:{s:6:\"author\";b:1;}\''=>$author, '\'a:1:{s:6:\"editor\";b:1;}\''=>$editor, '\'a:1:{s:11:\"contributor\";b:1;}\''=>$contributor, '\'a:0:{}\''=>$none);
	
	$roles = array();
	
	foreach($roleslist as $key=>$value)
	{
		if($value == 'yes')
			array_push($roles, $key);
		else
		{}
	}
	
	//create a string for use in a MySQL statement
	$roles = implode(', ', $roles);
	
	return $roles;
}

//returns the total number of registered users
function pf_user_count()
{
	global $wpdb;
	
	$count = $wpdb->get_var("SELECT COUNT(ID) 
	FROM $wpdb->users");
	
	return $count;
}

function pf_get_user_stats($id)
{
	global $wpdb;
	
	$stats = $wpdb->get_row("SELECT
	(SELECT COUNT(post_author) FROM $wpdb->posts WHERE post_author = $id) AS post_count,
	(SELECT COUNT(user_id) FROM $wpdb->comments WHERE user_id = $id) AS comment_count", ARRAY_A);
	
	return $stats;
}

//returns the total number of users, posts, and comments
function pf_get_stats()
{
	global $wpdb;
	
	$stats = $wpdb->get_row("SELECT
	(SELECT COUNT(ID) FROM $wpdb->users) AS user_count,
	(SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish') AS post_count,
	(SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'publish') AS page_count,
	(SELECT COUNT(comment_ID) FROM $wpdb->comments) AS comment_count", ARRAY_A);
	
	return $stats;
}

function pf_name_to_id($name)
{
	global $wpdb;
	
	//replace the spaces in a name with hypens for pretty urls
	$name = str_replace('-', ' ', $name);
	
	$id = $wpdb->get_var("SELECT ID
	FROM $wpdb->users
	WHERE display_name = '$name'");
	
	return $id;
}

function pf_get_display_name($id)
{
	global $wpdb;
	
	$display_name = $wpdb->get_var("SELECT display_name
	FROM $wpdb->users
	WHERE ID = $id");
	
	$display_name = str_replace(' ', '-', $display_name);
	
	return $display_name;
}

//returns the smallest ID number that exists
function pf_minuser()
{
	global $wpdb;
	
	$min = $wpdb->get_var("SELECT MIN(ID)
	FROM $wpdb->users
	");
	
	return $min;
}

//returns the largest ID number that exists
function pf_maxuser()
{
	global $wpdb;
	
	$max = $wpdb->get_var("SELECT MAX(ID)
	FROM $wpdb->users
	");
	return $max;	
}

//checks to see if a user exists and returns false if they do not
//also checks to see if they are assigned to an enabled role
function pf_user_exists($id)
{
	global $wpdb;
	
	$roles = pf_get_enabledroles();
	
	if(is_numeric($id))
	{
		$bool = $wpdb->get_var("SELECT ID
		FROM $wpdb->users
		WHERE ID = ANY
		(SELECT user_id FROM $wpdb->usermeta
		WHERE user_id = $id AND meta_value IN ($roles))
		");
	}
	
	if(isset($bool))
		return TRUE;
	else
		return FALSE;
}

//returns an object contains arrays for a user's recent posts
function pf_recent_posts($id, $limit)
{
	global $wpdb;
	
	$posts = $wpdb->get_results("SELECT post_title, ID
	FROM $wpdb->posts
	WHERE post_author = $id AND post_type = 'post'
	ORDER BY post_date DESC
	LIMIT $limit
	");
	
	return $posts;
}

//returns an object containing arrays for a user's recent comments
function pf_recent_comments($id, $limit)
{
	global $wpdb;

	//filter list
	//%whisper% - PMs made with the Whisper plugin
	
	$comments = $wpdb->get_results("SELECT comment_ID, comment_post_ID, SUBSTRING(comment_content, 1, 150) AS comment_content
	FROM $wpdb->comments
	WHERE user_id = $id
	AND
	comment_type NOT LIKE '%whisper%'
	ORDER BY comment_ID DESC
	LIMIT $limit
	");

	return $comments;
}

//change the character to use in the url depending on the current url and permalink structure
//returns "?" or "&". whichever will work
//========================until I discover a better way of doing this========================
function pf_single_url_char()
{
	$url = $_SERVER['REQUEST_URI'];
	$permalink = get_permalink(get_the_id());
	
	if(strpos($permalink, '?'))
		return '&';
	else
		return '?';
}

function pf_singlepagi_url_char()
{
	$url = $_SERVER['REQUEST_URI'];
	$permalink = get_permalink(get_the_id());
	
	if(strpos($permalink, '?'))
		return '&';
	else
		return '?';
}

function pf_directory_url_char()
{
	$page = round($_GET['page']);
	$url = $_SERVER['REQUEST_URI'];
	$permalink = get_permalink(get_the_id());
	
	if(strpos($url, '?'))
		return '&';
	else
		return '?';
}

function pf_directorypagi_url_char()
{
	$page = round($_GET['page']);
	$url = $_SERVER['REQUEST_URI'];
	$permalink = get_permalink(get_the_id());
	
	if(strpos($permalink, '?'))
		return '&';
	else
		return '?';
}
//========================until I discover a better way of doing this========================

//inserts a stylesheet for formatting the directory and profiles
function pf_insert_style()
{
	echo '<link rel="stylesheet" href="', bloginfo('url'), '/wp-content/plugins/profiler/pfstyle.css', '" type="text/css" media="screen" />';
}

//widget functions contained inside one initialization function
function pf_stats_widget_init()
{
	function pf_stats_widget($args)
	{
		$widget_title = get_option('pf_widget_title');
		//$before_widget = '';
		//$before_title = '';
		$title = "<h2>$widget_title</h2>";
		$after_title = '<ul>';
		$after_widget = '</ul>';
		
		if (!function_exists('register_sidebar_widget'))
			return;
		//if the function exists, display the required variables
		//needed for compatibility with certain themes
		else
			echo $before_widget . $before_title . $title . $after_title;
			
		$stats = pf_get_stats();
		
		echo '<li>Members:  ', $stats['user_count'], '</li>';
		echo '<div class="pfwidget">';
		echo '<li>Posts:  ', $stats['post_count'], '</li>';
		echo '<li>Pages:  ', $stats['page_count'], '</li>';
		echo '<li>Comments:  ', $stats['comment_count'], '</li>';
		echo '</div>';
			
		echo $after_widget;
	}
	
	//widget configuration page
	function pf_stats_widget_control()
	{
		$widget_title = get_option('pf_widget_title');
		if($_POST['pf_widget_submit'])
			update_option('pf_widget_title', strip_tags($_POST['pf_widget_title']));
		echo '<p>Title<input class="widefat" name="pf_widget_title" type="text" value="' . $widget_title . '" /></p>';
		echo '<input type="hidden" id="pf_widget_submit" name="pf_widget_submit" value="1" />';
	}
	
	//create a widget
	register_sidebar_widget('Profiler Stats', 'pf_stats_widget');
	//create the widgets edit menu
	register_widget_control('Profiler Stats', 'pf_stats_widget_control');
}

//called when each time a post or page is viewed
//whoo whoo!
function pf_start_train($content)
{
	//only display the directory on the specified page
	if(get_the_ID() == get_option('pf_directory_page_id'))
	{
		$user = $_GET['user'];
	
		if(is_numeric($user) && pf_user_exists($user))
			{}
		else
			$user =  pf_name_to_id($_GET['user']);
		
		$page = round($_GET['page']);
		
		//if a number is given for the user and the user exists
		if(isset($user) && pf_user_exists($user))
			pf_output_single($user);
		//if a number is given for the page
		elseif(isset($page) && is_numeric($page))
			pf_prepare_directory();
		//if invalid characters are given for the user
		elseif(isset($user) && !pf_user_exists($user))
		{
				echo pf_backlink();
				echo "<p>Invalid user specified.</p>";
		}
		//if invalid characters are given for the page
		elseif(isset($page) && !is_numeric($page))
		{
				echo pf_backlink();
				echo "<p>Invalid page specified.</p>";
		}
		//if the user is viewing a standard permalink
		//with no user or page specified
		else
			pf_prepare_directory();
	}
	
	//make sure to include the content
	//or all the posts will be blank!
	return $content;
}

//outputs a single profile for the specified user id
function pf_output_single($id)
{
	$vars = pf_get_vars($id);
	$grav_size = get_option('pf_gravatar_size');
	$recent_posts = pf_recent_posts($id, get_option('pf_recent_posts_per_profile'));
	$recent_comments = pf_recent_comments($id, get_option('pf_recent_comments_per_profile'));
	
	//variables based on the results of pf_get_vars
	foreach($vars as $key=>$value)
	{
		//if the variable is a string, we need to convert any HTML tags to HTML entities
		//to protect from XSS
		if(is_string($value))
			$$key = htmlspecialchars($value);
		else
			$$key = $value;
	}

	$output = "<h3>Profile</h3>";
	
	if(get_option('pf_show_gravatars') == 'yes')
	{
		if(function_exists('get_avatar')) 
		{
			$output .= "<p>" . get_avatar($id, $grav_size) . "</p>";
		} 
		else
		{
			$grav_url = "http://www.gravatar.com/avatar/" . md5($user_email) . "?s=" . $grav_size . "&d=http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536" . "?s=" . $grav_size;
			$output .= "<p><img src='$grav_url'/></p>";
 	 	}
	}
	
	if(get_option('pf_show_userphotos') == 'yes')
	{
		if(function_exists('userphoto_the_author_photo')) 
		{
			if(get_option('pf_show_userphotos_type') == '1')
			{
				$userphototype = USERPHOTO_FULL_SIZE;
			}
			else
			{
				$userphototype = USERPHOTO_THUMBNAIL_SIZE;
			}
			$output .= "<p>" . userphoto__get_userphoto($id, $userphototype, "", "", array(), "") . "</p>";
		}
		
	}
	
	$output .= "<p>$display_name</p>";
	if(get_option('pf_show_emails') == 'yes')
		$output .= "<p>Email:  <a href=" . "mailto:" . $user_email . ">" . antispambot($user_email) . "</a></p>";
	if($user_url != '' && $user_url != 'http://')
		$output .= "<p>Website:  <a href=" . $user_url . " rel=\"nofollow\">$user_url</a></p>";
	
	$output .= "<p>Join date:  " . pf_format_datetime($user_registered) . "</p>";
	
	if($user_description != '')
	{
		$output .= "<h3>About Me</h3>";
		$output .= "<p>$user_description</p>";
	}
	
	//display an author's recent posts, if any
	if(get_option('pf_recent_posts_per_profile') > 0 && !empty($recent_posts))
		$output .= "<h3>Recent Posts</h3>";
	foreach($recent_posts as $key=>$post)
	{
		$output .= "<a href=" . get_permalink($post->ID) . ">" . $post->post_title . "</a><br />";
	}
	
	//display an author's recent comments, if any
	if(get_option('pf_recent_comments_per_profile') > 0 && !empty($recent_comments))
		$output .= "<h3>Recent Comments</h3>";
	foreach($recent_comments as $key=>$comment)
	{
		$output .= "<a href=" . get_permalink($comment->comment_post_ID) . "#comment-" . $comment->comment_ID . ">" . get_the_title($comment->comment_post_ID) . "</a><br />";
		$output .= '<div style="font-size: 11px;font-style: italic;width: 75%; ">' . $comment->comment_content . '</div>';
		
	}
	
	echo pf_backlink();
	
	echo '<div class="pfprofile">';
	echo $output;
	echo '</div>';
	
	pf_insert_pagination_single();
}

//inserts the navigation bar on single profiles
function pf_insert_pagination_single()
{
	$character = pf_singlepagi_url_char();
	$user = $_GET['user'];
	if(is_numeric($user) && pf_user_exists($user))
		{}
	else
		$user = pf_name_to_id($user);
	
	for($i = 1; $i <= pf_maxuser(); $i++)
	{
		if(pf_user_exists($user - $i))
		{
			$prev = $user - $i;
			break;
		}
		else
			$prev = $user;
	}
	
	for($i = 1; $i <= pf_maxuser(); $i++)
	{
		if(pf_user_exists($user + $i))
		{
			$next = $user + $i;
			break;
		}
		else
			$next = $user;
	}
	
	echo '<div class="pfpagisingle">';
	
	if($prev != $user)
		echo "<a href=", the_permalink(), $character, "user=", pf_get_display_name($prev), ">&laquo; Previous</a>";
	else
		echo '&laquo; Previous';
		
	//divider
	echo " - ";
		
	if($next != $user)
		echo "<a href=", the_permalink(), $character, "user=", pf_get_display_name($next), ">Next &raquo;</a>";
	else
		echo 'Next &raquo;';
	
	echo '</div>';	
}

//prepares the directory to be displayed
function pf_prepare_directory()
{
	$page = round($_GET['page']);
	if($page < 1)
		$page = 1;
	$usersperpage = get_option(pf_users_per_page);
	$lastpage = ceil(pf_user_count() / $usersperpage);
	
	if($page > $lastpage)
		{
			echo pf_backlink($lastpage);
			echo "<p>Invalid page specified.</p>";
		}
	else
	{
		if(!isset($page))
			$page = 1;
	
		$start = ($page * $usersperpage) - $usersperpage;
		$records = $usersperpage;
	
		pf_output_directory($start, $records, $lastpage);
	}
}

function pf_output_directory($start, $records, $lastpage)
{
	$uids = pf_uids($start, $records, get_option('pf_sort_directory_by'), get_option('pf_sort_directory_order'));
	$page = round($_GET['page']);
	$character = pf_directory_url_char();
	
	$output .= '<table border="0">';
	$output .= '<tr>';
	$output .= '<th>Name</th>';
	if(get_option('pf_roles_enabled') == 'yes')
		$output .= '<th>Role</th>';
	if(get_option('pf_show_emails') == 'yes')
		$output .= '<th>Email</th>';
	$output .= '<th style="text-align: center;">Website</th>';
	$output .= '<th>Joined</th>';
	$output .= '</tr>';
	
	foreach($uids as $key=>$value)
	{
		//sets the required variables for the current user in the loop
		$vars = pf_get_vars($value);
		$vars['ID'] = pf_get_display_name($vars['ID']);
		
		//get the user's role as a title
		if(get_option('pf_roles_enabled') == 'yes')
			$role = ucfirst(pf_user_role($vars['wp_capabilities']));
		
		$output .= "<tr>";
		$output .= "<td><a href=" . $_SERVER['REQUEST_URI'] . $character . "user=" . $vars['ID'] . ">" . $vars['display_name'] . "</a></td>";
		if(get_option('pf_roles_enabled') == 'yes')
			$output .= "<td>" . $role . "</td>";
		if(get_option('pf_show_emails') == 'yes')
			$output .= "<td><a href=" . "mailto:" . $vars['user_email'] . ">" . antispambot($vars['user_email']) . "</a></td>";
		//only display the url if they have entered a url
		if($vars['user_url'] != 'http://' && $vars['user_url'] != '')
			$output .= '<td style="text-align: center;">' . "<a href=" . $vars['user_url'] . " rel=\"nofollow\">www</a></td>";
		else
			$output .= "<td />";
		$output .= "<td>" . pf_format_datetime($vars['user_registered']) . "</td>";
		$output .= "</tr>";
	}
	
	$output .= '</table>';
	
	echo '<div class="pfdirectory">';
	echo $output;
	echo '</div>';
	
	pf_directory_pagination($lastpage);
}

function pf_directory_pagination($lastpage)
{
	$page = round($_GET['page']);
	if($page < 1)
		$page = 1;
	$character = pf_directorypagi_url_char();
	
	//if a page number is not set
	//the user is on the first page
	if(!isset($page))
		$page = 1;
	
	//pagination for the directory
	echo '<div class="pfpagidirect">';
	//go back one page
	if($page > 1)
		echo "<a href=", the_permalink(), $character, "page=", $page - 1, "> &laquo; </a>";
	else
		echo " &laquo; ";
	//page number navigation
	for($i = 1; $i <= $lastpage; $i++)
	{	
		if($i != $page)
			echo "<a href=", the_permalink(), $character, "page=", $i, "> $i </a>";
		else
			echo $i;
	}
	//go forward one page
	if($page < $lastpage)
		echo "<a href=", the_permalink(), $character, "page=", $page + 1, "> &raquo; </a>";
	else
		echo " &raquo; ";
	echo '</div>';
}

function pf_backlink($lastpage = '')
{
	$page = round($_GET['page']);
	if(empty($page))
		$page = 1;
	$character = pf_single_url_char();
	
	echo $lastpage;
	
	if(isset($page) && $lastpage == '')
	{
		$output = 
			'<div class="pfback">' . 
			"<a href=" . get_permalink() . $character . "page=" . $page . ">&laquo; Back to the directory</a>" . 
			'</div>';
	}
	//if the current page is greater than the last page, the user
	//has entered an invalid page number
	elseif($page > $lastpage)
	{
		echo $test;
		$output = 
			'<div class="pfback">' . 
			"<a href=" . get_permalink() . $character . "page=" . $lastpage . ">&laquo; Back to the directory</a>" . 
			'</div>';
	}
	else
	{
		$output = 
			'<div class="pfback">' . 
			"<a href=" . get_permalink() . ">&laquo; Back to the directory</a>" . 
			'</div>';
	}
	
	return $output;
}

//used to display the values in arrays and objects for debugging purposes
function pf_print_r($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

//gets the role of a user
//ex:  administrator, contributor
function pf_user_role($level)
{
	$role = array_keys($level);
	$role = implode($role);
	return $role;
}

//converts a mysql datetime field to a unix timestamp and uses the date()
//function to output it as day-month-year
//think about using strtotime http://us2.php.net/strtotime
function pf_format_datetime($timestamp)
{
	list($year, $month, $day) = explode('-', $timestamp);
	return date('m-d-y', mktime(0,0,0,$month, $day, $year));
}

function pf_escape($var)
{
	global $wpdb;
	$var = $wpdb->escape($var);
	return $var;
}

//===========================================================================================
//Admin menu options and related functions
//===========================================================================================

//adds a page, naturally
function pf_add_page($title)
{	
	$name = strtolower($title);
	
	$post_title     = $title;
	$post_date      = '';
	$post_date_gmt  = '';
	$post_content   = '';
	$comment_status = 'closed';
	$ping_status    = '';
	$post_status    = 'publish';
	$post_name      = $name;
	$post_parent    = '';
	$menu_order     = '';
	$post_type      = 'page';
	$post_password  = '';
	$guid           = '';
	$post_author    = '';
		
	$postdata = compact('post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_status', 'post_name', 'comment_status', 'ping_status', 'guid', 'post_parent', 'menu_order', 'post_type', 'post_password');

	$post_id = wp_insert_post($postdata);
	update_option('pf_directory_page_id', $post_id);
}

//check to see if the directory page exists
//if it doesn't, let the user create it again from the options menu
function pf_repair_directory_page()
{
	$pageid = get_option('pf_directory_page_id');
	
	if(!get_the_title($pageid))
		update_option('pf_issetup', 'false');
	else
		return;
}

//prints those nice update messages that happen
//when you save options and update posts
function pf_update_msg($msg, $type)
{
	if($type == 'success')
		echo '<div id="message" class="updated fade"><p><b>' . $msg . '</p></b></div>';
	elseif($type == 'error')
		echo '<div id="message" class="updated error"><p><b>' . $msg . '</p></b></div>';
}

//set the default options
//only overrides options that haven't already been set
function pf_default_options()
{
	add_option('pf_users_per_page', 10);
	add_option('pf_users_per_page', 10);
	add_option('pf_sort_directory_by', 'display_name');
	add_option('pf_sort_directory_order', 'ASC');
	add_option('pf_recent_posts_per_profile', 5);
	add_option('pf_recent_comments_per_profile', 5);
	add_option('pf_show_gravatars', 'unchecked');
	add_option('pf_show_userphotos', 'unchecked');
	add_option('pf_show_emails', 'checked');
	add_option('pf_roles_enabled', '');
	add_option('pf_show_roles_admin', 'yes');
	add_option('pf_show_roles_subscriber', 'yes');
	add_option('pf_show_roles_author', 'yes');
	add_option('pf_show_roles_editor', 'yes');
	add_option('pf_show_roles_contributor', 'yes');
	add_option('pf_show_roles_none', 'yes');
	add_option('pf_gravatar_size', '80');
	add_option('pf_directory_page_id', -1);
	pf_repair_directory_page();
	add_option('pf_issetup', 'false');
	add_option('pf_widget_title', 'Site Stats');
}

function pf_setup()
{
	$title = $_POST["page_title"];
	
	if(isset($title))
	{
		if($title != '')
			update_option('pf_issetup', 'true');
		pf_option_create_page();
	}
	
	if(get_option('pf_issetup') != 'true')
	{
?>
<table class="form-table">
<tr valign="top">

<h3><?php _e('Setup') ?></h3>

<th scope="row"><?php _e('Directory Title') ?></th>
<form method="POST" action="<?php echo $SERVER_['PHP_SELF'];?>">
<td><input name="page_title" type="text" id="page_title" value="" size="30" />
<input type="submit" name="submit" value="<?php _e('Create Page') ?>" />
</tr>
</form>
</table>
<?php
	}
}

function pf_option_create_page()
{
	$title = $_POST["page_title"];
	
	if($title != '')
	{
		pf_add_page($title);
		$pageid = get_option('pf_directory_page_id');
		pf_update_msg('The directory has been created.<br />' . '<a href="' . get_permalink($pageid) . '">' . 'View directory' . '</a>', 'success');
	}
	else
		pf_update_msg('The directory title cannot be left blank.', 'error');

}

function pf_options()
{
?>

<?php
pf_default_options();
?>

<div class="wrap">

<h2><?php _e('Profiler Options') ?></h2>

<?php
pf_setup();
?>

<?php //=========================================== ?>

<form method="post" action="options.php">

<h3><?php _e('Global options') ?></h3>

<table class="form-table">
<tr>
<th scope="row" class="th-full">
<label for="pf_show_emails">
<input name="pf_show_emails" type="checkbox" id="pf_show_emails" value="yes" <?php checked('yes', get_option('pf_show_emails')); ?> />
<?php _e('Show email addresses') ?>
</label>
</th>
</tr>
</table>

<table class="form-table">
<tr>
<th scope="row" class="th-full">
<label for="pf_roles_enabled">
<input name="pf_roles_enabled" type="checkbox" id="pf_roles_enabled" value="yes" <?php checked('yes', get_option('pf_roles_enabled')); ?> />
<?php _e('Show roles') ?>
</label>
</th>
</tr>
</table>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Show profiles for these roles') ?></th>
<td>
<label for="pf_show_roles_admin"><input name="pf_show_roles_admin" type="checkbox" id="pf_show_roles_admin" value="yes" <?php checked('yes', get_option('pf_show_roles_admin')); ?> />
 Administrator
<br />
</label>
<label for="pf_show_roles_subscriber"><input name="pf_show_roles_subscriber" type="checkbox" id="pf_show_roles_subscriber" value="yes" <?php checked('yes', get_option('pf_show_roles_subscriber')); ?> />
 Subscriber
<br />
</label>
<label for="pf_show_roles_author"><input name="pf_show_roles_author" type="checkbox" id="pf_show_roles_author" value="yes" <?php checked('yes', get_option('pf_show_roles_author')); ?> />
 Author
<br />
</label>
<label for="pf_show_roles_editor"><input name="pf_show_roles_editor" type="checkbox" id="pf_show_roles_editor" value="yes" <?php checked('yes', get_option('pf_show_roles_editor')); ?> />
 Editor
<br />
</label>
<label for="pf_show_roles_contributor"><input name="pf_show_roles_contributor" type="checkbox" id="pf_show_roles_contributor" value="yes" <?php checked('yes', get_option('pf_show_roles_contributor')); ?> />
 Contributor
<br />
</label>
<label for="pf_show_roles_none"><input name="pf_show_roles_none" type="checkbox" id="pf_show_roles_none" value="yes" <?php checked('yes', get_option('pf_show_roles_none')); ?> />
 No role
<br />
</label>
</tr>
</table>


<h3><?php _e('Directory Options') ?></h3>
<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Users per page') ?></th>
<td><input name="pf_users_per_page" type="text" id="pf_users_per_page" value="<?php form_option('pf_users_per_page'); ?>" size="2" />
</tr>
</table>
<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Sorting') ?></th>
<td>
<?php
	$validorders = array("Name" => "display_name", "Email" => "user_email", "Website" => "user_url", "Join Date" => "user_registered");
	$validorderbys = array("Descending" => "DESC", "Ascending" => "ASC");
	
	echo "<label for='pf_sort_directory'>Sort by: <select name='pf_sort_directory_by' id='pf_sort_directory_by'>";
	foreach($validorders as $key=>$value)
	{
		if($value == get_option('pf_sort_directory_by'))
		{
			echo "<option value=\"" . $value . "\" selected=\"yes\">" . $key . "</option>";
		}
		else
		{
			echo "<option value=\"" . $value . "\">" . $key . "</option>";
		}
	}
?>
</select>
</label>
<?php
	echo "<label for='pf_sort_directory_order'><select name='pf_sort_directory_order' id='pf_sort_directory_order'>";
	foreach($validorderbys as $key=>$value)
	{
		if($value == get_option('pf_sort_directory_order'))
		{
			echo "<option value=\"" . $value . "\" selected=\"yes\">" . $key . "</option>";
		}
		else
		{
			echo "<option value=\"" . $value . "\">" . $key . "</option>";
		}
	}
?>
</select>
</label>
</td>
</tr>
</table>

<h3><?php _e('Profile Options') ?></h3>
<table class="form-table">
<tr valign="top">
<th scope="row" class="th-full">
<label for="pf_show_gravatars">
<input name="pf_show_gravatars" type="checkbox" id="pf_show_gravatars" value="yes" <?php checked('yes', get_option('pf_show_gravatars')); ?> />
<?php _e('Show <a href="http://gravatar.com/">Gravatars</a>') ?>
</label>
</th>
</tr>
</table>

<table class="form-table">
<tr valign="top">
<th scope="row" class="th-full">
<label for="pf_show_userphotos">
<input name="pf_show_userphotos" type="checkbox" id="pf_show_userphotos" value="yes" <?php checked('yes', get_option('pf_show_userphotos')); ?> />
<?php _e('Show <a href="http://wordpress.org/extend/plugins/user-photo/">User Photos</a>') ?>
</label>
<p><input id="pf_show_userphotos_full" type="radio" name="pf_show_userphotos_type" value="1" <?php checked('1', get_option('pf_show_userphotos_type')); ?> />
<label for="pf_show_userphotos_full"><?php _e('Full-Size');?></label></p>
<p><input id="pf_show_userphotos_thumb" type="radio" name="pf_show_userphotos_type" value="0" <?php checked('0', get_option('pf_show_userphotos_type')); ?> />
<label for="pf_show_userphotos_thumb"><?php _e('Thumbnail');?></label></p>
</th>
</tr>
</table>

<table class="form-table">
<th scope="row"><?php _e('Gravatar size (pixels)') ?></th>
<td><input name="pf_gravatar_size" type="text" id="pf_gravatar_size" value="<?php form_option('pf_gravatar_size'); ?>" size="2" />
</tr>
<th scope="row"><?php _e('Recent posts per profile') ?></th>
<td><input name="pf_recent_posts_per_profile" type="text" id="pf_recent_posts_per_profile" value="<?php form_option('pf_recent_posts_per_profile'); ?>" size="2" />
</tr>
<th scope="row"><?php _e('Recent comments per profile') ?></th>
<td><input name="pf_recent_comments_per_profile" type="text" id="pf_recent_comments_per_profile" value="<?php form_option('pf_recent_comments_per_profile'); ?>" size="2" />
</table>

<p><a href="http://www.visualguides.org/profiler/">Questions or Comments?</a></p>

<?php wp_nonce_field('update-options') ?>
<p class="submit">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="pf_users_per_page, pf_sort_directory_by, pf_sort_directory_order, pf_recent_posts_per_profile, pf_recent_comments_per_profile, pf_show_gravatars, pf_show_userphotos, pf_show_userphotos_type, pf_show_emails, pf_gravatar_size, pf_show_roles_admin, pf_show_roles_subscriber, pf_show_roles_author, pf_show_roles_editor, pf_show_roles_contributor, pf_show_roles_none, pf_roles_enabled" />
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>

<?php
}
?>

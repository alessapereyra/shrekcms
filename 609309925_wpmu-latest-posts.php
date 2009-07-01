<?php
/*
Plugin Name: WordPress MU Latest Posts
Plugin URI: http://www.kandar.info/index.php/plugin/wordpress-mu-latest-posts
Description: Retrieves a list of the most latest posts in a WordPress MU installation. Based on WordPress MU Recent Posts - Ron Rennick (http://atypicalhomeschool.net/)
Version: 1.0
Author: Kandar (iskadarsoesman@gmail.com)
Author URI: http://www.kandar.info/
*/

/*
Parameters
==========

$start_from: where array data start form.
$how_many (integer): how many array data are being to shorted.
$how_long_day (integer): time frame to choose recent posts from (in days).
$how_many_to_appear (integer): how many recent posts are being displayed.
how_many_words (integer): how many post's teaser are being displayed. Count by word. Default value are 50 words.
$clean_post (boolean): set true to remove any html tag within the post.
$short_by (string - post_date/post_modified): You can short the lattest post by positing date (post_date) or posting update (post_modified).

Return
======

ID
guid
post_title
post_content
author_url
author_name
post_date
post_time
comment_count

How to use: 
===========

example 1
Default config
10 most recent entries over the past 30 days, displaying titles only

$latest_posts = wpmu_latest_post();
foreach($latest_posts as $latest_post){
	
	echo '<p>'.$latest_post->post_title.'</p>';
}
---------------------------------------------------------------------
example 2
5 most recent entries over the past 10 days, displaying titles, date, time, author, post url and first 30 words post as clean (without any html tag) teaser and order by most posting date.

$start_from = null;
$how_many = null;
$how_long_day = 10;
$how_many_to_appear = 5;
$how_many_words = 30;
$clean_post = null;
$short_by = 'post_date';

$latest_posts = wpmu_latest_post($start_from, $how_many, $how_long_day, $how_many_to_appear, $how_many_words, $clean_post, $short_by);
foreach($latest_posts as $latest_post){
	
	echo '<p><a href="'.$latest_post->guid.'">'.$latest_post->post_title.'</a> - '.mysql2date(get_option('date_format'),$latest_post->post_date).' '.mysql2date(get_option('time_format'),$latest_post->post_date).' - by '.$latest_post->author_name.'</p>';
	echo '<p>'.$latest_post->post_title.'</p>';
	echo '<p>'.$latest_post->post_content.'</p>';
}
*/
function wpmu_latest_post($start_from = 0, $how_many = 20, $how_long_day = 30, $how_many_to_appear = 10, $how_many_words = 50, $clean_post = true, $short_by = 'post_date'){
	global $wpdb;

	//first, gat all blog id
	$query = "SELECT blog_id FROM $wpdb->blogs WHERE blog_id !='1'";
	$blogs = $wpdb->get_col($query);
	
	if ($blogs) {
		
		//we use blog id to loop post query
		foreach ($blogs as $blog){
			
			$blogPostsTable = 'wp_'.$blog.'_posts';
			
			$db_query = "SELECT $blogPostsTable.ID,
						$blogPostsTable.post_author,
						$blogPostsTable.post_title,
						$blogPostsTable.guid,
						$blogPostsTable.post_date,
						$blogPostsTable.post_content,
						$blogPostsTable.post_modified,
						$blogPostsTable.comment_count
						FROM $blogPostsTable WHERE $blogPostsTable.post_status = 'publish' 						AND $blogPostsTable.post_date >= DATE_SUB(CURRENT_DATE(), INTERVAL $how_long_day DAY)
						AND $blogPostsTable.post_type = 'post'";

			$thispos = $wpdb->get_results($db_query);
			
			foreach($thispos as $thispost){
				
				if($short_by == 'post_date'){
					
					$order = $thispost->post_date;
				}
				else{
					
					$order = $thispost->post_modified;
				}
				
				$post_date[]			= $order;
				$post_guid[$order]		= $thispost->guid;
				$post_ID[$order]		= $thispost->ID;
				$post_title[$order]		= $thispost->post_title;
				$post_author[$order]	= $thispost->post_author;
				$post_containts[$order]	= $thispost->post_content;
				$comments[$order]		= $thispost->comment_count;
			}
		}
		
		rsort($post_date);
		$union_results	= array_unique($post_date);
		$ResultArray	= array_slice($union_results, $start_from, $how_many);
		$count = 0;
		
		foreach ($ResultArray as $data){
			
			$ID					= $post_ID[$data];
			$id_author			= $post_author[$data];
			$post_url			= $post_guid[$data];
			$post_titles		= $post_title[$data];
			$post_containt		= $post_containts[$data];
			$date				= mysql2date(get_option('date_format'),$data);
			$time				= mysql2date(get_option('time_format'), $data);
			$total_comment		= $comments[$data];
			$author_blog_url	= get_usermeta($id_author, 'source_domain' );
			$user_info			= get_userdata($id_author);
			$user_status		= $user_info->user_status;
			
			if(get_usermeta($id_author, 'first_name' )){
				
				$name_user = get_usermeta($id_author, 'first_name' ).' '.get_usermeta($id_author, 'last_name' );
			}
			else{
				
				$name_user = get_usermeta($id_author, 'nickname' );
			}
			
			if($clean_post){
				
				$post_containt = wpmu_cleanup_post($post_containt);
			}
			
			$results['ID']				= $ID;
			$results['guid']			= $post_url;
			$results['post_title']		= $post_titles;
			$results['post_content']	= wpmu_cut_article_by_words($post_containt, $how_many_words);
			$results['author_url']		= 'http://'.$author_blog_url.'/';
			$results['author_name'] 	= $name_user;
			$results['post_date']		= $date;
			$results['post_time']		= $time;
			$results['comment_count'] 	= $total_comment;
			
			$returns[] = $results;
			
			$count++;
			if($count == $how_many_to_appear){
				
				break;
			}
		}
		
		$latest_posts = wpmu_bind_array_to_object($returns);
		return $latest_posts;
	}
}

function wpmu_bind_array_to_object($array) {

	$return = new stdClass();

	foreach ($array as $k => $v) {
		
		if (is_array($v)) {
			
			$return->$k = wpmu_bind_array_to_object($v);
			
		}
		else {
			
			$return->$k = $v;
			
		}
	}
	return $return;
}

function wpmu_cut_article_by_words($original_text, $how_many){
	
	$word_cut = strtok($original_text," ");
	
	$return = '';

	for ($i=1;$i<=$how_many;$i++){
		
		$return	.= $word_cut;
		$return	.= (" ");
		$word_cut = strtok(" ");
	}
	
	$return .= '';
	return $return;
}

function wpmu_cleanup_post($source){
	
	$replace_all_html = strip_tags($source);
	$bbc_tag = array('/\[caption(.*?)]\[\/caption\]/is');
	$result = preg_replace($bbc_tag, '', $replace_all_html);
	
	return $result;
}
?>
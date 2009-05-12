<?php
/*
Plugin Name: KF Most Read
Plugin URI: http://www.kifulab.net/wordpress-plugins/kf-most-read-plugin
Description: Shows the most viewed posts in an period of time defined by the user. Usage: just insert the code <?php kf_get_posts_by_hits(7,7) ?> where you want the list to be displayed (by default displays a <li> element for each entry). For more info about usage see the README.txt file or visit the plugin page
Version: 1.1
Author: Kifulab.net
E-Mail: kifulab@gmail.com
Author URI: http://www.kifulab.net
*/

/*  Copyright 2009 Kifulab.net

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    For a copy of the GNU General Public License, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
	
	define("KF_MR_DEBUG_MODE", false);
	session_start('kf_session_manager');	
	if(KF_MR_DEBUG_MODE) var_dump($_SESSION);
	/*
	 * 
	 * name: kf_register_post_hits
	 * description: Register session data to database
	 * @param void
	 * @return void
	 */
	
	function kf_register_post_hits(&$the_content){
		global $post, $wpdb;
		$post_id = (int)$post->ID;
		if(($post->post_status == 'publish') && (int)$post->ID){
			if(!empty($_SESSION)){
				if(is_single() && !in_array($post_id, $_SESSION['kf_session_manager']['kf_most_read']['posts'])){
					$_SESSION['kf_session_manager']['kf_most_read']['posts'][] = $post_id;
					$sql= "INSERT INTO {$wpdb->prefix}kf_most_read(post_ID, hit_ts) values('$post_id',".time().");\n";
					$wpdb->query($sql);
				}	
			}
			else{
				$_SESSION['kf_session_manager']['kf_most_read']['posts'] = array();
			}
		}
		return $the_content;
	}
	
	/*
	 * 
	 * name: kf_get_posts_by_hits
	 * @param int period (in days)
	 * @param int number of posts to retrieve
	 * @param bool choose output mode
	 * @return
	 */
	function kf_get_posts_by_hits($period,$limit,$echo = true){
		global $wpdb;
		$period = (int)$period > 0 ? $period : 7;
		$limit = (int)$limit > 0 ? $limit : 5;
		$sql = "SELECT count(mr.post_ID) as totHits, p.ID, p.post_title from $wpdb->posts p JOIN {$wpdb->prefix}kf_most_read mr on mr.post_ID = p.ID  where mr.hit_ts >= '".(time() - ( 86400 * $period))."' GROUP BY mr.post_ID order by totHits desc, ID ASC LIMIT $limit";
		if(KF_MR_DEBUG_MODE){
			var_dump($sql);
		}
		$posts = $wpdb->get_results($sql);
		if($echo){
			if(!empty($posts)){
				foreach($posts as $p){
					$post = get_postdata($p->ID);
					echo '<li><a href="'.get_permalink($post['ID']).'" title="'.$post['Title'].'">'.$post['Title'].'</a></li>'.chr(13);
				}
			}
			return;
		}
		else{
			return $posts;
		}
	}
	
	/*
	 * 
	 * name: kf_most_read_install_table
	 * @param void
	 * @return void
	 */
	
	function kf_most_read_install_table(){
		global $wpdb;
		$table_name = $wpdb->prefix.'kf_most_read';
		if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE `wp_kf_most_read` (
				`ID` bigint(20) unsigned NOT NULL auto_increment,
				`post_ID` bigint(20) NOT NULL,
				`hit_ts` bigint(20) NOT NULL,
				PRIMARY KEY  (`ID`)
				);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		}
		return;
	}
	
	register_activation_hook(__FILE__,'kf_most_read_install_table');
	add_filter('the_content','kf_register_post_hits');
?>

<?php
/*
Plugin Name: Xiando(tm) social network WPMU kit v0.0.1 - Comments Tracker
Plugin URI: http://livelyblog.com/
Description: This will store all the comments a user posts and add a page where you can view the last few comments from all the blogs you commented reciently.
Version: 0.0.1.2-Xi
Author: 
Author URI: http://livelyblog.com/

Interesting functions:

- Comment Tracking:
-- track_user_comment_posting - Function which tracks when users post comments
-- xiando_tracked_comments_overview - Function which displays my latest comments on a page

This work is Copyright GNU GPL You and Your Loved Ones. And:
- Xiando (Oyvind Sather), who originally wrote it
- And D. Sader - http://iblog.stjschool.org/ (track_user_comment_posting line)

*/

function track_user_comment_posting(){
	global $current_blog;
	global $comment;
	global $post;
	global $current_user;
	global $comment_post_ID;
	$thisnewcomment = array(
		$current_blog->blog_id,
		$comment_post_ID,
		);
	$addcomment = implode(", ", $thisnewcomment);

	$LatestCommentsList = $current_user->LatestComments;
	if (!$LatestCommentsList){
		$LatestCommentsList = array();
	}else{
		$array = explode(", ", $current_user->LatestComments);
	}

	if (!in_array($addcomment, $LatestCommentsList)) {
		array_push($LatestCommentsList, $addcomment);
		if (count($LatestCommentsList) > 30){
			unset($LatestCommentsList[0]);
			array_unshift($LatestCommentsList, array_shift($LatestCommentsList));
			if (!isset($LatestCommentsList[0])) {
				$LatestCommentsList = array();
			}
		}

	}
	update_usermeta($current_user->ID, 'LatestComments', $LatestCommentsList);
}


function xiando_show_users_latest_commented_blogs(){
	global $current_site;
	global $current_blog;
	global $current_user;
	global $wpdb;
	global $wpmuBaseTablePrefix;

	$stag='<li>';
	$etag='</li>';

	$LatestCommentsList = $current_user->LatestComments;
	if ($LatestCommentsList){
	  $xi=0;
	  foreach (array_reverse($current_user->LatestComments) as $key => $tmp_comment_post_array){
		$thiscomment = explode(", ", $tmp_comment_post_array);
		$commentedatblogdetails = get_blog_details( $thiscomment[0] );

		// Blog Post Content Assimilation
		$blogCommentsTable = $wpmuBaseTablePrefix.$thiscomment[0]."_comments";
		$mycomments = array();
		$mycomments = $wpdb->get_results("SELECT comment_author, comment_ID, comment_content, comment_date_gmt, comment_post_ID, user_id
		FROM $blogCommentsTable
		WHERE comment_post_ID = '$thiscomment[1]'

		AND comment_date_gmt >= DATE_SUB(CURRENT_DATE(), INTERVAL 20 DAY)
		ORDER BY comment_date_gmt 
		DESC LIMIT 0,3", ARRAY_A);

		// Blog Post Content Assimilation. Resistance = futile.
		$blogPostsTable = $wpmuBaseTablePrefix.$thiscomment[0]."_posts";
		$thispost = $wpdb->get_results("SELECT post_title, post_content, post_password, comment_count, post_author, guid
				FROM $blogPostsTable 
				WHERE id = '$thiscomment[1]'
				AND post_status = 'publish' 
				AND post_type = 'post'
				ORDER BY id DESC LIMIT 0,1");
		$wTMP = '';
		if( ($thispost) && ($thispost[0]->comment_count > 0) && ($xi < 4) ){
			$wTMP .= "\n\t" . $stag . "<a href=\"" . $thispost[0]->guid . '">' . $thispost[0]->post_title . "</a>";
			$wTMP .= "\n\t<br /><small>[". $thispost[0]->comment_count ."] (<a href=\"http://"
			.$commentedatblogdetails->domain.$blog->path. "\">"
			.$commentedatblogdetails->domain.$blog->path."</a>)</small>" . $etag;
		$xi++;
		}
		echo $wTMP;
	  }
	}
}




function xiando_tracked_comments_overview(){
	global $current_site;
	global $current_blog;
	global $current_user;
	global $wpdb;
	global $wpmuBaseTablePrefix;

	echo '<div class="wrap">';
	echo '<h1>My Latest Commented Blogs</h1>';
	$LatestCommentsList = $current_user->LatestComments;
	if (!$LatestCommentsList){
		echo '<p>You have not written any comments on this blogservice after this particular comment-related plugin was installed, so sorry. Write a comment at someones blog and revisit this page to view your own comments being tracked.</p>';
	}else{

	  foreach (array_reverse($current_user->LatestComments) as $key => $tmp_comment_post_array){
		$thiscomment = explode(", ", $tmp_comment_post_array);
		$commentedatblogdetails = get_blog_details( $thiscomment[0] );

		// Blog Post Content Assimilation
		$blogCommentsTable = $wpmuBaseTablePrefix.$thiscomment[0]."_comments";
		$mycomments = array();
		$mycomments = $wpdb->get_results("SELECT comment_author, comment_ID, comment_content, comment_date_gmt, comment_post_ID, user_id
		FROM $blogCommentsTable
		WHERE comment_post_ID = '$thiscomment[1]'

		AND comment_date_gmt >= DATE_SUB(CURRENT_DATE(), INTERVAL 20 DAY)
		ORDER BY comment_date_gmt 
		DESC LIMIT 0,3", ARRAY_A);

		// Blog Post Content Assimilation. Resistance = futile.
		$blogPostsTable = $wpmuBaseTablePrefix.$thiscomment[0]."_posts";
		$thispost = $wpdb->get_results("SELECT post_title, post_content, post_password, comment_count, post_author, guid
				FROM $blogPostsTable 
				WHERE id = '$thiscomment[1]'
				AND post_status = 'publish' 
				AND post_type = 'post'
				ORDER BY id DESC LIMIT 0,1");
		$wTMP = '';
		if( ($thispost) && ($thispost[0]->comment_count > 0) ){
			$wTMP .= "\n\t<div class=\"xiandoBoxOne\">";
			$wTMP .= "\n\t<a href=\"" . $thispost[0]->guid . '">' . $thispost[0]->post_title . "</a>";
			$wTMP .= "\n\t <small>(<a href=\"http://"
			.$commentedatblogdetails->domain.$blog->path. "\">"
			.$commentedatblogdetails->domain.$blog->path."</a>)</small>";

			$wTMP .= '<div class="xiandoSubBoxOne"><ul>';
			foreach (array_reverse($mycomments) as $mycomment){
				$output = $mycomment['comment_content'];
        	       		$output = strip_tags($output, '<a>');
				$output = rtrim($output, "\s\n\t\r\0\x0B");
				$output = apply_filters('the_content', $output);
				$wTMP .= '<li><strong><i>' . $mycomment['comment_author'] . '</i></strong> (' . 	$mycomment['comment_date_gmt'] . '): '. $output;
				$wTMP .= '</li>';
			}
			$wTMP .= "\n\t</ul>";
			$wTMP .= "\n\t<p><a href=\"" . $thispost[0]->guid . '#comments">' . $thispost[0]->comment_count . " total.</a></p>";
			$wTMP .= "\n\t</div>";
		$wTMP .= "\n\t</div>";
		echo $wTMP;
		}
	  }
	}
	echo "\n</div>";

}


function comments_tracker_addmenu() {
	add_submenu_page('index.php', 'My Comments', 'My Comments', 0, 'xiando_tracked_comments_overview', 'xiando_tracked_comments_overview');
}
add_action('admin_menu', 'comments_tracker_addmenu');
add_action('trackback_post', 'track_user_comment_posting');
add_action('comment_post', 'track_user_comment_posting');

?>
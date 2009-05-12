<?php
/*
Plugin Name: Most Popular Posts
Plugin URI: http://www.wesg.ca/2008/08/wordpress-widget-most-popular/
Description: Display a link to the most popular posts on your blog according to the number of comments.
Author: Wes Goodhoofd
Version: 1.2.1
Author URI: http://www.wesg.ca
*/

add_action("plugins_loaded", "init_popular");

function most_popular($arg) {
	global $wpdb;

	if ($arg == 1)
		$list = true;
	else
		$list = false;

$options = get_option("widget_mostpopular");
if (!is_array( $options ))
	{
		$options = array(
      'number' => '5', 'comment' => 'checked', 'title' => ''
      );
  }    

//get the post data from the database
$posts = $wpdb->get_results("SELECT ID, post_title, comment_count FROM $wpdb->posts where post_status LIKE 'publish' AND post_type LIKE 'post' ORDER BY comment_count DESC LIMIT " . $options['number'] . "");
//$posts = $wpdb->get_results("SELECT ID, post_title, comment_count FROM $wpdb->posts where post_status='publish' and comment_count>0 and post_type=post ORDER BY comment_count DESC LIMIT " . $options['number'] . "");

//determine if used as a sidebar or function
if ($list == false)
	echo '<li>';
?>

<h2><?php echo $options['title']; ?></h2>
<ul id="post_list">
<?php
//display each page as a link
foreach ($posts as $links) {
	if ($options['comment'] == 'checked')
		$comments = ' (' . $links->comment_count . ')';

	echo '<li><a href="' . get_permalink($links->ID) . '">' . $links->post_title . '</a>' . '</li>';
	}
?>

</ul>
<?php
if ($list == false)
	echo '</li>';
?>

<?php
}

function init_popular(){
	//initialize the widget
    register_sidebar_widget("Most Popular", "most_popular");     
	register_widget_control('Most Popular', 'mostpopular_control', 200, 300 );
}

function mostpopular_control() {
	//load translations
load_plugin_textdomain('most_popular_posts', "wp-content/plugins/most-popular-posts/");

	//update_option("widget_mostpopular-number", "5");
	$options = get_option("widget_mostpopular");

//if option is missing, insert defaults
if (!is_array( $options ))
	{
		$options = array(
      'number' => '7', 'comment' => 'checked', 'title' => ''
      );
  }    

//submit new data
if ($_POST['mostpopular-Submit'])
  {
	$options['title'] = htmlspecialchars($_POST['mostpopular-title']);
    $options['number'] = htmlspecialchars($_POST['mostpopular-number']);
	$options['comment'] = htmlspecialchars($_POST['mostpopular-comment']);
	
    update_option("widget_mostpopular", $options);
  }
//create widget configuration panel
?>
	<p>
    <label for="mostpopular-title"><?php _e('Title: ', 'most_popular_posts'); ?> </label>
    <input type="text" id="mostpopular-title" name="mostpopular-title" value="<?php echo $options['title'];?>" />
  </p>

	<p>
    <label for="mostpopular-number"><?php _e('Number of posts to display: ', 'most_popular_posts'); ?></label>
    <input type="text" id="mostpopular-number" name="mostpopular-number" value="<?php echo $options['number'];?>" size="5" />
  </p>

<p>
	 <input type="checkbox" id="mostpopular-comment" name="mostpopular-comment" value="checked" <?php echo $options['comment'];?> />
    <label for="mostpopular-comment"><?php _e('Show comment count ', 'most_popular_posts'); ?></label>

	<input type="hidden" id="mostpopular-Submit" name="mostpopular-Submit" value="1" />
  </p>
<?php
	}
?>
<?php
/*
Author: David Risley
Author URI: http://www.pcmech.com
Description: Administrative options for WP-Ustream
*/

load_plugin_textdomain('wpustream',$path = 'wp-content/plugins/ustream');
$location = get_option('siteurl') . '/wp-admin/admin.php?page=ustream/options-ustream.php'; // Form Action URI

/*Lets add some default options if they don't exist*/
add_option('wpustream_feeds', __('PCMech Live=><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="400" height="320" id="utv483780"><param name="flashvars" value="autoplay=false&amp;brand=embed"/><param name="allowfullscreen" value="true"/><param name="allowscriptaccess" value="always"/><param name="movie" value="http://www.ustream.tv/flash/live/8982"/><embed flashvars="autoplay=false&amp;brand=embed" width="400" height="320" allowfullscreen="true" allowscriptaccess="always" id="utv483780" name="utv_n_84226" src="http://www.ustream.tv/flash/live/8982" type="application/x-shockwave-flash" /></object><a href="http://www.ustream.tv/channels" style="padding:2px 0px 4px;width:400px;background:#FFFFFF;display:block;color:#000000;font-weight:normal;font-size:10px;text-decoration:underline;text-align:center;" target="_blank">Free TV : Ustream</a>', 'wpustream'));
add_option('wpustream_active', __('1', 'wpustream'));
delete_option('wpustream_height');
delete_option('wpustream_width');
add_option('wpustream_chatroom', __('<embed width="563" height="266" type="application/x-shockwave-flash" flashvars="channel=#David-Risley-Show&server=chat1.ustream.tv" pluginspage="http://www.adobe.com/go/getflashplayer" src="http://www.ustream.tv/IrcClient.swf" allowfullscreen="true" />', 'wpustream'));
delete_option('wpustream_chatheight');
delete_option('wpustream_chatwidth');
add_option('wpustream_show_quicktag', TRUE);

/*check form submission and update options*/
if ('process' == $_POST['stage']) {

$wpustream_feedstring = array();
while (list($key,$val)=each($_POST[wpust_feedname])) {
	if ($_POST[wpust_feeddelete][$key]!=1) {
		$wpustream_feedstring[] = $val." => ".$_POST[wpust_feedembed][$key];
	}
	if ($_POST[wpust_feedname_new]!="" and $_POST[wpust_feedid_new]!="") {
		$wpustream_feedstring[] = $_POST[wpust_feedname_new]." => ".$_POST[wpust_feedid_new];
	}
}
$wpustream_feedstring = implode("|||",$wpustream_feedstring);
	
update_option('wpustream_feeds', $wpustream_feedstring);
update_option('wpustream_active', $_POST['wpustream_active']);
//update_option('wpustream_height', $_POST['wpustream_height']);
//update_option('wpustream_width', $_POST['wpustream_width']);
update_option('wpustream_chatroom', $_POST['wpustream_chatroom']);
//update_option('wpustream_chatheight', $_POST['wpustream_chatheight']);
//update_option('wpustream_chatwidth', $_POST['wpustream_chatwidth']);

if(isset($_POST['wpustream_show_quicktag'])) // If wpustream_show_quicktag is checked
	{update_option('wpustream_show_quicktag', true);}
	else {update_option('wpustream_show_quicktag', false);}
}

/*Get options for form fields*/
$wpustream_feeds = stripslashes(get_option('wpustream_feeds'));
$wpustream_active = stripslashes(get_option('wpustream_active'));
//$wpustream_height = stripslashes(get_option('wpustream_height'));
//$wpustream_width = stripslashes(get_option('wpustream_width'));
$wpustream_chatroom = stripslashes(get_option('wpustream_chatroom'));
//$wpustream_chatheight = stripslashes(get_option('wpustream_chatheight'));
//$wpustream_chatwidth = stripslashes(get_option('wpustream_chatwidth'));
$wpustream_show_quicktag = get_option('wpustream_show_quicktag');
?>

<div class="wrap">
  <h2><?php _e('Ustream Feed Options', 'wpustream') ?></h2>
  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
<table width="100%" cellspacing="2" cellpadding="5" class="editform">
<tr valign="top"><td colspan="2"><h3><?php _e('Active Feed:') ?></h3></td></tr>
<?php
	$wpustream_feedarray = explode("|||",$wpustream_feeds);
	$wpustream_feeds2 = array();
	while (list($wpust_key,$wpust_val) = each($wpustream_feedarray)) {
		$wpustream_temp = explode(" => ",$wpust_val);
		$wpustream_feeds2[$wpustream_temp[0]] = $wpustream_temp[1];
	}
	//print_r($wpustream_feeds);
	$wpustream_feednames = array_keys($wpustream_feeds2);
	$wpustream_feedembeds = array_values($wpustream_feeds2);
?>
<tr><td><?php _e('Select the currently active show: ', 'wpustream') ?>
<select name="wpustream_active">
<?php
	while (list($key,$val) = each($wpustream_feednames)) {
		$keynumber = $key+1;
		if ($keynumber==$wpustream_active) { $wpustream_selected = " selected"; } else {$wpustream_selected = ""; }
		echo "<option value=\"$keynumber\"$wpustream_selected>$val</option>\n";
	}
?>
</select></td><td><input style="float:right;" type="submit" name="Submit" value="<?php _e('Update Options', 'wpustream') ?> &raquo;" /></td></tr>
</table>
<hr size="1">
<table width="100%" cellspacing="2" cellpadding="2" class="editform">
<tr valign="top"><td colspan="2"><h3><?php _e('Your Ustream Feeds:') ?></h3></td></tr>
<?php
	reset($wpustream_feednames);	
	while (list($key,$val) = each($wpustream_feednames)) {
		echo "<tr><td width=\"100\" align=\"right\">Name:</td><td><input type=\"text\" size=\"50\" name=\"wpust_feedname[$key]\" value=\"$val\"></td></tr>";
		echo "<tr><td align=\"right\">Embed Code:</td><td><textarea cols=\"80\" rows=\"5\" name=\"wpust_feedembed[$key]\">$wpustream_feedembeds[$key]</textarea></td></tr>";
		echo "<tr><td align=\"right\" style=\"border-bottom:1px #ccc dotted;\"><strong><input type=\"checkbox\" name=\"wpust_feeddelete[$key]\" value=\"1\" /><span style=\"color:red;\">Delete</span></strong></td><td style=\"border-bottom:1px #ccc dotted;\"></td>&nbsp;</tr>";
	}
?>
<tr valign="top"><td colspan="2"><h3><?php _e('Add New Feed:') ?></h3></td></tr>
<tr><td width="100" align="right">Name:</td><td><input type="text" name="wpust_feedname_new" value=""></td></tr>
<tr><td align="right">Embed Code:</td><td><textarea cols="80" rows="5" name="wpust_feedid_new"></textarea></td></tr>
</table>
<hr size="1">
<table width="100%" cellspacing="2" cellpadding="5" class="editform">
<tr valign="top"><td colspan="2"><h3><?php _e('Ustream Chat Feed') ?></h3></td></tr>
<tr><td><textarea rows="4" cols="60" name="wpustream_chatroom"><?php echo $wpustream_chatroom; ?></textarea></td></tr>
</table>
<hr size="1">
<table width="100%" cellspacing="2" cellpadding="5" class="editform">
<tr valign="top"><td colspan="2"><h3><?php _e('Advanced') ?></h3></td></tr>
<tr><td width="150"><?php _e('Show \'Ustream\' Quicktag', 'wpustream') ?></td><td>
<input name="wpustream_show_quicktag" type="checkbox" id="wpustream_show_quicktag" value="wpustream_show_quicktag"
	        	<?php if($wpustream_show_quicktag == TRUE) {?> checked="checked" <?php } ?> />
</td></tr>
</table>

<p class="submit">
  <input type="submit" name="Submit" value="<?php _e('Update Options', 'wpustream') ?> &raquo;" />
</p>
</form>
</div>
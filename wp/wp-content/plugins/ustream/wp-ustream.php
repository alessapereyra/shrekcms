<?php
/* 
 * Plugin Name:   WP-Ustream
 * Version:       1.1
 * Plugin URI:    http://www.pcmech.com
 * Description:   Allows embedding multiple Ustream feeds into Wordpress and selecting which feed is LIVE
 * Author:        David Risley
 * Author URI:    http://www.pcmech.com
 *
 * License:       GNU General Public License
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 * Copyright (C) 2008 PC Media, Inc. www.pcmedianet.com
 * 
 */

load_plugin_textdomain('wpcf',$path = 'wp-content/plugins/ustream');

/* Declare strings that change depending on input. This also resets them so errors clear on resubmission. */
/*$wpustream_strings = array(
	'height' => '<div class="contactright"><input type="text" name="wpustream_height" id="wpustream_height" size="10" maxlength="5" value="' . $_POST['wpustream_height'] . '" /> (' . __('required', 'wpustream') . ')</div>',
	'width' => '<div class="contactright"><input type="text" name="wpustream_width" id="wpustream_width" size="10" maxlength="5" value="' . $_POST['wpustream_width'] . '" /> (' . __('required', 'wpustream') . ')</div>',
	'feeds' => '<div class="contactright"><textarea name="wpcf_msg" id="wpcf_msg" cols="35" rows="8" >' . $_POST['wpustream_feeds'] . '</textarea></div>',
	'error' => '');*/

/*
This shows the quicktag on the write pages
Based off Buttonsnap Template
http://redalt.com/downloads
*/
if(get_option('wpustream_show_quicktag') == true) {
	include('buttonsnap.php');

	add_action('init', 'wpustream_button_init');
	add_action('marker_css', 'wpustream_marker_css');

	function wpustream_button_init() {
		$wpustream_button_url = buttonsnap_dirname(__FILE__) . '/wpustream_button.png';

		buttonsnap_textbutton($wpustream_button_url, __('Insert Ustream Feed', 'wpustream'), '<!--ustream feed-->');
		buttonsnap_register_marker('contact form', 'wpustream_marker');
	}

	function wpustream_marker_css() {
		$wpustream_marker_url = buttonsnap_dirname(__FILE__) . '/wpustream_marker.gif';
		echo "
			.wpcf_marker {
					display: block;
					height: 15px;
					width: 155px
					margin-top: 5px;
					background-image: url({$wpustream_marker_url});
					background-repeat: no-repeat;
					background-position: center;
			}
		";
	}
}

function wpustream_feed() {
	$ustream_feeds = get_option('wpustream_feeds');
    $ustream_active = get_option('wpustream_active');
    $ustream_feeds = explode("|||",$ustream_feeds);
	$feeds_array = array();
	while (list($foo,$feedline) = each($ustream_feeds)) {
		$templine = explode("=>",$feedline);
		$feeds_array[] = $templine[1];
	}
	$activefeed_embed = trim($feeds_array[$ustream_active-1]);	
    print $activefeed_embed;
}

/*Wrapper function which calls the form.*/
function wpustream_callback( $content )
{
	global $wpustream_strings;

	/* Run the input check. */

	if(! preg_match('|<!--ustream feed-->|', $content) and ! preg_match('|<!--ustream chat-->|', $content)) {
		return $content;
	}
    
    $ustream_feeds = get_option('wpustream_feeds');
    $ustream_active = get_option('wpustream_active');
    //$ustream_height = get_option('wpustream_height');
	//$ustream_width = get_option('wpustream_width');
    $ustream_chatroom = get_option('wpustream_chatroom');
    //$ustream_chatheight = get_option('wpustream_chatheight');
	//$ustream_chatwidth = get_option('wpustream_chatwidth');
	
	$ustream_feeds = explode("|||",$ustream_feeds);
	$feeds_array = array();
	while (list($foo,$feedline) = each($ustream_feeds)) {
		$templine = explode("=>",$feedline);
		$feeds_array[] = $templine[1];
	}
	$activefeed_embed = trim($feeds_array[$ustream_active-1]);
	
    //$ustream_content = '<embed width="'.$ustream_width.'" height="'.$ustream_height.'" flashvars="autoplay=false&brand=embed" src="http://ustream.tv/'.$activefeed.'" type="application/x-shockwave-flash" allowfullscreen="true" />';
    
    //$ustream_chat = '<embed width="'.$ustream_chatwidth.'" height="'.$ustream_chatheight.'" type="application/x-shockwave-flash" flashvars="channel='.$ustream_chatroom.'&server=chat1.ustream.tv" pluginspage="http://www.adobe.com/go/getflashplayer" src="http://ustream.tv/IrcClient.swf" allowfullscreen="true" />';
    
    $tempstring = str_replace('<!--ustream chat-->', stripslashes($ustream_chatroom), $content);
    return str_replace('<!--ustream feed-->', stripslashes($activefeed_embed), $tempstring);
    
}

function wpustream_add_options_page()
	{
		add_options_page('Ustream Options', 'Ustream', 'manage_options', 'ustream/options-ustream.php');
	}

/* Action calls for all functions */
add_action('admin_head', 'wpustream_add_options_page');
add_filter('the_content', 'wpustream_callback', 7);

?>

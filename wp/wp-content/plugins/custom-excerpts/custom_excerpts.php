<?php
/*
Plugin Name: Custom Excerpts
Version: 1.0.1
Plugin URI: http://www.seanbluestone.com/custom_excerpts
Author: Sean Bluestone
Author URI: http://www.seanbluestone.com
Description: Allows you to create custom excerpt text and define the length of excerpts without the need for messing around with WordPress core files.

Copyright 2008  Sean Bluestone  (email : thedux0r@gmail.com)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('the_excerpt', 'ce_excerpt_filter');
add_action('admin_menu', 'ce_menu');
register_activation_hook(__FILE__, 'ce_install');

function ce_install(){
	add_option('ce_html','<p>');
	add_option('ce_length',80);
	add_option('ce_moretext','..read more');
	add_option('ce_nofollow','Yes');
}

function ce_menu(){
	add_submenu_page('options-general.php', 'Custom Excerpts', 'Custom Excerpts', 8, 'ce_options', 'ce_options');
}

function ce_options(){

	echo '<div class="wrap"><h2>Custom Excerpt Options</h2>
	<form method="post" action="options.php" name="custom_excerpt">';

	wp_nonce_field('update-options');

	echo '<table class="form-table"><tr valign="top">
	<tr valign="top"><td><b>Excerpt Length:</b></td>
	<td><input type="text" name="ce_length" value="'.get_option('ce_length').'"></td><td>The length, in words, of excerpts.</td></tr>
	<tr valign="top"><td><b>Excerpt Text:</b></td>
	<td><input type="text" name="ce_moretext" value="'.get_option('ce_moretext').'"></td><td>If supplied a link will be generated to the post using this text.</td></tr>

	<tr valign="top"><td><b>Make Link Nofollow?</b></td>';

	if(get_option('ce_nofollow')=='No'){
		$No=' SELECTED';
	}else{
		$Yes=' SELECTED';
	}

	echo '<td><select name="ce_nofollow"><option value="Yes"'.$Yes.'>Nofollow</option><option value="No"'.$No.'>Dofollow</option></select></td><td>Most themes use the title of the article to link to the URL of the post. This means that a second follow link is unnesessary. By making the excerpt link nofollow, pages where it\'s used will gain a small amount of PR.</td></tr>

	<tr valign="top"><td><b>Allow These HTML Tags:</b></td>
	<td><input type="text" name="ce_html" value="'.get_option('ce_html').'"></td><td>The default WordPress excerpt function excludes all HTML tags which are sometimes useful in excerpts. Note that including tags with extra attributes like &#60;a&#62; or &#60;img&#62; may cause some formatting problems. Leave blank to exclude all HTML.</td></tr>

	<tr><td colspan="3"><input type="hidden" name="action" value="update" /><input type="submit" name="Submit" value="'.__('Save Changes',$WPLD_Domain).'" /></td></tr>
	</table>
	<input type="hidden" name="page_options" value="ce_length,ce_moretext,ce_html,ce_nofollow" />
	</form>
	</div>';
}

function ce_excerpt_filter($text) {
	$Length=get_option('ce_length');
	$MoreText=get_option('ce_moretext');
	$HTML=get_option('ce_html');
	$Nofollow=get_option('ce_nofollow');

	$text = get_the_content('');
	$text = strip_shortcodes( $text );

	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text,$HTML);
	$excerpt_length = apply_filters('excerpt_length', $Length);
	$words = explode(' ', $text, $excerpt_length + 1);
	if ($MoreText && count($words)>$Length) {
		array_pop($words);
		array_push($words, '<a '.($Nofollow=='Yes' ? 'rel="nofollow" ' : '').'href="'.get_permalink().'">'.$MoreText.'</a>');
		$text = implode(' ', $words);
	}
	return $text;
}

?>
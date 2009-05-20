<?php

echo '<div class="wrap" id="poststuff">';

echo sm_start_box('Session Manager');

$home_url = get_option('siteurl');
$hits = sm_get_num_hits();
$dates = sm_get_hit_dates();
$start_date = $dates->start_date;
$end_date = $dates->end_date;
$date_format = get_option('date_format');

$intro = '
<p><strong>Welcome to the Wordpress Session Manager by <a href="http://www.newmedias.co.uk" target="_blank">CNMS</a></strong>.</p>
<p>This lightweight yet informative plugin simply logs pages viewed by all site visitors in the last day (by default although this is configurable) and then allows you, the admin, to view the actions per user or per page. This will give you a good idea of the more popular pages on your site allowing you to optimise the site a little more.</p>
<p>Use the tabs down the left menu (WP2.7+) or along the top (<= WP 2.6) to get to the data pages. The navigation is also available below:</p>
<p>
	<ul style="list-style-type: square !important; margin-left: 20px; font-size: 11px;">
		<li><a href="' . $home_url . '/wp-admin/admin.php?page=sm_all_sessions">Hits By Page</a></li>
		<li><a href="' . $home_url . '/wp-admin/admin.php?page=sm_all_by_user">Hits By User</a></li>
		<li><a href="' . $home_url . '/wp-admin/admin.php?page=sm_all_data">Recent Hits</a></li>
		<li><a href="' . $home_url . '/wp-admin/admin.php?page=sm_settings">Settings</a></li>
	</ul>
</p>';

echo '<p>' . __($intro, 'sm') . '</p>';
echo '<p style="font-weight: bold;">' . __('There have been ', 'sm') . $hits . __(' hits between ', 'sm') . date($date_format, $start_date) . __(' and ', 'sm') . date($date_format, $end_date) . '</p>';

if ($hits) {
	if ($top_three = sm_get_top_pages()) {
		echo '<div style="float: left; width: 60%;">';
		echo '<p style="font-style: italic;">' . __('The five post popular pages on your site are:', 'sm') . '</p>';
		echo '<ul style="list-style-type: square !important; margin-left: 20px; font-size: 11px;">';

		foreach ($top_three as $page) {
			$hits = ' ' . ($page->hits == 1 ? 'Hit':'Hits') . ' - ';
			echo '<li>' . $page->hits . $hits . sm_shorten_url($page->url) . '</li>';
		}

		echo '</ul>';
		echo '</div>';
	}

	if ($top_three = sm_get_top_users()) {
		echo '<div style="float: left; width: 38%;">';
		echo '<p style="font-style: italic;">' . __('The five post active users on your site are:', 'sm') . '</p>';
		echo '<ul style="list-style-type: square !important; margin-left: 20px; font-size: 11px;">';

		foreach ($top_three as $user) {
			$pages = ' ' . ($user->num_pages == 1 ? 'Page':'Pages') . ' - ';
			echo '<li>' . $user->num_pages . $pages . sm_real_name($user->session_id, $user->user_id) . '</li>';
		}

		echo '</ul>';
		echo '</div>';
	}
	
	echo '<div style="clear: both;">&nbsp;</div>';
}

echo sm_end_box();

echo '</div>';

?>
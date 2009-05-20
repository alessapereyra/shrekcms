<?php

echo '<div class="wrap" id="poststuff">';

if ($url = sm_get('url')) {
	$url = base64_decode($url);

	echo '<form method="POST">';
	echo sm_start_box('Session Manager - URL stats: ' . sm_shorten_url($url));
	sm_hits_by_page($url);
	echo sm_end_box();
	echo '</form>';
	
} else if ($session_id = sm_get('session_id')) {
	echo '<form method="POST">';
	echo sm_start_box('Session Manager - Individual session stats: ' . sm_real_name($session_id, sm_get_user_by_session($session_id)));
	sm_show_session_stats($session_id);
	echo sm_end_box();
	echo '</form>';
	
} else {
	if (sm_post('exclude_pages_button')) {
		sm_save_excluded_pages();
	} else if (sm_post('delete_pagedata')) {
		sm_delete_pagedata();
	}

	echo sm_start_box('Session Manager - Filter Controls');
	sm_render_filters('by_page');
	echo sm_end_box();	
	
	echo '<form method="POST">';
	echo sm_start_box('Stats by page');
	sm_show_by_page();
	echo sm_end_box();

	echo sm_start_box('Actions');
	sm_render_actions('by_page');
	echo sm_end_box();
	echo '</form>';
}

echo '</div>';

?>
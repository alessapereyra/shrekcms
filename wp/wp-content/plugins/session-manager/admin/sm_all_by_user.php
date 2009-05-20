<?php

echo '<div class="wrap" id="poststuff">';

if (sm_post('exclude_users_button')) {
	sm_save_excluded_users();
} else if (sm_post('delete_userdata')) {
	sm_delete_userdata();
}

echo '<form method="POST">';

echo sm_start_box('Session Manager - All Sessions by User');
sm_show_all_sessions();
echo sm_end_box();

echo sm_start_box('Actions');
sm_render_actions('by_user');
echo sm_end_box();

echo '</form>';
echo '</div>';

?>
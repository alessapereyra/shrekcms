<?php
//yr-settings

echo '<div class="wrap" id="poststuff">
		<h2>' . __('Session Manager, Settings','yc') . '</h2>';

if (sm_post('sm_update_settings')) {
	sm_update_settings();
} else if ($filename = sm_post('exclude_filename')) {
	sm_exclude_filename($filename);
} else if ($session_id = sm_post('exclude_session')) {
	sm_exclude_user($session_id);
}

sm_render_settings();

function sm_render_settings() {
	$left_width = 420;
	$input_width = 420;
	$sm_settings = get_option('sm_settings');

	$detail_start = '<div style="margin-bottom: 5px;">';
	$detail_end = '</div>';

	$track_admin_detail = $detail_start . __('Should the plugin track hits on admin pages?', 'sm') . $detail_end;
	$track_expiry_detail = $detail_start . __('How many days should the data be kept for?', 'sm') . $detail_end;
	$robot_hits_detail = $detail_start . __('If you mark a user/ip address as a robot then should stats from them ever be shown?', 'sm') . $detail_end;

	echo sm_start_box('General Settings');
	echo '	<form method="POST">';
	echo '	<table style="width: 100%;">';

	echo '	<tr>
				<td style="vertical-align: top; width: ' . $left_width . 'px;">
					<div style="margin-bottom: 10px; font-weight: bold;">' . __('Track Admin?', 'sm') . '</div>
					<div style="font-size: 10px;">' . $track_admin_detail . '</div>
				</td>
				<td style="vertical-align: top;">
					<label><input type="radio" name="settings[track_admin]" value="1" ' . ($sm_settings->track_admin ? 'checked="checked"':'') . ' /> Yes</label><br />
					<label><input type="radio" name="settings[track_admin]" value="0" ' . (!$sm_settings->track_admin ? 'checked="checked"':'') . ' /> No</label>
				</td>
			</tr>';

	echo '	<tr>
				<td style="vertical-align: top; width: ' . $left_width . 'px;">
					<div style="margin-bottom: 10px; font-weight: bold;">' . __('Data Expiry', 'sm') . '</div>
					<div style="font-size: 10px;">' . $track_expiry_detail . '</div>
				</td>
				<td style="vertical-align: top;">
					<input name="settings[track_expiry]" value="' . ($sm_settings->track_expiry/86400) . '" />
				</td>
			</tr>';

	echo '	<tr>
				<td style="vertical-align: top; width: ' . $left_width . 'px;">
					<div style="margin-bottom: 10px; font-weight: bold;">' . __('Show Robot Hits', 'sm') . '</div>
					<div style="font-size: 10px;">' . $robot_hits_detail . '</div>
				</td>
				<td style="vertical-align: top;">
					<label><input type="radio" name="settings[view_robot_hits]" value="1" ' . ($sm_settings->view_robot_hits ? 'checked="checked"':'') . ' /> Yes</label><br />
					<label><input type="radio" name="settings[view_robot_hits]" value="0" ' . (!$sm_settings->view_robot_hits ? 'checked="checked"':'') . ' /> No</label>
				</td>
			</tr>';

	echo '</table>';

	echo '<p class="submit" style="margin-top: 0px; text-align: right;">
			<input type="submit" class="button" name="sm_update_settings" value="' . __('Save settings', 'sm') . '" />
		</p>';

	echo '</form>';
	
	echo sm_end_box();
	
	echo sm_start_box('Excluded Pages');
	sm_render_excluded_pages();
	echo sm_end_box();
	
	echo sm_start_box('Excluded Users');
	sm_render_excluded_users();
	echo sm_end_box();

}

function sm_update_settings() {
	$settings = get_option('sm_settings');

	foreach ($_POST['settings'] as $key=>$value) {
		if ($key == 'track_expiry') {
			$value *= 86400;
		}

		$settings->$key = stripcslashes($value);
	}

	if (update_option('sm_settings', $settings)) {
		sm_display_feedback(__('Settings have been successfully saved', 'sm'));
	}
}

echo '</div>';

?>
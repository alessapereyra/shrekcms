<?php

function sm_post($key, $default='', $strip_tags=false) {
	return sm_get_global($_POST, $key, $default, $strip_tags);
}

function sm_get($key, $default='', $strip_tags=false) {
	return sm_get_global($_GET, $key, $default, $strip_tags);
}

function sm_request($key, $default='', $strip_tags=false) {
	return sm_get_global($_REQUEST, $key, $default, $strip_tags);
}

function sm_get_global($array, $key, $default='', $strip_tags) {
	if (isset($array[$key])) {
		$default = $array[$key];

		if ($strip_tags) {
			$default = strip_tags($default);
		}
	}

	return $default;
}

function sm_start_box($title , $return=true){

	$html = '	<div class="postbox" style="margin: 5px 0px;">
					<h3>' . $title . '</h3>
					<div class="inside">';

	if ($return) {
		return $html;
	} else {
		echo $html;
	}
}

function sm_end_box($return=true) {
	$html = '</div>
		</div>';

	if ($return) {
		return $html;
	} else {
		echo $html;
	}
}

function sm_admin_page() {
	$admin_page = SM_ADMIN_DIR . 'sm_admin.php';
	$tab_title = __('Session Manager','sm');
	$func = 'sm_admin_loader';
	$access_level = 'manage_options';

	$sub_pages = array(
	__('Hits By Page','sm')=>'sm_all_sessions'
	, __('Hits By User','sm')=>'sm_all_by_user'
	, __('Recent Hits','sm')=>'sm_all_data'
	, __('Settings','sm')=>'sm_settings'
	);

	add_menu_page($tab_title, $tab_title, $access_level, $admin_page, $func);

	foreach ($sub_pages as $title=>$page) {
		add_submenu_page($admin_page, $title, $title, $access_level, $page, $func);
	}
}

function sm_admin_loader() {
	$page = trim(sm_request('page'));

	if (SM_PLUGIN_DIRNAME . 'admin/sm_admin.php' == $page) {
		require_once(SM_PLUGIN_DIR_PATH . 'admin/sm_admin.php');
	} else if (file_exists(SM_PLUGIN_DIR_PATH . 'admin/' . $page . '.php')) {
		require_once(SM_PLUGIN_DIR_PATH . 'admin/' . $page . '.php');
	}
}

function sm_init() {
	global $wpdb, $table_name, $validity_period, $excludes_table, $user_excludes_table;

	$sm_settings = get_option('sm_settings');
	$validity_period = $sm_settings->track_expiry;

	$table_name = $wpdb->prefix . 'session_manager';
	$excludes_table = $wpdb->prefix . 'session_manager_page_exclude';
	$user_excludes_table = $wpdb->prefix . 'session_manager_user_exclude';
}

function sm_real_name($session_id, $user_id=false) {
	$name = false;
	if ($user_id) {
		$user = get_userdata($user_id);
		if ($user) {
			$name = ucfirst($user->user_login);
		}
	}

	if (!$name) {
		$name = '<em>Guest ' . substr($session_id, 0, 5) . '</em>';
	}

	return $name;
}

function sm_show_session_stats($session_id, $user_id = false) {
	global $wpdb, $table_name;

	$name = sm_real_name($session_id, $user_id);
	$sort = sm_get('sort', 'unixtime');
	$order = sm_get('order', 'DESC');
	$this_page = get_option('siteurl') . '/wp-admin/admin.php?page=' . sm_get('page') . '&session_id=' . $session_id;

	sm_get_backlink();

	echo '<table style="width:100%;" cellspacing="0">
			<tr>
				<td style="font-weight: bold; border-bottom: 1px solid silver;">
					<a href="' . sm_get_sort_link($this_page, 'url', $sort, $order) . '">Page Viewed</a>
				</td>
				<td style="font-weight: bold; border-bottom: 1px solid silver;">
					<a href="' . sm_get_sort_link($this_page, 'user_agent', $sort, $order) . '">User Agent</a>
				</td>
				<td style="font-weight: bold; border-bottom: 1px solid silver; width: 90px;">
					<a href="' . sm_get_sort_link($this_page, 'ip_address', $sort, $order) . '">IP Address</a>
				</td>
				<td style="font-weight: bold; border-bottom: 1px solid silver; width: 150px;">
					<a href="' . sm_get_sort_link($this_page, 'unixtime', $sort, $order) . '">Date Visited</a>
				</td>
			</tr>';

	$sql = 'SELECT url, unixtime, ip_address, user_agent
				FROM ' . $table_name . '
				WHERE session_id = "' . $session_id . '"
				ORDER BY ' . $sort . ' ' . $order;
	$results = $wpdb->get_results($sql);
	$num_res = count($results);

	foreach ($results as $row) {
		echo '<tr style="background-color: ' . sm_get_bg() . ';">
					<td><span title="' . $row->url . '">' . sm_shorten_url($row->url) . '<span></td>
					<td>' . sm_shorten_string($row->user_agent, 25) . '</td>
					<td>' . $row->ip_address . '</td>
					<td>' . date('d/m/Y H:i:s',$row->unixtime) . '</td>
				</tr>';
	}

	echo '<tr><td colspan="4" style="text-align: right; border-top: 1px solid silver;">' . $num_res . ' ' . __(($num_res == 1 ? 'Page':'Pages'), 'sm') . '</td></tr>';

	echo '</table>';

	sm_get_backlink();

}

function sm_get_backlink() {
	echo '<div style="margin: 10px 0px;">
			<a href="' . get_option('siteurl') . '/wp-admin/admin.php?page=sm_all_sessions">&#0171; Back to Session Viewer</a>
		</div>';
}

function sm_get_bg() {
	global $bg;

	if ($bg == '#EFEFEF') {
		$bg = 'white';
	} else {
		$bg = '#EFEFEF';
	}

	return $bg;
}

function sm_hits_by_page($url) {
	global $wpdb, $table_name;

	$this_page = get_option('siteurl') . '/wp-admin/admin.php?page=' . sm_get('page') . '&url=' . sm_get('url');
	$sort = sm_get('sort', 'unixtime');
	$order = sm_get('order', 'DESC');

	sm_get_backlink();

	echo '<table style="width:100%;" cellspacing="0">
			<tr>
				<td style="border-bottom: 1px solid silver; font-weight: bold;">
					<a href="' . sm_get_sort_link($this_page, 'session_id', $sort, $order) . '">Viewed By</a>
				</td>
				<td style="border-bottom: 1px solid silver; font-weight: bold;">
					<a href="' . sm_get_sort_link($this_page, 'ip_address', $sort, $order) . '">Viewed From</a>
				</td>
				<td style="border-bottom: 1px solid silver; font-weight: bold;">
					<a href="' . sm_get_sort_link($this_page, 'user_agent', $sort, $order) . '">Viewed Using <em style="font-weight: normal;">(Hover)</em></a>
				</td>
				<td style="border-bottom: 1px solid silver; font-weight: bold; width: 200px;">
					<a href="' . sm_get_sort_link($this_page, 'unixtime', $sort, $order) . '">Date Visited</a>
				</td>
			</tr>';

	$sql = 'SELECT session_id, ip_address, user_agent, user_id, unixtime
			FROM ' . $table_name . '
			WHERE url = "' . $url . '"
			ORDER BY ' . $sort . ' ' . $order;
	$results = $wpdb->get_results($sql);
	$num_res = count($results);

	foreach ($results as $row) {
		$name = sm_real_name($row->session_id, $row->user_id);

		echo '	<tr style="background-color: ' . sm_get_bg() . ';">
					<td>' . $name . '</td>
					<td>' . $row->ip_address . '</td>
					<td>' . sm_shorten_string($row->user_agent) . '</td>
					<td>' . date('d/m/Y H:i:s',$row->unixtime) . '</td>
				</tr>';
	}

	echo '<tr><td colspan="4" style="text-align: right; border-top: 1px solid silver;">' . $num_res . ' ' . __(($num_res == 1 ? 'Hit':'Hits'), 'sm') . '</td></tr>';


	echo '</table>';

	sm_get_backlink();

}

function sm_get_sort_link($url, $field, $sort, $order) {
	return $url . '&sort=' . $field . '&order=' . ($sort == $field && $order == 'ASC' ? 'DESC':'ASC');
}

function sm_show_by_page() {
	$sort = sm_get('sort', 'hits');
	$order = sm_get('order', 'DESC');

	$sessions = sm_get_pages($sort, $order);

	if ($num_results = count($sessions)) {

		$this_page = get_option('siteurl') . '/wp-admin/admin.php?page=' . sm_get('page');

		echo '<table style="width:100%;" cellspacing="0">
				<tr>
					<td style="border-bottom: 1px solid silver; width: 20px;">&nbsp;</td>
					<td style="font-weight: bold; border-bottom: 1px solid silver;">
						<a href="' . sm_get_sort_link($this_page, 'url', $sort, $order) . '">Page Visited</a>
					</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 100px;">
						<a href="' . sm_get_sort_link($this_page, 'hits', $sort, $order) . '">Times Visited</a>
					</td>
				</tr>';

		foreach ($sessions as $obj) {
			$url = $obj->url;
			$hits = $obj->hits;

			$link = get_option('siteurl') . '/wp-admin/admin.php?page=sm_all_sessions&url=' . base64_encode($url);

			echo '<tr style="background-color: ' . sm_get_bg() . ';">
					<td><input type="checkbox" name="exclude_pages[' . $url . ']" /></td>
					<td>
						<a href="' . $link . '">' . sm_shorten_url($url) . '</a>
					</td>
					<td>' . $hits . '</td>
				</tr>';
		}

		echo '<tr><td colspan="3" style="text-align: right; border-top: 1px solid silver;">' . $num_results . ' ' . __(($num_results == 1 ? 'Page':'Pages'), 'sm') . '</td></tr>';

		echo '</table>';

	} else {
		echo 'No one has visited your site yet.';
	}
}

function sm_shorten_url($url) {
	$modified = false;

	if (trim($url) == SM_RELATIVE_ROOT) {
		$modified = true;
		$url = 'Homepage';
	} else if ($find = strstr($url, 'page_id=')) {
		$page_id = trim(str_replace('page_id=', '', $find));
		if ($page = (get_page($page_id))) {
			$modified = true;
			$url = $page->post_title;
		}
	} else if ($find = strstr($url, 'p=')) {
		$post_id = trim(str_replace('p=', '', $find));
		if ($post = (get_post($post_id))) {
			$modified = true;
			$url = $post->post_title;
		}
	} else if ($find = strstr($url, 'cat=')) {
		$cat_id = trim(str_replace('cat=', '', $find));
		if ($category = (get_category($cat_id))) {
			$modified = true;
			$url = $category->cat_name;
		}
	} else if ($find = strstr($url, 'm=')) {
		$modified = true;
		$archive = trim(str_replace('m=', '', $find));
		$archive_unixtime = mktime(12,0,0,substr($archive, 4), 1, substr($archive, 0, 4));
		$url = __('Archive - ') . date('F Y', $archive_unixtime);
	}

	if (strlen($url) >= 80 && !$modified) {
		$url = '<span title="' . $url . '">' . trim(substr($url,0,77)) . '...</span>';
	}

	return $url;
}

function sm_shorten_string($string, $max=50, $title_tags=true) {
	$full_string = $string;

	if (strlen($string) >= $max) {
		$string = substr($string,0,($max-3)) . '...';
	}

	if ($title_tags) {
		$string = '<span title="' . mysql_real_escape_string($full_string) . '">' . $string . '</span>';
	}

	return $string;
}

function sm_get_sessions($sort, $order, $limit=false) {
	global $wpdb, $table_name, $user_excludes_table;

	$sm_settings = get_option('sm_settings');

	$sql = 'SELECT
				DISTINCT(t1.session_id)
				, t1.id
				, MAX(t1.user_id) AS user_id
				, COUNT(t1.id) AS num_pages
				, MAX(t1.unixtime) AS unixtime
			FROM
				' . $table_name . ' t1
				' . (!$sm_settings->view_robot_hits ? ' LEFT JOIN ' . $user_excludes_table . ' t2 ON (t1.ip_address = t2.ip_address)':'') . '
			WHERE 1 ' . (!$sm_settings->view_robot_hits ? 'AND t2.id IS NULL':'') . '
			GROUP BY t1.session_id
			ORDER BY ' . $sort . ' ' . $order;
	if ($limit) {
		$sql .= ' LIMIT ' . $limit;
	}

	$sessions = $wpdb->get_results($sql);

	return $sessions;
}

function sm_get_hits() {
	global $wpdb, $table_name, $user_excludes_table;

	$sm_settings = get_option('sm_settings');
	$filter = sm_get('filter');

	$sql = 'SELECT t1.*
			FROM
				' . $table_name . ' t1
				' . (!$sm_settings->view_robot_hits ? ' LEFT JOIN ' . $user_excludes_table . ' t2 ON (t1.ip_address = t2.ip_address)':'') . '
			WHERE 1 ' . ($filter ? 'AND url LIKE "%' . $filter . '%"':'') . (!$sm_settings->view_robot_hits ? 'AND t2.id IS NULL':'') . '
			ORDER BY t1.unixtime DESC';
	if ($limit = sm_get('limit')) {
		$sql .= ' LIMIT ' . $limit;
	}

	return $wpdb->get_results($sql);
}

function sm_show_all_views() {
	$visitors = 0;
	$sm_settings = get_option('sm_settings');
	$validity_period = $sm_settings->track_expiry;

	$sessions = sm_get_hits();

	if ($pages_viewed = count($sessions)) {
		$this_page = get_option('siteurl') . '/wp-admin/admin.php?page=' . sm_get('page');

		echo '<table style="width:100%;" cellspacing="0">
				<tr>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 30px;">&nbsp;</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 110px;">' . __('User', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold;">' . __('Page Viewed', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 250px;">' . __('User Agent', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 90px;">' . __('IP', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 130px;">' . __('Visited', 'sm') . '</td>
				</tr>';

		foreach ($sessions as $obj) {
			$link = get_option('siteurl') . '/wp-admin/admin.php?page=sm_all_sessions&session_id=' . $obj->session_id;

			echo '<tr style="background-color: ' . sm_get_bg() . ';">
					<td><input type="checkbox" name="exclude_users[' . $obj->session_id . ']" value="' . $obj->id . '" /></td>
					<td>' . sm_real_name($obj->session_id, $obj->user_id) . '</td>
					<td>' . sm_shorten_url($obj->url) . '</td>
					<td>' . sm_shorten_string($obj->user_agent, 35) . '</td>
					<td>' . $obj->ip_address . '</td>
					<td>' . date('d/m/y H:i',$obj->unixtime) . '</td>
				</tr>';

			$visitors++;
		}

		echo '<tr>
				<td colspan="6" style="border-top: 1px solid #DEDEDE; font-size: 10px; text-align:right;">
					' . __('Showing a total of ','sm') . $pages_viewed . __(' hits across ','sm') . $visitors . ' ' . __(($visitors == 1 ? 'visitor':'visitors'),'sm') . __(' within the last ','sm') . ($validity_period/86400) . ' ' . __(($validity_period == 86400 ? 'day':'days'), 'sm') . '
				</td>
			</tr>';

		echo '</table>';

	} else {
		echo 'No one has visited your site yet.';
	}
}

function sm_show_all_sessions() {
	global $wpdb, $table_name;

	$visitors = 0;
	$pages_viewed = 0;
	$sort = sm_get('sort', 'unixtime');
	$order = sm_get('order', 'DESC');
	$sm_settings = get_option('sm_settings');
	$validity_period = $sm_settings->track_expiry;

	$sessions = sm_get_sessions($sort, $order);

	if (count($sessions)) {
		$this_page = get_option('siteurl') . '/wp-admin/admin.php?page=' . sm_get('page');

		echo '<table style="width:100%;" cellspacing="0">
				<tr>
					<td style="border-bottom: 1px solid silver; width: 20px;">&nbsp;</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 120px;">
						<a href="' . sm_get_sort_link($this_page, 'session_id', $sort, $order) . '">' . __('User', 'sm') . '</a>
					</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 80px;">
						<a href="' . sm_get_sort_link($this_page, 'num_pages', $sort, $order) . '">' . __('# Pages', 'sm') . '</a>
					</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold;">
						' . __('Last Page Viewed', 'sm') . '
					</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 90px;">
						' . __('Last IP', 'sm') . '
					</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 130px;">
						<a href="' . sm_get_sort_link($this_page, 'MAX(unixtime)', $sort, $order) . '">' . __('Visited', 'sm') . '</a>
					</td>
				</tr>';

		foreach ($sessions as $obj) {
			$session_id = $obj->session_id;
			$user_id = $obj->user_id;

			$sql = 'SELECT url, ip_address
					FROM ' . $table_name . '
					WHERE session_id = "' . $session_id . '"
					ORDER BY unixtime DESC
					LIMIT 1';
			$row = $wpdb->get_row($sql);

			$link = get_option('siteurl') . '/wp-admin/admin.php?page=sm_all_sessions&session_id=' . $session_id;

			echo '<tr style="background-color: ' . sm_get_bg() . ';">
					<td><input type="checkbox" name="exclude_users[' . $session_id . ']" value="' . $obj->id . '" /></td>
					<td>' . sm_real_name($session_id, $user_id) . '</td>
					<td style="text-align: center;">
						<a href="' . $link . '">' . $obj->num_pages . '</a>
					</td>
					<td>' . sm_shorten_url($row->url) . '</td>
					<td>' . $row->ip_address . '</td>
					<td>' . date('d/m/Y H:i',$obj->unixtime) . '</td>
				</tr>';

			$visitors++;
			$pages_viewed += $obj->num_pages;
		}

		echo '<tr>
				<td colspan="6" style="border-top: 1px solid #DEDEDE; font-size: 10px; text-align:right;">
					' . __('Showing a total of ','sm') . $pages_viewed . __(' page views across ','sm') . $visitors . ' ' . __(($visitors == 1 ? 'visitor':'visitors'),'sm') . __(' within the last ','sm') . ($validity_period/86400) . ' ' . __(($validity_period == 86400 ? 'day':'days'), 'sm') . '
				</td>
			</tr>';

		echo '</table>';

	} else {
		echo 'No one has visited your site yet.';
	}
}

function sm_clear_expired_data() {
	global $wpdb, $table_name;

	$sm_settings = get_option('sm_settings');

	$time = (time()-$sm_settings->track_expiry);
	$sql = 'DELETE FROM ' . $table_name . '
			WHERE unixtime < ' . $time;
	$wpdb->query($sql);
}

function sm_activate() {

	if (!get_option('sm_settings')) {
		$obj = new stdClass();
		$obj->track_admin = false;
		$obj->track_expiry = 86400;
		$obj->view_robot_hits = 0;

		add_option('sm_settings', $obj);

		sm_mysql_import(SM_SQL_IMPORT_FILE);
	}

}

function sm_deactivate() {

}

function sm_display_feedback($msg) {
	echo '<div id="message" class="updated fade" style="margin-top: 5px; padding: 7px;">' . $msg . '</div>';
}

function sm_display_error($msg) {
	echo '<div id="error" class="error" style="margin-top: 5px; padding: 7px;">' . $msg . '</div>';
}

function sm_mysql_import($filename) {
	global $wpdb;

	$return = false;
	$sql_start = array('INSERT', 'UPDATE', 'DELETE', 'DROP', 'GRANT', 'REVOKE', 'CREATE', 'ALTER');

	if (file_exists($filename)) {
		$query_string = false;
		$lines = file($filename);

		if (is_array($lines)) {
			foreach ($lines as $line) {
				$line = trim($line);

				if(!preg_match("'^--'", $line)) {
					$query_string.=" ".$line;
				}
			}

			if ($query_string) {
				$queries = explode(";", $query_string);
				$to_add = false;

				if (is_array($queries)) {
					$queries = array_reverse($queries, true);

					foreach ($queries as $sql) {
						$sql = trim($sql);

						if ($to_add) {
							$sql .= $to_add;
							$to_add = false;
						}

						$space = strpos($sql, ' ');
						$first_word = trim(strtoupper(substr($sql, 0, $space)));
						if (in_array($first_word, $sql_start)) {
							$pos = strpos($sql, '`')+1;
							$sql = substr($sql, 0, $pos) . $wpdb->prefix . substr($sql, $pos);

							$wpdb->query($sql);
							$to_add = false;
						} else {
							$to_add .= $sql;
						}
					}

					$return = true;
				}
			}
		}
	}

	return $return;
}

function sm_get_user_by_session($session_id) {
	global $wpdb, $table_name;

	$sql = 'SELECT DISTINCT(user_id)
			FROM ' . $table_name . '
			WHERE session_id = "' . $session_id . '"
			ORDER BY id DESC
			LIMIT 1';
	$user_id = $wpdb->get_var($sql);

	return $user_id;
}

function sm_render_filters($type) {
	$this_page = get_option('siteurl') . '/wp-admin/admin.php';

	echo '	<form action="' . $this_page  . '">
			<input type="hidden" name="page" value="' . sm_get('page') . '" />';

	if ($type == 'by_user') {
		echo __('Type in a keyword to filter the user by:', 'sm');
	} else if ($type == 'by_page') {
		echo __('Type in a keyword to filter the url on:', 'sm');
	}

	echo '	<input name="filter" value="' . sm_get('filter') . '" />
			<input type="button" class="button" onclick="this.form.submit();" value="' . __('Filter', 'sm') . '" />';

	if (sm_get('filter')) {
		$this_page = get_option('siteurl') . '/wp-admin/admin.php?page=' . sm_get('page');
		echo ' <a href="' . $this_page . '" class="button">' . __('Remove Filter?', 'sm') . '</a>';
	}

	echo '</form>';
}

function sm_render_actions($type) {
	echo '<div style="margin-bottom: 10px;">' . __('The following are actions for this page. Check the boxes next to your selected records above and submit the forum by using the selected button below.', 'sm') . '</div>';

	if ($type == 'by_user') {
		echo '<input type="submit" class="button" name="exclude_users_button" value="' . __('No longer track selected users?', 'sm') . '" /> ';
		echo '<br /><label><input type="checkbox" name="delete_old_data" /> Delete data that has already been logged against these sessions/users?</label>';
		echo '<br /><label><input type="checkbox" name="mark_robot" value="1" /> Mark this user as a robot?</label>';
		echo '<br /><label><input type="checkbox" name="block_ip" value="1" /> Block this IP address?</label>';
		echo '<p>- OR -</p><input type="submit" class="button" name="delete_userdata" value="' . __('Delete data for selected users?', 'sm') . '" /> ' . __('(Will continue to track unless they have been excluded)', 'sm');
	} else if ($type == 'by_page') {
		echo '<input type="submit" class="button" name="exclude_pages_button" value="' . __('No longer track selected pages?', 'sm') . '" /> ';
		echo '<label><input type="checkbox" name="delete_old_data" /> Delete data that has already been logged on these pages?</label><br />';
		echo '<input type="submit" class="button" name="delete_pagedata" value="' . __('Delete data for selected pages?', 'sm') . '" /> ' . __('(Will continue to track unless they have been excluded)', 'sm');
	}
}

function sm_save_excluded_pages() {
	global $excludes_table, $table_name, $wpdb;

	if ($pages = sm_post('exclude_pages')) {
		foreach ($pages as $key=>$value) {
			$sql = 'SELECT COUNT(id)
					FROM ' . $excludes_table . '
					WHERE filename = "' . mysql_real_escape_string($key) . '"';

			if (!$wpdb->get_var($sql)) {
				$sql = 'INSERT INTO ' . $excludes_table . ' (
							filename
							, unixtime
						)
						VALUES (
							"' . mysql_real_escape_string($key) . '"
							, UNIX_TIMESTAMP()
						)';
				$wpdb->query($sql);
			}

			if (sm_post('delete_old_data')) {
				$sql = 'DELETE FROM ' . $table_name . '
						WHERE url ="' . mysql_real_escape_string($key) . '"';
				$wpdb->query($sql);
			}
		}

		sm_display_feedback(__('Page excludes have been updated', 'sm'));
	} else {
		sm_display_error(__('Please select at least one page', 'sm'));
	}
}

function sm_save_excluded_users() {
	global $table_name, $user_excludes_table, $wpdb;

	$block_ip = (int)sm_post('block_ip');
	$robot = (int)sm_post('mark_robot');

	if ($users = sm_post('exclude_users')) {
		foreach ($users as $session_id=>$id) {
			$user_id = sm_get_user_by_session($session_id);

			$sql = 'SELECT COUNT(id)
					FROM ' . $user_excludes_table . '
					WHERE
						session_id = "' . mysql_real_escape_string($session_id) . '" ';
			if ($user_id) {
				$sql .= ' OR user_id = ' . $user_id;
			}

			if (!$wpdb->get_var($sql)) {
				$ip = 0;

				$sql = 'SELECT user_agent, ip_address
						FROM ' . $table_name . '
						WHERE id = ' . $id;
				$row = $wpdb->get_row($sql);

				if ($block_ip) {
					$ip = $row->ip_address;
				}

				$sql = 'INSERT INTO ' . $user_excludes_table . ' (
							session_id
							, ip_address
							, user_agent
							, robot
							, user_id
							, unixtime
						)
						VALUES (
							"' . mysql_real_escape_string($session_id) . '"
							, "' . $ip . '"
							, "' . $row->user_agent . '"
							, ' . $robot . '
							, ' . $user_id . '
							, UNIX_TIMESTAMP()
						)';
				$wpdb->query($sql);
			}

			if (sm_post('delete_old_data')) {
				$sql = 'DELETE FROM ' . $table_name . '
						WHERE
							session_id ="' . mysql_real_escape_string($session_id) . '" ';
				if ($user_id) {
					$sql .= 'OR user_id = ' . $user_id;
				}

				$wpdb->query($sql);
			}
		}

		sm_display_feedback(__('User excludes have been updated', 'sm'));
	} else {
		sm_display_error(__('Please select at least one user', 'sm'));
	}
}

function sm_delete_pagedata() {
	global $wpdb, $table_name;

	if ($pages = sm_post('exclude_pages')) {
		foreach ($pages as $key=>$value) {
			$sql = 'DELETE FROM ' . $table_name . '
					WHERE url ="' . mysql_real_escape_string($key) . '"';
			$wpdb->query($sql);
		}

		sm_display_feedback(__('Page data has been deleted', 'sm'));
	} else {
		sm_display_error(__('Please select at least one page', 'sm'));
	}
}

function sm_delete_userdata() {
	global $wpdb, $table_name;

	if ($users = sm_post('exclude_users')) {
		foreach ($users as $session_id=>$user_id) {
			$sql = 'DELETE FROM ' . $table_name . '
					WHERE
						session_id ="' . mysql_real_escape_string($session_id) . '" ';
			if ($user_id) {
				$sql .= 'OR user_id = ' . $user_id;
			}

			$wpdb->query($sql);
		}

		sm_display_feedback(__('User data has been deleted', 'sm'));
	} else {
		sm_display_error(__('Please select at least one user', 'sm'));
	}
}

function sm_render_excluded_pages() {
	global $wpdb, $excludes_table;

	$sort = sm_get('sort', 'hits');
	$order = sm_get('order', 'DESC');

	echo '	<form method="POST" name="exclude_filename_form" id="exclude_filename_form">
				<input type="hidden" id="exclude_filename" name="exclude_filename" value="" />
			</form>';

	echo '<script>
	function exclude_file_submit(filename) {
		document.getElementById("exclude_filename").value = filename;
		document.forms["exclude_filename_form"].submit();
	}
	</script>';

	$sql = 'SELECT
				filename
				, unixtime
			FROM ' . $excludes_table . '
			ORDER BY filename';
	$pages = $wpdb->get_results($sql);

	if ($num_results = count($pages)) {
		echo '<table style="width:100%;" cellspacing="0">
				<tr>
					<td style="border-bottom: 1px solid silver; font-weight: bold;">' . __('Filename', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 200px;">' . __('Date Added', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; width: 70px;">&nbsp;</td>
				</tr>';

		foreach ($pages as $page) {
			echo '<tr style="background-color: ' . sm_get_bg() . ';">
					<td><span title="' . $page->filename . '">' . sm_shorten_url($page->filename) . '</span></td>
					<td>' . date('d/m/Y H:i', $page->unixtime) . '</td>
					<td><a onclick="exclude_file_submit(\'' . $page->filename . '\');" style="cursor:pointer;">' . __('Delete', 'sm') . '</a></td>
				</tr>';
		}

		echo '<tr>
				<td colspan="3" style="text-align: right; border-top: 1px solid silver;">' . $num_results . ' ' . __(($num_results == 1 ? 'Page':'Pages'), 'sm') . '</td>
			</tr>';
		echo '</table>';

	} else {
		echo __('There are currently no excluded pages', 'sm');
	}
}

function sm_render_excluded_users() {
	global $wpdb, $user_excludes_table;

	$sort = sm_get('sort', 'hits');
	$order = sm_get('order', 'DESC');

	echo '	<form method="POST" name="exclude_user_form" id="exclude_user_form">
				<input type="hidden" id="exclude_session" name="exclude_session" value="" />
			</form>';


	echo '<script>
	function exclude_user_submit(session_id) {
		document.getElementById("exclude_session").value = session_id;
		document.forms["exclude_user_form"].submit();
	}
	</script>';

	$sql = 'SELECT
				session_id
				, user_id
				, unixtime
				, user_agent
				, ip_address
				, robot
			FROM ' . $user_excludes_table . '
			ORDER BY id';
	$users = $wpdb->get_results($sql);

	if ($num_results = count($users)) {
		echo '<table style="width:100%;" cellspacing="0">
				<tr>
					<td style="border-bottom: 1px solid silver; font-weight: bold;">' . __('User', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold;">' . __('IP Address', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold;">' . __('User Agent', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 100px;">' . __('Robot?', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; font-weight: bold; width: 200px;">' . __('Date Added', 'sm') . '</td>
					<td style="border-bottom: 1px solid silver; width: 70px;">&nbsp;</td>
				</tr>';

		foreach ($users as $user) {
			echo '<tr style="background-color: ' . sm_get_bg() . ';">
					<td>' . sm_real_name($user->session_id, $user->user_id) . '</td>
					<td>' . $user->ip_address . '</td>
					<td>' . sm_shorten_string($user->user_agent) . '</td>
					<td>' . ($user->robot ? '<span style="font-weight: bold; color: green;">' . __('Yes', 'sm') . '</span>':'<span style="font-weight: bold; color: red;">' . __('No', 'sm') . '</span>') . '</td>
					<td>' . date('d/m/Y H:i', $user->unixtime) . '</td>
					<td><a onclick="exclude_user_submit(\'' . $user->session_id . '\');" style="cursor:pointer;">' . __('Delete', 'sm') . '</a></td>
				</tr>';
		}

		echo '<tr>
				<td colspan="6" style="text-align: right; border-top: 1px solid silver;">' . $num_results . ' ' . __(($num_results == 1 ? 'User':'Users'), 'sm') . '</td>
			</tr>';
		echo '</table>';

	} else {
		echo __('There are currently no excluded users', 'sm');
	}
}

function sm_get_num_hits() {
	global $wpdb, $table_name;

	$sql = 'SELECT COUNT(id)
			FROM ' . $table_name;
	return $wpdb->get_var($sql);
}

function sm_get_hit_dates() {
	global $wpdb, $table_name;

	$sql = 'SELECT MIN(unixtime) AS start_date, MAX(unixtime) AS end_date
			FROM ' . $table_name;
	return $wpdb->get_row($sql);
}

function sm_exclude_filename($filename) {
	global $wpdb, $excludes_table;

	$sql = 'DELETE FROM ' . $excludes_table . '
			WHERE filename = "' . $filename . '"';
	if ($wpdb->query($sql)) {
		sm_display_feedback(sm_shorten_url($filename) . __(' has been successfully removed from the excludes list', 'sm'));
	}
}

function sm_exclude_user($session_id) {
	global $wpdb, $user_excludes_table;

	$user_id = false;
	$sql = 'DELETE FROM ' . $user_excludes_table . '
			WHERE session_id = "' . $session_id . '" ';

	if ($user_id = sm_get_user_by_session($session_id)) {
		$sql .= 'OR user_id = ' . $user_id;
	}

	$user = sm_real_name($session_id, $user_id);

	if ($wpdb->query($sql)) {
		sm_display_feedback($user . __(' has been successfully removed from the excludes list', 'sm'));
	}
}

function sm_get_top_pages($limit=5) {
	return sm_get_pages('hits', 'DESC', $limit);
}

function sm_get_top_users($limit=5) {
	return sm_get_sessions('num_pages', 'DESC', $limit);
}

function sm_get_pages($sort, $order, $limit=false) {
	global $wpdb, $table_name, $user_excludes_table;

	$sm_settings = get_option('sm_settings');
	$filter = sm_get('filter');

	$sql = 'SELECT
				COUNT(t1.id) AS hits
				, t1.url
			FROM
				' . $table_name . ' t1
				' . (!$sm_settings->view_robot_hits ? ' LEFT JOIN ' . $user_excludes_table . ' t2 ON (t1.ip_address = t2.ip_address)':'') . '
			WHERE 1 ' . ($filter ? 'AND url LIKE "%' . $filter . '%"':'') . (!$sm_settings->view_robot_hits ? ' AND t2.id IS NULL ':'') . '
			GROUP BY t1.url
			ORDER BY ' . $sort . ' ' . $order;
	if ($limit) {
		$sql .= ' LIMIT ' . $limit;
	}
	return $wpdb->get_results($sql);
}

?>
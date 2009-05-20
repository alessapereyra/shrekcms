CREATE TABLE IF NOT EXISTS `session_manager` (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id integer NOT NULL,
	session_id varchar(254) NOT NULL,
	url text NOT NULL,
	ip_address varchar(18) NOT NULL,
	user_agent varchar(255) NOT NULL,
	unixtime integer
);

CREATE TABLE IF NOT EXISTS `session_manager_page_exclude` (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	filename varchar(255) NOT NULL,
	unixtime integer
);

CREATE TABLE IF NOT EXISTS `session_manager_user_exclude` (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	session_id varchar(255),
	user_id integer,
	ip_address varchar(20) NOT NULL,
	user_agent varchar(255),
	robot integer NOT NULL,
	unixtime integer
);
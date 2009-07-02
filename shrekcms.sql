-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-05-2009 a las 20:32:49
-- Versión del servidor: 5.0.67
-- Versión de PHP: 5.2.6-2ubuntu4.2

SET FOREIGN_KEY_CHECKS=0;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `shrek`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
CREATE TABLE IF NOT EXISTS `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL auto_increment,
  `comment_post_ID` int(11) NOT NULL default '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL default '',
  `comment_author_url` varchar(200) NOT NULL default '',
  `comment_author_IP` varchar(100) NOT NULL default '',
  `comment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL default '0',
  `comment_approved` varchar(20) NOT NULL default '1',
  `comment_agent` varchar(255) NOT NULL default '',
  `comment_type` varchar(20) NOT NULL default '',
  `comment_parent` bigint(20) NOT NULL default '0',
  `user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`comment_ID`),
  KEY `comment_approved` (`comment_approved`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`)
) TYPE=MyISAM  AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Mr WordPress', '', 'http://wordpress.org/', '', '2009-05-08 21:02:49', '2009-05-09 02:02:49', 'Hi, this is a comment.<br />To delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.', 0, '1', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_countries`
--

DROP TABLE IF EXISTS `wp_countries`;
CREATE TABLE IF NOT EXISTS `wp_countries` (
  `country_id` int(11) NOT NULL auto_increment,
  `country` varchar(50) NOT NULL,
  `code` varchar(3) NOT NULL,
  PRIMARY KEY  (`country_id`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `wp_countries`
--

INSERT INTO `wp_countries` (`country_id`, `country`, `code`) VALUES
(1, 'Argentina', 'ARG'),
(2, 'Perú', 'PER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_states`
--

DROP TABLE IF EXISTS `wp_states`;
CREATE TABLE IF NOT EXISTS `wp_states` (
  `state_id` int(11) NOT NULL auto_increment,
  `state` varchar(50) NOT NULL,
  PRIMARY KEY  (`state_id`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `wp_states`
--

INSERT INTO `wp_states` (`state_id`, `state`) VALUES
(1, 'departamento 1'),
(2, 'departamento 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_distrits`
--

DROP TABLE IF EXISTS `wp_news_headers`;
CREATE TABLE IF NOT EXISTS `wp_news_headers` (
  `id` int(11) NOT NULL auto_increment,
  `header_type` varchar(50) NULL,
  `header_source` varchar(50) NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `wp_news_headers` (`id`, `header_type`, `header_source`) VALUES
(1, 'featured',''),
(2, 'most_voted',''),
(3, 'most_commented',''),
(4, 'special_blogs',''),
(5, 'random_blog','');


DROP TABLE IF EXISTS `wp_distrits`;
CREATE TABLE IF NOT EXISTS `wp_distrits` (
  `district_id` int(11) NOT NULL auto_increment,
  `distrit` varchar(50) NOT NULL,
  PRIMARY KEY  (`district_id`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `wp_distrits`
--

INSERT INTO `wp_distrits` (`district_id`, `distrit`) VALUES
(1, 'distrito 1'),
(2, 'distrito 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
CREATE TABLE IF NOT EXISTS `wp_links` (
  `link_id` bigint(20) NOT NULL auto_increment,
  `link_url` varchar(255) NOT NULL default '',
  `link_name` varchar(255) NOT NULL default '',
  `link_image` varchar(255) NOT NULL default '',
  `link_target` varchar(25) NOT NULL default '',
  `link_category` bigint(20) NOT NULL default '0',
  `link_description` varchar(255) NOT NULL default '',
  `link_visible` varchar(20) NOT NULL default 'Y',
  `link_owner` int(11) NOT NULL default '1',
  `link_rating` int(11) NOT NULL default '0',
  `link_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL default '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`link_id`),
  KEY `link_category` (`link_category`),
  KEY `link_visible` (`link_visible`)
) TYPE=MyISAM  AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `wp_links`
--

INSERT INTO `wp_links` (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_category`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_rel`, `link_notes`, `link_rss`) VALUES
(1, 'http://codex.wordpress.org/', 'Documentation', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', ''),
(2, 'http://wordpress.org/development/', 'Development Blog', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', 'http://wordpress.org/development/feed/'),
(3, 'http://wordpress.org/extend/ideas/', 'Suggest Ideas', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', ''),
(4, 'http://wordpress.org/support/', 'Support Forum', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', ''),
(5, 'http://wordpress.org/extend/plugins/', 'Plugins', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', ''),
(6, 'http://wordpress.org/extend/themes/', 'Themes', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', ''),
(7, 'http://planet.wordpress.org/', 'WordPress Planet', '', '', 0, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
CREATE TABLE IF NOT EXISTS `wp_options` (
  `option_id` bigint(20) NOT NULL auto_increment,
  `blog_id` int(11) NOT NULL default '0',
  `option_name` varchar(64) NOT NULL default '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL default 'yes',
  PRIMARY KEY  (`option_id`,`blog_id`,`option_name`),
  KEY `option_name` (`option_name`)
) TYPE=MyISAM  AUTO_INCREMENT=116 ;

--
-- Volcar la base de datos para la tabla `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `blog_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 0, 'siteurl', 'http://grimlock/shrekcms/wp', 'yes'),
(2, 0, 'blogname', 'La mula', 'yes'),
(3, 0, 'blogdescription', 'Just another WordPress weblog', 'yes'),
(4, 0, 'users_can_register', '0', 'yes'),
(5, 0, 'admin_email', 'algo@gmail.com', 'yes'),
(6, 0, 'start_of_week', '1', 'yes'),
(7, 0, 'use_balanceTags', '0', 'yes'),
(8, 0, 'use_smilies', '1', 'yes'),
(9, 0, 'require_name_email', '1', 'yes'),
(10, 0, 'comments_notify', '1', 'yes'),
(11, 0, 'posts_per_rss', '10', 'yes'),
(12, 0, 'rss_excerpt_length', '50', 'yes'),
(13, 0, 'rss_use_excerpt', '0', 'yes'),
(14, 0, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 0, 'mailserver_login', 'login@example.com', 'yes'),
(16, 0, 'mailserver_pass', 'password', 'yes'),
(17, 0, 'mailserver_port', '110', 'yes'),
(18, 0, 'default_category', '1', 'yes'),
(19, 0, 'default_comment_status', 'open', 'yes'),
(20, 0, 'default_ping_status', 'open', 'yes'),
(21, 0, 'default_pingback_flag', '0', 'yes'),
(22, 0, 'default_post_edit_rows', '10', 'yes'),
(23, 0, 'posts_per_page', '10', 'yes'),
(24, 0, 'what_to_show', 'posts', 'yes'),
(25, 0, 'date_format', 'F j, Y', 'yes'),
(26, 0, 'time_format', 'g:i a', 'yes'),
(27, 0, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(28, 0, 'links_recently_updated_prepend', '<em>', 'yes'),
(29, 0, 'links_recently_updated_append', '</em>', 'yes'),
(30, 0, 'links_recently_updated_time', '120', 'yes'),
(31, 0, 'comment_moderation', '0', 'yes'),
(32, 0, 'moderation_notify', '1', 'yes'),
(33, 0, 'permalink_structure', '', 'yes'),
(34, 0, 'gzipcompression', '0', 'yes'),
(35, 0, 'hack_file', '0', 'yes'),
(36, 0, 'blog_charset', 'UTF-8', 'yes'),
(37, 0, 'moderation_keys', '', 'no'),
(38, 0, 'active_plugins', '', 'yes'),
(39, 0, 'home', 'http://grimlock/shrekcms/wp', 'yes'),
(40, 0, 'category_base', '', 'yes'),
(41, 0, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(42, 0, 'advanced_edit', '0', 'yes'),
(43, 0, 'comment_max_links', '2', 'yes'),
(44, 0, 'gmt_offset', '-5', 'yes'),
(45, 0, 'default_email_category', '1', 'yes'),
(46, 0, 'recently_edited', '', 'no'),
(47, 0, 'use_linksupdate', '0', 'yes'),
(48, 0, 'template', 'default', 'yes'),
(49, 0, 'stylesheet', 'default', 'yes'),
(50, 0, 'comment_whitelist', '1', 'yes'),
(51, 0, 'page_uris', '', 'yes'),
(52, 0, 'blacklist_keys', '', 'no'),
(53, 0, 'comment_registration', '0', 'yes'),
(54, 0, 'rss_language', 'en', 'yes'),
(55, 0, 'html_type', 'text/html', 'yes'),
(56, 0, 'use_trackback', '0', 'yes'),
(57, 0, 'default_role', 'subscriber', 'yes'),
(58, 0, 'db_version', '9872', 'yes'),
(59, 0, 'uploads_use_yearmonth_folders', '1', 'yes'),
(60, 0, 'upload_path', '/var/www/shrekcms/wp/wp-content/uploads', 'yes'),
(61, 0, 'random_seed', '9044983101882e1308510de209cb4d1c', 'yes'),
(62, 0, 'secret', 'JriyeoY1h7w)OxtW9vEEbJJstKwALvN!N5AoJtqb#6n)!9XaWnuENAKVdJEIEZ!t', 'yes'),
(63, 0, 'blog_public', '0', 'yes'),
(64, 0, 'default_link_category', '2', 'yes'),
(65, 0, 'show_on_front', 'posts', 'yes'),
(66, 0, 'tag_base', '', 'yes'),
(67, 0, 'show_avatars', '1', 'yes'),
(68, 0, 'avatar_rating', 'G', 'yes'),
(69, 0, 'upload_url_path', '', 'yes'),
(70, 0, 'thumbnail_size_w', '150', 'yes'),
(71, 0, 'thumbnail_size_h', '150', 'yes'),
(72, 0, 'thumbnail_crop', '1', 'yes'),
(73, 0, 'medium_size_w', '300', 'yes'),
(74, 0, 'medium_size_h', '300', 'yes'),
(75, 0, 'avatar_default', 'mystery', 'yes'),
(76, 0, 'enable_app', '0', 'yes'),
(77, 0, 'enable_xmlrpc', '0', 'yes'),
(78, 0, 'large_size_w', '1024', 'yes'),
(79, 0, 'large_size_h', '1024', 'yes'),
(80, 0, 'image_default_link_type', 'file', 'yes'),
(81, 0, 'image_default_size', '', 'yes'),
(82, 0, 'image_default_align', '', 'yes'),
(83, 0, 'close_comments_for_old_posts', '0', 'yes'),
(84, 0, 'close_comments_days_old', '14', 'yes'),
(85, 0, 'thread_comments', '0', 'yes'),
(86, 0, 'thread_comments_depth', '5', 'yes'),
(87, 0, 'page_comments', '1', 'yes'),
(88, 0, 'comments_per_page', '50', 'yes'),
(89, 0, 'default_comments_page', 'newest', 'yes'),
(90, 0, 'comment_order', 'asc', 'yes'),
(91, 0, 'use_ssl', '0', 'yes'),
(92, 0, 'sticky_posts', 'a:0:{}', 'yes'),
(93, 0, 'widget_categories', 'a:0:{}', 'yes'),
(94, 0, 'widget_text', 'a:0:{}', 'yes'),
(95, 0, 'widget_rss', 'a:0:{}', 'yes'),
(96, 0, 'update_core', 'O:8:"stdClass":1:{s:12:"last_checked";i:1242091964;}', 'yes'),
(97, 0, 'dismissed_update_core', 'a:0:{}', 'yes'),
(98, 0, 'wp_user_roles', 'a:5:{s:13:"administrator";a:2:{s:4:"name";s:23:"Administrator|User role";s:12:"capabilities";a:53:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;}}s:6:"editor";a:2:{s:4:"name";s:16:"Editor|User role";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:16:"Author|User role";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:21:"Contributor|User role";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:20:"Subscriber|User role";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}}', 'yes'),
(99, 0, 'cron', 'a:2:{i:1242093775;a:2:{s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}s:7:"version";i:2;}', 'yes'),
(100, 0, 'logged_in_salt', 'XPHOz0R0BvO)', 'yes'),
(101, 0, 'auth_salt', '9N5F$aqo7wm2', 'yes'),
(102, 0, 'doing_cron', '0', 'yes'),
(103, 0, 'update_plugins', 'O:8:"stdClass":1:{s:12:"last_checked";i:1242053987;}', 'yes'),
(105, 0, 'dashboard_widget_options', 'a:3:{s:24:"dashboard_incoming_links";a:5:{s:4:"home";s:33:"http://localhost:8888/shrekcms/wp";s:4:"link";s:115:"http://blogsearch.google.com/blogsearch?hl=en&scoring=d&partner=wordpress&q=link:http://localhost:8888/shrekcms/wp/";s:3:"url";s:148:"http://blogsearch.google.com/blogsearch_feeds?hl=en&scoring=d&ie=utf-8&num=10&output=rss&partner=wordpress&q=link:http://localhost:8888/shrekcms/wp/";s:5:"items";i:10;s:9:"show_date";b:0;}s:17:"dashboard_primary";a:7:{s:4:"link";s:33:"http://wordpress.org/development/";s:3:"url";s:38:"http://wordpress.org/development/feed/";s:5:"title";s:26:"WordPress Development Blog";s:5:"items";i:2;s:12:"show_summary";i:1;s:11:"show_author";i:0;s:9:"show_date";i:1;}s:19:"dashboard_secondary";a:4:{s:4:"link";s:28:"http://planet.wordpress.org/";s:3:"url";s:33:"http://planet.wordpress.org/feed/";s:5:"title";s:20:"Other WordPress News";s:5:"items";i:5;}}', 'yes'),
(104, 0, 'update_themes', 'O:8:"stdClass":1:{s:12:"last_checked";i:1242053987;}', 'yes'),
(106, 0, 'nonce_salt', 'W@LD5(m5w6uW', 'yes'),
(107, 0, 'current_theme', 'WordPress Default', 'yes'),
(108, 0, 'sidebars_widgets', 'a:1:{s:13:"array_version";i:3;}', 'yes'),
(111, 0, 'upload_url', 'http://grimlock/shrekcms/wp/wp-content/upload', 'yes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
CREATE TABLE IF NOT EXISTS `wp_postmeta` (
  `meta_id` bigint(20) NOT NULL auto_increment,
  `post_id` bigint(20) NOT NULL default '0',
  `meta_key` varchar(255) default NULL,
  `meta_value` longtext,
  PRIMARY KEY  (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) TYPE=MyISAM  AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 1, '_edit_lock', '1242091963'),
(2, 1, '_edit_last', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
CREATE TABLE IF NOT EXISTS `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `post_author` bigint(20) NOT NULL default '0',
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_category` int(4) NOT NULL default '0',
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL default 'publish',
  `comment_status` varchar(20) NOT NULL default 'open',
  `ping_status` varchar(20) NOT NULL default 'open',
  `post_password` varchar(20) NOT NULL default '',
  `post_name` varchar(200) NOT NULL default '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content_filtered` text NOT NULL,
  `post_parent` bigint(20) NOT NULL default '0',
  `guid` varchar(255) NOT NULL default '',
  `menu_order` int(11) NOT NULL default '0',
  `post_type` varchar(20) NOT NULL default 'post',
  `post_mime_type` varchar(100) NOT NULL default '',
  `comment_count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`)
) TYPE=MyISAM  AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_category`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2009-05-08 21:02:49', '2009-05-09 02:02:49', 'Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!', 'Hello world!', 0, '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2009-05-11 20:32:42', '2009-05-12 01:32:42', '', 0, 'http://localhost:8888/shrekcms/wp/?p=1', 0, 'post', '', 1),
(2, 1, '2009-05-08 21:02:49', '2009-05-09 02:02:49', 'This is an example of a WordPress page, you could edit this to put information about yourself or your site so readers know where you are coming from. You can create as many pages like this one or sub-pages as you like and manage all of your content inside of WordPress.', 'About', 0, '', 'publish', 'open', 'open', '', 'about', '', '', '2009-05-08 21:02:49', '2009-05-09 02:02:49', '', 0, 'http://localhost:8888/shrekcms/wp/?page_id=2', 0, 'page', '', 0),
(3, 1, '2009-05-08 21:02:49', '2009-05-09 02:02:49', 'Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!', 'Hello world!', 0, '', 'inherit', 'open', 'open', '', '1-revision', '', '', '2009-05-08 21:02:49', '2009-05-09 02:02:49', '', 1, 'http://localhost:8888/shrekcms/wp/?p=3', 0, 'revision', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_providences`
--

DROP TABLE IF EXISTS `wp_providences`;
CREATE TABLE IF NOT EXISTS `wp_providences` (
  `providence_id` int(11) NOT NULL auto_increment,
  `providence` varchar(50) NOT NULL,
  PRIMARY KEY  (`providence_id`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `wp_providences`
--

INSERT INTO `wp_providences` (`providence_id`, `providence`) VALUES
(1, 'provincia 1'),
(2, 'provincia 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
CREATE TABLE IF NOT EXISTS `wp_terms` (
  `term_id` bigint(20) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `slug` varchar(200) NOT NULL default '',
  `term_group` bigint(10) NOT NULL default '0',
  PRIMARY KEY  (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) TYPE=MyISAM  AUTO_INCREMENT=12 ;

--
-- Volcar la base de datos para la tabla `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Lo bueno', 'bueno', 0),
(2, 'Blogroll', 'blogroll', 0),
(3, 'Lo malo', 'malo', 0),
(4, 'Lo roca', 'roca', 0),
(5, 'Internas', 'internas', 0),
(6, 'Publicas', 'publicas', 0),
(7, 'Articulos', 'articulos', 0),
(8, 'Fotos', 'fotos', 0),
(9, 'Videos', 'videos', 0),
(10, 'Documentos', 'documentos', 0),
(11, 'Audio', 'audio', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
CREATE TABLE IF NOT EXISTS `wp_term_relationships` (
  `object_id` bigint(20) NOT NULL default '0',
  `term_taxonomy_id` bigint(20) NOT NULL default '0',
  `term_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) TYPE=MyISAM;

--
-- Volcar la base de datos para la tabla `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 2, 0),
(2, 2, 0),
(3, 2, 0),
(4, 2, 0),
(5, 2, 0),
(6, 2, 0),
(7, 2, 0),
(3, 1, 0),
(1, 7, 0),
(1, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
CREATE TABLE IF NOT EXISTS `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) NOT NULL auto_increment,
  `term_id` bigint(20) NOT NULL default '0',
  `taxonomy` varchar(32) NOT NULL default '',
  `description` longtext NOT NULL,
  `parent` bigint(20) NOT NULL default '0',
  `count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`)
) TYPE=MyISAM  AUTO_INCREMENT=12 ;

--
-- Volcar la base de datos para la tabla `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 6, 0),
(2, 2, 'link_category', '', 0, 7),
(3, 3, 'category', '', 6, 1),
(4, 4, 'category', '', 6, 0),
(5, 5, 'category', '', 0, 0),
(6, 6, 'category', '', 0, 0),
(7, 7, 'category', '', 5, 1),
(8, 8, 'category', '', 5, 0),
(9, 9, 'category', '', 5, 0),
(10, 10, 'category', '', 5, 0),
(11, 11, 'category', '', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE IF NOT EXISTS `wp_usermeta` (
  `umeta_id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL default '0',
  `meta_key` varchar(255) default NULL,
  `meta_value` longtext,
  PRIMARY KEY  (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) TYPE=MyISAM  AUTO_INCREMENT=15 ;

--
-- Volcar la base de datos para la tabla `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'admin'),
(2, 1, 'rich_editing', 'true'),
(3, 1, 'comment_shortcuts', 'false'),
(4, 1, 'admin_color', 'fresh'),
(5, 1, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
(6, 1, 'wp_user_level', '10'),
(7, 1, 'wp_usersettings', 'm0=o&m1=o&m2=c&m3=c&m4=c&m5=c&m6=o&m7=c&m8=o&imgsize=medium&urlbutton=urlfile&align=center&editor=html'),
(8, 1, 'wp_usersettingstime', '1242091334'),
(9, 2, 'nickname', 'yaraher'),
(10, 2, 'rich_editing', 'true'),
(11, 2, 'comment_shortcuts', 'false'),
(12, 2, 'admin_color', 'fresh'),
(13, 2, 'wp_capabilities', 'a:1:{s:11:"contributor";b:1;}'),
(14, 2, 'wp_user_level', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE IF NOT EXISTS `wp_users` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `user_login` varchar(60) NOT NULL default '',
  `user_pass` varchar(64) NOT NULL default '',
  `user_nicename` varchar(50) NOT NULL default '',
  `user_email` varchar(100) NOT NULL default '',
  `user_url` varchar(100) NOT NULL default '',
  `user_registered` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL default '',
  `user_status` int(11) NOT NULL default '0',
  `display_name` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$BaRZI1tb4.JC7vartw90O2.vmajVxT.', 'admin', 'algo@gmail.com', 'http://', '2009-05-09 02:02:49', '', 0, 'admin'),
(2, 'yaraher', '$P$BGQqsexhFMsvMTRvEdmDLm0DJoCjCZ/', 'yaraher', 'algo@gmail.com', 'http://', '2009-05-09 02:04:00', '', 0, 'yaraher');

SET FOREIGN_KEY_CHECKS=1;

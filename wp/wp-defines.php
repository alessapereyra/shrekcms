<?php
//esto debe estar asi de feo T_T
$siteurl = 'http://localhost/shrekcms/wp';
$home = 'http://localhost/shrekcms/wp';

if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', $siteurl . '/wp-content'); // full url - WP_CONTENT_DIR is defined further up


/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down
	
/**
 * Allows for the plugins directory to be moved from the default location.
 *
 * @since 2.6.0
 */
if ( !defined('WP_PLUGIN_DIR') )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' ); // full path, no trailing slash

/**
 * Allows for the plugins directory to be moved from the default location.
 *
 * @since 2.6.0
 */
if ( !defined('WP_PLUGIN_URL') )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' ); // full url, no trailing slash

/**
 * Allows for the plugins directory to be moved from the default location.
 *
 * @since 2.1.0
 */
if ( !defined('PLUGINDIR') )
	define( 'PLUGINDIR', 'wp-content/plugins' ); // Relative to ABSPATH.  For back compat.

/**
 * Used to guarantee unique hash cookies
 * @since 1.5
 */
define('COOKIEHASH', md5($siteurl));

/**
 * Should be exactly the same as the default value of SECRET_KEY in wp-config-sample.php
 * @since 2.5.0
 */
$wp_default_secret_key = 'put your unique phrase here';

/**
 * It is possible to define this in wp-config.php
 * @since 2.0.0
 */
if ( !defined('USER_COOKIE') )
	define('USER_COOKIE', 'wordpressuser_' . COOKIEHASH);

/**
 * It is possible to define this in wp-config.php
 * @since 2.0.0
 */
if ( !defined('PASS_COOKIE') )
	define('PASS_COOKIE', 'wordpresspass_' . COOKIEHASH);

/**
 * It is possible to define this in wp-config.php
 * @since 2.5.0
 */
if ( !defined('AUTH_COOKIE') )
	define('AUTH_COOKIE', 'wordpress_' . COOKIEHASH);

/**
 * It is possible to define this in wp-config.php
 * @since 2.6.0
 */
if ( !defined('SECURE_AUTH_COOKIE') )
	define('SECURE_AUTH_COOKIE', 'wordpress_sec_' . COOKIEHASH);

/**
 * It is possible to define this in wp-config.php
 * @since 2.6.0
 */
if ( !defined('LOGGED_IN_COOKIE') )
	define('LOGGED_IN_COOKIE', 'wordpress_logged_in_' . COOKIEHASH);

/**
 * It is possible to define this in wp-config.php
 * @since 2.3.0
 */
if ( !defined('TEST_COOKIE') )
	define('TEST_COOKIE', 'wordpress_test_cookie');

/**
 * It is possible to define this in wp-config.php
 * @since 1.2.0
 */
if ( !defined('COOKIEPATH') )
	define('COOKIEPATH', preg_replace('|https?://[^/]+|i', '', $home . '/' ) );

/**
 * It is possible to define this in wp-config.php
 * @since 1.5.0
 */
if ( !defined('SITECOOKIEPATH') )
	define('SITECOOKIEPATH', preg_replace('|https?://[^/]+|i', '', $siteurl . '/' ) );

/**
 * It is possible to define this in wp-config.php
 * @since 2.6.0
 */
if ( !defined('ADMIN_COOKIE_PATH') )
	define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'wp-admin' );

/**
 * It is possible to define this in wp-config.php
 * @since 2.6.0
 */
if ( !defined('PLUGINS_COOKIE_PATH') )
	define( 'PLUGINS_COOKIE_PATH', preg_replace('|https?://[^/]+|i', '', WP_PLUGIN_URL)  );

/**
 * It is possible to define this in wp-config.php
 * @since 2.0.0
 */
if ( !defined('COOKIE_DOMAIN') )
	define('COOKIE_DOMAIN', false);

/**
 * It is possible to define this in wp-config.php
 * @since 2.5.0
 */
if ( !defined( 'AUTOSAVE_INTERVAL' ) )
	define( 'AUTOSAVE_INTERVAL', 60 );
?>
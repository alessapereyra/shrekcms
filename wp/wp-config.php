<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lamula');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */

// Para Dientuki
 define('DB_PASSWORD', '');
//define('DB_PASSWORD', 'JuhO&87$');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

//$table_prefix  = 'mulapress_';

/** Eliminar esto si comete problemas  */
//define('WP_HOME', 'http://localhost:8888/shrekcms/wp'); 

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */

define('AUTH_KEY', 'bc6444c2f1a3cad20dd04f37bec6159b656c6f3466e0df7373706a6a1077763f'); // Change this to a unique phrase.
define('SECURE_AUTH_KEY', '7edb189add73c42b2c8455edbf4474d2a67e519915524a2fb3b8ba52cf5fed7a'); // Change this to a unique phrase.
define('SECURE_AUTH_SALT', 'ae0afe50d81accebe53dc4cdcc8f5c5335480dc10e35093a5e37b7e45a1a3a06'); // Change this to a unique phrase.
define('LOGGED_IN_KEY', 'f5583b3124c7957a74d9cb519fa68adb8b23c398374be7bfd3032066985c5009'); // Change this to a unique phrase.
define('SECRET_KEY', 'e4e8d80cd9ab504c7541fa7bbb009fb54b36889a1938e3a83c91fb4e54ba267f'); // Change these to unique phrases.
define('SECRET_SALT', '253daac1e17844679af0ff8f730413bd35bbe96860ae203fdb42146bc1e987f6');
define('LOGGED_IN_SALT', '9d25725981a7ef0de0f94396d770fbe6a2eff7f7f1ca4b2fc8845dbf6a6d8086');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mulapress_';

define('CUSTOM_CAPABILITIES_PREFIX', 'wp_1_');
define('CUSTOM_USER_TABLE', 'wp_users');
define('CUSTOM_USER_META_TABLE', 'wp_usermeta');

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

//hcisneros : solicitara para la version wp-mu 2.7.1
define( 'NONCE_KEY', 'Wxm4k1DY4wFFXo2Y68gbOGhI' );
define( 'AUTH_SALT', '%kOO#HQq6Tu)5NN61jAMF0mP' );
/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
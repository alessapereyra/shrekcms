<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Libreria para las cookies de wp
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Libreria para las cookies de wp
 *
 *
 * @package		mulapress
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Wpcookies
{
	/**
	 * Constructor de la case
	 */  	
	function __construct()
	{			
		include('../../wp-includes/plugin.php');	
	}
	
/**
 * Get salt to add to hashes to help prevent attacks.
 *
 * The secret key is located in two places: the database in case the secret key
 * isn't defined in the second place, which is in the wp-config.php file. If you
 * are going to set the secret key, then you must do so in the wp-config.php
 * file.
 *
 * The secret key in the database is randomly generated and will be appended to
 * the secret key that is in wp-config.php file in some instances. It is
 * important to have the secret key defined or changed in wp-config.php.
 *
 * If you have installed WordPress 2.5 or later, then you will have the
 * SECRET_KEY defined in the wp-config.php already. You will want to change the
 * value in it because hackers will know what it is. If you have upgraded to
 * WordPress 2.5 or later version from a version before WordPress 2.5, then you
 * should add the constant to your wp-config.php file.
 *
 * Below is an example of how the SECRET_KEY constant is defined with a value.
 * You must not copy the below example and paste into your wp-config.php. If you
 * need an example, then you can have a
 * {@link https://api.wordpress.org/secret-key/1.1/ secret key created} for you.
 *
 * <code>
 * define('SECRET_KEY', 'mAry1HadA15|\/|b17w55w1t3asSn09w');
 * </code>
 *
 * Salting passwords helps against tools which has stored hashed values of
 * common dictionary strings. The added values makes it harder to crack if given
 * salt string is not weak.
 *
 * @since 2.5
 * @link https://api.wordpress.org/secret-key/1.1/ Create a Secret Key for wp-config.php
 *
 * @return string Salt value from either 'SECRET_KEY' or 'secret' option
 */	
	function _wp_salt($scheme = 'auth') {
		$secret_key = '';
		$salt = '1KxWxg$7mw$I';

		return apply_filters('salt', $secret_key . $salt, $scheme);
	}	

/**
 * Get hash of given string.
 *
 * @since 2.0.4
 * @uses wp_salt() Get WordPress salt
 *
 * @param string $data Plain text to hash
 * @return string Hash of $data
 */		
	function _wp_hash($data, $scheme = 'auth') {
		$salt = $this->_wp_salt($scheme);
	
		return hash_hmac('md5', $data, $salt);
	}	
	
/**
 * Generate authentication cookie contents.
 *
 * @since 2.5
 * @uses apply_filters() Calls 'auth_cookie' hook on $cookie contents, User ID
 *		and expiration of cookie.
 *
 * @param int $user_id User ID
 * @param int $expiration Cookie expiration in seconds
 * @param string $scheme Optional. The cookie scheme to use: auth, secure_auth, or logged_in
 * @return string Authentication cookie contents
 */	
	function _wp_generate_auth_cookie($user_login, $expiration, $scheme = 'auth', $user_id) {
		
		$key = $this->_wp_hash($user_login . '|' . $expiration, $scheme);
		$hash = hash_hmac('md5', $user_login . '|' . $expiration, $key);
	
		$cookie = $user_login . '|' . $expiration . '|' . $hash;
	
		return apply_filters('auth_cookie', $cookie, $user_id, $expiration, $scheme);
	}
		
/**
 * Sets the authentication cookies based User ID.
 *
 * The $remember parameter increases the time that the cookie will be kept. The
 * default the cookie is kept without remembering is two days. When $remember is
 * set, the cookies will be kept for 14 days or two weeks.
 *
 * @since 2.5
 *
 * @param integer $user_id User ID
 * @param string $user_login 
 */
	function set($user_id, $user_login)
	{

		$remember = false;
		$secure = FALSE;
		$scheme = 'auth';
		$ci_siteurl = 'http://lamula.pe';
		define('AUTH_COOKIE', 'wordpress_');
		define( 'WP_CONTENT_URL', $ci_siteurl . '/wp-content');
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );
		define( 'PLUGINS_COOKIE_PATH', '/' );
		define('COOKIE_DOMAIN', '.lamula');
		define('SITECOOKIEPATH', '/' );
		define( 'ADMIN_COOKIE_PATH', '/wp-admin' );
		define('LOGGED_IN_COOKIE', 'wordpress_logged_in_');
		define('COOKIEPATH', '/' );
		$auth_cookie_name = AUTH_COOKIE;	
		
		if ( $remember == TRUE )
		{
			$expiration = $expire = time() + 1209600;
		} else {
			$expiration = time() + 172800;
			$expire = 0;
		}
		
		$auth_cookie = $this->_wp_generate_auth_cookie($user_login, $expiration, $scheme, $user_id);
		$logged_in_cookie = $this->_wp_generate_auth_cookie($user_login, $expiration, 'logged_in', $user_id);
	  		
		do_action('set_auth_cookie', $auth_cookie, $expire, $expiration, $user_id, $scheme);
		do_action('set_logged_in_cookie', $logged_in_cookie, $expire, $expiration, $user_id, 'logged_in');

		// Set httponly if the php version is >= 5.2.0
		if ( version_compare(phpversion(), '5.2.0', 'ge') ) {
			$cookie_domain = COOKIE_DOMAIN;
		} else {
			$cookie_domain = COOKIE_DOMAIN;
			if ( !empty($cookie_domain) )
			{
				$cookie_domain .= '; HttpOnly';
			}
		}
		setcookie($auth_cookie_name, $auth_cookie, $expiration);
		setcookie($auth_cookie_name, $auth_cookie, $expiration);
		setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expiration);
		if ( COOKIEPATH != SITECOOKIEPATH )
			setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expiration);
	}
	
/**
 * Clears the authentication cookie, logging the user out.
 *
 * @since 1.5
 * @deprecated Use wp_clear_auth_cookie()
 * @see wp_clear_auth_cookie()
 */	
	function un_set()
	{
		wp_clearcookie();
	}
}

/* End of file Wpcookies.php */
/* Location: ./system/application/libraries/Wpcookies.php */
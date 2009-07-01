<?php
class Wpcookies
{
	function __construct()
	{		
		//include('../../wp-config.php');
		//include('../../wpmu-settings.php');
		//include('../../wp-includes/cache.php');	
		include('../../wp-includes/plugin.php');
		//include('../../wp-includes/pluggable.php');		
	}
	
	function _wp_salt($scheme = 'auth') {
		$secret_key = '';
		$salt = '1KxWxg$7mw$I';

		return apply_filters('salt', $secret_key . $salt, $scheme);
	}	
	function _wp_hash($data, $scheme = 'auth') {
		$salt = $this->_wp_salt($scheme);
	
		return hash_hmac('md5', $data, $salt);
	}	
	
	function _wp_generate_auth_cookie($user_login, $expiration, $scheme = 'auth', $user_id) {
		
		$key = $this->_wp_hash($user_login . '|' . $expiration, $scheme);
		$hash = hash_hmac('md5', $user_login . '|' . $expiration, $key);
	
		$cookie = $user_login . '|' . $expiration . '|' . $hash;
	
		return apply_filters('auth_cookie', $cookie, $user_id, $expiration, $scheme);
	}
		
	function set($user_id, $user_login)
	{
		//wp_setcookie($user, '', false, '', '' ,false ,$id);
		//variables de wp
		//setcookie('nombre', 'value');
		$remember = false;
		$secure = FALSE;
		$scheme = 'auth';
		$ci_siteurl = 'http://lamula.pe';
		define('AUTH_COOKIE', 'wordpress_');
		define( 'WP_CONTENT_URL', $ci_siteurl . '/wp-content');
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );
		//define( 'PLUGINS_COOKIE_PATH', preg_replace('|https?://[^/]+|i', '', WP_PLUGIN_URL)  );
		define( 'PLUGINS_COOKIE_PATH', '/' );
		define('COOKIE_DOMAIN', '.lamula');
		define('SITECOOKIEPATH', '/' );
		//define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'wp-admin' );
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

		/*
		$key = $this->_wp_hash($user_login . '|' . $expiration, $scheme);
		$hash = hash_hmac('md5', $user_login . '|' . $expiration, $key);
				
		$cookie = $user_login . '|' . $expiration . '|' . $hash;
		
		$auth_cookie = apply_filters('auth_cookie', $cookie, $user_id, $expiration, $scheme);
		$logged_in_cookie = apply_filters('auth_cookie', $cookie, $user_id, $expiration, 'logged_in');
		*/
		
		$auth_cookie = $this->_wp_generate_auth_cookie($user_login, $expiration, $scheme, $user_id);
		$logged_in_cookie = $this->_wp_generate_auth_cookie($user_login, $expiration, 'logged_in', $user_id);
	  		
		do_action('set_auth_cookie', $auth_cookie, $expire, $expiration, $user_id, $scheme);
		do_action('set_logged_in_cookie', $logged_in_cookie, $expire, $expiration, $user_id, 'logged_in');

		// Set httponly if the php version is >= 5.2.0
		if ( version_compare(phpversion(), '5.2.0', 'ge') ) {
			$cookie_domain = COOKIE_DOMAIN;
			/*
			setcookie($auth_cookie_name, $auth_cookie, $expiration, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN, $secure, true);
			setcookie($auth_cookie_name, $auth_cookie, $expiration, ADMIN_COOKIE_PATH, COOKIE_DOMAIN, $secure, true);
			setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expiration, COOKIEPATH, COOKIE_DOMAIN, false, true);
			if ( COOKIEPATH != SITECOOKIEPATH )
				setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expiration, SITECOOKIEPATH, COOKIE_DOMAIN, false, true);
			*/
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
		
		die ('hasta aca');
		/*
		setcookie($auth_cookie_name, $auth_cookie, $expiration, PLUGINS_COOKIE_PATH, $cookie_domain, $secure);
		setcookie($auth_cookie_name, $auth_cookie, $expiration, ADMIN_COOKIE_PATH, $cookie_domain, $secure);
		setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expiration, COOKIEPATH, $cookie_domain);
		if ( COOKIEPATH != SITECOOKIEPATH )
			setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expiration, SITECOOKIEPATH, $cookie_domain);
		*/
		//die('a:' . $auth_cookie_name . ' b:' . $auth_cookie);
		/*
		setcookie($auth_cookie_name.'c', $auth_cookie, $expiration, PLUGINS_COOKIE_PATH);
		die('a:' . $auth_cookie_name . ' b:' . $auth_cookie . ' c:' . $expiration . ' d:' . PLUGINS_COOKIE_PATH . ' e:' . COOKIE_DOMAIN . ' f:' .  $secure);
		*/
	}
	
	function un_set()
	{
		wp_clearcookie();
	}
}
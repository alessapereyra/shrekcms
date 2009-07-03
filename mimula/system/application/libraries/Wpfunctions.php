<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Libreria para algunas funciones de wp
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Libreria para algunas funciones de wp
 *
 *
 * @package		mulapress
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Wpfunctions {
	
/**
 * Serialize data, if needed.
 *
 * @since 2.0.5
 *
 * @param mixed $data Data that might be serialized.
 * @return mixed A scalar data
 */	
	function maybe_serialize($data)
	{
		if ( is_array( $data ) || is_object( $data ) )
			return serialize( $data );
	
		if ( $this->is_serialized( $data ) )
			return serialize( $data );
	
		return $data;		
	}
	
/**
 * Navigates through an array and removes slashes from the values.
 *
 * If an array is passed, the array_map() function causes a callback to pass the
 * value back to the function. The slashes from this value will removed.
 *
 * @since 2.0.0
 *
 * @param array|string $value The array or string to be striped.
 * @return array|string Stripped array (or string in the callback).
 */	
	function stripslashes_deep($value)
	{
		$value = is_array($value) ? array_map($this->stripslashes_deep, $value) : stripslashes($value);
		return $value;		
	}
	
/**
 * Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 *
 * @since 2.0.5
 *
 * @param mixed $data Value to check to see if was serialized.
 * @return bool False if not serialized and true if it was.
 */	
	function is_serialized( $data ) {
		// if it isn't a string, it isn't serialized
		if ( !is_string( $data ) )
			return false;
		$data = trim( $data );
		if ( 'N;' == $data )
			return true;
		if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
			return false;
		switch ( $badions[1] ) {
			case 'a' :
			case 'O' :
			case 's' :
				if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
					return true;
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
					return true;
				break;
		}
		return false;
	}
}

/* End of file Wpfunctions.php */
/* Location: ./system/application/libraries/Wpfunctions.php */
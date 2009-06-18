<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wpshit {
	
	function maybe_serialize($data)
	{
		if ( is_array( $data ) || is_object( $data ) )
			return serialize( $data );
	
		if ( $this->is_serialized( $data ) )
			return serialize( $data );
	
		return $data;		
	}
	
	function stripslashes_deep($value)
	{
		$value = is_array($value) ? array_map($this->stripslashes_deep, $value) : stripslashes($value);
		return $value;		
	}
	
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
?>
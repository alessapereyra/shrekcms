<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador para extender CodeIgniter
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de CodeIgniter
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class CIdip extends Controller {

	/**
	 * Extiende CodeIgniter
	 * @return void 
	 */		
    function CIdip()
    {
        parent::Controller();
    }

	/**
	 * Arma las url amigables
	 * @return void 
	 */	    
    function recover_get_array($query_string = '')
    {
        $query_string = urldecode($query_string);
        
        $_SERVER['QUERY_STRING'] = $query_string;
        $get_array = array();
        parse_str($query_string,$get_array);
        foreach($get_array as $key => $val) {
            $_GET[$key] = $this->input->xss_clean($val);
            $_REQUEST[$key] = $this->input->xss_clean($val);
        }
    }
}
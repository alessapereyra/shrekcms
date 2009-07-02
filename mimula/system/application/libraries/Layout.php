<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Libreria para el layout
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Libreria para el layout
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Layout {
	
	var $CI = NULL;
	var $subidon = NULL;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->subidon = array('fotos', 'documentos', 'articulos','videos','audios');
	}
	
	function active_controller($target)
	{
		if (in_array($this->CI->uri->segment(1), $this->subidon))
		{
	
		    if ($this->CI->uri->segment(1) == $target)
		    {
		    	return "selected";
		    }
		}		
	}
}
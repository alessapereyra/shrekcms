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
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Layout {
	
    /**
     * CodeIgniter
     * @var object
     *
     */		
	var $CI = NULL;
    /**
     * subidon
     * @var array
     *
     */		
	var $subidon = NULL;
	
	/**
	 * Constructor de la case
	 */  	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->subidon = array('fotos', 'documentos', 'articulos','videos','audios');
	}
	
	/**
	 * Agrega selected a un tag
	 * @param string $target controlador actual  
	 * @return string
	 */  	
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

/* End of file Layout.php */
/* Location: ./system/application/libraries/Layout.php */
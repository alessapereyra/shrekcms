<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
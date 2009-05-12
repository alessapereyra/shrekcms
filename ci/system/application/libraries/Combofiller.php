<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Combofiller {
	
	var $CI = NULL;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function countries($empty_row = FALSE)
	{
		$this->CI->load->model('countries');
		return $this->CI->countries->get_fkcombo($empty_row);		
	}

	function departments($empty_row = FALSE)
	{
		$this->CI->load->model('departments');
		return $this->CI->departments->get_fkcombo($empty_row);		
	}

	function distrits($empty_row = FALSE)
	{
		$this->CI->load->model('distrits');
		return $this->CI->distrits->get_fkcombo($empty_row);		
	}	
	
	function providences($empty_row = FALSE)
	{
		$this->CI->load->model('providences');
		return $this->CI->providences->get_fkcombo($empty_row);		
	}

	function categorias()
	{
		$this->CI->load->model('terms');
		return $this->CI->terms->get_categories();	
	}	
	
}
?>
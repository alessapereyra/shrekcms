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

	function districts($district, $empty_row = FALSE)
	{
		$this->CI->load->model('districts');
		return $this->CI->districts->get_fkcombo($district, $empty_row);		
	}	
	
	function provinces($province, $empty_row = FALSE)
	{
		$this->CI->load->model('provinces');
		return $this->CI->provinces->get_fkcombo($province, $empty_row);		
	}

	function categorias()
	{
		$this->CI->load->model('terms');
		return $this->CI->terms->get_categories();	
	}	

	function bloggers($empty_row = FALSE)
	{
		$this->CI->load->model('blogs');
		return $this->CI->blogs->get_fkblogs($empty_row);	
	}
	
	function defaultsblogs($empty_row = FALSE)
	{
		$this->CI->load->model('defaultblogs');
		return $this->CI->defaultblogs->get_fkdefaults($empty_row);	
	}	
	function head_blogs($empty_row = FALSE)
	{
		$this->CI->load->model('blogs');
		return $this->CI->blogs->get_head_blogs($empty_row);	
	}
	
	function removed_head_blogs($empty_row = FALSE)
	{
		$this->CI->load->model('blogs');
		return $this->CI->blogs->get_removed_head_blogs($empty_row);	
	}	
}
?>
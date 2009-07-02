<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Libreria que arma los combosbox
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Libreria que arma los combosbox
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Combofiller {
	
    /**
     * CodeIgniter
     * @var object
     *
     */		
	var $CI = NULL;
	
	/**
	 * Constructor de la case
	 */ 	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	 * Consigue los paices
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function countries($empty_row = FALSE)
	{
		$this->CI->load->model('countries');
		return $this->CI->countries->get_fkcombo($empty_row);		
	}

	/**
	 * Consigue los states
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function states($empty_row = FALSE)
	{
		$this->CI->load->model('states');
		return $this->CI->states->get_fkcombo($empty_row);		
	}

	/**
	 * Consigue los districts
	 * @param integer $district id del distrito
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function districts($district, $empty_row = FALSE)
	{
		$this->CI->load->model('districts');
		return $this->CI->districts->get_fkcombo($district, $empty_row);		
	}	
	
	/**
	 * Consigue las provincias
	 * @param integer $province id de la provincia
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function provinces($province, $empty_row = FALSE)
	{
		$this->CI->load->model('provinces');
		return $this->CI->provinces->get_fkcombo($province, $empty_row);		
	}

	/**
	 * Consigue las categorias
	 * @return array 
	 */  	
	function categorias()
	{
		$this->CI->load->model('terms');
		return $this->CI->terms->get_categories();	
	}	

	/**
	 * Consigue los bloggers
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function bloggers($empty_row = FALSE)
	{
		$this->CI->load->model('blogs');
		return $this->CI->blogs->get_fkblogs($empty_row);	
	}
	
	/**
	 * Consigue los blogs by default
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function defaultsblogs($empty_row = FALSE)
	{
		$this->CI->load->model('defaultblogs');
		return $this->CI->defaultblogs->get_fkdefaults($empty_row);	
	}	

	/**
	 * Consigue los blogs van a portada
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function head_blogs($empty_row = FALSE)
	{
		$this->CI->load->model('blogs');
		return $this->CI->blogs->get_head_blogs($empty_row);	
	}
	
	/**
	 * Consigue los blogs que no van a portada
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */  	
	function removed_head_blogs($empty_row = FALSE)
	{
		$this->CI->load->model('blogs');
		return $this->CI->blogs->get_removed_head_blogs($empty_row);	
	}	
}
?>
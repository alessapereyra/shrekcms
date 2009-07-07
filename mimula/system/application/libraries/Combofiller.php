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
	 * Consigue el id de un departamento
	 * @param string $state departamento
	 * @return integer
	 */  	
	function get_state($state)
	{
		$limit['from'] = 0;
		$limit['show'] = 1;
		
		$this->CI->load->model('states');
		$states = $this->CI->states->seleccionar(array('state' => $state), $limit);
		
		$fila = $states->row();
		
		return $fila->state_id;
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
	 * Consigue el id de un distrito
	 * @param string $district departamento
	 * @return integer
	 */  	
	function get_district($district)
	{
		$limit['from'] = 0;
		$limit['show'] = 1;
		
		$this->CI->load->model('districts');

		$districts = $this->CI->districts->seleccionar(array('district' => $district), $limit);
		
		$fila = $districts->row();
		
		return $fila->district_id;		
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
	 * Consigue el id de un distrito
	 * @param string $district departamento
	 * @return integer
	 */  	
	function get_province($province)
	{
		$limit['from'] = 0;
		$limit['show'] = 1;
		
		$this->CI->load->model('provinces');

		$provinces = $this->CI->provinces->seleccionar(array('province' => $province), $limit);
		
		$fila = $provinces->row();
		
		return $fila->province_id;		
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
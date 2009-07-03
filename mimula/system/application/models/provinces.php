<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de provincias
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de provincias
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Provinces extends Model {
	
    /**
     * Campos de la tabla
     * @var array
     *
     */	
	var $campos = array();
    /**
     * Tabla a utilizar
     * @var array
     *
     */	
    var $tabla = 'mulapress_provinces';

	/**
	 * Constructor de la case
	 */     
    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
	/**
	 * Consigue las provincias de un estado
	 * @param integer $id id del estado
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */     
    function get_fkcombo($id, $empty_row = FALSE)
    {
    	$this->load->database();
    	$this->db->select('province_id');
    	$this->db->select('province');
    	$this->db->from($this->tabla);
    	$this->db->where(array('fk_state' => $id));
    	$this->db->order_by("province","asc");    	
    	$query = $this->db->get();
    	
    	$tmp = '';
    	if ($empty_row != FALSE)
    	{
    		$tmp['null'] = '&nbsp;';
    	}
    	
    	foreach ($query->result() as $row)
		{
			$tmp[$row->province_id] = $row->province;
		}
		
		return $tmp;
    }
    
	/**
	 * Retorna una o más instancias del modelo
	 * @param array $search terminos de busqueda
	 * @param array $limit cantidad de registros a retornar
	 * @return array 
	 */    
    function seleccionar($search = NULL, $limit = NULL)
    {
    	$this->load->database();
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($field);
		}

    	$this->db->from($this->tabla);
    	
    	if ($search != NULL)
    	{
    		$this->db->where($search);
    	}

        if ($limit != NULL)
    	{
    		$this->db->limit($limit['show'], $limit['from']);
    	}
    	
    	$this->db->order_by('province_id', 'DESC');
    	
        $query = $this->db->get();
        return $query;
    }
    
	/**
	 * Inserta un registro
	 * @param array $values valores a insertar
	 * @return void 
	 */     
    function insertar($values)
    {	
        $this->db->insert($this->tabla, $values);
    }
    
	/**
	 * Actualiza un registro
	 * @param array $values valores a cambiar
	 * @param array $where id o dato del registro
	 * @return void 
	 */     
    function actualizar($values, $where)
    {
        $this->db->update($this->tabla, $values, $where);
    }  
}

/* End of file province.php */
/* Location: ./system/application/model/province.php */
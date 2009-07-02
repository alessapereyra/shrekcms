<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de postmeta
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de postmeta
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */


class Postmeta extends Model {
	
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
    var $tabla = 'mulapress_postmeta';

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
	 * Consigue la metadata de un post
	 * @param integer $id id de un post
	 * @return array 
	 */      
    function get_metas($id)
    {
    	$this->db->select('meta_key');
    	$this->db->select('meta_value');
    	$this->db->from($this->tabla);
    	$this->db->where('post_id', $id);
    	$query = $this->db->get();
    	
        foreach ($query->result() as $row)
		{
			$tmp[$row->meta_key] = $row->meta_value;
		}
		
		return $tmp;
    	
    }

	/**
	 * Inserta la localidad de la noticia
	 * @param array $values valores a insertar
	 * @param integer $id id de un post
	 * @return void 
	 */      
    function insertar_customs_locations($values, $id)
    {
    	$tmp['post_id'] = $id;
    	
    	foreach ($values as $key => $value)
    	{
    		$tmp['meta_key'] = $key;
    		switch ($key)
    		{
    			case 'pais':
    				$query = $this->countries->seleccionar(array('country_id' => $value));
    				$field = 'country';
    			break;
    			case 'departamento':
    				$query = $this->states->seleccionar(array('state_id' => $value));
    				$field = 'state';
    			break;
    			case 'provincia':
    				$query = $this->provinces->seleccionar(array('province_id' => $value));
    				$field = 'province';
    			break;
    			case 'distrito':
    				$query = $this->districts->seleccionar(array('district_id' => $value));
    				$field = 'district';
    			break;
    		}
    		$query = $query->result_array();
    		$query = current($query);
    		$value = $query[$field];
    		$tmp['meta_value'] = $value;
    		$this->_insertar($tmp);
    	}	
    }
    
	/**
	 * Inserta metadata
	 * @param array $values valores a insertar
	 * @param integer $id id de un post
	 * @return void 
	 */       
    function insertar($values, $id)
    {
    	$tmp['post_id'] = $id;
    	
    	foreach ($values as $key => $value)
    	{
    		$tmp['meta_key'] = $key;
    		$tmp['meta_value'] = $value;
    		$this->_insertar($tmp);
    	}
    }
    
	/**
	 * Inserta un registro
	 * @param array $values valores a cambiar
	 * @return void 
	 */    
    function _insertar($values)
    {
    	$this->db->insert($this->tabla, $values);
    }
    
	/**
	 * Retorna una o más instancias del modelo
	 * @param array $search terminos de busqueda
	 * @param array $limit cantidad de registros a retornar
	 * @return array 
	 */      
    function seleccionar($values)
    {
    	$this->load->database();
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($field);
		}

    	$this->db->from($this->tabla);
    	
    	$this->db->where($values);
    	
        $query = $this->db->get();
        return $query;   	
    }

}


/* End of file postmeta.php */
/* Location: ./system/application/model/postmeta.php */
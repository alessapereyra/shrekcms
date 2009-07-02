<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de usermeta
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de usermeta
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Usermeta extends Model {
	
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
    var $tabla = 'wp_usermeta';

	/**
	 * Constructor de la case
	 */       
    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('lamula');        
    }
    
	/**
	 * Inserta los metadatos
	 * @param array $values valores a insertar
	 * @return void 
	 */       
    function insertar($values, $id)
    {
    	$tmp['user_id'] = $id;
    	foreach($values as $value)
    	{
    		$tmp['meta_key'] = $value['meta_key'];
    		$tmp['meta_value'] = $value['meta_value'];
    		$this->_insertar($tmp);
    	}
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
    	
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query;
    }

	/**
	 * Devuelve todos los metadata de un usuario
	 * @param integer $id id del usuario
	 * @return array 
	 */        
    function select_all($id)
    {
    	$this->db->select('meta_key');
    	$this->db->select('meta_value');
    	$this->db->from($this->tabla);
    	$this->db->where(array('user_id' => $id));
    	
    	$query = $this->db->get();
    	return $query;
    }
    
	/**
	 * Inserta un registro
	 * @param array $values valores a insertar
	 * @return void 
	 */        
    function _insertar($values)
    {
    	$this->db->insert($this->tabla, $values);
    }    
}

/* End of file countries.php */
/* Location: ./system/application/model/countries.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de term_taxonomy
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de term_taxonomy
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Term_taxonomy extends Model {
	
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
    var $tabla = 'mulapress_term_taxonomy';

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
        return $query;
    }
    
	/**
	 * Actualizar un registro
	 * @param integer $id id del tag a insertar
	 * @return void 
	 */       
    function update_record($id)
    {
    	$this->db->where('term_taxonomy_id', $id);
    	$this->db->set('count', 'count + 1', FALSE);
    	
    	$this->db->update($this->tabla);

    }

	/**
	 * Descuenta un tag/categoria
	 * @param array  $term_taxonomy_id de los registros a descontar
	 * @return void 
	 */       
    function discount($ids)
    {
    	$this->db->where_in('term_taxonomy_id', $ids);
    	$this->db->set('count', 'count - 1', FALSE);
    	
    	$this->db->update($this->tabla);

    }    
	/**
	 * Inserta un tag
	 * @param integer $id id del tag a insertar
	 * @return integer 
	 */      
    function insertar_tag($id)
    {
    	$tmp['term_taxonomy_id'] = $id;
    	$tmp['term_id'] = $id;
    	$tmp['taxonomy'] = 'post_tag';
    	$tmp['parent'] = "0";
    	$tmp['count'] = "'1'";
    	
    	return $this->_insertar($tmp);
    }
    
	/**
	 * Inserta un registro
	 * @param array $values valores a insertar
	 * @return integer 
	 */      
    function _insertar($values)
    {   	   	   
    	$this->db->insert($this->tabla, $values);
    	return $this->db->insert_id();
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
/* End of file term_taxonomy.php */
/* Location: ./system/application/model/term_taxonomy.php */
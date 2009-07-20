<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de term_relationships
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de term_relationships
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Term_relationships extends Model {
	
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
    var $tabla = 'wp_1_terms_relationships';

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
	 * Inserta relaciones
	 * @param integer $post id del post
	 * @param array $values valores a insertar
	 * @return void 
	 */     
    function insertar($post, $values)
    {   	   	   
    	$tmp['object_id'] = $post; 
    	foreach($values as $value)
    	{
    		$tmp['term_taxonomy_id'] = $value; 	
    		$this->db->insert($this->tabla, $tmp);	
    	}
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
    
	/**
	 * Borra tags
	 * @param integer $id id del post
	 * @param array $terms_taxonomy_id id del term taxonomy
	 * @return void 
	 */      
    function borrar($id, $terms_taxonomy_id)
    {
    	$this->db->where(array('object_id' => $id));
		$this->db->where_in('term_taxonomy_id', $terms_taxonomy_id);    		
    	$this->db->delete($this->tabla);
    }    
    
}
/* End of file term_relationships.php */
/* Location: ./system/application/model/term_relationships.php */
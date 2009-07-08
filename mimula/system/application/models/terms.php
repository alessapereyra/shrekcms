<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de terms
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de terms
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Terms extends Model {
	
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
    var $tabla = 'mulapress_terms';

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
	 * Consigue los categorias
	 * @return array 
	 */      
    function get_categories()
    {
    	$this->db->select($this->tabla . '.term_id');
    	$this->db->select($this->tabla . '.name');
    	
    	$this->db->from($this->tabla);
    	$this->db->join('mulapress_term_taxonomy', 'mulapress_terms.term_id = mulapress_term_taxonomy.term_id');
    	
    	$this->db->where(array('mulapress_term_taxonomy.taxonomy' => 'category', 'parent' => 29));
    	
    	$query = $this->db->get();
    	  
    	foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
		}
		
		return $tmp;       	
    }
    
	/**
	 * Consigue las categorias de un post
	 * @param integer $id id de un post
	 * @return array 
	 */       
    function get_postcategories($id)
    {
    	$this->db->select($this->tabla . '.term_id');
    	$this->db->select($this->tabla . '.name');
    	
    	$this->db->from($this->tabla);

    	$this->db->join('mulapress_term_relationships', 'mulapress_terms.term_id = mulapress_term_relationships.term_taxonomy_id');
    	$this->db->join('mulapress_term_taxonomy', 'mulapress_term_taxonomy.term_taxonomy_id = mulapress_term_relationships.term_taxonomy_id');
    	
    	$this->db->where('taxonomy', 'category');
    	//Online
    	$this->db->where('parent', '29');
    	$this->db->where('object_id', $id);
    	
    	$query = $this->db->get();
    	//die($this->db->last_query());
    	$tmp = NULL;
        foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
		}    	

    	return $tmp;
    }
    
	/**
	 * Consigue los tags de un post
	 * @param integer $id id del post
	 * @return array 
	 */       
    function get_tags($id)
    {
    	$this->db->select($this->tabla . '.name');
    	$this->db->select('mulapress_term_relationships.term_taxonomy_id');
    	
    	$this->db->from($this->tabla);

    	$this->db->join('mulapress_term_relationships', 'mulapress_terms.term_id = mulapress_term_relationships.term_taxonomy_id');
    	$this->db->join('mulapress_term_taxonomy', 'mulapress_term_taxonomy.term_taxonomy_id = mulapress_term_relationships.term_taxonomy_id');
    	
    	$this->db->where('taxonomy', 'post_tag');
    	$this->db->where('object_id', $id);
    	
    	$query = $this->db->get(); 	

    	return $query;
    }
    
	/**
	 * Consigue los tags y categorias de un post
	 * @param integer $id id del post
	 * @return array 
	 */       
    function get_tags_categorias($id)
    {
    	$this->db->select($this->tabla . '.name');
    	$this->db->select('mulapress_term_relationships.term_taxonomy_id');
    	
    	$this->db->from($this->tabla);

    	$this->db->join('mulapress_term_relationships', 'mulapress_terms.term_id = mulapress_term_relationships.term_taxonomy_id');
    	$this->db->join('mulapress_term_taxonomy', 'mulapress_term_taxonomy.term_taxonomy_id = mulapress_term_relationships.term_taxonomy_id');
    	
    	$this->db->where('object_id', $id);
    	$this->db->where('parent !=', 28);
    	
    	$query = $this->db->get(); 	

    	return $query;
    }
    
    /**
	 * Consigue las categorias privadas
	 * @return array 
	 */      
    function get_categories_perfil()
    {
    
    	$db->select($this->tabla . '.term_id');
    	$db->select($this->tabla . '.name');
    	
    	$db->from($this->tabla);
    	$db->join('mulapress_term_taxonomy', 'mulapress_terms.term_id = mulapress_term_taxonomy.term_id');
    	
    	$db->where(array('mulapress_term_taxonomy.taxonomy' => 'category', 'parent' => 29));
    	
    	$query = $db->get();
    	  
    	foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
		}
		
		return $tmp;       	
    }    
    
	/**
	 * Inserta un tag
	 * @param array $values valores a insertar
	 * @return void 
	 */         
    function insert_tags($values)
    {
    	$values = split(',', $values);
    	$this->load->helper('inflector');
    	
    	foreach ($values as $value)
    	{
    		$value = trim($value);
    		
    		$tmp['name'] = $value;
    		$tmp['slug'] = score($value);
    		
    		$this_tag = $this->_check_insert($tmp);
    		
    		if ($this_tag == FALSE)
    		{
    			$id = $this->_insertar($tmp);
    			$tags[] = $this->term_taxonomy->insertar_tag($id);
    		}
    		else
    		{
    			$tags[] = $this_tag; 
    		}
    	}
    	return $tags;
    }

	/**
	 * Borra todos los tags de un post
	 * @param integer $id id del post
	 * @return void 
	 */         
    function clear_tags($id)
    {
    	//Consigo todos los tags/categorias
    	$id_terms = $this->get_tags_categorias($id);
    	
		if ($id_terms->num_rows() > 0) 
		{
	    	//Arma el array con los id
	    	foreach ($id_terms->result() as $row)
	    	{
	    		$discount[] = $row->term_taxonomy_id;
	    	}
	    	//Borra esos id
	    	$this->term_relationships->borrar($id, $discount);
	    	//Descuenta esos id
	    	$this->term_taxonomy->discount($discount);
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
        return $query;
    }
    
	/**
	 * Inserta un registro
	 * @param array $values valores a insertar
	 * @return integer 
	 */       
    function _insertar($values)
    {   	   	   
    	$this->db->insert($this->tabla, $values);
    	$query = $this->seleccionar($values);
    	$query = $query->row();
    	return $query->term_id;
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
	 * Inserta o actualiza el contador de un tag
	 * @param array $values valores a cambiar
	 * @return boolean | integer 
	 */       
    function _check_insert($value)
    {
    	$this->db->select('term_id');
    	$this->db->from($this->tabla);
    	$this->db->or_where($value); 
    	$this->db->limit(1,0);
    	
    	$query = $this->db->get();

    	if ($query->num_rows() == 0)
    	{
    		return FALSE; 
    	}
    	else
    	{
    		$query =  $query->row();
    		
    		//suma uno mas
    		$this->term_taxonomy->update_record($query->term_id);
    				
    		return $query->term_id;
    	}

    }    
}
/* End of file terms.php */
/* Location: ./system/application/model/terms.php */
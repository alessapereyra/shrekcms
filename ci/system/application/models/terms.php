<?php
class Terms extends Model {
	
	var $campos = array();
    var $tabla = 'wp_terms';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }

    function get_categories()
    {
    	$this->db->select($this->tabla . '.term_id');
    	$this->db->select($this->tabla . '.name');
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_term_taxonomy', 'wp_terms.term_id = wp_term_taxonomy.term_id');
    	
    	$this->db->where(array('wp_term_taxonomy.taxonomy' => 'category', 'parent' => 6));
//    	$this->db->where(array('wp_term_taxonomy.taxonomy' => 'category', 'parent' => 29));
    	
    	$query = $this->db->get();
    	  
    	foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
		}
		
		return $tmp;       	
    }
    
    function get_postcategories($id)
    {
    	$this->db->select($this->tabla . '.term_id');
    	$this->db->select($this->tabla . '.name');
    	
    	$this->db->from($this->tabla);

    	$this->db->join('wp_term_relationships', 'wp_terms.term_id = wp_term_relationships.term_taxonomy_id');
    	$this->db->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id');
    	
    	$this->db->where('taxonomy', 'category');
    	$this->db->where('parent', '6');
    	$this->db->where('object_id', $id);
    	
    	$query = $this->db->get();
    	
        foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
		}    	
    	
    	
    	//die($this->db->last_query());
    	return $tmp;
    }
    
    function get_tags($id)
    {
    	$this->db->select($this->tabla . '.name');
    	
    	$this->db->from($this->tabla);

    	$this->db->join('wp_term_relationships', 'wp_terms.term_id = wp_term_relationships.term_taxonomy_id');
    	$this->db->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id');
    	
    	$this->db->where('taxonomy', 'post_tag');
    	$this->db->where('object_id', $id);
    	
    	$query = $this->db->get(); 	
    	
    	return $query;
    }
    
    function get_categories_perfil($db)
    {
    
    	$db->select($this->tabla . '.term_id');
    	$db->select($this->tabla . '.name');
    	
    	$db->from($this->tabla);
    	$db->join('wp_term_taxonomy', 'wp_terms.term_id = wp_term_taxonomy.term_id');
    	
    	//$db->where(array('mulapress_term_taxonomy.taxonomy' => 'category', 'parent' => 29));
	    $db->where(array('mulapress_term_taxonomy.taxonomy' => 'category', 'parent' => 6));
    	
    	$query = $db->get();
    	  
    	foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
		}
		
		return $tmp;       	
    }    
    
    function insert_tags($values)
    {
    	$values = split(',', $values);
    	$this->load->helper('inflector');
    	
    	foreach ($values as $value)
    	{
    		$value = trim($value);
    		$this_tag = $this->_check_insert($value);
    		
    		if ($this_tag == FALSE)
    		{
    			$tmp['name'] = $value;
    			$tmp['slug'] = score($value);
    			$id = $this->_insertar($tmp);
    			
    			$this->term_taxonomy->insertar_tag($id);
    			
    			$tags[] = $this->_check_insert(trim($value));
    		}
    		else
    		{
    			$tags[] = $this_tag; 
    		}
    		
    	}
    	return $tags;
    }
       
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
    
    function _insertar($values)
    {   	   	   
    	$this->db->insert($this->tabla, $values);
    	$query = $this->seleccionar($values);
    	$query = $query->row();
    	return $query->term_id;
    }
    
    function actualizar($values, $where)
    {
        $this->db->update($this->tabla, $values, $where);
    }
    
    function borrar($values)
    {
		if ($this->_check('propiedades', $values['id']) == FALSE)
    	{
    		return $this->lang->line('error_reg_usado'); //$this->lang->line('error_' . $resultado);
    	}
    	else
    	{
	    	$this->db->where($values);
	    	$this->db->limit(1, 0);
	    	$this->db->delete($this->tabla);
	    	return $this->db->affected_rows() == 1 ? FALSE : $this->lang->line('error_no_borra');
    	}
    }
    
    function _check_insert($value)
    {
    	$this->db->select('term_id');
    	$this->db->from($this->tabla);
    	$this->db->where(array('name' => trim($value)));
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
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
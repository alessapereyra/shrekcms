<?php

class Term_relationships extends Model {
	
	var $campos = array();
    var $tabla = 'wp_term_relationships';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
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
    
    function insertar($post, $values)
    {   	   	   
    	$tmp['object_id'] = $post; 
    	foreach($values as $value)
    	{
    		$tmp['term_taxonomy_id'] = $value; 	
    		$this->db->insert($this->tabla, $tmp);	
    	}

    }
    
    function actualizar($values, $where)
    {
        $this->db->update($this->tabla, $values, $where);
    }
    
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
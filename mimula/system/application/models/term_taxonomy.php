<?php

class Term_taxonomy extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_term_taxonomy';

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
    
    function update_record($id)
    {
    	$this->db->where('term_taxonomy_id', $id);
    	$this->db->set('count', 'count + 1', FALSE);
    	
    	$this->db->update($this->tabla);

    }
    
    function insertar_tag($id)
    {
    	$tmp['term_taxonomy_id'] = $id;
    	$tmp['term_id'] = $id;
    	$tmp['taxonomy'] = 'post_tag';
    	$tmp['parent'] = "0";
    	$tmp['count'] = "'1'";
    	
    	return $this->_insertar($tmp);
    }
    
    function _insertar($values)
    {   	   	   
    	$this->db->insert($this->tabla, $values);
    	return $this->db->insert_id();
    }    
    
    /*
    function insertar($post, $values)
    {   	   	   
    	$tmp['object_id'] = $post; 
    	foreach($values as $value)
    	{
    		$tmp['term_taxonomy_id'] = $value; 	
    		$this->db->insert($this->tabla, $tmp);	
    	}
    	
    }
    */
    
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
    
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
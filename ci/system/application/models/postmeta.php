<?php
class Postmeta extends Model {
	
	var $campos = array();
    var $tabla = 'wp_postmeta';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
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
    
    function _insertar($values)
    {
    	$this->db->insert($this->tabla, $values);
    }
    
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
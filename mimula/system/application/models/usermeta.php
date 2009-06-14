<?php
class Usermeta extends Model {
	
	var $campos = array();
    var $tabla = 'wp_usermeta';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('lamula');        
    }
    
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
        
    function select_all($id)
    {
    	$this->db->select('meta_key');
    	$this->db->select('meta_value');
    	$this->db->from($this->tabla);
    	$this->db->where(array('user_id' => $id));
    	
    	$query = $this->db->get();
    	return $query;
    }
    
    function _insertar($values)
    {
    	$this->db->insert($this->tabla, $values);
    }    
}
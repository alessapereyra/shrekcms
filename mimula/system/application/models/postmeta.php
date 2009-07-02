<?php
class Postmeta extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_postmeta';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
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
    				$query = $this->departments->seleccionar(array('department_id' => $value));
    				$field = 'department';
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
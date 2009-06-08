<?php
class Mularangos extends Model {
	
	var $tabla = 'mulapress_mularangos';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    
    function seleccionar()
    {
    	$this->load->database();
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($field);
		}

    	$this->db->from($this->tabla);
    	
    	$this->db->orderby('minimo','DESC');
    	
        $query = $this->db->get();
        return $query;
    }
   
}
?>
<?php
class Options extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_options';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_($value)
    {
    	$this->db->select('option_value');
    	$this->db->from($this->tabla);
    	$this->db->where(array('option_name' => $value));
    	
    	$query = $this->db->get();
    	$query = $query->row_array();
    	return $query['option_value'];
    }

}
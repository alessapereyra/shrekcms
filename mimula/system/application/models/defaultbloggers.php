<?php
class Defaultbloggers extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_default_bloggers';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_fkdefaults($empty_row = FALSE)
    {
    	$this->db->select($this->tabla . '.id as miid', FALSE);
    	$this->db->select('user_nicename as user', FALSE);
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_users', 'wp_users.ID = mulapress_default_bloggers.blogger_id');

		$this->db->order_by('user_nicename', 'ASC'); 
  	
    	$query = $this->db->get();
    	
    	$tmp = '';
    	if ($empty_row != FALSE)
    	{
    		$tmp['null'] = '&nbsp;';
    	}
    	
    	if ($query->num_rows == 0)
    	{
    		$tmp['null'] = 'No hay muleros seleccionados';
    		return $tmp;
    	}
    	
    	foreach ($query->result() as $row)
		{
			$tmp[$row->miid] = $row->user;
		}
		
		return $tmp;
    }
    
    function insertar($values)
    {	
        $this->db->insert($this->tabla, $values);
    }

    function borrar($values)
    {
    	$this->db->where($values);
    	$this->db->limit(1, 0);
    	$this->db->delete($this->tabla);
    }    
    
}
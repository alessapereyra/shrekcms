<?php
class Countries extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_countries';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_fkcombo($empty_row = FALSE)
    {
    	$this->load->database();
    	$this->db->select('country_id');
    	$this->db->select('country');
    	$this->db->from($this->tabla);
    	$query = $this->db->get();
    	
    	$tmp = '';
    	if ($empty_row != FALSE)
    	{
    		$tmp['null'] = '&nbsp;';
    	}
    	
    	foreach ($query->result() as $row)
		{
			$tmp[$row->country_id] = $row->country;
		}
		
		return $tmp;
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
    	
    	$this->db->order_by('id', 'DESC');
    	
        $query = $this->db->get();
        return $query;
    }
    
    function insertar($values)
    {	
        $this->db->insert($this->tabla, $values);
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
}
?>
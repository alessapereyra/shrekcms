<?php
class Providences extends Model {
	
	var $campos = array();
    var $tabla = 'wp_providences';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_fkcombo($id, $empty_row = FALSE)
    {
    	$this->load->database();
    	$this->db->select('providence_id');
    	$this->db->select('providence');
    	$this->db->from($this->tabla);
    	$this->db->where(array('fk_department' => $id));
    	$query = $this->db->get();
    	
    	$tmp = '';
    	if ($empty_row != FALSE)
    	{
    		$tmp['null'] = '&nbsp;';
    	}
    	
    	foreach ($query->result() as $row)
		{
			$tmp[$row->providence_id] = $row->providence;
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
<?php
class Users extends Model {
	
	var $campos = array();
    var $tabla = 'wp_users';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }

    function seleccionar($search = NULL, $limit = NULL)
    {
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
    	if ($values['id'] != $this->session->userdata('id'))
    	{
	    	$this->db->where($values);
	    	$this->db->limit(1, 0);
	    	$this->db->delete($this->tabla);
	    	return $this->db->affected_rows() == 1 ? FALSE : $this->lang->line('error_no_borra');
    	}
    	return $this->lang->line('error_borrar_usuario');
    }
  
}
/* End of file usuarios.php */
/* Location: ./system/application/model/usuarios.php */
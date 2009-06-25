<?php
class Users extends Model {
	
	var $campos = array();
    var $tabla = 'wp_users';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('lamula');        
    }
    
    function approve($aproved, $desaproved)
    {
    	$values['aproved'] = 1;
    	
    	$this->db->where_in('ID', $aproved);
    	$this->db->update($this->tabla, $values);

    	$values['aproved'] = 0;
    	
    	$this->db->where_in('ID', $desaproved);
    	$this->db->update($this->tabla, $values);
    	
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
    
    function count_all()
    {
    	return $this->db->count_all($this->tabla);
    }
    
    function get_view($limit = NULL)
    {
		$this->db->select('ID');
		$this->db->select('user_login');
		$this->db->select('user_url');
		$this->db->select('aproved');
		
  		$this->db->from($this->tabla);
    	
        if ($limit != NULL)
    	{
    		$this->db->limit($limit['show'], $limit['from']);
    	}
    	
    	$this->db->order_by('user_login', 'ASC');
    	    	
        $users = $this->db->get();
        
		foreach ($users->result() as $row)
		{
			$actual_users[] = $row->ID;
		}
		
		
		$this->db->select('user_id');
		$this->db->select('meta_key');
		$this->db->select('meta_value');

		$this->db->from('wp_usermeta');
		
		$this->db->where("(`meta_key` = 'dni' OR `meta_key` = 'telefono' OR `meta_key` = 'first_name' OR `meta_key` = 'last_name')");
		
		$this->db->where_in('user_id', $actual_users);
		
		//$this->db->order_by('user_id', 'ASC');
		
		$user_meta = $this->db->get();
		
		$tmp['users'] = $users;
		$tmp['user_meta'] = $user_meta;
		
		return $tmp;
        
    }
    
    
    function insertar($values)
    {	  
        $this->db->insert($this->tabla, $values);
        
        $query = $this->seleccionar(array('user_login' => $values['user_login']));
        $query = $query->row();
        
        return $query->ID;
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
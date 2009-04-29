<?php
class Terms extends Model {
	
	var $campos = array();
    var $tabla = 'wp_terms';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }

    function get_categories()
    {
    	$this->db->select($this->tabla . '.term_id');
    	$this->db->select($this->tabla . '.name');
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_term_taxonomy', 'wp_terms.term_id = wp_term_taxonomy.term_id');
    	
    	$this->db->where(array('wp_term_taxonomy.taxonomy' => 'category'));
    	
    	$query = $this->db->get();
    	  
    	foreach ($query->result() as $row)
		{
			$tmp[$row->term_id] = $row->name;
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
    
    function _insertar($values)
    {	
    	$values['post_date'] = date('Y-m-d G:i:s');
    	$values['post_date_gmt'] = $values['post_date'];
    	$values['post_modified'] = $values['post_date'];
    	$values['post_modified_gmt'] = $values['post_date'];

    	$values['post_status'] = 'draft';
    	$values['comment_status'] = 'closed';
    	$values['ping_status'] = 'closed';    	   	
        
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
    
    function _check($tabla, $id)
    {
    	$this->db->select('id');
    	$this->db->from($tabla);
    	$this->db->where(array($this->fk => $id));
    	$query = $this->db->get();
    	
    	return $query->num_rows() == 0 ? TRUE : FALSE;
    }    
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
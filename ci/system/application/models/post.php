<?php
class Post extends Model {
	
	var $campos = array();
    var $tabla = 'wp_posts';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function insert_attach($name, $ext)
    {
    	$this->load->library('session');
    	$this->load->helper('inflector');
    	
    	$values['post_author'] = $this->session->userdata('id');
    	$values['post_type'] = 'attachment';
    	$values['post_name'] = score($name);
		$values['post_status'] = 'inherit';
		$values['post_mime_type'] = 'image/' . $ext;

		$post_id = $this->_insertar($values);
    	
		return $post_id;
    }
    
    
    function insert_article($values, $customs)
    {
    	$this->load->library('session');
    	$this->load->helper('inflector');
    	
    	$values['post_author'] = $this->session->userdata('id');
    	$values['post_type'] = 'post';
    	$values['post_name'] = score($values['post_title']);
		$values['post_status'] = 'draft';    	
    	
    	//inserta los tags
    	$tags_id = $this->terms->insert_tags($values['tags']);
    	
    	//limpia los tags
    	unset($values['tags']);

    	if (is_array($tags_id))
    	{
    		foreach ($tags_id as $value)
    		{
    			$tmp[] = $value;
    		}
    	}
    	
    	if (is_array($values['terms_taxonomy_id']))
    	{
    		foreach ($values['terms_taxonomy_id'] as $value)
    		{
    			$tmp[] = $value;
    		}
    	}
    	
    	$terms_taxonomy_id = $tmp; //array_merge($tags_id, $values['terms_taxonomy_id']);

    	unset($values['terms_taxonomy_id']);
    	
    	$post_id = $this->_insertar($values);
    	
    	$this->postmeta->insertar($customs, $post_id);
    	
    	$this->term_relationships->insertar($post_id, $terms_taxonomy_id);
    	
    	

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
        return $query;
    }
    
    function _insertar($values)
    {	
    	$values['post_date'] = date('Y-m-d G:i:s');
    	$values['post_date_gmt'] = $values['post_date'];
    	$values['post_modified'] = $values['post_date'];
    	$values['post_modified_gmt'] = $values['post_date'];

    	$values['comment_status'] = 'closed';
    	$values['ping_status'] = 'closed';
    	
    	$this->db->insert($this->tabla, $values);
    	
    	$this->db->select($this->tabla . '.ID');
    	$this->db->from($this->tabla);
    	
    	$this->db->where(array('post_date' => $values['post_date']));
    	$this->db->limit(1, 0);
    	$query = $this->db->get();
    	$query = $query->row(); 
    	
    	return $query->ID;
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
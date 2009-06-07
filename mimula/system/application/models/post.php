<?php
class Post extends Model {
	
	var $campos = array();
	var $tabla = 'mulapress_posts';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_geomula($values, $limit)
    {
        $fields = array($this->tabla . '.ID',
        				$this->tabla . '.guid',
        				$this->tabla . '.post_title',
        				'DATE_FORMAT(`mulapress_posts`.`post_date`, \'%d-%m-%Y\') as post_date',
        				$this->tabla . '.comment_count',
        				$this->tabla . '.post_content');

		foreach ($fields as $field)
		{
		   $this->db->select($field, FALSE);
		}
		
    	
		$this->db->select('mulapress_users.user_login');
		$this->db->select('mulapress_users.user_nicename');
		
		$this->db->from($this->tabla);
		$this->db->join('mulapress_postmeta', 'mulapress_posts.ID = mulapress_postmeta.post_id');
		$this->db->join('mulapress_users', 'mulapress_posts.post_author = mulapress_users.ID');
			
		$this->db->where('post_type', 'post');
		$this->db->where('post_status', 'publish');
		$this->db->where($values);
		
		$this->db->limit($limit['show'], $limit['from']);
		
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query;
    }
    
    function get_lastpost($id, $posts)
    { 
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($this->tabla . '.' . $field);
		}

		$this->db->from($this->tabla);
		$this->db->where('post_type', 'post');
		$this->db->where('post_author', $id);
		$this->db->where('(post_status like "publish" or post_status like "inherit")');
		//$this->db->where('post_status', 'publish');
		
		$this->db->limit($posts, 0);
		
		$this->db->order_by($this->tabla . '.post_date', 'DESC');
		
		$todo = $this->db->get();
		$post[] = $todo->result_array();

		//$categorias = $this->terms->get_categories();
		$categorias = $this->terms->get_categories_perfil($db);
		
		foreach($categorias as $key => $values)
		{
			
	    	$fields = $this->db->list_fields($this->tabla);

			foreach ($fields as $field)
			{
			   $this->db->select($this->tabla . '.' . $field);
			}
			
			$this->db->from($this->tabla);
			$this->db->join('mulapress_term_relationships', 'mulapress_posts.ID = mulapress_term_relationships.object_id');
			
			$this->db->where('post_type', 'post');
			$this->db->where('post_author', $id);
			$this->db->where('mulapress_term_relationships.term_taxonomy_id', $key);
			
			$this->db->order_by($this->tabla . '.post_date', 'DESC');
			
			$this->db->limit($posts, 0);
			$query = $this->db->get();
			$post[] = $query->result_array();

		}

		return $post;
		
    }
    
    function get_mypost($user, $limit = NULL)
    {   	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($this->tabla . '.' . $field);
		}
		$this->db->select('mulapress_terms.name');
		$this->db->select('mulapress_terms.slug');
		
		
		$this->db->from($this->tabla);
		
		$this->db->join('mulapress_term_relationships', 'mulapress_posts.ID = mulapress_term_relationships.object_id');
		$this->db->join('mulapress_term_taxonomy', 'mulapress_term_taxonomy.term_taxonomy_id = mulapress_term_relationships.term_taxonomy_id');
		$this->db->join('mulapress_terms', 'mulapress_terms.term_id = mulapress_term_taxonomy.term_id');		
		
		$this->db->where('mulapress_posts.post_type', 'post');
     //              $this->db->where('wp_term_taxonomy.parent', '5');
     $this->db->where('mulapress_term_taxonomy.parent', '28');
     $this->db->where($this->tabla . '.post_author', $user);		
		$this->db->order_by($this->tabla . '.post_date', 'DESC');
		
		$this->db->limit($limit['show'], $limit['from']);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query;
    }
    
    function insert_attach($values)
    {
    	$values['post_type'] = 'attachment';    	
		$values['post_status'] = 'inherit';
		
		$post_id = $this->_insertar($values);
    	
		return $post_id;
    }
    
    
    function insert_article($values, $customs)
    {
    	$this->load->library('session');
    	$this->load->helper('inflector');
    	
    	$values['post_author'] = $this->session->userdata('id');
    	$values['post_type'] = 'post';
    	$values['post_name'] = preg_replace('/[^a-zA-Z0-9 -]/','',score($values['post_title']));
		$values['post_status'] = 'publish';    	
    	
		$this->load->library('HTMLPurifier');
        $config = HTMLPurifier_Config::createDefault();
        $values['post_content'] = $this->htmlpurifier->purify( $values['post_content'] , $config );
		    
		  
		  
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
    	
    	return $post_id;
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

    	$values['comment_status'] = 'open';
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
    	//die(print_r($values));
    	//TODO: aca deberia limpiar esto T_T
    	
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
    
    function published_posts($id)
    {
      
      $this->db->select('post_author');
      $this->db->from($this->tabla);
      $this->db->where('post_author',$id);
		  $this->db->where('(post_status like "publish" or post_status like "inherit")');
      return $this->db->count_all_results();
    }
 
    function total_posts($id){
       $this->db->select('post_author');
       $this->db->from($this->tabla);
       $this->db->where('post_author',$id);
       return $this->db->count_all_results();
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

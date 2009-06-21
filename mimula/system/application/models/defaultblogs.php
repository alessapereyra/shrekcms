<?php
class Defaultblogs extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_default_blogs';

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
    	$this->db->select('wp_bp_user_blogs_blogmeta.meta_value AS blogname', FALSE);
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_bp_user_blogs_blogmeta', 'wp_bp_user_blogs_blogmeta.blog_id = mulapress_default_blogs.blog_id');
    	$this->db->join('wp_bp_user_blogs', 'wp_bp_user_blogs.blog_id = mulapress_default_blogs.blog_id');
    	$this->db->join('wp_users', 'wp_users.ID = wp_bp_user_blogs.user_id');
    	
    	$this->db->where('wp_bp_user_blogs_blogmeta.meta_key', 'name');
    	
		$this->db->order_by('wp_bp_user_blogs_blogmeta.meta_value', 'ASC'); 
  	
    	$query = $this->db->get();
    	//die($this->db->last_query());
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
			$tmp[$row->miid] = $row->blogname . ' - ' . $row->user;
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
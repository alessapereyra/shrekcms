<?php
class Blogs extends Model {
	
	var $campos = array();
    var $tabla = 'wp_blogs';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_fkbloggers($empty_row = FALSE)
    {
    	$this->db->select('wp_users.ID AS miid', FALSE);
    	$this->db->select('user_nicename AS user', FALSE);
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_bp_user_blogs', 'wp_bp_user_blogs.blog_id = wp_blogs.blog_id');
    	$this->db->join('wp_users', 'wp_users.ID = wp_bp_user_blogs.user_id');

    	$this->db->where('public',1);
    	$this->db->where('archived',"'0'",FALSE);
    	$this->db->where('mature',0);
    	$this->db->where($this->tabla . '.spam',0);
    	$this->db->where($this->tabla . '.deleted',0);

		$this->db->order_by('user_nicename', 'ASC'); 
  	
    	$query = $this->db->get();
    	//TODO: Mejorar esta consulta para que traiga a todos los que no estan en el otro combo
    	//die($this->db->last_query());
    	
    	$tmp = '';
    	if ($empty_row != FALSE)
    	{
    		$tmp['null'] = '&nbsp;';
    	}
    	
    	foreach ($query->result() as $row)
		{
			$tmp[$row->miid] = $row->user;
		}
		
		return $tmp;
    }
    
}
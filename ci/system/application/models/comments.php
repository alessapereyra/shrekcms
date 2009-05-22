<?php
class Comments extends Model {
	
	var $campos = array();
    var $tabla = 'wp_comments';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function total_comments($id){
      
    	$db = $this->load->database('default', TRUE); 
    	
      $db->select('user_id');
      $db->from($this->tabla);
      $db->where('user_id',$id);
      return $db->count_all_results();
    }

    function total_received_comments($id)
    {
      
    	$db = $this->load->database('default', TRUE);
      $db->select('post_author');
  		$db->from($this->tabla);
  		$db->join('wp_posts', 'wp_posts.ID = wp_comments.comment_post_ID');		
    	$db->where('wp_posts.post_author', $id);
    
      return $db->count_all_results();
      
    }
            
    
    function get_lastowncomments($id, $posts)
    {
      
      $db = $this->load->database('default', TRUE); 
    	
	    $fields = $db->list_fields($this->tabla);
	
		  foreach ($fields as $field)
		  {
		    $db->select($this->tabla . '.' . $field);
		  }

	      $db->select('wp_posts.guid');
	      $db->select('wp_posts.post_title');

  		$db->from($this->tabla);    
  		$db->join('wp_posts', 'wp_posts.ID = wp_comments.comment_post_ID');		    
  		$db->where('user_id', $id);
		
  		$db->limit($posts, 0);
		
  		$db->order_by($this->tabla . '.comment_date', 'DESC');
		
  		$query = $db->get();
  		return $query->result_array();      
      
    }
    
    
    
    function get_lastcomments($id, $posts)
    {
      
      $db = $this->load->database('default', TRUE); 
    	
    	$fields = $db->list_fields($this->tabla);

		  foreach ($fields as $field)
		  {
		    $db->select($this->tabla . '.' . $field);
		  }
    
      $db->select('wp_posts.guid');
  		$db->from($this->tabla);
  		$db->join('wp_posts', 'wp_posts.ID = wp_comments.comment_post_ID');		
    
  		$db->where('wp_posts.post_author', $id);
		
  		$db->limit($posts, 0);
		
  		$db->order_by($this->tabla . '.comment_date', 'DESC');
		
  		$query = $db->get();
  		return $query->result_array();
  		
    }
       
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
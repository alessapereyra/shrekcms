<?php
class Sessionmanager extends Model {
	
	var $campos = array();
    var $tabla = 'wp_session_manager';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_lastread($id,$posts)
    {

      $db = $this->load->database('default', TRUE); 
      $db->distinct();      	
      $fields = $db->list_fields('wp_posts');

  		foreach ($fields as $field)
  		{
  		   $db->select('wp_posts.' . $field);
  		}

 	    $db->select('wp_session_manager.unixtime');
  		$db->from('wp_posts');
  		$db->join('wp_session_manager', 'wp_posts.ID = wp_session_manager.url');		

  		$db->where('wp_session_manager.user_id', $id);

  		$db->limit($posts, 0);

  		$db->order_by($this->tabla . '.unixtime', 'ASC');

  		$query = $db->get();
  		//die($db->last_query());
  		return $query->result_array();
      
      
      
    }
    
    
    function get_lastviews($id, $posts)
    {
        $db = $this->load->database('default', TRUE); 
    	
        $db->distinct();
    	$fields = $db->list_fields('wp_posts');

		foreach ($fields as $field)
		{
		   $db->select('wp_posts.' . $field);
		}
    	
		$db->from('wp_posts');
		$db->join('wp_session_manager', 'wp_posts.ID = wp_session_manager.url');		

		$db->where('wp_posts.post_author', $id);
		
		$db->limit($posts, 0);
		
		$db->order_by($this->tabla . '.unixtime', 'ASC');
		
		$query = $db->get();
		//die($db->last_query());
		return $query->result_array();
    }
       
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
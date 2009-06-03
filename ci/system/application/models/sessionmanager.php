<?php
class Sessionmanager extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_session_manager';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_lastread($id,$posts)
    {

      $this->db->distinct();      	
      $fields = $this->db->list_fields('wp_posts');

  		foreach ($fields as $field)
  		{
  		   $this->db->select('wp_posts.' . $field);
  		}

 	    $this->db->select('wp_session_manager.unixtime');
  		$this->db->from('wp_posts');
  		$this->db->join('wp_session_manager', 'wp_posts.ID = wp_session_manager.url');		

  		$this->db->where('wp_session_manager.user_id', $id);

  		$this->db->limit($posts, 0);

  		$this->db->order_by($this->tabla . '.unixtime', 'ASC');

  		$query = $this->db->get();
  		//die($this->db->last_query());
  		return $query->result_array();
      
      
      
    }
    
    
    function get_lastviews($id, $posts)
    {    	
        $this->db->distinct();
    	$fields = $this->db->list_fields('wp_posts');

		foreach ($fields as $field)
		{
		   $this->db->select('wp_posts.' . $field);
		}
    	
		$this->db->from('wp_posts');
		$this->db->join('wp_session_manager', 'wp_posts.ID = wp_session_manager.url');		

		$this->db->where('wp_posts.post_author', $id);
		
		$this->db->limit($posts, 0);
		
		$this->db->order_by($this->tabla . '.unixtime', 'ASC');
		
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result_array();
    }
       
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
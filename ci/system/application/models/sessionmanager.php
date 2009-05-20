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

      $db = $this->load->database('default', TRUE); 
      $db->distinct();      	
      $fields = $db->list_fields('mulapress_posts');

  		foreach ($fields as $field)
  		{
  		   $db->select('mulapress_posts.' . $field);
  		}

  		$db->from('mulapress_posts');
  		$db->join('mulapress_session_manager', 'mulapress_posts.ID = mulapress_session_manager.url');		

  		$db->where('mulapress_session_manager.user_id', $id);

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
    	$fields = $db->list_fields('mulapress_posts');

		foreach ($fields as $field)
		{
		   $db->select('mulapress_posts.' . $field);
		}
    	
		$db->from('mulapress_posts');
		$db->join('mulapress_session_manager', 'mulapress_posts.ID = mulapress_session_manager.url');		

		$db->where('mulapress_posts.post_author', $id);
		
		$db->limit($posts, 0);
		
		$db->order_by($this->tabla . '.unixtime', 'ASC');
		
		$query = $db->get();
		//die($db->last_query());
		return $query->result_array();
    }
       
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
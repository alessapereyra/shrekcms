<?php
class Comments extends Model {
	
	var $campos = array();
    var $tabla = 'mulapress_comments';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function get_lastcomments($id, $posts)
    {
        $db = $this->load->database('default', TRUE); 
    	
    	$fields = $db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $db->select($this->tabla . '.' . $field);
		}
		$db->select('mulapress_posts.guid');
    	
		$db->from($this->tabla);
		$db->join('mulapress_posts', 'mulapress_posts.ID = mulapress_comments.comment_post_ID');		

		$db->where('mulapress_posts.post_author', $id);
		
		$db->limit($posts, 0);
		
		$db->order_by($this->tabla . '.comment_date', 'DESC');
		
		$query = $db->get();
		return $query->result_array();
    }
       
}
/* End of file PropertyType.php */
/* Location: ./system/application/model/PropertyType.php */
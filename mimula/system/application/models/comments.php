<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de blogs
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de blogs
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Comments extends Model {
	
    /**
     * Campos de la tabla
     * @var array
     *
     */	
	var $campos = array();
    /**
     * Tabla a utilizar
     * @var array
     *
     */	
    var $tabla = 'mulapress_comments';

	/**
	 * Constructor de la case
	 */     
    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
	/**
	 * Consigue comentarios de un usuario
	 * @param integer $id id del usuario
	 * @return integer 
	 */     
    function total_comments($id){
      
    	$db = $this->load->database('default', TRUE); 
    	
      $db->select('user_id');
      $db->from($this->tabla);
      $db->where('user_id',$id);
      return $db->count_all_results();
    }

	/**
	 * Consigue comentarios echos a un usuario
	 * @param integer $id id del usuario
	 * @return integer 
	 */      
    function total_received_comments($id)
    {
      
    	$db = $this->load->database('default', TRUE);
      $db->select('post_author');
  		$db->from($this->tabla);
  		$db->join('mulapress_posts', 'mulapress_posts.ID = mulapress_comments.comment_post_ID');		
    	$db->where('mulapress_posts.post_author', $id);
    
      return $db->count_all_results();
      
    }
            
	/**
	 * Consigue los ultimos comentarios echo por un usuario
	 * @param integer $id id del usuario
	 * @param integer $posts cantidad de comentarios
	 * @return integer 
	 */      
    function get_lastowncomments($id, $posts)
    {
      
      $db = $this->load->database('default', TRUE); 
    	
	    $fields = $db->list_fields($this->tabla);
	
		  foreach ($fields as $field)
		  {
		    $db->select($this->tabla . '.' . $field);
		  }

	      $db->select('mulapress_posts.guid');
	      $db->select('mulapress_posts.post_title');

  		$db->from($this->tabla);    
  		$db->join('mulapress_posts', 'mulapress_posts.ID = mulapress_comments.comment_post_ID');		    
  		$db->where('user_id', $id);
		
  		$db->limit($posts, 0);
		
  		$db->order_by($this->tabla . '.comment_date', 'DESC');
		
  		$query = $db->get();
  		return $query->result_array();      
    }
    
	/**
	 * Consigue los ultimos comentarios echo por un usuario
	 * @param integer $id id del usuario
	 * @param integer $posts cantidad de comentarios
	 * @return integer 
	 */    
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
/* End of file comments.php */
/* Location: ./system/application/model/comments.php */
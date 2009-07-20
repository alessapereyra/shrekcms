<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de manejador de sesiones
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de manejador de sesiones
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Sessionmanager extends Model {
	
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
    var $tabla = 'wp_1_session_manager';

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
	 * Retorna los ultimos post leido por un usuario
	 * @param integer $id id del usuario
	 * @param integer $posts cantidad de posts a traer
	 * @return array 
	 */     
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
  		return $query->result_array();
    }
    
	/**
	 * Retorna los ultimos post vistos por un usuario
	 * @param integer $id id del usuario
	 * @param integer $posts cantidad de posts a traer
	 * @return array 
	 */       
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
		return $query->result_array();
    }
       
}
/* End of file sessionmanager.php */
/* Location: ./system/application/model/sessionmanager.php */
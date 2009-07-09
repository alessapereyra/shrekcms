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

class Blogs extends Model {
	
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
    var $tabla = 'wp_blogs';

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
	 * Consigue los blogs que no van a portada
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */    
    function get_removed_head_blogs($empty_row = FALSE)
    {
    	$this->db->select('wp_bp_user_blogs.blog_id AS miid', FALSE);
    	$this->db->select('user_nicename AS user', FALSE);
    	$this->db->select('wp_bp_user_blogs_blogmeta.meta_value AS blogname', FALSE);
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_bp_user_blogs', 'wp_bp_user_blogs.blog_id = wp_blogs.blog_id');
    	$this->db->join('wp_users', 'wp_users.ID = wp_bp_user_blogs.user_id');
    	$this->db->join('wp_bp_user_blogs_blogmeta', 'wp_bp_user_blogs_blogmeta.blog_id = wp_bp_user_blogs.blog_id');
    	$this->db->where('headlines',0);
    	$this->db->where('wp_bp_user_blogs_blogmeta.meta_key','name');
    	
		$this->db->order_by('wp_bp_user_blogs_blogmeta.meta_value', 'ASC'); 
  	
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
			$tmp[$row->miid] = $row->blogname . ' - ' . $row->user;
		}
		
		return $tmp;    	
    }
    
	/**
	 * Consigue los blogs que si van a portada
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */       
    function get_head_blogs($empty_row = FALSE)
    {
    	$this->db->select('wp_bp_user_blogs.blog_id AS miid', FALSE);
    	$this->db->select('user_nicename AS user', FALSE);
    	$this->db->select('wp_bp_user_blogs_blogmeta.meta_value AS blogname', FALSE);
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_bp_user_blogs', 'wp_bp_user_blogs.blog_id = wp_blogs.blog_id');
    	$this->db->join('wp_users', 'wp_users.ID = wp_bp_user_blogs.user_id');
    	$this->db->join('wp_bp_user_blogs_blogmeta', 'wp_bp_user_blogs_blogmeta.blog_id = wp_bp_user_blogs.blog_id');
    	$this->db->where('headlines',1);
    	$this->db->where('wp_bp_user_blogs_blogmeta.meta_key','name');

		$this->db->order_by('wp_bp_user_blogs_blogmeta.meta_value', 'ASC'); 
  	
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
			$tmp[$row->miid] = $row->blogname . ' - ' . $row->user;
		}
		
		return $tmp;   	
    }
    
	/**
	 * Consigue los blogs
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */       
    function get_fkblogs($empty_row = FALSE)
    {
    	$this->db->select('wp_bp_user_blogs.blog_id AS miid', FALSE);
    	$this->db->select('user_nicename AS user', FALSE);
    	$this->db->select('wp_bp_user_blogs_blogmeta.meta_value AS blogname', FALSE);
    	
    	$this->db->from($this->tabla);
    	$this->db->join('wp_bp_user_blogs', 'wp_bp_user_blogs.blog_id = wp_blogs.blog_id');
    	$this->db->join('wp_users', 'wp_users.ID = wp_bp_user_blogs.user_id');
    	$this->db->join('wp_bp_user_blogs_blogmeta', 'wp_bp_user_blogs_blogmeta.blog_id = wp_bp_user_blogs.blog_id');

    	$this->db->where('public',1);
    	$this->db->where('archived',"'0'",FALSE);
    	$this->db->where('mature',0);
    	$this->db->where($this->tabla . '.spam',0);
    	$this->db->where($this->tabla . '.deleted',0);
    	$this->db->where('wp_bp_user_blogs_blogmeta.meta_key','name');
    	
    	//$this->db->where_not_in('wp_users.ID', "SELECT mulapress_default_bloggers.blogger_id FROM mulapress_default_bloggers", FALSE);

		$this->db->order_by('wp_bp_user_blogs_blogmeta.meta_value', 'ASC'); 
  	
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
			$tmp[$row->miid] = $row->blogname . ' - ' . $row->user;
		}
		
		return $tmp;
    }
    
	/**
	 * Actualiza un registro
	 * @param array $values valores a cambiar
	 * @param array $where id o dato del registro
	 * @return void 
	 */       
    function actualizar($values, $where)
    {
        $this->db->update($this->tabla, $values, $where);
    }    
}
/* End of file blogs.php */
/* Location: ./system/application/model/blogs.php */
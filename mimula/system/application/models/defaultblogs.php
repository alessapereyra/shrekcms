<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de defaultblogs
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de defaultblogs
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Defaultblogs extends Model {
	
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
    var $tabla = 'mulapress_default_blogs';

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
	 * Consigue los blogs by default
	 * @param boolean $empty_row primera fila en blanco del combo
	 * @return array 
	 */     
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
    
	/**
	 * Inserta un registro
	 * @param array $values valores a cambiar
	 * @return void 
	 */     
    function insertar($values)
    {
		$this->db->insert($this->tabla, $values);    		    	
    }

	/**
	 * borra un registro
	 * @param array $values valores a borrar
	 * @return void 
	 */     
    function borrar($values)
    {
    	$this->db->where($values);
    	$this->db->limit(1, 0);
    	$this->db->delete($this->tabla);
    }    
    
}


/* End of file countries.php */
/* Location: ./system/application/model/countries.php */
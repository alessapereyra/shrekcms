<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de usuarios
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de usuarios
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */


class Users extends Model {
	
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
    var $tabla = 'wp_users';

	/**
	 * Constructor de la case
	 */       
    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('lamula');        
    }
    
	/**
	 * Aprueba y desaprueba usuarios
	 * @param integer $aproved id del usuario a aprobar
	 * @param integer $desaproved id del usuario a desaprobar
	 * @return void 
	 */      
    function approve($aproved, $desaproved)
    {
    	$values['aproved'] = 1;
    	
    	$this->db->where_in('ID', $aproved);
    	$this->db->update($this->tabla, $values);

    	$values['aproved'] = 0;
    	
    	$this->db->where_in('ID', $desaproved);
    	$this->db->update($this->tabla, $values);
    	
    }
    
	/**
	 * Retorna una o más instancias del modelo
	 * @param array $search terminos de busqueda
	 * @param array $limit cantidad de registros a retornar
	 * @return array 
	 */       
    function seleccionar($search = NULL, $limit = NULL)
    {
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($field);
		}

  		$this->db->from($this->tabla);
		
    	
    	if ($search != NULL)
    	{
    		$this->db->where($search);
    	}

        if ($limit != NULL)
    	{
    		$this->db->limit($limit['show'], $limit['from']);
    	}
    	    	
        $query = $this->db->get();
        return $query;
    }
    
	/**
	 * Retorna el total de usuarios
	 * @return integer
	 */     
    function count_all()
    {
    	return $this->db->count_all($this->tabla);
    }
    
	/**
	 * Retorna una o más instancias del modelo
	 * @param array $limit registros a traer
	 * @return array 
	 */     
    function get_view($limit = NULL)
    {
		$this->db->select('ID');
		$this->db->select('user_login');
		$this->db->select('user_url');
		$this->db->select('aproved');
		
  		$this->db->from($this->tabla);
    	
        if ($limit != NULL)
    	{
    		$this->db->limit($limit['show'], $limit['from']);
    	}
    	
    	$this->db->order_by('user_login', 'ASC');
    	    	
        $users = $this->db->get();
        
		foreach ($users->result() as $row)
		{
			$actual_users[] = $row->ID;
		}
		
		
		$this->db->select('user_id');
		$this->db->select('meta_key');
		$this->db->select('meta_value');

		$this->db->from('wp_usermeta');
		
		$this->db->where("(`meta_key` = 'dni' OR `meta_key` = 'telefono' OR `meta_key` = 'first_name' OR `meta_key` = 'last_name')");
		
		$this->db->where_in('user_id', $actual_users);
		
		//$this->db->order_by('user_id', 'ASC');
		
		$user_meta = $this->db->get();
		
		$tmp['users'] = $users;
		$tmp['user_meta'] = $user_meta;
		
		return $tmp;
        
    }
    
	/**
	 * Inserta un registro
	 * @param array $values valores a insertar
	 * @return void 
	 */      
    function insertar($values)
    {	  
        $this->db->insert($this->tabla, $values);
        
        $query = $this->seleccionar(array('user_login' => $values['user_login']));
        $query = $query->row();
        
        return $query->ID;
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
/* End of file users.php */
/* Location: ./system/application/model/users.php */
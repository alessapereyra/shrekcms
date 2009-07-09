<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de options
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de options
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */


class Options extends Model {
	
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
    var $tabla = 'mulapress_options';

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
	 * Retorna una opcion
	 * @param string $value nombre de la opcion a devolver
	 * @return string 
	 */     
    function get_($value)
    {
    	$this->db->select('option_value');
    	$this->db->from($this->tabla);
    	$this->db->where(array('option_name' => $value));
    	
    	$query = $this->db->get();
    	$query = $query->row_array();
    	return $query['option_value'];
    }

	/**
	 * Retorna el id de una opcion
	 * @param string $value nombre de la opcion a devolver
	 * @return integer 
	 */     
    function get_id_($value)
    {
    	$this->db->select('option_id');
    	$this->db->from($this->tabla);
    	$this->db->where(array('option_name' => $value));
    	
    	$query = $this->db->get();
    	$query = $query->row_array();
    	return $query['option_id'];
    }  

	/**
	 * Actualiza un registro
	 * @param array $values valores a cambiar
	 * @param array $where id o dato del registro
	 * @return void 
	 */      
    function actualizar($values, $where)
    {
		$tmp['option_id'] = $where;
        $this->db->update($this->tabla, $values, $tmp);
    }     

}


/* End of file options.php */
/* Location: ./system/application/model/options.php */
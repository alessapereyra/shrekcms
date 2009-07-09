<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de encabezados de las noticias
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de encabezados de las noticias
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */


class News_Header extends Model {
	
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
	var $tabla = 'mulapress_news_headers';

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
	 * Actualiza un registro
	 * @param array $values valores a cambiar
	 * @param array $where id o dato del registro
	 * @return void 
	 */     
    function actualizar($values)
    {	
    	
    	$this->load->database();    	
      $where['id'] = $values["id"];
      $result = $this->db->update($this->tabla, $values, $where);
    	
    }
    
	/**
	 * Obtiene un encabezado
	 * @param integer $id id a retornar
	 * @return array 
	 */      
    function opcion($id){

      	$this->load->database();

      	$fields = $this->db->list_fields($this->tabla);

  		foreach ($fields as $field)
  		{
  		   $this->db->select($field);
  		}

      	$this->db->from($this->tabla);
      	$this->db->where('id',$id);
      	$this->db->limit(1, 0);     	

        $query = $this->db->get();
    		$header = $query->result_array();
    		$header = current($header);
   
        return $header;   
    }
   
}

/* End of file news_header.php */
/* Location: ./system/application/model/news_header.php */
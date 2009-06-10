<?php
class News_Header extends Model {
	
	var $tabla = 'mulapress_news_headers';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    
    function actualizar($values)
    {	
    	
    	$this->load->database();    	
      $where['id'] = $values["id"];
      $result = $this->db->update($this->tabla, $values, $where);
    	
    }
    
    function opcion($id){

      	$this->load->database();

      	$fields = $this->db->list_fields($this->tabla);

  		foreach ($fields as $field)
  		{
  		   $this->db->select($field);
  		}

      	$this->db->from($this->tabla);
      	$this->db->where('id',$id);      	

        $query = $this->db->get();
    		$header = $query->result_array();
    		$header = current($header);
    		
//        die(print_r($query));
        return $header;
      
      
    }
    
    function seleccionar()
    {
    	$this->load->database();
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($field);
		}

    	$this->db->from($this->tabla);
    	
    	$this->db->orderby('minimo','DESC');
    	
        $query = $this->db->get();
        return $query;
    }
   
}
?>
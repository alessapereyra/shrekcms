<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de banderas
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de banderas
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Flag extends Controller {

	/**
	 * Marca como ofensiva una noticia
	 * @return void 
	 */		
	function flag_this()
	{
		$FLAG_COUNT = 5;
		$id = $this->input->post('id');		
		$this->load->helper('inflector');		
		$this->load->model('post');
		$post = $this->post->seleccionar(array('ID' => $id));
	  $post = $post->result_array();
	  $post = current($post);

	  //gets current post offensive votes
		$new_count = $post['offensive_votes'];
		
		//we add one
		$new_count += 1;

		$data['flagged'] = false;		
		
		if ($new_count > $FLAG_COUNT)
    {
      
      $values['post_status'] = "draft";
		  $data['flagged'] = true;      
    }
    
    $values['offensive_votes'] = $new_count;
		$data['offensive_votes'] = $new_count;
		$this->post->actualizar_count($values,array('ID' => $id));
		
		$this->load->view('articulos/flagged', $data);
	}
}


/* End of file flag.php */
/* Location: ./system/application/controllers/flag.php */
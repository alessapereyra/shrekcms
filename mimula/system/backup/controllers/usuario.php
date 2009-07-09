<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de usuario
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de usuario
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Usuario extends DI_Controller {

	/**
	 * Muestra el perfil del usuario
	 * @return void 
	 */		
	function perfil()
	{			

		$this->load->library('session');
		$this->load->model('terms');
		$this->load->model('post');
		
		$id = $this->session->userdata('id');
		
		//consigue los ultimos post
		$data['posts'] = $this->post->get_lastpost($id, 5);


		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('usuario/perfil', $data);
		$this->__destruct();
	}
}

/* End of file monedas.php */
/* Location: ./system/application/controllers/backend/monedas.php */
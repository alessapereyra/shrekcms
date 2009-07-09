<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador del home
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador del home
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */


class Home extends DI_Controller {
	
	/**
	 * Muestra dashboard
	 * @param integer $id id de un articulo
	 * @param boolean $ie6 es Internet Explorer 6
	 * @return void 
	 */	
	function dashboard()
	{
		$this->load->model('users');
		$this->load->model('usermeta');
		    
		$this->load->model('terms');
		$this->load->model('sessionmanager');
		$this->load->model('comments');
		$this->load->model('post');

    	$this->load->helper('url');
    	
    	$this->load->library('session');
    	
    	$id = $this->session->userdata('id');

    	$limit['from'] = 0;
    	$limit['show'] = 25;
    	
  		$data['myposts'] = $this->post->get_mypost($id, $limit);
  		$data['myposts'] = $data['myposts']->result_array();

		$this->load->view('home/myposts', $data);
					
		$this->__destruct();
	}
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
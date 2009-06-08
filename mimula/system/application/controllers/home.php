<?php

class Home extends DI_Controller {
	
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
    	$limit['show'] = 5;
    	
  		$data['myposts'] = $this->post->get_mypost($id, $limit);
  		$data['myposts'] = $data['myposts']->result_array();

		$this->load->view('home/myposts', $data);
					
		$this->__destruct();
	}
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
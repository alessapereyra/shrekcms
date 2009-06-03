<?php

class Home extends DI_Controller {
	
	function index()
	{
		$this->load->view('home');
		$this->__destruct();
	}
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
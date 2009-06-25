<?php

class Log extends DI_Controller {

	var $usuario = array();
	
	function __construct()
	{
		parent::__construct();

		$this->usuario['id'] = NULL;
		$this->usuario['usuario'] = NULL;
		$this->usuario['nombre'] = NULL;
	}
	
	function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['destino'] = $this->session->userdata('url') != NULL ? $this->session->userdata('url'): $this->config->item('default_controller');
		$data['usuario'] = NULL;
		$data['info'] = $this->error;
		
		$this->load->view('login/formulario', $data);
		$this->__destruct();		
	}
	
	function login()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules($this->_reglas());
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['destino'] = $this->input->post('destino');			
			$this->load->view('login/formulario', $data);
			$this->__destruct();			
		}
		else
		{
			$this->session->set_userdata('url', '');
			
			redirect($this->input->post('destino'));		
		}					
	}
	
	function olvido()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->load->view('login/olvido');
		$this->__destruct();		
	}
	
	function recuperar()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->library('form_validation');

		$reglas[] = array('field'   => 'usuario', 'label'   => 'lang:field_usuario', 'rules'   => 'trim|required|min_length[4]|max_length[20]|callback_usuario_check'); 
		
		$this->form_validation->set_rules($reglas);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{			
			$this->load->view('login/olvido');
			$this->__destruct();			
		}
		else
		{
			$this->load->helper('string');
			$new_pass = random_string('alnum', 8);
			
			$this->load->model('users');
			
			$data['password'] = md5($new_pass);
			$where['usuario'] = $this->input->post('usuario');
			
			$this->users->actualizar($data, $where);
			
			$user = $this->users->seleccionar(array('usuario' => $this->input->post('usuario')));
			$user = $user->row_array();

			$this->load->library('email');
			$email = $this->config->item('retrieve_password');

			$this->email->from($email['from_email'], $email['from_name']);
			$this->email->to($user['email']);

			$this->email->subject($email['subject']);
			$this->email->message($email['message'] . $new_pass);
			
			$this->email->send();
			
			$this->session->set_userdata($this->usuario);
			$this->session->set_userdata('info', 'Un email ha sido enviado a su casilla de correo con la nueva contraseña.');
			redirect('/log');	
		}			
	}	

	function _reglas()
	{
		$reglas[] = array('field'   => 'password', 'label'   => 'lang:field_password', 'rules'   => 'trim|required|md5');
		$reglas[] = array('field'   => 'usuario', 'label'   => 'lang:field_usuario', 'rules'   => 'trim|required|min_length[4]|max_length[20]|callback_password_check');	
		return $reglas;
	}

	function usuario_check($value)
	{
		$this->load->model('users');

		$consulta = $this->users->seleccionar(array('usuario' => $value));
		
		if ($consulta->num_rows() > 0)		
		{
			return true;
		}
		else
		{
			return false;
		}			
	}
		
	function password_check($value)
	{

		$this->load->model('users');
		
		$consulta = $this->users->seleccionar(array('user_login' => $value ));
		
		if ($consulta->num_rows() == 1)
		{
			$fila = $consulta->row();
			
			$this->load->library('passwordhasher');
			$this->passwordhasher->passwordhash(8, TRUE);
			
			//die ($this->input->post('password'). ' ' . $fila->user_pass);
			
			if ( $this->passwordhasher->CheckPassword($this->input->post('password'), $fila->user_pass) )
			{
				$this->usuario['id'] = $fila->ID;
				$this->usuario['usuario'] = $fila->user_login;
				$this->usuario['nombre'] = $fila->user_nicename;
				
				$this->load->library('wpcookies');
				$this->wpcookies->set($fila->user_login);				

				$this->session->set_userdata($this->usuario);
				return TRUE;
			}

		}
		
		return FALSE;			   			
	}
		
	function logout()
	{
		$this->session->set_userdata($this->usuario);
		$this->session->set_userdata('info', 'Salio OK!');

		$this->load->library('wpcookies');
		$this->wpcookies->un_set();		
		
		redirect('/log');
	}
}
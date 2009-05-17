<?php

class Usuarios extends Controller {
	
	function formulario($id = NULL)
	{
		$data['id'] = NULL;
		$data['url'] = NULL;
		$data['usuario'] = NULL;	
		$data['email'] = NULL;
		
		if ($id != NULL)
		{
			$data = $this->_show($id, $data);
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$tmp = $this->config->item('post_content');
		
		$this->load->view('layout/' . $tmp['head'], array('seccion' => 'Registrate'));
		$this->load->view('layout/' . $tmp['menu'], array('log' => FALSE));
		
		$this->load->view('usuarios/formulario', $data);
		
		$this->load->view('layout/' . $tmp['footer']);
	}
	
	function actualizar()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules($this->_reglas());
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['id'] = $this->input->post('id');
			//$data['url'] = set_value('url');
			$data['usuario'] = set_value('usuario');		
			$data['email'] = set_value('email');

			$tmp = $this->config->item('post_content');
			
			$this->load->view('layout/' . $tmp['head'], array('seccion' => 'Registrate'));
			$this->load->view('layout/' . $tmp['menu'], array('log' => FALSE));			
			$this->load->view('usuarios/formulario', $data);
			$this->load->view('layout/' . $tmp['footer']);			
		}
		else
		{
			$this->load->model('users');
			$this->load->model('usermeta');
			
			$this->load->library('passwordhasher');
			$this->passwordhasher->passwordhash(8, TRUE);			
			
			//lleno el primer data
			$id = $this->input->post('id');
			$data['user_login'] = $this->input->post('usuario');
			$data['user_pass'] = $this->passwordhasher->HashPassword($this->input->post('password'));
			$data['user_nicename'] = $data['user_login'];
			$data['user_email'] = $this->input->post('email');
			//$data['user_url'] = $this->input->post('url');
			$data['user_registered'] = date('Y-m-d G:i:s');
			$data['user_activation_key'] = '';
			$data['user_status'] = 0;
			$data['display_name'] = $data['user_login'];
			
			if ($id == NULL)
			{
				$id = $this->users->insertar($data);
				
				$meta[] = array('meta_key' => 'nickname', 'meta_value' => $data['user_login']);
				$meta[] = array('meta_key' => 'rich_editing', 'meta_value' => 'true');
				$meta[] = array('meta_key' => 'comment_shortcuts', 'meta_value' => 'false');
				$meta[] = array('meta_key' => 'admin_color', 'meta_value' => 'fresh');
				$meta[] = array('meta_key' => 'wp_capabilities', 'meta_value' => 'a:1:{s:11:"contributor";b:1;}');
				$meta[] = array('meta_key' => 'wp_user_level', 'meta_value' => 1);
				$meta[] = array('meta_key' => 'wp_usersettings', 'meta_value' => 'm0=o&m1=o&m2=c&m3=c&m4=c&m5=c&m6=c&m7=c&m8=o&imgsize=thumbnail&urlbutton=urlfile');
				$meta[] = array('meta_key' => 'wp_usersettingstime', 'meta_value' => '1241715323');
				
				//aqui se irian agregando mas datos
				$this->usermeta->insertar($meta, $id);	
			}
			else
			{
				//modificacion, no implementado todavia
				//$where['id'] = $id;
				//$this->users->actualizar($data, $where);
				//arma los meta
				//$this->usermeta->actualizar($meta, $id);
				
			}
			
			redirect('');
		}			
	}

	function _show($id, $data)
	{
		$this->load->model('users');
		$consulta = $this->users->seleccionar(array('id' => $id));
		if ($consulta->num_rows() > 0)
		{
		   $fila = $consulta->row();
		
		   $data['id'] = $fila->id;
		   $data['nombre'] = $fila->nombre;
		   $data['usuario'] = $fila->usuario;
		   $data['email'] = $fila->email;
		} 
		return $data;		
	}
	
	function _reglas()
	{
		$tmp['usuario'] = "trim|required|min_length[4]|max_length[20]";

		//$reglas[] = array('field'   => 'url', 'label'   => 'lang:field_url', 'rules'   => 'trim|required|min_length[4]|max_length[40]');
		$reglas[] = array('field'   => 'email', 'label'   => 'lang:field_email', 'rules'   => 'trim|required|min_length[5]|valid_email');

		if ($this->input->post('id') == NULL) {
			$tmp['usuario'] .= '|callback_usuario_exist';
			$reglas[] = array('field'   => 'password', 'label'   => 'lang:field_password', 'rules'   => 'trim|required|matches[password_check]');			  
			$reglas[] = array('field'   => 'password_check', 'label'   => 'lang:field_password_check', 'rules'   => 'trim|required');			
		}
		else
		{
			if (($this->input->post('password') != '') || ($this->input->post('password_check') != ''))
			{
				$reglas[] = array('field'   => 'password', 'label'   => 'lang:field_password', 'rules'   => 'trim|required|matches[password_check]');			  
				$reglas[] = array('field'   => 'password_check', 'label'   => 'lang:field_password_check', 'rules'   => 'trim|required');			
			}
		}
		
		$reglas[] = array('field'   => 'usuario', 'label'   => 'lang:field_usuario', 'rules'   => $tmp['usuario']);
		
		return $reglas;
	}
	
	function usuario_exist($value)
	{
		$this->load->model('users');
				
		$consulta = $this->users->seleccionar(array('user_login' => $value));
		
		if ($consulta->num_rows() > 0)		
		{
			return false;
		}
		else
		{
			return true;
		}			
	}
}

/* End of file usuarios.php */
/* Location: ./system/application/controllers/usuarios.php */
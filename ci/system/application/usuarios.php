<?php

class Usuarios extends Controller {
	
	
	var $usuario = array();
	
	function formulario($id = NULL)
	{

  	$this->usuario['id'] = NULL;
  	$this->usuario['usuario'] = NULL;
  	$this->usuario['nombre'] = NULL;

		$data['id'] = NULL;
		$data['url'] = NULL;
		$data['usuario'] = NULL;	
		$data['email'] = NULL;
		$data['current_controller'] = $this->uri->segment(1);		
		
		if ($id != NULL)
		{
			$data = $this->_show($id, $data);
		}


		$this->load->library('session');		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$tmp = $this->config->item('post_content');
		
		$this->load->view('layout/' . $tmp['head'], array('log' => FALSE,'seccion' => 'Registrate', 'ie6' => $this->_is_ie6()));
    // $this->load->view('layout/' . $tmp['menu'], array('log' => FALSE, 'ie6' => $this->_is_ie6(), 'current_controller' => $this->uri->segment(1) ));
		
		$this->load->view('usuarios/formulario', $data);
		
		$this->load->view('layout/' . $tmp['footer']);
	}
	
	function perfil(){

		$this->load->library('session');
    $usuario = $this->session->userdata('usuario');
    $id = $this->session->userdata('id'); 
    
  	$data['id'] = NULL;
		$data['url'] = NULL;
		$data['usuario'] = NULL;	
		$data['email'] = NULL;
		$data['nombre_completo'] = NULL;
		$data['telefono'] = NULL;	
		$data['descripcion'] = NULL;
		$data['dni'] = NULL;		
    $data['perfil_address'] = "http://lamula.pe/mulapress/author/" . $usuario; // la direccion!!
		
		$data['current_controller'] = $this->uri->segment(1);		

		if ($id != NULL)
		{
			$data = $this->_show($id, $data);
		}
  		    
  	$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$tmp = $this->config->item('post_content');

		
	  $this->load->view('layout/' . $tmp['head'], array('log' => FALSE,'seccion' => 'Creando Perfil', 'ie6' => $this->_is_ie6()));
		$this->load->view('usuarios/perfil', $data);		
		$this->load->view('layout/' . $tmp['footer']);
		
    
	  
	}
	
	function grabar_perfil(){

		$this->load->helper('url');
		$this->load->helper('form');
	  $this->load->library('form_validation');
		$this->form_validation->set_rules($this->_reglas_perfil());
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
    	if ($this->form_validation->run() == FALSE)
  		{
  			$data['id'] = $this->input->post('id');
    		$data['nombre_completo'] =  $this->input->post('nombre_completo');
    		$data['descripcion'] =  $this->input->post('descripcion');
    		$data['url'] = $this->input->post('url');
    		$data['dni'] =  $this->input->post('dni');
    		$data['telefono'] =  $this->input->post('telefono');
      		  			
  			$tmp = $this->config->item('post_content');

  			$this->load->view('layout/' . $tmp['head'], array('seccion' => 'Registrate'));
  			$this->load->view('layout/' . $tmp['menu'], array('log' => FALSE, 'ie6' => $this->_is_ie6(), 'current_controller' => $this->uri->segment(1)));			
  			$this->load->view('usuarios/formulario', $data);
  			$this->load->view('layout/' . $tmp['footer']);			
  		}
  		else
  		{
  			$this->load->model('users');
  			$this->load->model('usermeta');

  			//lleno el primer data
  			$id = $this->input->post('id');
  			$data['id'] = $this->input->post('id');
    		$data['nombre_completo'] =  $this->input->post('nombre_completo');
    		$data['descripcion'] =  $this->input->post('descripcion');
    		$data['url'] = $this->input->post('url');
    		$data['dni'] =  $this->input->post('dni');
    		$data['telefono'] =  $this->input->post('telefono');

				$meta[] = array('meta_key' => 'nombre_completo', 'meta_value' => $data['nombre_completo']);
				$meta[] = array('meta_key' => 'descripcion', 'meta_value' => $data['descripcion']);
				$meta[] = array('meta_key' => 'url', 'meta_value' => $data['url']);
				$meta[] = array('meta_key' => 'dni', 'meta_value' => $data['dni']);
				$meta[] = array('meta_key' => 'telefono', 'meta_value' => $data['telefono']);

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

      	$this->load->library('session');
        $usuario = $this->session->userdata('usuario');

  			redirect("http://lamula.pe/mulapress/author/" . $usuario;);		

  		}	  
	  
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
  		$data['current_controller'] = $this->uri->segment(1);		

			$tmp = $this->config->item('post_content');
			
			$this->load->view('layout/' . $tmp['head'], array('seccion' => 'Registrate'));
			$this->load->view('layout/' . $tmp['menu'], array('log' => FALSE, 'ie6' => $this->_is_ie6(), 'current_controller' => $this->uri->segment(1)));			
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
			$telefono = $this->input->post('telefono');
			$dni = $this->input->post('dni');			
			
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
				$meta[] = array('meta_key' => 'telefono', 'meta_value' => $telefono);
				$meta[] = array('meta_key' => 'dni', 'meta_value' => $dni);

				
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
  		$this->load->library('session');

  		$data['destino'] = $this->session->userdata('url') != NULL ? $this->session->userdata('url'): "articulos/formulario";

			$this->session->set_userdata('url', '');

			$this->usuario['id'] = $id;
			$this->usuario['usuario'] = $data['user_login'];
			$this->usuario['nombre'] = $data['user_nicename'];

			$this->session->set_userdata($this->usuario);

			redirect($data['destino']);		
			
		}			
	}

	function _show($id, $data)
	{
		$this->load->model('users');
		echo $id; 
		$consulta = $this->users->seleccionar(array('id' => $id));
		if ($consulta->num_rows() > 0)
		{
		   $fila = $consulta->row();
		
		   $data['id'] = $id;
		   $data['nombre'] = $fila->user_login;
		   $data['usuario'] = $fila->user_nicename;
		   $data['email'] = $fila->user_email;
		} 
		return $data;		
	}
	
	function _reglas()
	{
		$tmp['usuario'] = "trim|required|min_length[4]|max_length[40]";

		//$reglas[] = array('field'   => 'url', 'label'   => 'lang:field_url', 'rules'   => 'trim|required|min_length[4]|max_length[40]');
		$reglas[] = array('field'   => 'email', 'label'   => 'lang:field_email', 'rules'   => 'trim|required|min_length[5]|valid_email');
		$reglas[] = array('field'   => 'dni', 'label'   => 'lang:field_dni', 'rules'   => 'trim|required|min_length[8]');
		$reglas[] = array('field'   => 'telefono', 'label'   => 'lang:field_telefono', 'rules'   => 'trim|required|min_length[6]');


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
	
	function _reglas_perfil()
	{
		//$reglas[] = array('field'   => 'url', 'label'   => 'lang:field_url', 'rules'   => 'trim|required|min_length[4]|max_length[40]');
		$reglas[] = array('field'   => 'dni', 'label'   => 'lang:field_dni', 'rules'   => 'trim|required|min_length[8]');
		$reglas[] = array('field'   => 'telefono', 'label'   => 'lang:field_telefono', 'rules'   => 'trim|required|min_length[6]');
				
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
	
	function _is_ie6()
	{
		$this->load->library('user_agent');
		
		if ($this->agent->is_browser())
		{
			if ( ($this->agent->browser() == 'Internet Explorer') AND ($this->agent->version() == 6) )
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}	
}

/* End of file usuarios.php */
/* Location: ./system/application/controllers/usuarios.php */
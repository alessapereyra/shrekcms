<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de logeo
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de logeo
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Usuarios extends DI_Controller {
	
    /**
     * Datos del usuario
     * @var array
     */		
	var $usuario = array();
	
	/**
	 * Setea las reglas de validacion para el formulario
	 * @return array 
	 */		
	function reglas()
  {
  
		$this->load->helper('url');
    	$tmp = $this->config->item('post_content');

  		$this->load->view('layout/' . $tmp['head'], array('log' => FALSE,'seccion' => 'Registrate', 'ie6' => $this->_is_ie6()));
      // $this->load->view('layout/' . $tmp['menu'], array('log' => FALSE, 'ie6' => $this->_is_ie6(), 'current_controller' => $this->uri->segment(1) ));

  		$this->load->view('usuarios/reglas', $data);

  		$this->load->view('layout/' . $tmp['footer']);

  
  }	

	/**
	 * Muestra los usuaris actuales
	 * @param integer $page numero de pagina
	 * @param integer $perpage registros por pagina 
	 * @return void 
	 */	  
	function verificado($page = 1, $per_page = NULL)
	{
		
		$data['page'] = $page;
		$data['per_page'] = $per_page;
				
		$this->load->helper('form');
		$this->load->library('form_validation');
				
		if ($per_page == NULL)
		{
			$per_page = $this->config->item('per_page');
		}
		
		$this->load->model('users');
		
		//arma el paginador
		$total = $this->users->count_all();
		$data['paginador'] = $this->_paginador($total, $per_page);
		$data['selector'] = $this->pagination->create_selector($per_page);
		
		//calcula cuantos mostrar
		$limit['show'] = $per_page;
		$limit['from'] = ($page - 1) * $per_page;
		
		//consulta
		$tmp = $this->users->get_view($limit);
		$data['users'] = $tmp['users'];
		$data['user_meta'] = $tmp['user_meta'];

		$data['users'] = $data['users']->result_array();
		$data['user_meta'] = $data['user_meta']->result_array();
		
		$data['error'] = $this->error;
		
		$this->load->view('usuarios/verificado', $data);
		
		$this->__destruct();
	}
	
	/**
	 * Verifica o no los usuarios
	 * @return void 
	 */		
	function verificar()
	{
		$bloggers = $this->input->post('user_id');
		$aproveds = $this->input->post('aproved');
		$total = count($bloggers);
		
		for($x=1; $x <= $total; $x++)
		{
			if ( isset($aproveds[$x]))
			{
				$is_aproved[] = $bloggers[$x];
			}
			else
			{
				$is_desaproved[] = $bloggers[$x];	
			}
		}
		
		$this->load->model('users');
		$this->users->approve($is_aproved, $is_desaproved);
		
		redirect('usuarios/verificado/' . $this->input->post('page') . '/' . $this->input->post('per_page'));
	}
	
	/**
	 * Muestra el formulario para agregar/editar un usuario
	 * @param integer $id id de un articulo
	 * @return void 
	 */		
	function formulario($id = NULL)
	{

  	$this->usuario['id'] = NULL;
  	$this->usuario['usuario'] = NULL;
  	$this->usuario['nombre'] = NULL;

		$data['id'] = NULL;
		$data['dni'] = NULL;
		$data['url'] = NULL;
		$data['usuario'] = NULL;	
		$data['email'] = NULL;
		$data['reglas'] = NULL;
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
	
	/**
	 * Muestra el formulario para modificar los titulares y varias cosas mas
	 * @return void 
	 */			
	function titulares()
	{
	  
		$this->load->library('session');
		$this->load->library('combofiller');
		
		$usuario = $this->session->userdata('usuario');
		$id = $this->session->userdata('id');
		
		$data['blogs'] = $this->combofiller->bloggers();
		$data['defaultsblogs'] = $this->combofiller->defaultsblogs();
		
		$data['head_blogs'] = $this->combofiller->head_blogs();
		$tmp = $this->combofiller->removed_head_blogs();
		if ($tmp != NULL)
		{
			$data['removed_head_blogs'] = $tmp;
		}
		else
		{
			$data['removed_head_blogs'] = array();
		}
		//$data['removed_head_blogs'] = $this->combofiller->removed_head_blogs();		

		$this->load->model('news_header');
		$this->load->model('options');

		$header_types = array(
                      'blog'  => 'Un Blog',
                      'post'    => 'Un Post',
                      'most_voted'   => 'La más votada',
                      'most_commented' => 'La más comentada',
                      'special_blogs' => 'De la red',                      
                      'featured' => 'La destacada',
                      'random_blog' => 'Cualquier Blog'
                    );

		$data['id'] = NULL;    
		$data['header_types'] = $header_types;
		$data['random'] = $this->options->get_('bloggers_random');
    
    $header_1 = $this->news_header->opcion(1);
    $header_2 = $this->news_header->opcion(2);
    $header_3 = $this->news_header->opcion(3);
    $header_4 = $this->news_header->opcion(4);
    $header_5 = $this->news_header->opcion(5);
    
		$data['header_1_type'] = $header_1['header_type'];
		$data['header_1_value'] = $header_1['header_source'];
		$data['header_2_type'] = $header_2['header_type'];
		$data['header_2_value'] = $header_2['header_source'];
		$data['header_3_type'] = $header_3['header_type'];
		$data['header_3_value'] = $header_3['header_source'];
		$data['header_4_type'] = $header_4['header_type'];
		$data['header_4_value'] = $header_4['header_source'];
		$data['header_5_type'] = $header_5['header_type'];
		$data['header_5_value'] = $header_5['header_source'];
    

  	$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$tmp = $this->config->item('post_content');
	  
	  
    $this->load->view('layout/' . $tmp['head'], array('log' => FALSE,'seccion' => 'Titulacion', 'ie6' => $this->_is_ie6()));
		
		$this->load->view('usuarios/titulares', $data);
		
		$this->load->view('layout/' . $tmp['footer']);	  
	  
	}

	/**
	 * Actualiza los titulares
	 * @return void 
	 */			
	function enviar_titulares(){
	  
	  $this->load->library('session');
    $usuario = $this->session->userdata('usuario');
    $id = $this->session->userdata('id'); 


    $header_types = array(
                      'blog'  => 'Un Blog',
                      'post'    => 'Un Post',
                      'most_voted'   => 'La más votada',
                      'most_commented' => 'La más comentada',
                      'special_blogs' => 'De la red',                      
                      'feature' => 'La destacada',
                      'random_blog' => 'Cualquier Blog'
                    );

  	$data['id'] = NULL;    
    $data['header_types'] = $header_types;

  	$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$tmp = $this->config->item('post_content');
	  		
		$this->load->model('news_header');
			
		//lleno el primer data
		$data_1['id'] = 1;
		$data_1['header_type'] = $this->input->post('header_1_type');
		$data_1['header_source'] = $this->input->post('header_1_value');
    $this->news_header->actualizar($data_1);

		$data_2['id'] = 2;
		$data_2['header_type'] = $this->input->post('header_2_type');
		$data_2['header_source'] = $this->input->post('header_2_value');
    $this->news_header->actualizar($data_2);


		$data_3['id'] = 3;
		$data_3['header_type'] = $this->input->post('header_3_type');
		$data_3['header_source'] = $this->input->post('header_3_value');
    $this->news_header->actualizar($data_3);

		$data_4['id'] = 4;
		$data_4['header_type'] = $this->input->post('header_4_type');
		$data_4['header_source'] = $this->input->post('header_4_value');
    $this->news_header->actualizar($data_4);

		$data_5['id'] = 5;
		$data_5['header_type'] = $this->input->post('header_5_type');
		$data_5['header_source'] = $this->input->post('header_5_value');
    $this->news_header->actualizar($data_5);

			
  	$this->load->library('session');
		$this->session->set_flashdata('notice', 'Titulares establecidos en LaMula.');	
		redirect('usuarios/titulares');
	  
	  
	}
	
	/**
	 * Muestra el perfil de un usuario
	 * @return void 
	 */			
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

	/**
	 * Actualiza la cantidad de usuarios que aparecen de forma random
	 * @return void 
	 */			
	function actualizar_random()
	{
		$this->load->helper('url');
		$this->load->model('options');
		$this->load->library('session');
		$this->load->helper('form');

		$this->load->library('form_validation');
		
		$reglas[] = array('field'   => 'random', 'label'   => 'lang:field_random', 'rules'   => 'trim|required|is_natural_no_zero');
		
		$this->form_validation->set_rules($reglas);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		
		if ($this->form_validation->run() == FALSE)
		{		
		
			$this->session->set_flashdata('random', 'Ingrese un valor numero');
			$this->session->set_flashdata('value', '');
		}
		else
		{
			$id = $this->options->get_id_('bloggers_random');
			$data['option_value'] = $this->input->post('random');
		
			$this->options->actualizar($data, $id);
		
			$this->session->set_flashdata('random', 'Cantidad cambiada con exito');
		}
		redirect("usuarios/titulares");
	}
	
	/**
	 * Actualiza los usuarios que aparecen en el home
	 * @return void 
	 */			
	function actualizar_muleros()
	{
		$this->load->library('session');
		$this->load->helper('url');
		
		switch ($this->input->post('update_blog'))
		{
			case 'Agregar':
				if ($this->input->post('add_blog') != 'null')
				{
					$data['blog_id'] = $this->input->post('add_blog');
					
					$this->load->model('defaultblogs');
					$this->defaultblogs->insertar($data);
					
					$this->session->set_flashdata('blogger', 'Blog agregado con exito');
					
				}
			break;
			case 'Remover':
				if ($this->input->post('remove_blog') != 'null')
				{
					$data['id'] = $this->input->post('remove_blog');
					
					$this->load->model('defaultblogs');
					$this->defaultblogs->borrar($data);
					
					$this->session->set_flashdata('blogger', 'Blogger borrado con exito');
					
				}
			break;
			default:
				die('NO TOQUES TE DIJE');
		}
		redirect("usuarios/titulares");
	}
	
	/**
	 * Actualiza los blog que no salen en portada
	 * @return void 
	 */			
	function actualizar_portada()
	{
		$this->load->library('session');
		$this->load->helper('url');
		
		switch ($this->input->post('healines_blog'))
		{
			//Agrega un blog a portada
			case 'Agregar':
				if ($this->input->post('add_head_blog') != 'null')
				{
					$where['blog_id'] = $this->input->post('add_head_blog');
					$values['headlines'] = 1;
					
					$this->load->model('blogs');
					$this->blogs->actualizar($values, $where);
					
					$this->session->set_flashdata('headlines', 'Blog agregado con exito');
					
				}
			break;
			
			//Quita un blog de portada
			case 'Remover':
				if ($this->input->post('remove_head_blog') != 'null')
				{
					$where['blog_id'] = $this->input->post('remove_head_blog');
					$values['headlines'] = 0;
					
					$this->load->model('blogs');
					$this->blogs->actualizar($values, $where);
					
					$this->session->set_flashdata('headlines', 'Blogger removido con exito');
					
				}
			break;
			default:
				die('NO TOQUES TE DIJE');
		}
		redirect("usuarios/titulares");
	}

	/**
	 * Actualiza el perfil
	 * @return void 
	 */			
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

      	$this->load->library('session');
        $usuario = $this->session->userdata('usuario');

  			redirect("http://lamula.pe/mulapress/author/" . $usuario);		

  		}	  
	  
	}
	
	/**
	 * Agrega o actualiza un usuario
	 * @return void 
	 */			
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
			$data['dni'] = set_value('dni');
  			$data['current_controller'] = $this->uri->segment(1);		

			$tmp = $this->config->item('post_content');
			
			$this->load->view('layout/' . $tmp['head'], array('log' => FALSE,'seccion' => 'Registrate', 'ie6' => $this->_is_ie6()));
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
				$email_conf['mailtype'] = 'html';
				
				$this->load->library('email');
				$this->email->initialize($email_conf);
				
				$this->load->library('email');
				$this->email->initialize($config);
				
				$email = $this->config->item('send_welcome');
				
				$this->email->from($email['from_email'], $email['from_name']);
				$this->email->to($this->input->post('email'));
	
				$this->email->subject($email['subject']);
				$this->email->message($email['message']);
				
				$this->email->send();
							
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

	/**
	 * Setea las reglas de validacion para el formulario
	 * @return array 
	 */			
	function _reglas()
	{
		$tmp['usuario'] = "trim|required|min_length[4]|max_length[40]";

		//$reglas[] = array('field'   => 'url', 'label'   => 'lang:field_url', 'rules'   => 'trim|required|min_length[4]|max_length[40]');
		$reglas[] = array('field'   => 'email', 'label'   => 'lang:field_email', 'rules'   => 'trim|required|min_length[5]|valid_email');
		$reglas[] = array('field'   => 'dni', 'label'   => 'lang:field_dni', 'rules'   => 'trim|required|min_length[8]|callback_dni_exist');
		$reglas[] = array('field'   => 'telefono', 'label'   => 'lang:field_telefono', 'rules'   => 'trim|required|min_length[6]');
		$reglas[] = array('field'   => 'reglas', 'label'   => 'lang:field_reglas', 'rules'   => 'required');


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
	
	/**
	 * Setea las reglas de validacion para el formulario de perfiles
	 * @return array 
	 */	
	function _reglas_perfil()
	{
		//$reglas[] = array('field'   => 'url', 'label'   => 'lang:field_url', 'rules'   => 'trim|required|min_length[4]|max_length[40]');
		$reglas[] = array('field'   => 'dni', 'label'   => 'lang:field_dni', 'rules'   => 'trim|required|min_length[8]');
		$reglas[] = array('field'   => 'telefono', 'label'   => 'lang:field_telefono', 'rules'   => 'trim|required|min_length[6]');
				
		return $reglas;
	}

	/**
	 * Chequea que ese usuario no exista
	 * @param string $value contenido del input
	 * @return boolean 
	 */		
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

	/**
	 * Chequea que ese dni no exista
	 * @param string $value contenido del input
	 * @return boolean 
	 */		
	function dni_exist($value)
	{
		$this->load->model('usermeta');
		$where = array('meta_key' => 'dni', 'meta_value' => $value);
				
		$consulta = $this->usermeta->seleccionar($where);
		
		if ($consulta->num_rows() > 0)		
		{
			return false;
		}
		else
		{
			return true;
		}			
	}
	
	/**
	 * Chequea se este usando o no ie6
	 * @return boolean 
	 */		
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

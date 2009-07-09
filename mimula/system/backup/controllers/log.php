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

class Log extends DI_Controller {

    /**
     * Datos del usuario
     * @var array
     */	
	var $usuario = array();
	
	/**
	 * Constructor de la case
	 */		
	function __construct()
	{
		parent::__construct();

		$this->usuario['id'] = NULL;
		$this->usuario['usuario'] = NULL;
		$this->usuario['nombre'] = NULL;
	}

	/**
	 * Muestra el formulario para loguearse
	 * @return void 
	 */		
	function index()
	{
		$this->load->helper('form');

		$data['destino'] = $this->session->userdata('url') != NULL ? $this->session->userdata('url'): $this->config->item('default_controller');
		$data['usuario'] = NULL;
		$data['info'] = $this->error;
		
		$this->load->view('login/wpci', $data);
		$this->__destruct();		
	}
	
	/**
	 * Hace el login
	 * @return void 
	 */		
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

	/**
	 * Muestra el formulario para recuperar la constraseña
	 * @param integer $id id de un articulo
	 * @param boolean $ie6 es Internet Explorer 6
	 * @return void 
	 */		
	function olvido()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->load->view('login/olvido');
		$this->__destruct();		
	}
	
	/**
	 * Pone una contraseña random y envia un email al usuario
	 * @return void 
	 */		
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

	/**
	 * Setea las reglas de validacion para el formulario
	 * @return array 
	 */		
	function _reglas()
	{
		$reglas[] = array('field'   => 'password', 'label'   => 'lang:field_password', 'rules'   => 'trim|required|md5');
		$reglas[] = array('field'   => 'usuario', 'label'   => 'lang:field_usuario', 'rules'   => 'trim|required|min_length[4]|max_length[20]|callback_password_check');	
		return $reglas;
	}

	/**
	 * Chequea que ese usuario no exista
	 * @param string $value contenido del input
	 * @return boolean 
	 */		
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

	/**
	 * Chequea que el password y hace el login
	 * @param string $value contenido del input
	 * @return boolean 
	 */		
	function password_check($value)
	{

		$this->load->model('users');
		
		$consulta = $this->users->seleccionar(array('user_login' => $value ));
		
		if ($consulta->num_rows() == 1)
		{
			$fila = $consulta->row();
			
			$this->load->library('passwordhasher');
			$this->passwordhasher->passwordhash(8, TRUE);
			
			if ( $this->passwordhasher->CheckPassword($this->input->post('password'), $fila->user_pass) )
			{
				$this->usuario['id'] = $fila->ID;
				$this->usuario['usuario'] = $fila->user_login;
				$this->usuario['nombre'] = $fila->user_nicename;
				
				$this->session->set_userdata($this->usuario);
				return TRUE;
			}

		}
		
		return FALSE;			   			
	}

	/**
	 * Hace el logout
	 * @return void 
	 */		
	function logout()
	{
		$this->session->set_userdata($this->usuario);
		$this->session->set_userdata('info', 'Salio OK!');

		$a = 5;
		if ($a == 6)
		{		
			$this->load->library('wpcookies');
			$this->wpcookies->un_set();
		}		
		
		redirect('/log');
	}
}

/* End of file log.php */
/* Location: ./system/application/controllers/log.php */
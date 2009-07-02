<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Reescritura del controlador de Codeigniter
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Reescritura del controlador de Codeigniter
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class DI_Controller extends Controller {

    /**
     * es ajax?
     * @var boolean
     *
     */		
	var $is_ajax = TRUE;
    /**
     * url actual
     * @var string
     *
     */		
	var $me_url = '';
    /**
     * formulario
     * @var string
     *
     */		
	var $form = 'ajax';
    /**
     * Error si lo hay
     * @var string
     *
     */		
	var $error = '';

	/**
	 * Constructor de la case
	 */  
	function __construct()
	{
		parent::Controller();
	
		$tmp = $this->config->item('pre_content');
		
		$this->load->helper('url');
		
		$this->load->library('session');

		$this->me_url = site_url() . '/' . $this->uri->segment(1) . '/' . $this->uri->segment(2);
		
		if ($this->uri->segment(2) != 'ajax')
		{
			
			if (($this->uri->segment(1) != 'log') AND ($this->uri->segment(1) != 'usuarios'))
			{
				if ($this->session->userdata('usuario') == NULL)
				{
					if (isset($_COOKIE['to_ci']))
					{
						//debe loguearse y redirecciona
						$this->load->model('users');
						
						$consulta = $this->users->seleccionar(array('ID' => $_COOKIE['to_ci']));
						$fila = $consulta->row();
						$usuario['id'] = $fila->ID;
						$usuario['usuario'] = $fila->user_login;
						$usuario['nombre'] = $fila->user_nicename;
						$this->session->set_userdata($usuario);
						
						setcookie('to_ci', '', time() - 3600, '/', 'lamula.pe');
						
						redirect('home/dashboard');
					}
					else
					{
						$this->session->set_userdata('info', '');
						$this->session->set_userdata('url', $this->uri->uri_string());
						//die(print_r($_COOKIE['wordpress_logged_in_']));
						redirect('/log');
					}
				}
			}		
			
			$this->error = $this->session->userdata('info');
			$this->session->set_userdata('info', '');
			
			$this->load->helper('inflector');	
			
			$data['seccion'] = humanize($this->uri->segment(2));
			$data['log'] = $this->_is_log();
			$data['ie6'] = $this->_is_ie6();
			$data['user_name'] = $this->session->userdata('usuario');
			$data['current_controller'] = $this->uri->segment(1);
			
			$this->load->view('layout/' . $tmp['head'], $data);
			
			//$data['seccion'] =  underscore($data['seccion']);
			if (($this->uri->segment(1) != 'usuarios') && ($this->uri->segment(1) != 'log') && ($this->uri->segment(1) != 'usuarios/formulario'))
			{
				$this->load->view('layout/' . $tmp['menu'], $data);
			}
			
			$this->is_ajax = FALSE;
			$this->form = '';
		}
		
	}

	/**
	 * Destructor de la case
	 */  	
	function __destruct() {
		if ($this->is_ajax == FALSE)
		{
			$tmp = $this->config->item('post_content');
			
			$this->load->view('layout/' . $tmp['footer'], $this->_is_log());
		}
	}
	
	/**
	 * verifica que sea ie6
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

	/**
	 * Constructor de la case
	 * @param integer $total cantidad de registros 
	 * @param integer $per_page cantidad de registros por pagina
	 * @return string
	 */  	
	function _paginador($total, $per_page)
	{
		$this->load->library('pagination');
		$config['base_url'] = $this->me_url;
		$config['total_rows'] = $total;
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 3;

		$this->pagination->initialize($config);

		return $this->pagination->create_links();
	}

	/**
	 * Verifica que el usuario este logueado
	 * @return boolean
	 */  
	function _is_log()
	{
		
		if ($this->session->userdata('usuario') != NULL)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	

}
// END _Controller class

/* End of file Controller.php */
/* Location: ./system/libraries/Controller.php */
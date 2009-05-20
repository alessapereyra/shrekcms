<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class the every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class DI_Controller extends Controller {

	var $is_ajax = TRUE;
	var $me_url = '';
	var $form = 'ajax';
	var $error = '';
	
	function __construct()
	{
		parent::Controller();
	
		$tmp = $this->config->item('pre_content');
		
		$this->load->helper('url');
		
		$this->load->library('session');

		$this->me_url = site_url() . '/' . $this->uri->segment(1) . '/';
		
		if ($this->uri->segment(2) != 'ajax')
		{
			if ($this->uri->segment(1) != 'log')
			{
				if ($this->session->userdata('usuario') == NULL)
				{
					$this->session->set_userdata('info', '');
					$this->session->set_userdata('url', $this->uri->uri_string());
					redirect('/log');
				}
			}		
			
			$this->error = $this->session->userdata('info');
			$this->session->set_userdata('info', '');
			
			$this->load->helper('inflector');	
			
			$data['seccion'] = humanize($this->uri->segment(2));
			$data['log'] = $this->_is_log();
			$data['ie6'] = $this->_is_ie6();
			
			$this->load->view('layout/' . $tmp['head'], $data);
			
			//$data['seccion'] =  underscore($data['seccion']);
			if ($this->uri->segment(1) != 'usuario')
			{
				$this->load->view('layout/' . $tmp['menu'], $data);
			}
			
			$this->is_ajax = FALSE;
			$this->form = '';
		}
		
	}
	
	function __destruct() {
		if ($this->is_ajax == FALSE)
		{
			$tmp = $this->config->item('post_content');
			
			$this->load->view('layout/' . $tmp['footer'], $this->_is_log());
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
	
	function _paginador($total, $per_page)
	{
		$this->load->library('pagination');
		$config['base_url'] = $this->me_url;
		$config['total_rows'] = $total;
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;

		$this->pagination->initialize($config);

		return $this->pagination->create_links();
	}

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
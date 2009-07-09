<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de emails
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de emails
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Email extends Controller {
	
	/**
	 * Envia un email
	 * @return void 
	 */		
	function index()
	{
		//envia emails
		$email_conf['mailtype'] = 'html';
		
		$this->load->library('email');
		$this->email->initialize($email_conf);
		
		$email = $this->config->item('send_welcome');
		
		$this->email->from($email['from_email'], $email['from_name']);
		$this->email->to('dientuki@gmail.com');
		
		$this->email->subject($email['subject']);
		$this->email->message($email['message']);
		
		$this->email->send();
	
	}

}
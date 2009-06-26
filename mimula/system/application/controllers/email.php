<?php
class Email extends Controller {
	
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
		
		echo 'ya ps';		
	}

}
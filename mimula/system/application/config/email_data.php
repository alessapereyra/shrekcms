<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$from_email = 'desde@email.com';
$from_name = 'La mulamaster';

//Recupero de contraseña
$email['from_email'] = $from_email;
$email['from_name'] = $from_name;
$email['subject'] = 'Mula: Cambio de contraseña';
$email['message'] = 'Su nueva contraeña es: ';

$config['retrieve_password'] = $email;

//Formulario de bienvenido
$email['from_email'] = $from_email;
$email['from_name'] = $from_name;
$email['subject'] = 'Nuevo Bienvenido';
$email['message'] = 'data';

$config['send_welcome'] = $email;

/* End of file config.php */
/* Location: ./system/application/config/config.php */
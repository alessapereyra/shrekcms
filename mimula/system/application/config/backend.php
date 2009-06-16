<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$backend['head'] = 'head';
$backend['header'] = 'header';
$backend['menu'] = 'menu';
$backend['sidebar'] = 'sidebar';
$backend['content'] = 'content';

$config['pre_content'] = $backend;

//unset($backend);
$backend['footer'] = 'footer';

$config['post_content'] = $backend;

$config['per_page'] = 5;

/* End of file config.php */
/* Location: ./system/application/config/config.php */
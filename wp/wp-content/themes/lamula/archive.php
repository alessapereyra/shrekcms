<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

/*
Template Name: Archive
*/

$row = null; 
get_header(); ?>

<?php include '/usr/local/www/wordpress-mu2//ci/system/cidip/cidip_index.php';  ?>

<div id="content">
  
	<div id="content_feed">
	
	<?php
	$ci =& get_instance();
	$ci->load->model('users');
	$ci->load->model('usermeta');
	
	$perfil = $ci->usermeta->select_all($author);
	$perfil = $perfil->result_array();
	$data['perfil'] = $perfil;
	echo $ci->load->view('usuarios/perfil', $data, true)  ?> 
	</div> <!-- content_feed -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

/*
Template Name: Archive
*/

$row = null; 
//$author = 1;
get_header();

$id = $author; 
?>

<?php include '/usr/local/www/wordpress-mu2/mulapress/ci/system/cidip/cidip_index.php';  ?>
<?php //include '/var/www/shrekcms/ci/system/cidip/cidip_index.php';  ?>

<div id="content" class="inner">
  
	<div id="content_feed">
	  
	  <div id="user_profile">
	   
    	<?php
    	$ci =& get_instance();
    	$ci->load->model('users');
    	$ci->load->model('usermeta');

    	$perfil = $ci->usermeta->select_all($author);
    	$perfil = $perfil->result_array();
    	
    	//Mi ciclo es mas c00l b'cause i know php and i'm a TRUE man
    	foreach($perfil as $miperfil)
    	{
    		$data[$miperfil['meta_key']] = $miperfil['meta_value']; 
    	}
    	
    	echo $ci->load->view('usuarios/bloggerinfo', $data, true);
    	unset($data);  ?> 
	      
	  </div>
	  
	  <div>
    	<?php 
    	
		$ci->load->model('terms');
		$ci->load->model('post');
		
		//consigue los ultimos post
		$data['posts'] = $ci->post->get_lastpost($id, 5);

		echo $ci->load->view('usuarios/bloggerposts', $data, true);
  		unset($data);
    	?> 	  
	  </div>
	
	</div> <!-- content_feed -->

  <div id="sidebars">
    
      <div id="important">
        
          <p>
          
            <a href="http://lamula.pe/mulapress/ci" class="send_news">
              
                publica en lamula.pe
                <em>  
                        envíanos tus fotos, noticias, denuncias,<br/>historias o lo que quieras
                </em>
            </a>
            
          </p>
        
      </div>
      

      <div id="sidebar_central">
        
          <h4>Muleros</h4>

	    	<?php 
	    	
			$ci->load->model('comments');
			
			//consigue los ultimos comentarios a los post de ese autor
			$data['comments'] = $ci->comments->get_lastcomments($id, 5);
	
			echo $ci->load->view('usuarios/bloggercomments', $data, true);
	  		unset($data);
	  		
	  		$ci->load->model('sessionmanager');
	  		$ci->sessionmanager->get_lastviews($id, 5);
	    	?> 	   
        
      </div> <!-- sidebar_central -->
      
      <div id="sidebar_recomendados">
       
       	  <h4>ultimas vistas</h4> 

	    	<?php 
	    	
	  		$ci->load->model('sessionmanager');
	  		$data['views'] = $ci->sessionmanager->get_lastviews($id, 5);
	    		
			echo $ci->load->view('usuarios/bloggerviews', $data, true);
	  		unset($data);
	  		
	    	?> 	   

        
      </div> <!-- sidebar_recomendados -->
    
  </div> <!-- sidebars -->

<?php get_footer(); ?>
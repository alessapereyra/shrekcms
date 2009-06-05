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

include 'perfil_header.php';
$id = $author; 
?>

<?php //include '/var/www/shrekcms/mimula/system/cidip/cidip_index.php';  ?>
<?php include 'C:\xampp\htdocs\shrekcms\mimula\system\cidip\cidip_index.php';  ?>

<div id="content" class="inner author">
  
	<div id="content_feed">
	  
	  <div id="user_profile">
	   
    	<?php
		$ci =& get_instance();
		$ci->load->model('users');
		$ci->load->model('usermeta');
		    
		$ci->load->model('terms');
		$ci->load->model('sessionmanager');
		$ci->load->model('comments');
		$ci->load->model('post');		  
	  
	  $ci->load->library('session');
    $data['logged_id'] = $ci->session->userdata('usuario');
    
	  
	  $data['id'] = $id;
		$data['views'] = $ci->sessionmanager->get_lastread($id, 1);
  
		$data['user'] = $ci->users->seleccionar(array('id' => $id));
    $data['user'] = $data['user']->result_array();
    $data['user'] = current($data['user']);

    $data['total_comments'] = $ci->comments->total_comments($id);
    $data['received_comments'] = $ci->comments->total_received_comments($id);

    $data['published_posts'] = $ci->post->published_posts($id);
    $data['total_posts'] = $ci->post->total_posts($id);                
  
    $mularanking = 0;
  
      if ( $data['total_posts'] > 0)
      { 
          $mularanking = $data['published_posts'] / $data['total_posts'];
      }
      
      $mularanking = $mularanking * 10;
      
      $mularanking = $mularanking + $data['total_comments'] + $data['received_comments'] * 1.2;
   
      $data['mula_ranking'] = $mularanking;
                      
    	$perfil = $ci->usermeta->select_all($author);
    	$perfil = $perfil->result_array();
    	
    	//Mi ciclo es mas c00l b'cause i know php and i'm a TRUE man
    	foreach($perfil as $miperfil)
    	{
    		$data[$miperfil['meta_key']] = $miperfil['meta_value']; 
    	}
    	
    	echo $ci->load->view('usuarios/bloggerinfo', $data, true);
    	unset($data);
    	  
    	?> 
	      
	  </div>
	  
	    
    <div id="articles_edit">
	    	<?php
	    	$ci->load->helper('url');
	    	$limit['from'] = 0;
	    	$limit['show'] = 5;
	    	
	  		$data['myposts'] = $ci->post->get_mypost($id, $limit);
	  		$data['myposts'] = $data['myposts']->result_array();

			  echo $ci->load->view('usuarios/bloggermypost', $data, true);
	  		unset($data);
	    	?> 	      
    </div> <!-- articles_edit -->
  
	  
	  <div>
    	<?php 
		  //consigue los ultimos post
		  $data['posts'] = $ci->post->get_lastpost($id, 8);

		  echo $ci->load->view('usuarios/bloggerposts', $data, true);
  		unset($data); ?> 	  
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
        
        <div class="sidebar_box">
          

          <h4>lo que te han comentado</h4>

  	    	<?php 
			
  			  //consigue los ultimos comentarios a los post de ese autor
  			  $data['comments'] = $ci->comments->get_lastcomments($id, 10);
	
  			  echo $ci->load->view('usuarios/bloggercomments', $data, true);
  	  		unset($data);
	  		
  	    	?> 	   

        </div> <!-- sidebar_box -->

        <div class="sidebar_box">
        

          <h4>lo que has comentado</h4>

    	    <?php 

    			//consigue los ultimos comentarios a los post de ese autor
    			$data['comments'] = $ci->comments->get_lastowncomments($id, 10);

    			echo $ci->load->view('usuarios/bloggerowncomments', $data, true);
  	  		unset($data);

  	    	?> 	   

        </div> <!-- sidebar_box -->
        
      </div> <!-- sidebar_central -->
      
      <div id="sidebar_recomendados">
        
            <div class="sidebox">
                      
                <div class="sidebox_wrapper">

                 	  <h4>tus noticias m&aacute;s le&iacute;das</h4> 

                   <div class="tab_content">
             	    	<?php 

             	  		$ci->load->model('sessionmanager');
             	  		$data['views'] = $ci->sessionmanager->get_lastviews($id, 10);

             			  echo $ci->load->view('usuarios/bloggerviews', $data, true);
             	  		unset($data);

             	    	?>
             	
             	      </div> <!-- sidebox_wrapper -->

                </div> <!-- sidebox_wrapper -->
        
            </div>        

            <div class="sidebar">

               <div class="sidebox_wrapper">

              <h4>las que ya leiste</h4> 

       	    	<?php 

         	  		$data['views'] = $ci->sessionmanager->get_lastread($id, 10);

         			  echo $ci->load->view('usuarios/bloggerviews', $data, true);
         	  		unset($data);

         	    	?> 	   
         	    	
       	    	  </div>

              </div> <!-- sidebar -->
        
        
        
        
      </div> <!-- sidebar_recomendados -->
          
  </div> <!-- sidebars -->

<?php get_footer(); ?>

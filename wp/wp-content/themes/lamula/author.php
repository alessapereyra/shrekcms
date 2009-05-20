<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

/*
Template Name: Archive
*/

function snippet($text,$length=64,$tail="...") {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
}

$row = null; 
//$author = 1;
get_header();

$id = $author; ?>

<?php //include '/usr/local/www/wordpress-mu2/mulapress/ci/system/cidip/cidip_index.php';  ?>
<?php include '/var/www/shrekcms/ci/system/cidip/cidip_index.php';  ?>

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
	    	?> 	   
        
      </div> <!-- sidebar_central -->
      
      <div id="sidebar_recomendados">
        

        <div id="corresponsales" class="sidebox">
   
               <h4>Corresponsales más</h4>
               
               <div class="tab_content">
                	vistos
                  <!-- vistos -->
                
               </div>

               <div class="tab_content">
                votados
                  <!-- votados -->
                
               </div>


               <div class="tab_content">
                comentados
                <!-- comentados -->
                
               </div>
   
        </div>

        <ul id="corresponsales" class="sidebox_menu">
          <li><a href="#vistos">vistos</a></li>
          <li><a href="#votados">votados</a></li>
          <li><a href="#comentados" class="selected">comentados</a></li>                
        </ul>
   
        <div id="articulos" class="sidebox">

          <h4>Art&iacute;culos más</h4>
          
          <div class="sidebox_content">
            plugin vistos
              <?php kf_get_posts_by_hits(7,10); ?>

            
          </div>
                
          <div class="sidebox_content">
            plugin votados
              <!-- VOTADOS -->
            
          </div>
          
          <div class="sidebox_content">

            <?php most_popular(1); ?>
            
          </div>                          
                    
        </div>     
        
        <ul id="articulos" class="sidebox_menu">
          <li><a href="#vistos" >vistos</a></li>
          <li><a href="#votados">votados</a></li>
          <li><a href="#comentados" class="selected">comentados</a></li>                
        </ul>
   
      
        <div id="videos" class="sidebox">

          <h4>Video destacado</h4>          

        </div>

        
      </div> <!-- sidebar_recomendados -->
    
  </div> <!-- sidebars -->

<?php get_footer(); ?>
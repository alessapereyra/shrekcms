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
get_header(); ?>

<?php include '/usr/local/www/wordpress-mu2/mulapress/ci/system/cidip/cidip_index.php';  ?>

<div id="content">
  
	<div id="content_feed">
	  
	  <div id="user_profile">
	   
    	<?php
    	$ci =& get_instance();
    	$ci->load->model('users');
    	$ci->load->model('usermeta');

    	$perfil = $ci->usermeta->select_all($author);
    	$perfil = $perfil->result_array();
    	
    	
    	$data['perfil'] = $perfil;
    	$data['nickname'] = $perfil[0]["meta_value"] ;
    	$data['nombre'] = $perfil[10]["meta_value"] . ' ' . $perfil[11]["meta_value"] ;
    	$data['descripcion'] = $perfil[12]["meta_value"];
    	$data['blogs'] = $perfil[4]["meta_value"];    	
    	echo $ci->load->view('usuarios/perfil', $data, true)  ?> 
	   
	   
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
          
          <ul class="bloggers_list">

            <li>

              <div class="sidebar_foto">
                  <img src="<?php bloginfo('template_url'); ?>/images/mulero1.png" alt="Noticia 1" title="Noticia 1"/>
              </div>     
              <div class="sidebar_txt">
                  <h6><a href="http://lavozatidebida.lamula.pe">La Voz a ti Debida</a></h6>
                  <strong>Pedro Salinas</strong>
                  <p></p>
              </div>

            </li>

            <li>

            <div class="sidebar_foto">
                <img src="<?php bloginfo('template_url'); ?>/images/mulero2.png" alt="Noticia 1" title="Noticia 1"/>
            </div>     
            <div class="sidebar_txt">
                <h6><a href="http://2mil32.lamula.pe">2mil32</a></h6>
                <strong>Juan Infante</strong>                      
                <p></p>
            </div>

            </li>
            
            <li>
              
            <div class="sidebar_foto">
                <img src="<?php bloginfo('template_url'); ?>/images/mulero3.png" alt="Noticia 1" title="Noticia 1"/>
            </div>
            <div class="sidebar_txt">
                <h6><a href="http://zonacero.lamula.pe">Zona Cero</a></h6>
                <strong>C&eacute;sar Gutierrez</strong>                      
                <p></p>
            </div>

            </li>

            <li>

            <div class="sidebar_foto">
                 <img src="<?php bloginfo('template_url'); ?>/images/mulero1.png" alt="Noticia 1" title="Noticia 1"/>
            </div>
             <div class="sidebar_txt">
                 <h6><a href="http://datitinger.lamula.pe">Datitinger</a></h6>
                 <strong>Daniel Titinger</strong>
                 <p></p>
             </div>

            </li>
            
             <li>

             <div class="sidebar_foto">
                 <img src="<?php bloginfo('template_url'); ?>/images/mulero2.png" alt="Noticia 1" title="Noticia 1"/>
               </div>
             <div class="sidebar_txt">
                 <h6><a href="http://elarriero.lamula.pe">El Arriero</a></h6>
                 <strong>Javier Torres</strong>                      
                 <p></p>
              </div>

            </li>

            <li>

             <div class="sidebar_foto">
                 <img src="<?php bloginfo('template_url'); ?>/images/mulero3.png" alt="Noticia 1" title="Noticia 1"/>
             </div>
             <div class="sidebar_txt">
                 <h6><a href=" http://carlostapia.lamula.pe ">Carlos Tapia</a></h6>
                 <strong>Carlos Tapia</strong>                      
                 <p></p>
             </div>

            </li>
              
          </ul>                
        
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
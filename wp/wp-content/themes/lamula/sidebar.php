<?php //include 'C:\xampp\htdocs\shrekcms\mimula\system\cidip\cidip_index.php';   ?>
<?php //include '/var/www/shrekcms/mimula/system/cidip/cidip_index.php';  ?>

<?php

 // $ci =& get_instance();

?>

  <div id="sidebars">
    
        <div id="important">
          
            <p>
            
              <a href="http://lamula.pe/mulapress/ci" class="send_news">
                
                  publica en lamula.pe
                  <em>  
                          envíanos tus fotos, noticias, denuncias,<br/>historias o lo que quieras
                  </em>
                  <em>
                          ya tenemos 78 noticias enviadas, &iquest;qu&eacute; est&aacute;s esperando?
                  </em>
                  
              </a>
              
            </p>
          
        </div>
        

      <div id="sidebar_central">

          <h4>Muleros</h4>
          
          <ul class="bloggers_list">

            <?php show_sidebar_bloggers(); ?>
              
          </ul>                
        
        
      </div> <!-- sidebar_central -->
      
      <div id="sidebar_recomendados">
        
              <a href="http://lamula.lamula.pe/?p=53#respond">
                <img src="http://lamula.pe/mulapress/wp/wp-content/themes/lamula/images/comentarios.png" class="sidebox_image" id="comentarios_banner" />
              </a>


      <a href="<?php bloginfo('siteurl'); ?>/?s=friaje">
        <img src="http://lamula.pe/mulapress/wp/wp-content/themes/lamula/images/campana.png" class="sidebox_image" id="campana_banner" />
      </a>



        <!-- <div id="ranking_usuarios" class="sidebox">

              <h4>r&aacute;nking de usuarios</h4>
              
              <div class="sidebox_wrapper">
              
                <div class="sidebox_content">

                    <ul id="mulakids">
                      Mulakids
                    </ul>
                
                </div>
                    
                <div class="sidebox_content">

                  <ul id="mulitas">
                      Mulitas              
                  </ul>
                
                </div>
              
                <div class="sidebox_content">

                  <ul id="mulos">
                      Mulos
                  </ul>

                </div>                          

              </div>                    
                        
            </div>     
             -->
        
        <!-- <ul id="ranking_menu" class="sidebox_menu">
          <li><a href="#mulakids" class="selected">mulakids</a></li>
          <li><a href="#mulitas">mulitas</a></li>
          <li><a href="#mulas">mulas</a></li>                
        </ul> -->
        
        <div id="articulos" class="sidebox">

          <h4>Art&iacute;culos más</h4>
         
          <div class="sidebox_wrapper">
            
                <div class="sidebox_content">

                    <ul id="post_most_seen">
                      <?php echo kf_get_posts_by_hits(7,10); ?>
                    </ul>
            
                </div> <!-- sidebox_content -->
                
                <div class="sidebox_content">
                    <!-- VOTADOS -->
            
                      <!-- Define the div tag where the gadget will be inserted. -->
                    <div id="div-6886351088514799323" style="width:100px;"></div>
                    <!-- Render the gadget into a div. -->
    
            
                </div> <!-- sidebox_content -->
          
                <div class="sidebox_content">

                  <?php most_popular(1); ?>
            
                </div>  <!-- sidebox_content -->
          
            </div>  <!-- sidebox_wrapper -->                 
                    
        </div>  <!-- sidebox -->
        
        <ul id="articulos_menu" class="sidebox_menu">
          <li><a href="#vistos" >vistos</a></li>
          <li><a href="#votados">votados</a></li>
          <li><a href="#comentados" class="selected">comentados</a></li>                
        </ul>
   
      
        <!-- <div id="videos" class="sidebox">

               <div class="sidebox_wrapper">

                 <h4>Video destacado</h4>          
                 
               </div> <sidebox_wrapper

             </div> <sidebox 
              -->

        <div id="comentarios" class="sidebox">

          <div class="sidebox_wrapper">
            
            <h4>&Uacute;ltimos Comentarios</h4>          
            
            <ul>
              <?php mostrar_ultimos_comentarios(); ?>
            </ul>
            
          </div> <!-- sidebox_wrapper -->
  
        </div> <!-- sidebox -->
      
                            
        <div class="sidebox cc">
            <a rel="license" href="http://creativecommons.org/licenses/by-sa/2.5/pe/">
              <img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/2.5/pe/88x31.png" />
            </a><br />
            <span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dc:title" rel="dc:type">La Mula</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="www.rcp.pe" property="cc:attributionName" rel="cc:attributionURL">RCP</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/2.5/pe/">Creative Commons Reconocimiento-Compartir bajo la misma licencia 2.5 Per&#250; License</a>.<br />Based on a work at <a xmlns:dc="http://purl.org/dc/elements/1.1/" href="www.lamula.pe" rel="dc:source">www.lamula.pe</a>.
        </div>
        
      </div> <!-- sidebar_recomendados -->
    
  </div> <!-- sidebars -->
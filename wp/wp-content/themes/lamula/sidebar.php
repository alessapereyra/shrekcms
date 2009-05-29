<?php include 'C:\xampp\htdocs\shrekcms\ci\system\cidip\cidip_index.php';  ?>

<?php

 // $ci =& get_instance();

?>

  <div id="sidebars">
    
  <!--       <div id="important">
          
            <p>
            
              <a href="http://lamula.pe/mulapress/ci" class="send_news">
                
                  publica en lamula.pe
                  <em>  
                          envíanos tus fotos, noticias, denuncias,<br/>historias o lo que quieras
                  </em>
              </a>
              
            </p>
          
        </div>
         -->

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
   
            <div class="sidebox_wrapper">
    
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
   
        </div>

        <ul id="corresponsales" class="sidebox_menu">
          <li><a href="#vistos">vistos</a></li>
          <li><a href="#votados">votados</a></li>
          <li><a href="#comentados" class="selected">comentados</a></li>                
        </ul>
        
        <div id="ranking_usuarios" class="sidebox">

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
        
        <ul id="ranking_menu" class="sidebox_menu">
          <li><a href="#mulakids" class="selected">mulakids</a></li>
          <li><a href="#mulitas">mulitas</a></li>
          <li><a href="#mulas">mulas</a></li>                
        </ul>
        
        
   
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
   
      
        <div id="videos" class="sidebox">

          <div class="sidebox_wrapper">

            <h4>Video destacado</h4>          
            
          </div> <!-- sidebox_wrapper -->

        </div> <!-- sidebox -->
        

        <div id="comentarios" class="sidebox">

          <div class="sidebox_wrapper">
            
            <h4>&Uacute;ltimos Comentarios</h4>          
            
          </div> <!-- sidebox_wrapper -->
  
        </div> <!-- sidebox -->
      
        
      </div> <!-- sidebar_recomendados -->
    
  </div> <!-- sidebars -->
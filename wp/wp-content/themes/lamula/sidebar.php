<?php include '/usr/local/www/wordpress-mu2/mulapress/ci/system/cidip/cidip_index.php';   ?>

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
            
                    <!-- Include the Google Friend Connect javascript library. -->
                    <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
                    <!-- Define the div tag where the gadget will be inserted. -->
                    <div id="div-6886351088514799323" style="width:200px;"></div>
                    <!-- Render the gadget into a div. -->
                    <script type="text/javascript">
                    var skin = {};
                    skin['BORDER_COLOR'] = 'transparent';
                    skin['ENDCAP_BG_COLOR'] = 'transparent';
                    skin['ENDCAP_TEXT_COLOR'] = '#333333';
                    skin['ENDCAP_LINK_COLOR'] = '#0000cc';
                    skin['ALTERNATE_BG_COLOR'] = 'transparent';
                    skin['CONTENT_BG_COLOR'] = 'transparent';
                    skin['CONTENT_LINK_COLOR'] = '#0000cc';
                    skin['CONTENT_TEXT_COLOR'] = '#333333';
                    skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
                    skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
                    skin['CONTENT_HEADLINE_COLOR'] = '#333333';
                    skin['HEADER_TEXT'] = 'Historias recomendadas';
                    skin['RECOMMENDATIONS_PER_PAGE'] = '5';
                    google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
                    google.friendconnect.container.renderOpenSocialGadget(
                     { id: 'div-6886351088514799323',
                       url:'http://www.google.com/friendconnect/gadgets/recommended_pages.xml',
                       site: '18025864853307811361',
                       'view-params':{"docId":"recommendedPages"}
                     },
                      skin);
                    </script>
            
            
            
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
      
        <div id="friend_connect" class="sidebox">
          
          <!-- Include the Google Friend Connect javascript library. -->
          <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
          <!-- Define the div tag where the gadget will be inserted. -->
          <div id="div-9068912511230268267" style="width:276px;border:1px solid #cccccc;"></div>
          <!-- Render the gadget into a div. -->
          <script type="text/javascript">
          var skin = {};
          skin['BORDER_COLOR'] = '#cccccc';
          skin['ENDCAP_BG_COLOR'] = '#ffffff';
          skin['ENDCAP_TEXT_COLOR'] = '#333333';
          skin['ENDCAP_LINK_COLOR'] = '#fe008a';
          skin['ALTERNATE_BG_COLOR'] = '#ffffff';
          skin['CONTENT_BG_COLOR'] = '#ffffff';
          skin['CONTENT_LINK_COLOR'] = '#0000cc';
          skin['CONTENT_TEXT_COLOR'] = '#333333';
          skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
          skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
          skin['CONTENT_HEADLINE_COLOR'] = '#333333';
          skin['NUMBER_ROWS'] = '6';
          google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
          google.friendconnect.container.renderMembersGadget(
           { id: 'div-9068912511230268267',
             site: '18025864853307811361' },
            skin);
          </script>
          
        </div>
      
        
      </div> <!-- sidebar_recomendados -->
    
  </div> <!-- sidebars -->
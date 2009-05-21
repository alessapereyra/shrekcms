<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */
get_header(); ?>

<div id="content" class="inner">
  
  <div id="content_feed">    

    <ul id="post_list">
    
    <?php if (have_posts()) : ?>
        
  		<?php while (have_posts()) : the_post(); ?>
				<?php sm_store_session_data(get_the_ID()); ?>
        <li>

          <h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
    				  <?php the_title(); ?>
            </a>
          </h5>
          
          <div class="post_content">
              
              <?php 
                    //get_the_time('g:i a')
                    
              ?>
              <h6 class="metadata">enviado por <?php the_author_posts_link() ?> publicado a las <?php the_time('g:i a'); ?> </h6>
              
              <?php echo get_the_content(); ?>
              
              <div class="news_footer">

                <p class="rate">Califica esta nota: <?php wp_gdsr_render_article(); ?></p>
                <p class="tags">Etiquetas: <?php the_tags(); ?></p>
              </div> <!-- news_footer -->              


          </div>

        </li>

  		<?php endwhile; ?>

  		<div class="navigation">
  			<div class="alignleft"><?php next_posts_link('&laquo; Anterior') ?></div>
  			<div class="alignright"><?php previous_posts_link('Siguiente &raquo;') ?></div>
  		</div>

  	<?php else : ?>

  		<h2 class="center">No hay noticias</h2>
  		<p class="center">Pero puedes buscar algo que te interese</p>
  		<?php get_search_form(); ?>

  	<?php endif; ?>
  	
	
  </ul>


  <?php comments_template(); ?>
  

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


          </div>

          <ul class="sidebox_menu">
            <li><a href="#" class="selected">vistos</a></li>
            <li><a href="#">votados</a></li>
            <li><a href="#">comentados</a></li>                
          </ul>

          <div id="articulos" class="sidebox">

            <h4>Art&iacute;culos más</h4>

            <div class="sidebox_content">

              <?php most_popular(1); ?>

            </div>

          </div>     

          <ul class="sidebox_menu">
            <li><a href="#" class="selected">vistos</a></li>
            <li><a href="#">votados</a></li>
            <li><a href="#">comentados</a></li>                
          </ul>


          <div id="videos" class="sidebox">

            <h4>Video destacado</h4>          

          </div>


        </div> <!-- sidebar_recomendados -->
 
    
  </div> <!-- sidebars -->

<?php get_footer(); ?>
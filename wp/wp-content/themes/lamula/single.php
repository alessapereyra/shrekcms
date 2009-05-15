<?php
/**
 * @package WordPress
 * @subpackage LaMula
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


get_header(); ?>

<div id="top_news">
  
  <?php
  
   // $featured_query = new WP_Query('category_name=featured&showposts=2');
   $featured_query = new WP_Query('showposts=1');
    while ($featured_query->have_posts()) : $featured_query->the_post();
    $do_not_duplicate = $post->ID; ?>

  
  <div id="top_news_image">
    <img src="<?php bloginfo('template_url'); ?>/images/top_news.png" alt="Top News" title="Top News"/>
  </div> <!-- top_news_image -->
  
  <div id="top_news_text">
    
    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <p>
  
      
        <span class="author">Por <?php the_author_posts_link() ?> <em><?php the_date('d/m/y'); ?></em></span>
        
        
        <?php 
              $content = get_the_content();
              $content = apply_filters('the_content', $content);
              $content = str_replace(']]>', ']]&gt;', $content);  
              $content = snippet($content,235);
              $content = strip_tags($content, '<p>');            
              
        ?>

        <?php echo $content ?>
        
    </p>
        
  </div> <!-- top_news_text -->

  <div id="top_news_footer">
    
    <a href="<?php the_permalink() ?>" id="leer_mas_footer">Leer m&aacute;s</a>
    <p class="comments"><a href="<?php comments_link(); ?>" class="comments"><?php comments_number('cero', 'uno', 'm&aacute;s'); ?> comentarios</a></p>
    <p class="rate"><em><?php wp_gdsr_render_article(); ?></em></p>
    
  </div> <!-- top_news_footer -->



  <?php endwhile; ?>
 
  
</div> <!-- top_news -->

<div id="content" class="inner">
  
  <div id="content_feed">    

    <ul id="post_list">
    
    <?php if (have_posts()) : ?>
        
  		<?php while (have_posts()) : the_post(); ?>

        <li>

          <h5>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
    				  <?php the_title(); ?>
            </a>
          </h5>
          
          <div class="post_content">
              
              <?php 
                    //get_the_time('g:i a')
                    
              ?>

              <h6 class="metadata">Por <?php the_author(); ?> publicado a las <?php the_time('g:i a'); ?> </h6>
              
              <?php echo get_the_content(); ?>
              
              <div class="news_footer">

                <a class="rate"><?php wp_gdsr_render_article(); ?></a>

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
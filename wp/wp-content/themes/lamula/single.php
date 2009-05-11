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
  
  <div id="top_news_image">
    <img src="<?php bloginfo('template_url'); ?>/images/top_news.png" alt="Top News" title="Top News"/>
  </div> <!-- top_news_image -->
  
  <div id="top_news_text">
    
    <h3>La noticia del día: <br />la mula en 2 líneas</h3>
    <p>
        <span class="author">Por <a href="#">Pepito</a> <em>05/05/2009</em></span>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Cras augue arcu, mattis et, interdum a, placerat sed, massa. Nullam pretium. 
        Vestibulum risus turpis, pellentesque non, ultricies ut, posuere sed, tortor. 
        Suspendisse volutpat porttitor elit. Sed venenatis. Vestibulum vitae velit a tellus 
        feugiat scelerisque. Pellentesque dolor.
    </p>
        
  </div> <!-- top_news_text -->

  <div id="top_news_footer">
    
    <a href="#" id="leer_mas_footer">Leer m&aacute;s</a>
    <p class="comments"><a href="#"><em>12</em> comentarios</a></p>
    <p class="rate"><em>estrellas</em></p>
    
  </div> <!-- top_news_footer -->
  
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
        
          <p><a href="http://localhost:8888/shrekcms/ci" class="send_news">m&aacute;ndanos tu noticia</a></p>
        
      </div>

      <div id="sidebar_central">
        
          <h4>Muleros</h4>
          
          <dl>

            <dt>
                <img src="<?php bloginfo('template_url'); ?>/images/mulero1.png" alt="Noticia 1" title="Noticia 1"/>
            </dt>
            <dd>
                <h6>norte chico</h6>
                <strong>xOcram</strong>
                <p>Este concepto nace de un concepto raro
                <a href="#">leer mas</a></p>
            </dd>

            <dt>
                <img src="<?php bloginfo('template_url'); ?>/images/mulero2.png" alt="Noticia 1" title="Noticia 1"/>
            </dt>
            <dd>
                <h6>centro sur</h6>
                <strong>xPedro Salinas</strong>                      
                <p>Este concepto nace de un concepto raro
                <a href="#">leer mas</a></p>
            </dd>

            <dt>
                <img src="<?php bloginfo('template_url'); ?>/images/mulero3.png" alt="Noticia 1" title="Noticia 1"/>
            </dt>
            <dd>
                <h6>oriente medio</h6>
                <strong>xO brien</strong>                      
                <p>Este concepto nace de un concepto raro
                <a href="#">leer mas</a></p>
            </dd>

            <dt>
                 <img src="<?php bloginfo('template_url'); ?>/images/mulero1.png" alt="Noticia 1" title="Noticia 1"/>
             </dt>
             <dd>
                 <h6>norte chico</h6>
                 <strong>xOcram</strong>
                 <p>Este concepto nace de un concepto raro
                 <a href="#">leer mas</a></p>
             </dd>

             <dt>
                 <img src="<?php bloginfo('template_url'); ?>/images/mulero2.png" alt="Noticia 1" title="Noticia 1"/>
             </dt>
             <dd>
                 <h6>centro sur</h6>
                 <strong>xPedro Salinas</strong>                      
                 <p>Este concepto nace de un concepto raro
                 <a href="#">leer mas</a></p>
             </dd>

             <dt>
                 <img src="<?php bloginfo('template_url'); ?>/images/mulero3.png" alt="Noticia 1" title="Noticia 1"/>
             </dt>
             <dd>
                 <h6>oriente medio</h6>
                 <strong>xO brien</strong>                      
                 <p>Este concepto nace de un concepto raro
                 <a href="#">leer mas</a></p>
             </dd>

          </dl>                
        
      </div> <!-- sidebar_central -->
      
      <div id="sidebar_recomendados">
        
        <h4>Corresponsales más</h4>
        
        <ul>
          <li><a href="#">vistos</a></li>
          <li><a href="#">votados</a></li>
          <li><a href="#">comentados</a></li>                
        </ul>
        
        <h4>Art&iacute;culos más</h4>
        <ul>
          <li><a href="#">vistos</a></li>
          <li><a href="#">votados</a></li>
          <li><a href="#">comentados</a></li>                
        </ul>


        <h4>Video destacado</h4>
        
      </div> <!-- sidebar_recomendados -->
    
  </div> <!-- sidebars -->

<?php get_footer(); ?>
<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>

<div id="top_news">
  
  <div id="top_news_image">
    <img src="<?php bloginfo('template_url'); ?>/images/top_news.png" alt="Top News" title="Top News"/>
  </div> <!-- top_news_image -->
  
  <div id="top_news_text">
    
    <h3>La noticia del día: <br />la mula en 2 líneas</h3>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Cras augue arcu, mattis et, interdum a, placerat sed, massa. Nullam pretium. 
        Vestibulum risus turpis, pellentesque non, ultricies ut, posuere sed, tortor. 
        Suspendisse volutpat porttitor elit. Sed venenatis. Vestibulum vitae velit a tellus 
        feugiat scelerisque. Pellentesque dolor.
    </p>
    
  </div> <!-- top_news_text -->
  
  
</div> <!-- top_news -->

<div id="content">
  
  <div id="content_feed">

    <ul>
      <li><a href="#">lo bueno</a></li>
      <li><a href="#">lo malo</a></li>
      <li><a href="#">la roca</a></li>
      <li><a href="#" class="active">lo todo</a></li>
    </ul>
    

    <dl>
    
    <?php if (have_posts()) : ?>


  		<?php while (have_posts()) : the_post(); ?>


          <dt>
              <img src="<?php bloginfo('template_url'); ?>/images/feed<?php echo rand(1,5) ?>.png" alt="Noticia 1" title="Noticia 1"/>
          </dt>
          <dd>
              <h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
              <?php the_excerpt('Leer el resto'); ?><a href="<?php the_permalink() ?>">Leer m&aacute;s</a>
          </dd>

  		<?php endwhile; ?>

  		<div class="navigation">
  			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
  			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
  		</div>

  	<?php else : ?>

  		<h2 class="center">No hay noticias</h2>
  		<p class="center">Pero puedes buscar algo que te interese</p>
  		<?php get_search_form(); ?>

  	<?php endif; ?>
  	
    
    
      <dt>
          <img src="<?php bloginfo('template_url'); ?>/images/feed1.png" alt="Noticia 1" title="Noticia 1"/>
      </dt>
      <dd>
          <h5>Burdel gay en Huayc&aacute;n</h5>
          net a través de una experiencia virtual única y diferente. 
          Este concepto nace de un ejercicio de filiación marcado p
      </dd>

      <dt>
          <img src="<?php bloginfo('template_url'); ?>/images/feed3.png" alt="Noticia 1" title="Noticia 1"/>
      </dt>
      <dd>
          <h5>La RCP desarrolla Museo Virtual de la Memoria</h5>
          net a través de una experiencia virtual única y diferente. 
          Este concepto nace de un ejercicio de filiación marcado p
      </dd>
	
  </dl>


  </div> <!-- content_feed -->

  <div id="sidebars">
    
      <div id="important">
        
          <p><a href="#" class="send_news">m&aacute;ndanos tu noticia</a></p>
        
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
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
              
              <?php the_content(); ?>
              
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
  

	 
  

  
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

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
              $row = NULL;
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

<div id="content">
  
  <div id="content_feed">

    <ul id="category_tabs">
      <li><a href="#todo" class="active">lo todo</a></li>      
      <li><a href="#bueno">lo bueno</a></li>
      <li><a href="#malo">lo malo</a></li>
      <li><a href="#roca">la roca</a></li>
    </ul>
    <div id="todo" class="class_content">

	    <ul id="post_list">
	    
	    <?php if (have_posts()) : ?>
	        
	  		<?php while (have_posts()) : the_post(); ?>
	
	        <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
	
	        <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>
	
	        <li class=<?php echo $row; ?>>
	
	          <h5>
	            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	    				  <?php the_title(); ?>
	            </a>
	          </h5>
	          
	          <div class="post_image">
	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	              <img src="<?php bloginfo('template_url'); ?>/images/feed<?php echo rand(1,5) ?>.png" alt="Noticia 1" title="Noticia 1"/>
	              </a>
	          </div>
	          <div class="post_content">
	              
	              <?php 
	                    $content = get_the_content();
	                    $content = apply_filters('the_content', $content);
	                    $content = str_replace(']]>', ']]&gt;', $content);
	                    $content = snippet($content,235);
	                    $author = "por <small class='author'> ". get_the_author() . "</small>";
	                    $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
	                    $content =  $content; 
	              ?>
	
	              <?php echo strip_tags($content, '<p>'); ?>
	              <?php //echo $author . $date ?>
	              
	              <div class="news_footer">
	
	                <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
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
  </div>

  <div id="bueno" class="class_content">
  		<?php query_posts('cat=3'); ?>
	    <ul id="post_list">
	    
	    <?php if (have_posts()) : ?>
	        
	  		<?php while (have_posts()) : the_post(); ?>
	
	        <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
	
	        <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>
	
	        <li class=<?php echo $row; ?>>
	
	          <h5>
	            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	    				  <?php the_title(); ?>
	            </a>
	          </h5>
	          
	          <div class="post_image">
	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	              <img src="<?php bloginfo('template_url'); ?>/images/feed<?php echo rand(1,5) ?>.png" alt="Noticia 1" title="Noticia 1"/>
	              </a>
	          </div>
	          <div class="post_content">
	              
	              <?php 
	                    $content = get_the_content();
	                    $content = apply_filters('the_content', $content);
	                    $content = str_replace(']]>', ']]&gt;', $content);
	                    $content = snippet($content,235);
	                    $author = "por <small class='author'> ". get_the_author() . "</small>";
	                    $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
	                    $content =  $content; 
	              ?>
	
	              <?php echo strip_tags($content, '<p>'); ?>
	              <?php //echo $author . $date ?>
	              
	              <div class="news_footer">
	
	                <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
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

  </div>
  
  <div id="malo" class="class_content">
  		<?php query_posts('cat=1'); ?>
	    <ul id="post_list">
	    
	    <?php if (have_posts()) : ?>
	        
	  		<?php while (have_posts()) : the_post(); ?>
	
	        <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
	
	        <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>
	
	        <li class=<?php echo $row; ?>>
	
	          <h5>
	            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	    				  <?php the_title(); ?>
	            </a>
	          </h5>
	          
	          <div class="post_image">
	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	              <img src="<?php bloginfo('template_url'); ?>/images/feed<?php echo rand(1,5) ?>.png" alt="Noticia 1" title="Noticia 1"/>
	              </a>
	          </div>
	          <div class="post_content">
	              
	              <?php 
	                    $content = get_the_content();
	                    $content = apply_filters('the_content', $content);
	                    $content = str_replace(']]>', ']]&gt;', $content);
	                    $content = snippet($content,235);
	                    $author = "por <small class='author'> ". get_the_author() . "</small>";
	                    $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
	                    $content =  $content; 
	              ?>
	
	              <?php echo strip_tags($content, '<p>'); ?>
	              <?php //echo $author . $date ?>
	              
	              <div class="news_footer">
	
	                <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
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

  </div>

  <div id="roca" class="class_content">
  		<?php query_posts('cat=4'); ?>
	    <ul id="post_list">
	    
	    <?php if (have_posts()) : ?>
	        
	  		<?php while (have_posts()) : the_post(); ?>
	
	        <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
	
	        <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>
	
	        <li class=<?php echo $row; ?>>
	
	          <h5>
	            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	    				  <?php the_title(); ?>
	            </a>
	          </h5>
	          
	          <div class="post_image">
	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	              <img src="<?php bloginfo('template_url'); ?>/images/feed<?php echo rand(1,5) ?>.png" alt="Noticia 1" title="Noticia 1"/>
	              </a>
	          </div>
	          <div class="post_content">
	              
	              <?php 
	                    $content = get_the_content();
	                    $content = apply_filters('the_content', $content);
	                    $content = str_replace(']]>', ']]&gt;', $content);
	                    $content = snippet($content,235);
	                    $author = "por <small class='author'> ". get_the_author() . "</small>";
	                    $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
	                    $content =  $content; 
	              ?>
	
	              <?php echo strip_tags($content, '<p>'); ?>
	              <?php //echo $author . $date ?>
	              
	              <div class="news_footer">
	
	                <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
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

  </div>

</div> <!-- content_feed -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */
get_header(); ?>
<?php include 'geomula.php' ?>



<div id="top_news">
  
  <div id="top_news_content">

        <div id="top_news_featured">

          <?php  
           // $featured_query = new WP_Query('category_name=featured&showposts=2');
           $featured_query = new WP_Query('showposts=1&category_name=featured');
           while ($featured_query->have_posts()) : $featured_query->the_post();
           $do_not_duplicate = $post->ID;
           ?>

          <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
          <p>

              <?php 
                    $content = get_the_content();
                    $html = str_get_html($content);
                    $img_link = $html->find('img',0)->src;

                    $html->clear(); 
                    unset($html);
                    
            //        $content = apply_filters('the_content', $content);
            //        $content = str_replace(']]>', ']]&gt;', $content);  
            //        $content = snippet($content,235);
            //        $content = strip_tags($content, '<p>');            
                    $row = NULL;
              ?>
              <div id="top_news_featured_content">
                
              <?php if ($img_link != "") { ?>
                <div id="top_news_media">
                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
                </div>

                  <div id="top_news_featured_companion_text">
                <?php the_excerpt(235); ?>	                  
                  </div>
                
              <?php } 
              else 
                  {  ?>
                    <div id="top_news_featured_text">
                      <?php the_excerpt(235); ?>	                                       
                    </div>   
                <?php  }?>

              </div>
                              
              <span class="author">enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <em> el <?php the_date('d/m/y'); ?></em></span>

          </p>

          <div class="top_news_featured_footer">

            <a href="<?php the_permalink() ?>" id="leer_mas_footer">Leer m&aacute;s</a>
            <p class="comments"><a href="<?php comments_link(); ?>" class="comments"><?php comments_number('cero', 'uno', 'm&aacute;s'); ?> comentarios</a></p>
            <p class="rate"><em><?php wp_gdsr_render_article(); ?></em></p>
            
          </div>

        <?php endwhile; ?>

        </div> <!-- top_news_featured -->

        <div id="top_news">
          
            <div class="top_news_item">
            	<?php $post = get_most_voted();
            	$links = current($post); ?>
	              <h3><a href="#" class="news_item_title"><?php echo $links->post_title; ?></a></h3>
	              <h4>lala</h4>					
            </div>

            <div class="top_news_item">
              <h3><a href="#" class="news_item_title">Rendicion De Cuentas de Comite Expoferia Pacasmayo ¿ Un Cuentazo?</a></h3>
              <h4>publicado hace 7 horas por <a href="#">dientuki</a></h4>
            </div>

            <div class="top_news_item">
              <h3><a href="#" class="news_item_title">Una noticia aleatoria</a></h3>
              <h4>publicado hace 7 horas por <a href="#">coby</a></h4>
            </div>


            <div class="top_news_item">
              <h3><a href="#" class="news_item_title">Los niños de Avelino</a></h3>
              <h4>publicado en <a href="#">DeveloperAtWork</a> por <a href="#">yaraher</a></h4>
            </div>

        </div> <!-- top_news_text -->
    
  </div> <!-- top_news_content -->
  

  <div id="top_news_footer">
    
    
  </div> <!-- top_news_footer -->  
    
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

                     <?php 
      	                    $content = get_the_content();
      	                    $html = str_get_html($content);
      	                    $img_link = $html->find('img',0)->src;

                            $html->clear(); 
                            unset($html);

      	                    $content = apply_filters('the_content', $content);
      	                    $content = str_replace(']]>', ']]&gt;', $content);
      	                    $content = snippet($content,235);
      	                    $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
      	              ?>
	
	        <li class=<?php echo $row; ?>>
	
	          <h5>
	            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
	    				  <?php the_title(); ?>
	            </a>
	          </h5>
	          
	        <div class="post_item">
	        
          <?php if ($img_link != "") { ?>

	          <div class="post_image <?php the_category_unlinked(' '); ?>">

	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
                  <img src="<?php echo $img_link; ?>" alt="" title=""/>
	                <span><?php the_category_unlinked(' '); ?></span>
	              </a>
	          </div>
	          
	          <div class="post_companion_content">
	              <?php the_excerpt(100); ?>		              
	          </div>
            <?php } else { ?>

	          <div class="post_content">
	              <?php the_excerpt(100); ?>	
	          </div>
                          
            <?php } ?>
	        
	        </div> <!-- post_item -->
	        	          
            <div class="news_footer">
	            <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
              <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
              <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
              <a class="rate"><?php wp_gdsr_render_article(); ?></a>

            </div> <!-- news_footer -->	          
	
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
  </div> <!-- todo -->

  <div id="bueno" class="class_content">
   		<?php query_posts('cat=3'); ?>
  	    <ul id="post_list">

  	    <?php if (have_posts()) : ?>

  	  		<?php while (have_posts()) : the_post(); ?>

  	        <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

  	        <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>

  	        <li class=<?php echo $row; ?>>

  	          <?php 
                   $content = get_the_content();
                   $html = str_get_html($content);
                   $img_link = $html->find('img',0)->src;
                   // foreach($html->find('img') as $element)
                   //         $img_link = $element->src;


                   $html->clear(); 
                   unset($html);



                   $content = apply_filters('the_content', $content);
                   $content = str_replace(']]>', ']]&gt;', $content);
                   $content = snippet($content,235);
                   $author = "por <small class='author'> ". get_the_author() . "</small>";
                   $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
             ?>


  	          <h5>
  	            <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
  	    				  <?php the_title(); ?>
  	            </a>
  	          </h5>

   	        <div class="post_item">

                      <?php if ($img_link != "") { ?>

            	          <div class="post_image <?php the_category_unlinked(' '); ?>">

            	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
                              <img src="<?php echo $img_link; ?>" alt="" title=""/>
            	                <span><?php the_category_unlinked(' '); ?></span>
            	              </a>
            	          </div>

            	          <div class="post_companion_content">
            	              <?php the_excerpt(100); ?>		              
            	          </div>
                        <?php } else { ?>

            	          <div class="post_content">
            	              <?php the_excerpt(100); ?>	
            	          </div>

                        <?php } ?>

   	        </div> <!-- post_item -->


             <div class="news_footer">
 	             <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
               <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
               <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
               <a class="rate"><?php wp_gdsr_render_article(); ?></a>

             </div> <!-- news_footer -->              

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

            <?php 
                  $content = get_the_content();
                  $html = str_get_html($content);
                  $img_link = $html->find('img',0)->src;
                  // foreach($html->find('img') as $element)
                  //         $img_link = $element->src;


                  $html->clear(); 
                  unset($html);

                  $content = apply_filters('the_content', $content);
                  $content = str_replace(']]>', ']]&gt;', $content);
                  $content = snippet($content,235);
                  $author = "por <small class='author'> ". get_the_author() . "</small>";
                  $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
                  $content =  $content; 
            ?>


            <h5>
              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
      				  <?php the_title(); ?>
              </a>
            </h5>

  	        <div class="post_item">

                      <?php if ($img_link != "") { ?>

            	          <div class="post_image <?php the_category_unlinked(' '); ?>">

            	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
                              <img src="<?php echo $img_link; ?>" alt="" title=""/>
            	                <span><?php the_category_unlinked(' '); ?></span>
            	              </a>
            	          </div>

            	          <div class="post_companion_content">
            	              <?php the_excerpt(100); ?>		              
            	          </div>
                        <?php } else { ?>

            	          <div class="post_content">
            	              <?php the_excerpt(100); ?>	
            	          </div>

                        <?php } ?>

  	        </div> <!-- post_item -->


            <div class="news_footer">
	            <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
              <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
              <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
              <a class="rate"><?php wp_gdsr_render_article(); ?></a>

            </div> <!-- news_footer -->

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

                        <?php 
                              $content = get_the_content();
                              $html = str_get_html($content);
                              $img_link = $html->find('img',0)->src;
                              // foreach($html->find('img') as $element)
                              //         $img_link = $element->src;


                              $html->clear(); 
                              unset($html);

                              $content = apply_filters('the_content', $content);
                              $content = str_replace(']]>', ']]&gt;', $content);
                              $content = snippet($content,235);
                              $author = "por <small class='author'> ". get_the_author() . "</small>";
                              $date = " a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
                              $content =  $content; 
                        ?>

            <h5>
              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
      				  <?php the_title(); ?>
              </a>
            </h5>

  	        <div class="post_item">

                      <?php if ($img_link != "") { ?>

            	          <div class="post_image <?php the_category_unlinked(' '); ?>">

            	              <a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
                              <img src="<?php echo $img_link; ?>" alt="" title=""/>
            	                <span><?php the_category_unlinked(' '); ?></span>
            	              </a>
            	          </div>

            	          <div class="post_companion_content">
            	              <?php the_excerpt(100); ?>		              
            	          </div>
                        <?php } else { ?>

            	          <div class="post_content">
            	              <?php the_excerpt(100); ?>	
            	          </div>

                        <?php } ?>

  	        </div> <!-- post_item -->


            <div class="news_footer">
	            <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
              <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
              <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
              <a class="rate"><?php wp_gdsr_render_article(); ?></a>

            </div> <!-- news_footer -->

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
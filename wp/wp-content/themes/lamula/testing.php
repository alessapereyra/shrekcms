<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */
get_header(); ?>
<?php include 'geomula.php' ?>

<div id="top_news">
  
  <div id="top_news_content">          	          	      

          <?php  
           $featured_query = new WP_Query('showposts=1&category_name=featured');
           while ($featured_query->have_posts()) : $featured_query->the_post();
           $do_not_duplicate = $post->ID;
           ?>
		<div id="featured" class="top_news_featured">
          <h3><a href="">La mula en Vivo</a></h3>
          <p>

     
              <div class="top_news_featured_content.special">
                
                    <div class="top_news_featured_text">

                      <object id="utv_o_699958" height="326" width="400"
                      classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param
                      value="http://www.ustream.tv/flash/live/699958" name="movie" /><param
                      value="true" name="allowFullScreen" /><param value="always"
                      name="allowScriptAccess" /><param value="transparent" name="wmode"
                      /><param value="viewcount=true&amp;autoplay=false" name="flashvars"
                      /><embed name="utv_e_699958" id="utv_e_699958"
                      flashvars="viewcount=true&amp;autoplay=false" height="326" width="400"
                      allowfullscreen="true" allowscriptaccess="always" wmode="transparent"
                      src="http://www.ustream.tv/flash/live/699958"
                      type="application/x-shockwave-flash" /></object>
                      
                    </div> 
     
              </div>
                              
              <span class="author">enviado por <a href="http://lamula.pe/members/lamula">lamula</a> <em> el <?php the_date('d/m/y'); ?></em> desde las noticias destacadas</span>

          </p>

          <div class="top_news_featured_footer">

            <a href="#" class="leer_mas_footer"></a>
            <p class="comments"></p>
            <p class="rate"><em></em></p>
            
          </div>

        <?php endwhile; ?>

        </div> <!-- top_news_featured -->
       <?php
       		$post = get_a_post(661);
            $most_voted = current($post);
           ?> 
        <div id="most_voted" class="top_news_featured">
        	<h3><a href="<?php echo $most_voted->guid ?>"><?php echo $most_voted->post_title; ?></a></h3>
	          <p>
	
	              <?php 
	                    $content = $most_voted->post_content;
	                    $html = str_get_html($content);
	                    $img_link = $html->find('img',0)->src;
	                    $img = $html->find('img',0);
	         
	                    $row = NULL;
	              ?> 
		          <div class="top_news_featured_content">
	                
	              <?php if ($img_link != "") { ?>
	                <div class="top_news_media">
	                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
	                </div>
	
	                  <div class="top_news_featured_companion_text">
	                  	<?php $most_voted->post_content = eregi_replace($img->outertext, ' ', $most_voted->post_content); ?>
	                	<?php echo mulapress_trim_excerpt($most_voted->post_content, 235) ?>                 
	                  </div>
	              <?php } 
	              else 
	                  {  ?>
	                    <div class="top_news_featured_text">
	                     <?php echo mulapress_trim_excerpt($most_voted->post_content, 235) ?>                                            
	                    </div>   
	                <?php  }?>
	
	              </div>
	                    <?php $html->clear(); 
	                    unset($html); ?> 
	              <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $most_voted->user_nicename; ?>" ><?php echo $most_voted->user_nicename; ?></a> <em>el <?php echo $most_voted->post_date; ?></em> desde las noticias m&aacute;s votadas</span>
	
	          </p>

	          <div class="top_news_featured_footer">
	
	            <a href="<?php echo $most_voted->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	            <p class="comments"><a href="<?php echo $most_voted->guid; ?>#comments" class="comments"><?php echo $most_voted->comment_count; ?> comentarios</a></p>
	            <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>
	            
	          </div>	          
        </div>
        <?php   $post = get_a_blog(41);
            	$most_viewed = current($post);
?>        <div id="most_viewed" class="top_news_featured">
        	<h3><a href="<?php echo $most_viewed->guid ?>"><?php echo $most_viewed->post_title; ?></a></h3>
	          <p>
	
	              <?php 
	                    $content = $most_viewed->post_content;
	                    $html = str_get_html($content);
	                    $img_link = $html->find('img',0)->src;
	                    $img = $html->find('img',0);
	        
	                    $row = NULL;
	              ?> 
		          <div class="top_news_featured_content">
	                
	              <?php if ($img_link != "") { ?>
	                <div class="top_news_media">
	                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
	                </div>
	
	                  <div class="top_news_featured_companion_text">
	                    <?php $most_viewed->post_content = eregi_replace($img->outertext, ' ', $most_viewed->post_content); ?>
	                	<?php echo mulapress_trim_excerpt($most_viewed->post_content, 235) ?>                 
	                  </div>
	                
	              <?php } 
	              else 
	                  {  ?>
	                    <div class="top_news_featured_text">
	                     <?php echo mulapress_trim_excerpt($most_viewed->post_content, 235) ?>                                            
	                    </div>   
	                <?php  }?>
	
	              </div>
	                 <?php 	                    $html->clear(); 
	                    unset($html);  ?>            
	              <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $most_viewed->user_nicename; ?>" ><?php echo $most_viewed->user_nicename; ?></a> <em>el <?php echo $most_viewed->post_date; ?></em> desde las noticias m&aacute;s comentadas</span>
	
	          </p>

	          <div class="top_news_featured_footer">
	
	            <a href="<?php echo $most_viewed->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	            <p class="comments"><a href="<?php echo $most_viewed->guid; ?>#comments" class="comments"><?php echo $most_viewed->comment_count; ?> comentarios</a></p>
	            <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>
	            
	          </div> <!--	  top_news_featured_footer  -->
	          
	     </div>
        <?php 
        
              $post = get_a_blog(26);
            	$blog_special = current($post);
            	
         ?>
         
        <div id="blog_special" class="top_news_featured">
        	<h3><a href="<?php echo $blog_special->guid ?>"><?php echo $blog_special->post_title; ?></a></h3>
	          <p>
	
	              <?php 
	                    $content = $blog_special->post_content;
	                    $html = str_get_html($content);
	                    $img_link = $html->find('img',0)->src;
	                    $img = $html->find('img',0);
	        
	                    $row = NULL;
	              ?> 
		          <div class="top_news_featured_content">
	                
	              <?php if ($img_link != "") { ?>
	                <div class="top_news_media">
	                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
	                </div>
	
	                  <div class="top_news_featured_companion_text">
	                    <?php $blog_special->post_content = eregi_replace($img->outertext, ' ', $blog_special->post_content); ?>
	                	<?php echo mulapress_trim_excerpt($blog_special->post_content, 200) ?>                 
	                  </div>
	                
	              <?php } 
	              else 
	                  {  ?>
	                    <div class="top_news_featured_text">
	                     <?php echo mulapress_trim_excerpt($blog_special->post_content, 200) ?>                                            
	                    </div>   
	                <?php  }?>
	
	              </div>
	                 <?php 	
	                 
	                    $html->clear(); 
	                    unset($html);  ?>            
	              <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $blog_special->user_nicename; ?>" ><?php echo $blog_special->user_nicename; ?></a> <em>el <?php echo $blog_special->post_date; ?></em> desde nuestros corresponsales</span>
	
	          </p>

	          <div class="top_news_featured_footer">
	
	            <a href="<?php echo $blog_special->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	            <p class="comments"><a href="<?php echo $blog_special->guid; ?>#comments" class="comments"><?php echo $blog_special->comment_count; ?> comentarios</a></p>
	            <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>
	            
	          </div>	          
        </div>
             	<?php
            	$post = get_a_post(330);
            	$blog_random = current($post); ?>          
        <div id="blog_random" class="top_news_featured">
        	<h3><a href="<?php echo $blog_random->guid ?>"><?php echo $blog_random->post_title; ?></a></h3>
	          <p>
	
	              <?php 
	                    $content = $blog_random->post_content;
	                    $html = str_get_html($content);
	                    $img_link = $html->find('img',0)->src;
	                    $img = $html->find('img',0);
	        
	                    $row = NULL;
	              ?> 
		          <div class="top_news_featured_content">
	                
	              <?php if ($img_link != "") { ?>
	                <div class="top_news_media">
	                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
	                </div>
	
	                  <div class="top_news_featured_companion_text">
	                    <?php $blog_random->post_content = eregi_replace($img->outertext, ' ', $blog_random->post_content); ?>
	                	<?php echo mulapress_trim_excerpt($blog_random->post_content, 235) ?>                 
	                  </div>
	                
	              <?php } 
	              else 
	                  {  ?>
	                    <div class="top_news_featured_text">
	                     <?php echo mulapress_trim_excerpt($blog_random->post_content, 235) ?>                                            
	                    </div>   
	                <?php  }?>
	
	              </div>
	                 <?php 	                    $html->clear(); 
	                    unset($html);  ?>            
	              <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $blog_random->user_nicename; ?>" ><?php echo $blog_random->user_nicename; ?></a> <em>el <?php echo $blog_random->post_date; ?></em> desde nuestros blogs</span>
	
	          </p>

	          <div class="top_news_featured_footer">
	
	            <a href="<?php echo $blog_random->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	            <p class="comments"><a href="<?php echo $blog_random->guid; ?>#comments" class="comments"><?php echo $blog_random->comment_count; ?> comentarios</a></p>
	            <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>
	            
	          </div>	          
        </div>                       

        <div id="top_news">

            <div class="top_news_item portada-active">
		            <h3><a href="#featured" class="news_item_title">La Mula en Vivo</a></h3>
	              <h4>publicado ahora mismo por <a href="http://lamula.pe/members/lamula" >La Mula</a></h4>					
            </div>
            
            <div class="top_news_item">
	              <h3><a href="#most_voted" class="news_item_title"><?php echo $most_voted->post_title; ?></a></h3>
	              <h4>publicado el <?php echo $most_voted->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $most_voted->user_nicename; ?>" ><?php echo $most_voted->user_nicename; ?></a></h4>					
            </div>          

            <div class="top_news_item">
	              <h3><a href="#most_viewed" class="news_item_title"><?php echo $most_viewed->post_title; ?></a></h3>
					<h4>publicado el <?php echo $most_viewed->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $most_viewed->user_nicename; ?>"><?php echo $most_viewed->user_nicename; ?></a></h4>            	
            </div>

            <div class="top_news_item">
	              <h3><a href="#blog_special" class="news_item_title"><?php echo $blog_special->post_title; ?></a></h3>
	              <h4>publicado el <?php echo $blog_special->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $blog_special->user_nicename; ?>" ><?php echo $blog_special->user_nicename; ?></a></h4>					
            </div>

            <div class="top_news_item">
	              <h3><a href="#blog_random" class="news_item_title"><?php echo $blog_random->post_title; ?></a></h3>
	              <h4>publicado el <?php echo $blog_random->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $blog_random->user_nicename; ?>" ><?php echo $blog_random->user_nicename; ?></a></h4>					
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
      	                    $date = "el <small class='author'>" . get_the_time('d/m/y') . "</small> a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
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
              
              <div class="footer_links">

                <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
                <a class="rate"><?php wp_gdsr_render_article(); ?></a>
                
              </div>

	            <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>	          
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
                   $date = "el <small class='author'>" . get_the_time('d/m/y') . "</small> a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
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
               <div class="footer_links">

                  <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                  <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
                  <a class="rate"><?php wp_gdsr_render_article(); ?></a>

                </div>
 	             <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
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
                  $date = "el <small class='author'>" . get_the_time('d/m/y') . "</small> a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
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
              <div class="footer_links">

                 <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                 <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
                 <a class="rate"><?php wp_gdsr_render_article(); ?></a>

               </div>
	            <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
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
        	                    $date = "el <small class='author'>" . get_the_time('d/m/y') . "</small> a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
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
              <div class="footer_links">

                 <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                 <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ning&uacute;n', 'uno', 'm&aacute;s'); ?> comentario</a>
                 <a class="rate"><?php wp_gdsr_render_article(); ?></a>

               </div>
	            <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
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
 
 
  <div id="bloggers_navigation">
    
      <h3>nuestros bloggers</h3>
      <!-- navigator --> 
      <div class="navi"></div> 

      <!-- prev link --> 
      <a class="prev"></a>
 
      <div id="bloggers_box" class="scrollable">
        
        <ul class="items">

          <?php get_blogs(); ?>
      
        </ul>
    
      </div>
  
      <!-- next link --> 
      <a class="next"></a>

    </div>


</div> <!-- content_feed -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
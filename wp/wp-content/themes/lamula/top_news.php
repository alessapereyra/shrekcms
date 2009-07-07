<?php
/**
  * @package WordPress
  * @subpackage LaMula
  */
?>
  <div id="top_news">

    <div id="top_news_content">          	          	      

      <div id="featured" class="top_news_featured">

        <?php  
           $first_query = new WP_Query('showposts=1&category_name=featured');
           while ($first_query->have_posts()) : $first_query->the_post();
           
           $do_not_duplicate = $post->ID; 
           
           $first = $post;

          ?>

        <div class="top_news_content">
		<h4>Noticia Destacada</h4>
        <h3>
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </h3>
   
        <?php setup_text(get_the_content(),$img_link,$img); ?>
        <div class="top_news_featured_content  <?php if ($post->ID==940){ echo "special";} ?>">

          <?php if ($img_link != "") { ?>  
          
            <!-- noticia a dos columnas -->
    
            <div class="top_news_media">
              <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
            </div>

            <div class="top_news_featured_companion_text">
              <?php the_excerpt(235); ?>	                  


			       <div class="top_news_featured_footer">
			          <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
			          <p class="comments"><a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ningun comentario', 'un comentario', 'm&aacute;s comentarios'); ?> </a></p>
			          <div class="rate"><?php wp_gdsr_render_article(); ?></div>

			        </div>


            </div>

            <?php } 
          else 
          {  ?>
            
            <!-- noticia a una columna -->
            
            <div class="top_news_featured_text">

                
              <?php the_excerpt(235); ?>	                                       

	        <div class="top_news_featured_footer">
	          <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	          <p class="comments"><a href="<?php comments_link(); ?>" class="comments"><?php comments_number('ningun comentario', 'un comentario', 'm&aacute;s comentarios'); ?> </a></p>
	          <div class="rate"><?php wp_gdsr_render_article(); ?></div>

	        </div>



            </div>   

          <?php  }?>

          </div>

          <span class="author">enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php $first->user_nicename = the_author(); ?></a> <em> el <?php the_date('d/m/y'); ?></em></span>

        </div>


      <?php endwhile; ?>

      </div> <!-- top_news_featured -->

      <div id="most_voted" class="top_news_featured">
      <?php
            unset($new_post);
            $new_post = get_from_header(2,$text);
            $second = $new_post;
            setup_featured_news($new_post,$text) 
      ?>
    </div> <!-- top_news_featured -->

    <div id="most_viewed" class="top_news_featured">
      <?php
            unset($new_post);
            $new_post = get_from_header(3,$text);
            $third = $new_post;
            setup_featured_news($new_post,$text); 
        ?>
    </div> <!-- top_news_featured -->


    <div id="blog_special" class="top_news_featured">
    <?php 
          unset($new_post);
          $new_post = get_from_header(4,$text);
          $fourth = $new_post;
          setup_featured_news($new_post,$text); 
     ?>
    </div> <!-- top_news_featured -->


    <div id="blog_random" class="top_news_featured">
    <?php
          unset($new_post);    
          $new_post = get_from_header(5,$text);
          $fifth = $new_post; 
          setup_featured_news($new_post,$text); 
    ?>          
    </div> <!-- top_news_featured -->
    

<div id="top_news_list">

  <div class="top_news_item portada-active">
    <h3><a href="#featured" class="news_item_title"><?php echo $first->post_title; ?></a></h3>
    <h4>publicado el <?php echo $first->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $first->user_nicename; ?>" ><?php echo $first->user_nicename; ?></a></h4>					
  </div>

  <div class="top_news_item">
    <h3><a href="#most_voted" class="news_item_title"><?php echo $second->post_title; ?></a></h3>
    <h4>publicado el <?php echo $second->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $second->user_nicename; ?>" ><?php echo $second->user_nicename; ?></a></h4>					
  </div>          

  <div class="top_news_item">
    <h3><a href="#most_viewed" class="news_item_title"><?php echo $third->post_title; ?></a></h3>
    <h4>publicado el <?php echo $third->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $third->user_nicename; ?>"><?php echo $third->user_nicename; ?></a></h4>            	
  </div>

  <div class="top_news_item">
    <h3><a href="#blog_special" class="news_item_title"><?php echo $fourth->post_title; ?></a></h3>
    <h4>publicado el <?php echo $fourth->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $fourth->user_nicename; ?>" ><?php echo $fourth->user_nicename; ?></a></h4>					
  </div>

  <div class="top_news_item">
    <h3><a href="#blog_random" class="news_item_title"><?php echo $fifth->post_title; ?></a></h3>
    <h4>publicado el <?php echo $fifth->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $fifth->user_nicename; ?>" ><?php echo $fifth->user_nicename; ?></a></h4>					
  </div>

</div> <!-- top_news_text -->

</div> <!-- top_news_content -->


<div id="top_news_footer">


</div> <!-- top_news_footer -->  

</div> <!-- top_news_wrapper -->

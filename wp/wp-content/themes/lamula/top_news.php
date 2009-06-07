  <?php die("llega aca"); ?>

  <div id="top_news_wrapper">

    <div id="top_news_content">          	          	      

      <div id="featured" class="top_news_featured">

        <?php  
           $featured_query = new WP_Query('showposts=1&category_name=featured');
           while ($featured_query->have_posts()) : $featured_query->the_post();
           $do_not_duplicate = $post->ID; 
           $featured = $post;

          ?>


        <div class="top_news_content">
        <h3>
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </h3>
   
        <?php 
                  setup_text(get_the_content(),$img_link,$img);
                  $row = NULL;  
        ?>
        <div class="top_news_featured_content">

          <?php if ($img_link != "") { ?>  
          
            <!-- noticia a dos columnas -->
    
            <div class="top_news_media">
              <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
            </div>

            <div class="top_news_featured_companion_text">
              <?php the_excerpt(235); ?>	                  
            </div>

            <?php } 
          else 
          {  ?>
            
            <!-- noticia a una columna -->
            
            <div class="top_news_featured_text">
              <?php the_excerpt(235); ?>	                                       
            </div>   
            
          <?php  }?>

          </div>

          <span class="author">enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php $featured->user_nicename = the_author(); ?></a> <em> el <?php the_date('d/m/y'); ?></em> desde las noticias destacadas</span>

        </div>

        <div class="top_news_featured_footer">

          <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
          <p class="comments"><a href="<?php comments_link(); ?>" class="comments"><?php comments_number('cero', 'uno', 'm&aacute;s'); ?> comentarios</a></p>
          <p class="rate"><em><?php wp_gdsr_render_article(); ?></em></p>

        </div>

      <?php endwhile; ?>

      </div> <!-- top_news_featured -->

      <div class="top_news_featured_content">
      <?php
            $post = get_most_voted();
            $most_voted = $post;
            setup_featured_news($post,"las noticias m&aacute;s votadas") 
      ?>
    </div> <!-- top_news_featured_content -->

    <div class="top_news_featured_content">
      <?php
            $post = kf_get_posts_by_hits(7,1,false);
            $most_viewed = $post;
            setup_featured_news($post,"las noticias m&aacute;s comentadas") 
        ?>
      </div> <!-- top_news_featured_content -->


      <div class="top_news_featured_content">
      <?php 

            $post = get_blog_special();
            $blog_special = $post;
            setup_featured_news($post,"nuestra red") 
       ?>
     </div> <!-- top_news_featured_content -->


       <div class="top_news_featured_content">
     <?php
            $post = get_blog_random();
            $blog_random = $post; 
            setup_featured_news($post,"nuestros bloggers") 
      ?>          
      </div> <!-- top_news_featured_content -->
      


<div id="top_news">

  <div class="top_news_item portada-active">
    <h3><a href="#featured" class="news_item_title"><?php echo $featured->post_title; ?></a></h3>
    <h4>publicado el <?php echo $featured->post_date; ?> por <a href="http://lamula.pe/members/<?php echo $featured->user_nicename; ?>" ><?php echo $featured->user_nicename; ?></a></h4>					
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

</div> <!-- top_news_wrapper -->
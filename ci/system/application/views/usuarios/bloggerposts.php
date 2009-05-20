<div id="content">

	  	<div id="content_feed">
	  		<ul id="category_tabs">
	  			<li><a href="#todo" class="active">Lo todo</a></li>
	  			<li><a href="#bueno">Lo bueno</a></li>
	  			<li><a href="#malo">Lo malo</a></li>
	  			<li><a href="#roca">Lo roca</a></li>	  			
	  		</ul> <!-- category_tabs -->

          <div id="todo" class="class_content">

      	    <ul id="post_list">



          	<?php foreach($posts as $cat): ?>

          				<?php foreach($cat as $post): ?>
										<?php $row = 'even'; ?>
                    <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>

                    <li class=<?php echo $row; ?>>

                      <h5>
          	            <a href="<?php echo $post['guid']; ?>" rel="bookmark" title="Enlace a <?php echo $post['post_title']; ?>">
          	    				  <?php echo $post['post_title']; ?>
          	            </a>
          	          </h5>


          	          <div class="post_image">
          	              <a href="<?php echo $post['guid']; ?>" rel="bookmark" title="Enlace a <?php echo $post['post_title']; ?>">
          	              <img src="<?php bloginfo('template_url'); ?>/images/feed<?php echo rand(1,5) ?>.png" alt="Noticia 1" title="Noticia 1"/>
          	              </a>
          	          </div> <!-- post_image -->
          	          
          	          <div class="post_content">

          	              <?php 
          	                    $content = $post['post_content'];
          	                    //$content = apply_filters('the_content', $content);
          	                    //$content = str_replace(']]>', ']]&gt;', $content);
          	                    $content = snippet($content,235);
          	                    $author = "<p>por <small class='author'> ". $nickname . "</small></p>";
          	                    //('g:i a')
          	                    $date = " <p>a las <small class='author'>" . $post['post_date'] . "</small></p>";           
          	                    $content =  $content; 
          	              ?>

          	              <?php echo $content; ?>
          	              <?php echo $author . $date ?>

          	              <div class="news_footer">

            	                <a href="<?php echo $post['guid']; ?>" class="leer_mas_footer">Leer m&aacute;s</a>
            	                <a href="<?php echo $post['guid'] . '#comments' ?>" class="comments"><?php echo $post['comment_count']; ?> comentario</a>
            	                <a class="rate"><?php //wp_gdsr_render_article(); ?></a>

          	              </div> <!-- news_footer -->              
          	          

              	          </div> <!-- post_content -->


                	    </li> <!-- post_item -->

          	          
          				<?php endforeach; ?>
      	  		<?php endforeach; ?>
 
      	  </ul> <!-- post_list -->
        </div> <!-- todo -->


	  	</div> <!-- content_feed -->
	  	
</div> <!-- content -->	  	
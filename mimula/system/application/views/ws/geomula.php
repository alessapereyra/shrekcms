<?php 
$consulta = $consulta->result_array();
$post = current($consulta);
//die(print_r( $post ));
?>
          <h3><a href="<?php echo $post['guid']; ?>"><?php echo $post['post_title']; ?></a></h3>
          <p>

              <?php 
             
                    $content = $post['post_content'];
                    include('system/application/libraries/Simplehtml.php');
                    
                    $html = str_get_html($content . ' ');
                    $img_link = $html->find('img',0);

                    $html->clear(); 
                    unset($html);          
                    
                    //pasa las variables para usar luego
                    /*$featured = $post;
                    */
              ?>
              <div class="top_news_featured_content">
                
              <?php if ($img_link != "") { ?>
                <div class="top_news_media">
                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
                </div>

                  <div class="top_news_featured_companion_text">
                <?php //the_excerpt(235); ?>	                  
                  </div>
                
              <?php  } 
              else 
                  {  ?>
                    <div class="top_news_featured_text">
                      sdf<?php //the_excerpt(235); ?>	                                       
                    </div>   
                <?php   }?>

              </div>
                              
              <span class="author">enviado por <a href="http://lamula.pe/members/<?php //the_author_login(); ?>"><?php //$featured->user_nicename = the_author(); ?></a> <em> el <?php //the_date('d/m/y'); ?></em> en noticia destacada</span>

          </p>

          <div class="top_news_featured_footer">

            <a href="<?php //the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
            <p class="comments"><a href="<?php //comments_link(); ?>" class="comments"><?php //comments_number('cero', 'uno', 'm&aacute;s'); ?> comentarios</a></p>
            <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>
            
          </div>
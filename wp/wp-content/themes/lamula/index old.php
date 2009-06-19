<?php
/**
  * @package WordPress
  * @subpackage LaMula
  */
    
    get_header(); 
    $row = NULL;
    include 'geomula.php';

    include 'top_news.php';      

?>

<div id="content">

  <div id="content_feed">

    <ul id="category_tabs">
      <li><a href="#todo" class="active">lo todo</a></li>      
      <li><a href="#bueno">lo bueno</a></li>
      <li><a href="#malo">lo malo</a></li>
      <li><a href="#roca">la roca</a></li>
    </ul>
    <div id="todo" class="class_content">

      <ul class="post_list">

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
            $date = "el <small class='author'>" . get_the_time('d/m/y') . "</small> a las <small class='author'>" . get_the_time('g:i a'). "</small>";           
            ?>

            <li class='<?php echo $row; ?>'>

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
                    <?php echo the_excerpt(); ?>		              
                  </div>
                  <?php } else { ?>

                    <div class="post_content">
                    <?php echo the_excerpt(); ?>		              
                    </div>

                    <?php } ?>

                  </div> <!-- post_item -->

                  <div class="news_footer">

                    <div class="footer_links">

                      <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                      <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('comenta', 'un comentario', 'm&aacute;s comentario'); ?></a>

                    </div>

                    <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>	          
                  </div> <!-- news_footer -->	          

                </li>

              <?php endwhile; ?>

              </ul>
            
              <div class="navigation">
                <div class="alignleft"><?php next_posts_link('&laquo; Anterior') ?></div>
                <div class="alignright"><?php previous_posts_link('Siguiente &raquo;') ?></div>
              </div>

            <?php else : ?>

              <h2 class="center">No hay noticias</h2>
              <span class="center">Pero puedes buscar algo que te interese</p>
                <?php get_search_form(); ?>

              <?php endif; ?>

          </div> <!-- todo -->

          <div id="bueno" class="class_content">
            <?php query_posts('cat=3'); ?>
            <ul class="post_list">

              <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                  <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

                  <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>

                  <li class='<?php echo $row; ?>'>

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
                          <?php the_excerpt(); ?>		                        
                        </div>
                        <?php } else { ?>

                          <div class="post_content">
                          <?php the_excerpt(); ?>		                        
                          </div>

                          <?php } ?>

                        </div> <!-- post_item -->


                        <div class="news_footer">
                          <div class="footer_links">

                            <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                            <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('comenta', 'un comentario', 'm&aacute;s comentario'); ?></a>

                          </div>
                          <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
                        </div> <!-- news_footer -->              

                      </li>

                    <?php endwhile; ?>

                  </ul>
                
                    <div class="navigation">
                      <div class="alignleft"><?php next_posts_link('&laquo; Anterior') ?></div>
                      <div class="alignright"><?php previous_posts_link('Siguiente &raquo;') ?></div>
                    </div>

                  <?php else : ?>

                    <h2 class="center">No hay noticias</h2>
                    <p class="center">Pero puedes buscar algo que te interese</p>
                    <?php get_search_form(); ?>

                  <?php endif; ?>



              </div>

              <div id="malo" class="class_content">
                <?php query_posts('cat=1'); ?>
                <ul class="post_list">

                  <?php if (have_posts()) : ?>

                    <?php while (have_posts()) : the_post(); ?>

                      <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

                      <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>

                      <li class='<?php echo $row; ?>'>

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
                        $content = snippet($content,135);
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
                                <?php the_excerpt(); ?>		                               
                            </div>
                            <?php } else { ?>

                              <div class="post_content">
                                <?php the_excerpt(); ?>		                        
                              </div>

                              <?php } ?>

                            </div> <!-- post_item -->


                            <div class="news_footer">
                              <div class="footer_links">

                                <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('comenta', 'un comentario', 'm&aacute;s comentario'); ?> </a>

                              </div>
                              <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
                            </div> <!-- news_footer -->

                          </li>

                        <?php endwhile; ?>

                      </ul>
                    
                        <div class="navigation">
                          <div class="alignleft"><?php next_posts_link('&laquo; Anterior') ?></div>
                          <div class="alignright"><?php previous_posts_link('Siguiente &raquo;') ?></div>
                        </div>

                      <?php else : ?>

                        <h2 class="center">No hay noticias</h2>
                        <p class="center">Pero puedes buscar algo que te interese</p>
                        <?php get_search_form(); ?>

                      <?php endif; ?>



                  </div>

                  <div id="roca" class="class_content">
                    <?php query_posts('cat=4'); ?>
                    <ul class="post_list">

                      <?php if (have_posts()) : ?>

                        <?php while (have_posts()) : the_post(); ?>

                          <?php if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

                          <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>

                          <li class='<?php echo $row; ?>'>

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
                            $content = snippet($content,135);
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
                                    <?php the_excerpt(); ?>		                             
                                </div>
                                <?php } else { ?>

                                  <div class="post_content">
                                      <?php the_excerpt(); ?>		                        
                                  </div>

                                  <?php } ?>

                                </div> <!-- post_item -->


                                <div class="news_footer">
                                  <div class="footer_links">

                                    <a href="<?php the_permalink() ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                                    <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('comenta', 'un comentario', 'm&aacute;s comentario'); ?></a>

                                  </div>
                                  <span>enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> <?php echo $date ?></span>
                                </div> <!-- news_footer -->

                              </li>

                            <?php endwhile; ?>

                            </ul>
                        
                            <div class="navigation">
                              <div class="alignleft"><?php next_posts_link('&laquo; Anterior') ?></div>
                              <div class="alignright"><?php previous_posts_link('Siguiente &raquo;') ?></div>
                            </div>

                          <?php else : ?>

                            <h2 class="center">No hay noticias</h2>
                            <p class="center">Pero puedes buscar algo que te interese</p>
                            <?php get_search_form(); ?>

                          <?php endif; ?>



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


<?php 
  get_sidebar();
  get_footer(); 
?>
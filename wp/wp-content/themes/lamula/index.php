<?php
/**
  * @package WordPress
  * @subpackage LaMula
  */
    
    get_header(); 
    $row = NULL;
    include 'geomula.php';

    include 'top_news.php';      
    
    function get_last_blogs_updated()
    {
    	global $wpdb;
    	
		$sql['select'] = 'SELECT blog_id';
		$sql['from'] = 'FROM wp_blogs';
		$sql['order_by'] = 'ORDER BY last_updated DESC';
		$sql['limit'] = 'LIMIT 0, 10';
		//die(implode(' ', $sql));
		return  $wpdb->get_results(implode(' ', $sql));
    }
    
	function get_index_post($blogs)
	{
	    global $wpdb;
		
		foreach($blogs as $blog)
		{
			//echo $blog->blog_id;
			//$blog->blog_id = 59;
			$wp_posts = 'wp_' . $blog->blog_id . '_posts';
			$wp_term_taxonomy = 'wp_' . $blog->blog_id . '_term_taxonomy';
			$wp_term_relationships = 'wp_' . $blog->blog_id . '_term_relationships';
			$wp_terms = 'wp_' . $blog->blog_id . '_terms';
			$wp_users = 'wp_users';
			
			//tabla post
			$sql['select'] = 'SELECT ' . $wp_posts . '.ID, ' . $wp_posts . '.post_title, ' . $wp_posts . '.post_content, ' . $wp_posts . '.comment_count, ' . $wp_posts . '.guid, ';
			//time
			$sql['select'] .= $wp_posts . '.post_date , DATE_FORMAT(' . $wp_posts . '.post_date,\'%d/%m/%Y\') as my_date, DATE_FORMAT(' . $wp_posts . '.post_date,\'%l:%i %p\') as my_time, ';
			//$sql['select'] .= $wp_posts . '.post_date, ' . $wp_posts . '.post_date as post_time, ';
			//tabla user
			$sql['select'] .= $wp_users . '.user_login, ' . $wp_users . '.user_nicename';
			
			//from
			$sql['from'] = 'FROM ' . $wp_posts . ' ';
			//inner join terms relationships
			//$sql['from'] .= 'INNER JOIN ' . $wp_term_relationships . ' ON ' . $wp_term_relationships . '.object_id = ' . $wp_posts . '.ID ';
			//inner join terms relationships
			//$sql['from'] .= 'INNER JOIN ' . $wp_term_taxonomy . ' ON ' . $wp_term_taxonomy . '.term_taxonomy_id = ' . $wp_term_relationships . '.term_taxonomy_id ';
			//inner join terms relationships
			$sql['from'] .= 'INNER JOIN ' . $wp_users . ' ON ' . $wp_users . '.ID = ' . $wp_posts . '.post_author ';
			
			//where
			$sql['where'] = 'WHERE post_type = \'post\' AND post_status = \'publish\' ';			
			
			//order by
			$sql['order_by'] = 'ORDER BY post_date DESC';
			
			$sql['limit'] = 'LIMIT 0, 10';
			
			$the_sql[] = implode(' ', $sql);
			//die($the_sql[0]);
			//break;
		}
		
		$wp_posts = 'mulapress_posts';
		$wp_term_taxonomy = 'mulapress_term_taxonomy';
		$wp_term_relationships = 'mulapress_term_relationships';
		$wp_terms = 'mulapress_terms';
		$wp_users = 'wp_users';
					
		//tabla post
		$sql['select'] = 'SELECT ' . $wp_posts . '.ID, ' . $wp_posts . '.post_title, ' . $wp_posts . '.post_content, ' . $wp_posts . '.comment_count, ' . $wp_posts . '.guid, ';
		//time
		$sql['select'] .= $wp_posts . '.post_date , DATE_FORMAT(' . $wp_posts . '.post_date,\'%d/%m/%Y\') as my_date, DATE_FORMAT(' . $wp_posts . '.post_date,\'%l:%i %p\') as my_time, ';
		//$sql['select'] .= $wp_posts . '.post_date, ' . $wp_posts . '.post_date as post_time, ';
		//tabla user
		$sql['select'] .= $wp_users . '.user_login, ' . $wp_users . '.user_nicename';
		
		//from
		$sql['from'] = 'FROM ' . $wp_posts . ' ';
		//inner join terms relationships
		$sql['from'] .= 'INNER JOIN ' . $wp_term_relationships . ' ON ' . $wp_term_relationships . '.object_id = ' . $wp_posts . '.ID ';
		//inner join terms relationships
		$sql['from'] .= 'INNER JOIN ' . $wp_term_taxonomy . ' ON ' . $wp_term_taxonomy . '.term_taxonomy_id = ' . $wp_term_relationships . '.term_taxonomy_id ';
		//inner join terms relationships
		$sql['from'] .= 'INNER JOIN ' . $wp_users . ' ON ' . $wp_users . '.ID = ' . $wp_posts . '.post_author ';
		
		//where
		$sql['where'] = 'WHERE ((post_type = \'post\' AND post_status = \'publish\') AND ';
		$sql['where'] .= '(' . $wp_term_taxonomy . '.term_id = \'1\' OR ' . $wp_term_taxonomy . '.term_id = \'3\' OR ' . $wp_term_taxonomy . '.term_id = \'4\' ))';			
		
		//order by
		$sql['order_by'] = 'ORDER BY post_date DESC';
		
		$sql['limit'] = 'LIMIT 0, 10';
		
		$the_sql[] = implode(' ', $sql);
	
		unset($sql);
		
		$sql = '(' . implode(') UNION (', $the_sql) . ') ORDER BY post_date DESC LIMIT 0, 10';
		return $wpdb->get_results($sql);
	}    
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
<?php

$blogs = get_last_blogs_updated();
$posts = get_index_post($blogs, $x);

?>
      <ul class="post_list">

        <?php if ($posts) : ?>

          <?php foreach($posts as $post): ?>

            <?php $row = ( 'odd' != $row ) ? 'odd' : 'even'; ?>

            <?php 
            $content = $post->post_content;
            $html = str_get_html($content);
            $img_link = $html->find('img',0)->src;
            $html->clear(); 
            unset($html);

            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
            $date = "el <small class='author'>" . $post->my_date . "</small> a las <small class='author'>" . $post->my_time ."</small>";           
            ?>

            <li class='<?php echo $row; ?>'>

              <h5>
                <a href="<?php echo $post->guid; ?>" rel="bookmark" title="Enlace a <?php echo $post->post_title; ?>">
                  <?php echo $post->post_title; ?>
                </a>
              </h5>

              <div class="post_item">

                <?php if ($img_link != "") { ?>

                  <div class="post_image <?php the_category_unlinked(' '); ?>">

                    <a href="<?php echo $post->guid; ?>" rel="bookmark" title="Enlace a <?php echo $post->post_title; ?>">
                      <img src="<?php echo $img_link; ?>" alt="" title=""/>
                      <span><?php //the_category_unlinked(' '); ?></span>
                    </a>
                  </div>

                  <div class="post_companion_content">
                    <?php echo mulapress_trim_excerpt($post->post_content, 35) ?>     	              
                  </div>
                  <?php } else { ?>

                    <div class="post_content">
                    <?php echo mulapress_trim_excerpt($newpost->post_content, 35) ?>                   
                    </div>

                    <?php } ?>

                  </div> <!-- post_item -->

                  <div class="news_footer">

                    <div class="footer_links">

                      <a href="<?php echo $post->guid; ?>" class="leer_mas_footer">Leer m&aacute;s</a>
                      <a href="<?php echo $post->guid; ?>#comments" class="comments"><?php comments_number('comentar', 'un comentario', 'm&aacute;s comentario'); ?></a>

                    </div>

                    <span>enviado por <a href="http://lamula.pe/members/<?php echo $post->user_login; ?>"><?php echo $post->user_nicename; ?></a> <?php echo $date ?></span>	          
                  </div> <!-- news_footer -->	          

                </li>

              <?php endforeach; ?>

              </ul>
            
              <div class="navigation">
                <div class="alignleft"><?php next_posts_link('&laquo; Anterior') ?></div>
                <div class="alignright"><?php previous_posts_link('Siguiente &raquo;') ?></div>
              </div>

            <?php else : ?>

              <h2 class="center">No hay noticias :(</h2>
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
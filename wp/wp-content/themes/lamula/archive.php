<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

function snippet($text,$length=64,$tail="...") {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
}

$row = null; 
//$author tiene el id del autor
get_header(); ?>

<?php include '/var/www/shrekcms/ci/system/cidip/cidip_index.php';  ?>
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
  
      
        <span class="author">Por <a href="#"><?php the_author_posts_link() ?></a> <em><?php the_date('d/m/y'); ?></em></span>
        
        
        <?php 
              $content = get_the_content();
              $content = apply_filters('the_content', $content);
              $content = str_replace(']]>', ']]&gt;', $content);  
              $content = snippet($content,235);
              $content = strip_tags($content, '<p>');            
              
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
	
	<?php
	$ci =& get_instance();
	$ci->load->model('users');
	$ci->load->model('usermeta');
	
	$perfil = $ci->usermeta->select_all($author);
	$perfil = $perfil->result_array();
	$data['perfil'] = $perfil;
	echo $ci->load->view('usuarios/perfil', $data, true);
	 ?> 
	</div> <!-- content_feed -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
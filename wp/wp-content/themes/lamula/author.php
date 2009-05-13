<?php
/*
Template Name: Author
*/
?>
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


get_header(); ?>


<div id="content" class="inner">
  
  <div id="content_feed">    

    <ul id="post_list">
    
  	
  	  	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    		<div class="post" id="post-<?php the_ID(); ?>">
    		<h2><?php the_title(); ?></h2>
    			<div class="entry">
    				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

    				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

    			</div>
    		</div>
    		<?php endwhile; endif; ?>
    	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
  	
	
    </ul>


  </div> <!-- content_feed -->

  <div id="sidebars">
    
        <div id="important">

            <p>

              <a href="http://lamula.pe/mulapress/ci" class="send_news">

                  publica en lamula.pe
                  <em>  
                          envíanos tus fotos, noticias, denuncias,<br/>historias o lo que quieras
                  </em>
              </a>

            </p>

        </div>


        <div id="sidebar_central">

            <h4>Muleros</h4>

            <ul class="bloggers_list">

              <li>

                <div class="sidebar_foto">
                    <img src="<?php bloginfo('template_url'); ?>/images/mulero1.png" alt="Noticia 1" title="Noticia 1"/>
                </div>     
                <div class="sidebar_txt">
                    <h6><a href="http://lavozatidebida.lamula.pe">La Voz a ti Debida</a></h6>
                    <strong>Pedro Salinas</strong>
                    <p></p>
                </div>

              </li>

              <li>

              <div class="sidebar_foto">
                  <img src="<?php bloginfo('template_url'); ?>/images/mulero2.png" alt="Noticia 1" title="Noticia 1"/>
              </div>     
              <div class="sidebar_txt">
                  <h6><a href="http://2mil32.lamula.pe">2mil32</a></h6>
                  <strong>Juan Infante</strong>                      
                  <p></p>
              </div>

              </li>

              <li>

              <div class="sidebar_foto">
                  <img src="<?php bloginfo('template_url'); ?>/images/mulero3.png" alt="Noticia 1" title="Noticia 1"/>
              </div>
              <div class="sidebar_txt">
                  <h6><a href="http://zonacero.lamula.pe">Zona Cero</a></h6>
                  <strong>C&eacute;sar Gutierrez</strong>                      
                  <p></p>
              </div>

              </li>

              <li>

              <div class="sidebar_foto">
                   <img src="<?php bloginfo('template_url'); ?>/images/mulero1.png" alt="Noticia 1" title="Noticia 1"/>
              </div>
               <div class="sidebar_txt">
                   <h6><a href="http://datitinger.lamula.pe">Datitinger</a></h6>
                   <strong>Daniel Titinger</strong>
                   <p></p>
               </div>

              </li>

               <li>

               <div class="sidebar_foto">
                   <img src="<?php bloginfo('template_url'); ?>/images/mulero2.png" alt="Noticia 1" title="Noticia 1"/>
                 </div>
               <div class="sidebar_txt">
                   <h6><a href="http://elarriero.lamula.pe">El Arriero</a></h6>
                   <strong>Javier Torres</strong>                      
                   <p></p>
                </div>

              </li>

              <li>

               <div class="sidebar_foto">
                   <img src="<?php bloginfo('template_url'); ?>/images/mulero3.png" alt="Noticia 1" title="Noticia 1"/>
               </div>
               <div class="sidebar_txt">
                   <h6><a href=" http://carlostapia.lamula.pe ">Carlos Tapia</a></h6>
                   <strong>Carlos Tapia</strong>                      
                   <p></p>
               </div>

              </li>

            </ul>                

        </div> <!-- sidebar_central -->

        <div id="sidebar_recomendados">


          <div id="corresponsales" class="sidebox">

                 <h4>Corresponsales más</h4>


          </div>

          <ul class="sidebox_menu">
            <li><a href="#" class="selected">vistos</a></li>
            <li><a href="#">votados</a></li>
            <li><a href="#">comentados</a></li>                
          </ul>

          <div id="articulos" class="sidebox">

            <h4>Art&iacute;culos más</h4>

            <div class="sidebox_content">

              <?php most_popular(1); ?>

            </div>

          </div>     

          <ul class="sidebox_menu">
            <li><a href="#" class="selected">vistos</a></li>
            <li><a href="#">votados</a></li>
            <li><a href="#">comentados</a></li>                
          </ul>


          <div id="videos" class="sidebox">

            <h4>Video destacado</h4>          

          </div>


        </div> <!-- sidebar_recomendados -->
 
    
  </div> <!-- sidebars -->

<?php get_footer(); ?>
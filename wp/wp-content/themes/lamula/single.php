<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */
get_header(); ?>

<div id="content" class="inner">
  
  <div id="content_feed">    

    <ul class="post_list">
    
    <?php if (have_posts()) : ?>
        
  		<?php while (have_posts()) : the_post(); ?>
				<?php sm_store_session_data(get_the_ID()); ?>
        <li>

          <h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
    				  <?php the_title(); ?>
            </a>
          </h5>
          
          <div class="post_content">
              
              <?php 
                    //get_the_time('g:i a')
                    
              ?>
              <h6 class="metadata">enviado por <a href="http://lamula.pe/members/<?php the_author_login(); ?>"><?php the_author(); ?></a> publicado a las <?php the_time('g:i a'); ?> </h6>
              
              <?php the_content(); ?>
              
              <div class="news_footer">
                <p class="tags"><!-- Include the Google Friend Connect javascript library. -->
                <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
                <!-- Define the div tag where the gadget will be inserted. -->
                <div id="div-8568675974817128026" style="width:100%;"></div>
                <!-- Render the gadget into a div. -->
                <script type="text/javascript">
                var skin = {};
                skin['HEIGHT'] = '21';
                skin['BUTTON_STYLE'] = 'compact';
                skin['BUTTON_TEXT'] = 'Me gusta';
                skin['BUTTON_ICON'] = 'default';
                google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
                google.friendconnect.container.renderOpenSocialGadget(
                 { id: 'div-8568675974817128026',
                   url:'http://www.google.com/friendconnect/gadgets/recommended_pages.xml',
                   height: 21,
                   site: '18025864853307811361',
                   'view-params':{"pageUrl":location.href,"pageTitle":(document.title ? document.title : location.href),"docId":"recommendedPages"}
                 },
                  skin);
                </script>
                </p>
                <div class="rate">Califica esta nota: <?php wp_gdsr_render_article(); ?></div>
                <p class="tags"><?php the_tags(); ?></p>
              </div> <!-- news_footer -->              


          </div>

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


  <?php comments_template(); ?>
  

  </div> <!-- content_feed -->
  

	 
  

  
<?php get_sidebar(); ?>
<?php get_footer(); ?>
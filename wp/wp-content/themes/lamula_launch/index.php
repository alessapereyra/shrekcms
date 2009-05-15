<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

get_header(); ?>

<div id="wrapper">
  
    <h1>LaMula.pe</h1>
    <img style="max-width:68.57em; margin-top:-1em;" src="http://lamula.pe/wp-content/themes/pressbox-premium/images/header.jpg"/>

    <?php if (have_posts()) : ?>

  		<?php while (have_posts()) : the_post(); ?>

  				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

  				<div class="entry">
  					<?php the_content('Read the rest of this entry &raquo;'); ?>
  				</div>

  		<?php endwhile; ?>

  		<div class="navigation">
  			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
  			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
  		</div>

  	<?php else : ?>

  		<h2 class="center">Not Found</h2>
  		<p class="center">Sorry, but you are looking for something that isn't here.</p>
  		<?php get_search_form(); ?>

  	<?php endif; ?>
  
</div>

<?php get_footer(); ?>
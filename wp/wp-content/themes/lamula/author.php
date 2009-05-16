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

<?php include '/var/www/shrekcms/ci/system/cidip/cidip_index.php';  ?>
<div id="content" class="inner">
  
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

<?php get_sidebar(); ?>

<?php get_footer(); ?>
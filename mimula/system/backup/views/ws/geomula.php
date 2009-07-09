<?php
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
 
function comments_number($zero,$one,$more,$comments)
{
  switch ($comments)
  {
    case 0:
      return $zero;
    break;
    case 1:
      return $one;
    break;
    default:
      return $more;
    break;    
  }
}
 
?>
 
<div id="top_news_content">

	<?php
 
	$tot = $consulta->num_rows();
	$consulta = $consulta->result_array();
	 
	$ids = array('featured', 'most_voted', 'most_viewed', 'blog_special', 'blog_random');
	reset($ids);
	$id = current($ids);
	include('system/application/libraries/Simplehtml.php');
	$max = 5;
	$clase = 'top_news_featured_content';
	?>
	<?php if ($tot > 0):?>
		
		<?php foreach($consulta as $post): ?>
			<div id="<?php echo $id; ?>" class="top_news_featured">
				<div class="top_news_content">
					<h3><a href="<?php echo $post['guid']; ?>"><?php echo $post['post_title']; ?></a></h3>
					<?php
					$content = $post['post_content'];
					                    
					$html = str_get_html($content . ' ');
					$img_link = '';
					$img = @$html->find('img',0);
					$img_link = @$html->find('img',0)->src;
					$img = $img->outertext;
										 
					$html->clear();
					unset($html);
					?>
					<?php if ($img_link != "") { ?>
						<div class="top_news_media">
						<img src="<?php echo $img_link; ?>" alt="" title=""/>
						</div>
					 	<?php $content = ereg_replace($img, '', $content); ?>
						<div class="top_news_featured_companion_text" style="overflow: hidden; height: 160px; ">
						<?php echo $content; ?>  
						</div>
					<?php } else { ?>
						<div class="top_news_featured_text" style="overflow: hidden; height: 160px; ">
						<?php echo $content; ?>
						</div>
					<?php }?>
				
				</div><!-- //.top_news_content -->
				
				<div class="top_news_featured_footer">
					<a href="<?php echo $post['guid']; ?>" class="leer_mas_footer">Leer m&aacute;s</a>
					<p class="comments"><a href="<?php echo $post['guid']; ?>#comments" class="comments"><?php echo comments_number('cero', 'uno', 'm&aacute;s', $post['comment_count']); ?> comentarios</a></p>
					<p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>				
				</div>
				<span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $post['user_login']; ?>"><?php echo $post['user_nicename']; ?></a> <em> el <?php echo $post['post_date']; ?></em></span>
			</div>
			
		<?php endforeach;?>
		
		<div id="top_news_list">
			<?php
			$first = TRUE;
			reset($ids);
			$id = current($ids);
			?>		
			<?php foreach($consulta as $post): ?>
				<div class="top_news_item <?php if ($first != FALSE) { echo 'portada-active'; } ?>">
					<h3><a href="#<?php echo $id; ?>" class="news_item_title"><?php echo $post['post_title']; ?></a></h3>
					<h4>publicado el <?php echo $post['post_date'] ?> por <a href="http://lamula.pe/members/<?php echo $post['user_login']; ?>" ><?php echo $post['user_nicename']; ?></a></h4>          
				</div>
				<?php $first = FALSE;?>
				<?php $id = next($ids);?>			
			<?php endforeach;?>
		</div>
		
	<?php else:?>
		<div class="top_news_not_found">
			No hemos encontrado noticias para <?php echo $from ?>. Ayúdanos <a href="http://lamula.pe/mulapress/ci">mandando tus propias noticias</a>.
		</div> <!-- top_news_not_found -->
	<?php endif;?>

</div> <!-- //#top_news_content -->

<div id="top_news_footer"></div>
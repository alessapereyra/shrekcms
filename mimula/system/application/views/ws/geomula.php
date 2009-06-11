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

$consulta = $consulta->result_array();
if (count($consulta) != 0){
$post = current($consulta);

?>

          <h3><a href="<?php echo $post['guid']; ?>"><?php echo $post['post_title']; ?></a></h3>
          <p>

              <?php 
                    $content = $post['post_content'];
                    include('system/application/libraries/Simplehtml.php');
                    
                    $html = str_get_html($content . ' ');
                    $img_link = @$html->find('img',0)->src;

                    $html->clear(); 
                    unset($html);          
                    
              ?>
              <div class="top_news_featured_content">
                
               <?php if ($img_link != "") { ?>
                <div class="top_news_media">
                  <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
                </div>

                  <div class="top_news_featured_companion_text">
                <?php echo snippet($content,235); ?>	                  
                  </div>
            
              <?php } 
              else 
                 {  ?>
                    <div class="top_news_featured_text">
                      <?php echo snippet($content,235); ?>                                       
                    </div>   
                <?php   }?>

              </div>
                              
              <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $post['user_login']; ?>" ><?php echo $post['user_nicename']; ?></a> <em> el <?php echo $post['post_date'] ?></em> en noticia destacada</span>

          </p>

          <div class="top_news_featured_footer">

            <a href="<?php echo $post['guid']; ?>" class="leer_mas_footer">Leer m&aacute;s</a>
            <p class="comments"><a href="<?php echo $post['guid']; ?>#comments" class="comments"><?php echo comments_number('cero', 'uno', 'm&aacute;s', $post['comment_count']); ?> comentarios</a></p>
            <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>
            
          </div>
          <?php }
          else
          { ?>
            <h3></h3>
             <p>

   
                 <div class="top_news_featured_content">

                       <div class="top_news_featured_text nothing_found">
                         No tenemos aún noticias geolocalizadas en <?php echo $final ?>. 
                         <a href="http://lamula.pe/mulapress/ci">Env&iacute;anos</a> las tuyas
                         <div style="display:none;">
                       </div>   
   
                 </div>

                 <span class="author"></span>

             </p>

             <div class="top_news_featured_footer">

             </div>
<?php	} ?>
<?php

include('simple_html_dom.php');

if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '1',
'after_widget' => '2',
'before_title' => '3',
'after_title' => '4',
));

function snippet($text,$length=64,$tail="[...]") {
  
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


function setup_text($content, &$img_link = NULL,&$img = NULL){
  
  $html = str_get_html($content);
  $img_link = $html->find('img',0)->src;
  $img = $html->find('img',0);
  $html->clear(); 
  unset($html);          
  
}

function mulapress_trim_excerpt($text, $length = 55) {
	if ( '' == $text ) {
		$text = get_the_content('');
  }   
	
		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', $length);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '...');
			$text = implode(' ', $words);
		}
		
	return $text;
}

function mula_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">        
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
      </div>
      <div class="comment-content">
            
            <div class="coment-top-metadata">
                <?php printf(__('<cite class="fn">%s</cite> <span class="says">dice:</span>'), get_comment_author_link()) ?>
            </div> <!-- coment-top-metadata -->

            <div class="comment-content">

              <?php comment_text() ?>            

            </div>

            <?php if ($comment->comment_approved == '0') : ?>
               <em><?php _e('Tu comentario requiere revisi&oacute;n.') ?></em>
               <br />
            <?php endif; ?>

          <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('publicado el %1$s a las %2$s'), get_comment_date('j/n/y'),  get_comment_time('g:i a') ) ?></a><?php edit_comment_link(__('(Editar)'),'  ','') ?></div>

      </div> <!-- comment-content -->
      

     </div>
<?php
        }


function the_category_unlinked($separator = ' ') {
    $categories = (array) get_the_category();

    $thelist = '';
    foreach($categories as $category) {    // concate
        $thelist .= $separator . $category->category_nicename;
    }

    echo $thelist;
}


function timeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s'){

        $difference = time() - $timestamp;
        
        if($difference < 0) return 'hace 0 segundos';             // if difference is lower than zero check server offset
        elseif($difference < 864000){                                   // if difference is over 10 days show normal time form
        
                $periods = array('semanas' => 604800,'dias' => 86400,'horas' => 3600,'minutos' => 60,'segundos' => 1);
                $output = '';
                foreach($periods as $key => $value){
                
                        if($difference >= $value){
                        
                                $time = round($difference / $value);
                                $difference %= $value;
                                
                                $output .= ($output ? ' ' : '').$time.' ';
                                $output .= (($time > 1 && $key == 'dia') ? $key.'s' : $key);
                                
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return 'hace ' . ($output ? $output : '0 segundos');
        }
        else return date($format, $timestamp);
}



function sm_store_session_data($mypost) {
	get_currentuserinfo();

	global $wpdb, $table_name, $current_user, $excludes_table, $user_excludes_table;

	//echo '<pre>';
	//print_r($_SERVER);
	//echo '</pre>';

	$track = true;
	$url = $_SERVER['REQUEST_URI'];
	$sm_settings = get_option('sm_settings');
	$track_admin = $sm_settings->track_admin;
	$name = $wpdb->prefix . 'user_level';
	$user_level = $current_user->$name;
	$user_id = (int)$current_user->id;

	if(!isset($_SESSION)) {
		session_start();
	}

	$session_id = session_id();

	$sql = 'SELECT COUNT(id)
			FROM ' . $excludes_table . '
			WHERE filename = "' . mysql_real_escape_string($url) . '"';

	$sql2 = 'SELECT COUNT(id)
			FROM ' . $user_excludes_table . '
			WHERE
				session_id = "' . $session_id . '"
				OR ip_address = "' . $_SERVER['REMOTE_ADDR'] . '"';
	if ($user_id) {
		$sql2 .= ' OR user_id = "' . $user_id . '"';
	}

	if ($wpdb->get_var($sql)) {
		//If the current page is in the list of excluded pages (eg: robots.txt, xmlrpc.php, favicon.ico)
		$track = false;
	} else if ($wpdb->get_var($sql2)) {
		//If the current user/session is in the excludes table then don't track
		$track = false;
	} else {
		//Check for the admin area of the site
		if (strpos($url, 'wp-admin')) {
			//If track admin is set on the settings page
			if (!$track_admin) {
				$track = false;
			} else {
				//Check for the existence of the page argument in the querystring
				if ($page = sm_get('page')) {
					//If it mentions sm_ then don't log it
					if (stripos($page, 'sm_') !== false) {
						$track = false; //we dont want to track hits to the session data pages.
					}
				}
			}
		}
	}

	if ($track) {
		$sql = 'INSERT INTO ' . $table_name . ' (user_id, session_id, url, ip_address, user_agent, unixtime)
				VALUES (
					' . $user_id . '
					, "' . $session_id . '"
					, "' . $mypost . '"
					, "' . $_SERVER['REMOTE_ADDR'] . '"
					, "' . $_SERVER['HTTP_USER_AGENT'] . '"
					, UNIX_TIMESTAMP()
				)';
		$wpdb->query($sql);

		if ($user_id > 0) {
			$sql = 'UPDATE ' . $table_name . '
					SET user_id = ' . $user_id . '
					WHERE session_id = "' . $session_id . '"';
			$wpdb->query($sql);
		}
	}
}

function get_gravatar($email="") {
   if ($email) {
      $email=trim($email);
      $email=md5($email);
      
      return '<img src="http://www.gravatar.com/avatar/'.$email.'?s=40&amp;d=http://google.com/friendconnect/static/images/NoPictureDark.png" title="Avatar autor" alt="Gravatar" />';
   } else {
      return '<img src="http://www.google.com/friendconnect/static/images/NoPictureDark.png" title="Avatar autor" alt="Sin Avatar"/>';
   }
}

function get_most_voted()
{
	global $wpdb;
	$sql['select'] = 'SELECT wp_users.user_nicename, `mulapress_posts`.`ID`, `mulapress_posts`.`post_author`, DATE_FORMAT(`mulapress_posts`.`post_date`, \'%d-%m-%Y\') as post_date, `mulapress_posts`.`post_date_gmt`, `mulapress_posts`.`post_content`, `mulapress_posts`.`post_title`, `mulapress_posts`.`post_category`, `mulapress_posts`.`post_excerpt`, `mulapress_posts`.`post_status`, `mulapress_posts`.`comment_status`, `mulapress_posts`.`ping_status`, `mulapress_posts`.`post_password`, `mulapress_posts`.`post_name`, `mulapress_posts`.`to_ping`, `mulapress_posts`.`pinged`, `mulapress_posts`.`post_modified`, `mulapress_posts`.`post_modified_gmt`, `mulapress_posts`.`post_content_filtered`, `mulapress_posts`.`post_parent`, `mulapress_posts`.`guid`, `mulapress_posts`.`menu_order`, `mulapress_posts`.`post_type`, `mulapress_posts`.`post_mime_type`, `mulapress_posts`.`comment_count`';
	$sql['from'] = 'FROM mulapress_posts
					inner join mulapress_gdsr_votes_log on mulapress_posts.ID = mulapress_gdsr_votes_log.id
					inner join wp_users on mulapress_posts.post_author = wp_users.ID';
	$sql['order_by'] = 'ORDER BY vote DESC';
	$sql['limit'] = 'LIMIT 0,1';
	
	$post = $wpdb->get_results(implode(' ', $sql));
	unset($sql);	
	return current($post);
}

function get_blogs()
{
	global $wpdb;
	$sql['select'] = 'SELECT wp_blogs.blog_id, wp_bp_user_blogs.user_id';
	$sql['from'] = 'FROM wp_blogs join wp_bp_user_blogs 
                  ON wp_blogs.blog_id = wp_bp_user_blogs.blog_id';
  $sql['where'] = "WHERE public = '1' AND archived = '0' AND mature = '0' AND 
                         spam = '0' AND deleted = '0' AND
                         last_updated >= DATE_SUB(CURRENT_DATE(), INTERVAL 2 DAY)";
	$sql['order_by'] = 'ORDER BY last_updated DESC';

  $blogs = $wpdb->get_results(implode(' ', $sql));
	unset($sql);
  	  	
  	if ($blogs) {
  		foreach ($blogs as $blog) {

        $author = $wpdb->get_results("SELECT wp_users.user_nicename
                                  FROM wp_users 
                                  WHERE wp_users.ID = $blog->user_id");

  			$blogOptionsTable = "wp_".$blog->blog_id."_options";
  		  $blogPostsTable = "wp_".$blog->blog_id."_posts";
  		  
  			$options = $wpdb->get_results("SELECT option_value 
  			                               FROM $blogOptionsTable 
  			                               WHERE option_name IN ('siteurl','blogname') 
  				                             ORDER BY option_name DESC");

  			$thispost = $wpdb->get_results("SELECT id, post_title, guid
  				                              FROM $blogPostsTable 
  				                              WHERE post_status = 'publish' 
  				                                    AND post_type = 'post'  				                              ORDER BY id DESC 
  				                              LIMIT 0,1");

  			if($thispost) {		  			
  			  
  			  $current_post = current($thispost);
  			  $current_author = current($author);
  			  
          echo "<li>";
          // echo "<h4>" . $current_author->user_nicename . " en ". $options[1]->option_value . "</h4>";
          echo "<h4>" . $options[1]->option_value . "</h4>";          
          echo "<div class='blogger_avatar'></div>";
          echo "<div class='blogger_last_post_content'>";
          echo "<h5><a href='". $current_post->guid . "' title='Enlace al articulo'> " . $current_post->post_title . " </a></h5>";

          $content = $current_post->post_content;

          $content = apply_filters('the_content', $content);
          $content = str_replace(']]>', ']]&gt;', $content);
          //$content = snippet($content,235);
                
          echo $content;
          echo "</div>";
          echo "</li>";
            	
  					
  			}
 
  		}
  	
  	}
}


function get_a_post($post_id)
{
	global $wpdb;

	//$blog_id = 1;
	$blog = 'mulapress_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'
	                 and mulapress_posts.ID = ' . $post_id;	
	
	$sql['order_by'] = 'ORDER BY post_date ASC';
	$sql['limit'] = 'LIMIT 0,1';	
	//die(implode(' ',$sql));
	return $wpdb->get_results(implode(' ', $sql));
}


function get_a_blog($blog_id)
{
	global $wpdb;

	//$blog_id = 1;
	$blog = 'wp_' . $blog_id . '_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'';	
	$sql['order_by'] = 'ORDER BY post_date ASC';
	$sql['limit'] = 'LIMIT 0,1';	
	//die(implode(' ',$sql));
	return $wpdb->get_results(implode(' ', $sql));
}


function get_blog_random()
{
	global $wpdb;
	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
	$sql['where'] = 'WHERE public =1';
	$sql['order_by'] = 'ORDER BY RAND()';
	$sql['limit'] = 'LIMIT 0,1';
	
	
	
	$blog_id = $wpdb->get_results(implode(' ', $sql));
	$blog_id = current($blog_id);
	$blog_id = $blog_id->blog_id;
  // $blog_id = 1;
	$blog = 'wp_' . $blog_id . '_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'';	
	$sql['order_by'] = 'ORDER BY post_date ASC';
	$sql['limit'] = 'LIMIT 0,1';	
	//die(implode(' ',$sql));
	$post = $wpdb->get_results(implode(' ', $sql));
	unset($sql);
	return current($post);
}


function setup_featured_news($post,$type){ 
    
    $img_link = NULL;
    $img = NULL;
    setup_text($post->post_content,$img_link,$img);
  ?>
  
    <div>
        <div>
        <?php if ($img_link != "") { ?>
          <div class="top_news_media">
            <img src="<?php echo $img_link; ?>" alt="" title=""/>                  
          </div>

          <div class="top_news_featured_companion_text">
            <?php $post->post_content = eregi_replace($img->outertext, ' ', $post->post_content); ?>
            <?php echo mulapress_trim_excerpt($post->post_content, 35) ?>                 
          </div>
          <?php } 
        else 
        {  ?>
          <div class="top_news_featured_text">
            <?php echo mulapress_trim_excerpt($post->post_content, 35) ?>                                            
          </div>   
        <?php  }?>

        </div>
      <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $post->user_nicename; ?>" ><?php echo $post->user_nicename; ?></a> <em>el <?php echo $post->post_date; ?></em> desde <?php echo $type; ?></span>

    </div>

    <div class="top_news_featured_footer">

      <a href="<?php echo $post->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
      <p class="comments"><a href="<?php echo $post->guid; ?>#comments" class="comments"><?php echo comments_number('ning&uacute;n comentario', 'un comentario', 'm&aacute;s comentarios', $post->comment_count); ?> </a></p>
      <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>

    </div>	          
  
<?php }


function mostrar_ranking($ranking="mula wawa", $limit=5){
  
  		global $wpdb;
			
			
				$sql['select'] = 'SELECT puntaje, user_nicename, user_email, ID';
				$sql['from'] = 'FROM wp_users';			
				$sql['where'] = 'WHERE mularango = "' . $ranking . '"';  
	      $sql['order_by'] = 'ORDER BY puntaje DESC';				
				$sql['limit'] = 'LIMIT 0,' . $limit; 
				$ranking = $wpdb->get_results(implode(' ', $sql));
	      unset($sql);    		
	    
	      if ($ranking) {
       		foreach ($ranking as $mulero) {
	
	
	          	$sql['select'] = 'SELECT wp_usermeta.meta_value as avatar';
            	$sql['from'] = 'FROM wp_usermeta ';
            	$sql['where'] = 'where wp_usermeta.meta_key = "bp_core_avatar_v1" and wp_usermeta.user_id = ' . $mulero->ID ;	
            	$sql['limit'] = 'LIMIT 0,1';
              $avatar_results = $wpdb->get_results(implode(' ', $sql));
        	    unset($sql);    		
              $avatar_results = current($avatar_results);                    
	
			 ?>
			 
			 <li>
         <?php if ($avatar_results->avatar == "") {
           echo get_gravatar($blog_results->user_email);          
         }
         else
         {
           echo "<img src='".  $avatar_results->avatar . "' title='Avatar autor' /> ";          
         }
			    ?>
			    <a href="http://lamula.pe/members/<?php echo $mulero->user_nicename ?>"><?php echo $mulero->user_nicename ?></a> -
			    <strong><?php echo number_format($mulero->puntaje,0) ?></strong>
		   </li>
<?php  }
    }
    else {
      ?>
      <li class="not_found">
        
        Todav&iacute;a no hay muleros con &eacute;ste ranking. &iquest;Qu&eacute; est&aacute;s esperando para participar?
        
      </li>
      
      <?php }
}

function place_name($person){
  
    if (ISSET($person->user_nicename)){
      
        if ($person->user_nicename != ""){ return $person->user_nicename; }        
        else { return "anonimo"; }
      
    }
    
    
  
}

function mostrar_mas_votados($limit = 5){
  
  global $wpdb;
      
    $sql['select'] = 'SELECT user_votes + visitor_votes as votes, 
                             mulapress_posts.post_title, 
                             mulapress_posts.guid as post_url';
    $sql['from'] = 'FROM `mulapress_gdsr_data_article` 
                    JOIN mulapress_posts 
                    ON mulapress_gdsr_data_article.post_id = mulapress_posts.ID';
    $sql['where'] = 'where mulapress_posts.post_status = "publish"';                    
    $sql['order_by'] = 'order by votes';
    $sql['limit'] = 'LIMIT 0,' . $limit;
    
    $most_voted = $wpdb->get_results(implode(' ', $sql));
	  unset($sql);
	  
    if ($most_voted) {
  		foreach ($most_voted as $post) {

            echo "<li>";
            echo "<a href='" .  $post->post_url . "'>" . $post->post_title . "</a>";
            echo "</li>";

      }
    }

}

function mostrar_ultimos_comentarios($limit = 5){
  
  global $wpdb;
  
  $sql['select'] = 'SELECT mulapress_comments.comment_ID, 
                           mulapress_comments.comment_author, 
                           mulapress_comments.comment_content,  
                           wp_users.user_nicename, 
                           `mulapress_posts`.`post_author`, 
                           `mulapress_posts`.`post_title`,
                           `mulapress_posts`.`guid` as post_url';
                           
  $sql['from'] = 'FROM mulapress_comments
                 left join wp_users on mulapress_comments.user_id = wp_users.ID 
                 join mulapress_posts on mulapress_comments.comment_post_id = mulapress_posts.ID
                 ';
  $sql['order_by'] = 'ORDER BY post_date DESC';
  $sql['limit'] = 'LIMIT 0,' . $limit;
  $comments = $wpdb->get_results(implode(' ', $sql));
	unset($sql);  
  
  //muestra los ultimos comentarios 
  
  if ($comments) {
		foreach ($comments as $comment) {
		  
          echo "<li>";
          
          if ($comment->user_nicename != ""){
            echo "<a href='http://lamula.pe/members/" . $comment->user_nicename . "'>" . $comment->user_nicename . "</a> dijo ";            
          }
          else
          {
            echo $comment->comment_author . " dijo ";            
          }

          echo "<a href='" .  $comment->post_url . "#comments-" . $comment->comment_ID ."'>" . snippet($comment->comment_content,80) . "</a>";
          echo " en <a href='" .  $comment->post_url . "'>" . $comment->post_title . "</a>";
          echo "</li>";
          
        		  
    }
  }
      
        
  
}

function show_sidebar_bloggers($insiders = 6, $outsiders = 3)
{
  global $wpdb;
  
  //Obtenemos los blogs de los usuarios
	$blogs = array(16,26,40,41,45,47,51,57,59,62,64,67,71,72,75,78,79,85,87,96,153,208,213,214,222);
  // $blogs = array(1);
	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
	$sql['where'] = 'WHERE blog_id in (' . implode(',',$blogs) . ')';
	$sql['order_by'] = 'ORDER BY RAND()';
	$sql['limit'] = 'LIMIT 0,' . $insiders ;
	$insiders_blogs = $wpdb->get_results(implode(' ', $sql));
	unset($sql);

  //Obtenemos cualquier otros
	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
  // $sql['where'] = 'WHERE blog_id not in (' . implode(',',$blogs) . ')';
	$sql['where'] = 'WHERE blog_id NOT in (' . implode(',',$blogs) . ')';
	$sql['order_by'] = 'ORDER BY RAND()';
	$sql['limit'] = 'LIMIT 0,' . $outsiders ;
	$outsiders_blogs = $wpdb->get_results(implode(' ', $sql));
	unset($sql);


  //se crean los <li> de insiders
  if ($insiders_blogs) {
		foreach ($insiders_blogs as $blog) {
  
      $blog_id = $blog->blog_id;
      $blog_table = 'wp_' .$blog_id . '_posts';
      $blog_options_table = 'wp_' . $blog_id . '_options';
      
			$options = $wpdb->get_results("SELECT option_value 
			                               FROM $blog_options_table 
			                               WHERE option_name IN ('siteurl','blogname') 
				                             ORDER BY option_name DESC");
				                             
    	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_email, ' . $blog_table . '.ID, wp_users.ID as user_id';
    	$sql['from'] = 'FROM ' . $blog_table . '
    					inner join wp_users on ' . $blog_table . '.post_author = wp_users.ID';
    	$sql['where'] = 'where post_status = \'publish\'';	
    	$sql['order_by'] = 'ORDER BY post_date DESC';
    	$sql['limit'] = 'LIMIT 0,1';
      $blog_results = $wpdb->get_results(implode(' ', $sql));
	    unset($sql);    		
      $blog_results = current($blog_results);

    	$sql['select'] = 'SELECT wp_usermeta.meta_value as avatar';
    	$sql['from'] = 'FROM wp_usermeta ';
    	$sql['where'] = 'where wp_usermeta.meta_key = "bp_core_avatar_v1" and wp_usermeta.user_id = ' . $blog_results->user_id ;	
    	$sql['limit'] = 'LIMIT 0,1';
      $avatar_results = $wpdb->get_results(implode(' ', $sql));
	    unset($sql);    		
      $avatar_results = current($avatar_results);


//      bp_core_avatar_v1

      echo "<li>";
      echo "<div class='sidebar_foto'>";
        if ($avatar_results->avatar == "") {
          echo get_gravatar($blog_results->user_email);          
        }
        else
        {
          echo "<img src='".  $avatar_results->avatar . "' title='Avatar autor' /> ";          
        }

      echo "</div>";
      echo "<div class='sidebar_txt'>";
      echo "<h6><a href='" .  $options[0]->option_value . "'>" . $options[1]->option_value . "</a></h6>";
//      echo "<strong>de <a href='http://lamula.pe/members/" . $blog_results->user_nicename . "'>" . $blog_results->user_nicename . "</a></strong>";
      echo "<strong>de <a href='" .  $options[0]->option_value . "'>" . $blog_results->user_nicename . "</a></strong>";
      echo "<p></p>";
      echo "</div>";
      echo "</li>";
  
    }
    
  }
  
  // se crean <li> de los outsiders
  if ($outsiders_blogs) {
		foreach ($outsiders_blogs as $blog) {
  
          $blog_id = $blog->blog_id;
          $blog_table = 'wp_' .$blog_id . '_posts';
          $blog_options_table = 'wp_' . $blog_id . '_options';

    			$options = $wpdb->get_results("SELECT option_value 
    			                               FROM $blog_options_table 
    			                               WHERE option_name IN ('siteurl','blogname') 
    				                             ORDER BY option_name DESC");

        	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, wp_users.user_email, ' . $blog_table . '.ID, wp_users.ID as user_id';
        	$sql['from'] = 'FROM ' . $blog_table . '
        					inner join wp_users on ' . $blog_table . '.post_author = wp_users.ID';
        	$sql['where'] = 'where post_status = \'publish\'';	
        	$sql['order_by'] = 'ORDER BY post_date DESC';
        	$sql['limit'] = 'LIMIT 0,1';
          $blog_results = $wpdb->get_results(implode(' ', $sql));
    	    unset($sql);    		
          $blog_results = current($blog_results);

        	$sql['select'] = 'SELECT wp_usermeta.meta_value as avatar';
        	$sql['from'] = 'FROM wp_usermeta ';
        	$sql['where'] = 'where wp_usermeta.meta_key = "bp_core_avatar_v1" and wp_usermeta.user_id = ' . $blog_results->user_id ;	
        	$sql['limit'] = 'LIMIT 0,1';
          $avatar_results = $wpdb->get_results(implode(' ', $sql));
    	    unset($sql);    		
          $avatar_results = current($avatar_results);


    //      bp_core_avatar_v1

          echo "<li>";
          echo "<div class='sidebar_foto'>";

            if ($avatar_results->avatar == "") {
              echo get_gravatar($blog_results->user_email);          
            }
            else
            {
              echo "<img src='".  $avatar_results->avatar . "' title='Avatar autor' /> ";          
            }

          echo "</div>";
          echo "<div class='sidebar_txt'>";
          echo "<h6><a href='" .  $options[0]->option_value . "'>" . $options[1]->option_value . "</a></h6>";
          echo "<strong>de <a href='" .  $options[0]->option_value . "'>" . $blog_results->user_nicename . "</a></strong>";
          echo "<p></p>";
          echo "</div>";
          echo "</li>";
  
    }
    
  }  
  
  // $sql['join'] = 'JOIN wp_bp_user_blog ON wp_blogs.blog_id = wp_bp_user_blog.blog_id ';
  // $sql['join2'] = 'JOIN wp_users ON wp_bp_user_blog.user_id = wp_users.user_id ';    

}

function get_blog_special()
{
	global $wpdb;
	$blogs = array(16,26,40,41,45,47,51,57,59,62,64,67,71,72,75,78,79,85,87,96,153,208,213,214,222);
  // $blogs = array(1);
	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
	$sql['where'] = 'WHERE blog_id in (' . implode(',',$blogs) . ')';
	$sql['order_by'] = 'ORDER BY RAND()';
	$sql['limit'] = 'LIMIT 0,1';
	//die(implode(' ',$sql));
	$blog_id = $wpdb->get_results(implode(' ', $sql));
	$blog_id = current($blog_id);
	$blog_id = $blog_id->blog_id;
	$blog = 'wp_' . $blog_id . '_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'';	
	$sql['order_by'] = 'ORDER BY post_date ASC';
	$sql['limit'] = 'LIMIT 0,1';	
	//die(implode(' ',$sql));
	$post = $wpdb->get_results(implode(' ', $sql));
	return current($post);
}

?>
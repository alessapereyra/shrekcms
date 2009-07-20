<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

include('simple_html_dom.php');

if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '1',
'after_widget' => '2',
'before_title' => '3',
'after_title' => '4',
));
  



	/**
	 * Obtiene los ultimos blogs actualizados
	 * @return object
	 */	    
    function get_last_blogs_updated()
    {
    	global $wpdb;
    	
		$sql['select'] = 'SELECT blog_id';
		$sql['from'] = 'FROM wp_blogs';
		$sql['where'] = "WHERE spam = '0' AND headlines = '1' and public = '1'";
		$sql['order_by'] = 'ORDER BY last_updated DESC';
		$sql['limit'] = 'LIMIT 0, 10';
		return  $wpdb->get_results(implode(' ', $sql));
    }
    
	/**
	 * Obtiene los post para mostrar en portada
	 * @param object $blogs blogs a mostrar
	 * @return object
	 */	    
	function get_index_post($blogs)
	{
	    global $wpdb;
		
		foreach($blogs as $blog)
		{
			$wp_posts = 'wp_' . $blog->blog_id . '_posts';
			$wp_term_taxonomy = 'wp_' . $blog->blog_id . '_term_taxonomy';
			$wp_term_relationships = 'wp_' . $blog->blog_id . '_term_relationships';
			$wp_terms = 'wp_' . $blog->blog_id . '_terms';
			$wp_users = 'wp_users';
			
			//tabla post
			$sql['select'] = 'SELECT ' . $wp_posts . '.ID, ' . $wp_posts . '.post_title, ' . $wp_posts . '.post_content, ' . $wp_posts . '.comment_count, ' . $wp_posts . '.guid, ';
			//time
			$sql['select'] .= $wp_posts . '.post_date , DATE_FORMAT(' . $wp_posts . '.post_date,\'%d/%m/%Y\') as my_date, DATE_FORMAT(' . $wp_posts . '.post_date,\'%l:%i %p\') as my_time, ';
			//tabla user
			$sql['select'] .= $wp_users . '.user_login, ' . $wp_users . '.user_nicename';
			
			//from
			$sql['from'] = 'FROM ' . $wp_posts . ' ';
			$sql['from'] .= 'INNER JOIN ' . $wp_users . ' ON ' . $wp_users . '.ID = ' . $wp_posts . '.post_author ';
			
			//where
			$sql['where'] = 'WHERE post_type = \'post\' AND post_status = \'publish\' ';			
			
			//order by
			$sql['order_by'] = 'ORDER BY post_date DESC';
			
			$sql['limit'] = 'LIMIT 0, 10';
			
			$the_sql[] = implode(' ', $sql);
		}
		
		$wp_posts = 'wp_1_posts';
		$wp_term_taxonomy = 'mulapress_term_taxonomy';
		$wp_term_relationships = 'wp_1_terms_relationships';
		$wp_terms = 'mulapress_terms';
		$wp_users = 'wp_users';
					
		//tabla post
		$sql['select'] = 'SELECT ' . $wp_posts . '.ID, ' . $wp_posts . '.post_title, ' . $wp_posts . '.post_content, ' . $wp_posts . '.comment_count, ' . $wp_posts . '.guid, ';
		//time
		$sql['select'] .= $wp_posts . '.post_date , DATE_FORMAT(' . $wp_posts . '.post_date,\'%d/%m/%Y\') as my_date, DATE_FORMAT(' . $wp_posts . '.post_date,\'%l:%i %p\') as my_time, ';
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
		//Me excluyo para no molestar			
		//$sql['where'] .= ' AND (' . $wp_users . '.user_login != \'dientuki\')';
		//order by
		$sql['order_by'] = 'ORDER BY post_date DESC';
		
		$sql['limit'] = 'LIMIT 0, 10';
		
		$the_sql[] = implode(' ', $sql);
	
		unset($sql);
		
		$sql = '(' . implode(') UNION (', $the_sql) . ') ORDER BY post_date DESC LIMIT 0, 20';
		return $wpdb->get_results($sql);
	}    

	/**
	 * Obtiene el id de un blog a partir de una url
	 * @param string $url url
	 * @return integer
	 */	
  function get_blog_id_from($url){
    
    
    $url = str_replace("http://", "", $url);
    $url = str_replace("/", "", $url);
        
  	global $wpdb;
  	$sql['select'] = 'SELECT blog_id';
  	$sql['from'] = 'FROM wp_blogs';
  	$sql['where'] = 'WHERE domain LIKE "' . $url .'"';
  	$sql['limit'] = 'LIMIT 0,1';
  	$blog_id = $wpdb->get_results(implode(' ', $sql));
  	$blog_id = current($blog_id);
  	$blog_id = $blog_id->blog_id;    
  	

    return $blog_id;

  }
  
	/**
	 * Obtiene un post a partir de su guid
	 * @param string $guid guid
	 * @return array
	 */	  
  function get_post_from_guid($guid)
  {
  	global $wpdb;

  	$blog = 'wp_1_posts';
  	
  	$guid_total = explode("/",$guid);
  	$guid = array_slice($guid_total, -2, 1);
  	$guid = current($guid);
  	
  	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
  	$sql['from'] = 'FROM ' . $blog . ' inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
  	$sql['where'] = 'where post_status = \'publish\' and wp_1_posts.post_name = "' . $guid . '"';	

  	$sql['order_by'] = 'ORDER BY post_modified ASC';
  	$sql['limit'] = 'LIMIT 0,1';	

  	$post = $wpdb->get_results(implode(' ', $sql));
  	return current($post); 
  }

  	/**
	 * Obtiene un post para mostrar en los titulares
	 * @param integer $id
	 * @param string $text texto
	 * @return object
	 */	
  function get_from_header($id, &$text){
    
    global $wpdb;
  	$sql['select'] = 'SELECT header_type, header_source';
  	$sql['from'] = 'FROM mulapress_news_headers';
  	$sql['where'] = 'WHERE id = ' . $id;
  	$sql['limit'] = 'LIMIT 0,1';
  	$header = $wpdb->get_results(implode(' ', $sql));
  	$header = current($header);
  	unset($sql);
    $post = NULL;
    
    switch ($header->header_type) {

        case "blog":
        
            $blog_id = get_blog_id_from($header->header_source);
            $post = get_from_blog($blog_id);
            $text = $header->header_source;
            break;

        case "post":
            $post = get_post_from_guid($header->header_source);
            $text = "una nota de " . $post->user_nicename;
            break;

        case "most_voted":
            $post = get_most_voted();
            $text = "las m&aacute;s votadas ";        
            break;

        case "most_commented":
            $post = kf_get_posts_by_hits(7,1,false);
            $text = "las m&aacute;s comentadas ";        
            break;

        case "special_blogs":
            $post = get_blog_special();
            $text = "nuestra red ";                    
            break;    

        case "feature":

            $text = "las noticias destacadas ";        
            break;

        case "random_blog":
            $post = get_blog_random();
            $text = "nuestros bloggers ";        
            break;

    }
    
      return $post;
  }

  	/**
	 * Corta el principio del texto para mostra en el home
	 * @param string $text texto a cortar
	 * @param integer $length cantidad de caracteres
	 * @param string $tail texto a mostrar luego del texto principal
	 * @return string
	 */	  
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

  	/**
	 * Obtiene el src de una imagen a partir de un contenido
	 * @param string $content contenido
	 * @param string $img_link src de la imagen
	 * @param string $img tag completo de la imagen
	 * @return string
	 */	 
function setup_text($content, &$img_link = NULL,&$img = NULL){
  
  $html = str_get_html($content);
  $img_link = $html->find('img',0)->src;
  $img = $html->find('img',0);
  $html->clear(); 
  unset($html);          
  
}

  	/**
	 * Corta el principio del texto para mostra en el home
	 * @param string $text texto a cortar
	 * @param integer $length cantidad de caracteres
	 * @return string
	 */	 
function mulapress_trim_excerpt($text, $length = 55) {

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		// $text = strip_tags($text,'<a><strong><object><embed><em><b><i>');
		$text = strip_tags($text);		
		$excerpt_length = apply_filters('excerpt_length', $length);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '[...]');
			$text = implode(' ', $words);
		}
		
	return $text;
}

  	/**
	 * Pone un comentario
	 * @param string $comment comentario
	 * @return void
	 */	 
function mula_comments($comment) {
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

  	/**
	 * Lista las categorias
	 * @param string $separator separador
	 * @return string
	 */	
function the_category_unlinked($separator = ' ') {
    $categories = (array) get_the_category();

    $thelist = '';
    foreach($categories as $category) {    // concate
        $thelist .= $separator . $category->category_nicename;
    }

    echo $thelist;
}

  	/**
	 * Obtiene una diferencia de tiempo
	 * @param integer $timestamp marca de tiempo
	 * @param integer $granularity periodos de tiempo
	 * @param string $format formato del tiempo
	 * @return string
	 */	
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

  	/**
	 * Marca el post como que alguien lo esta leyendo
	 * @param string $mypost post
	 * @return void
	 */
function sm_store_session_data($mypost) {
	get_currentuserinfo();

	global $wpdb, $table_name, $current_user, $excludes_table, $user_excludes_table;

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

  	/**
	 * Obtiene un gravatar
	 * @param string $email email
	 * @return string
	 */
function get_gravatar($email="") {
   if ($email) {
      $email=trim($email);
      $email=md5($email);
      
      return '<img src="http://www.gravatar.com/avatar/'.$email.'?s=40&amp;d=http://lamula.pe/wp-content/bp-themes/bpskeletonmember/images/skull-transparent.png" title="Avatar autor" alt="Gravatar" />';
   } else {
      return '<img src="http://lamula.pe/wp-content/bp-themes/bpskeletonmember/images/skull-transparent.png" title="Avatar autor" alt="Sin Avatar"/>';
   }
}

  	/**
	 * Obtiene los post mas votados
	 * @return array
	 */
function get_most_voted()
{
	global $wpdb;
	$sql['select'] = 'SELECT wp_users.user_nicename, `wp_1_posts`.`ID`, `wp_1_posts`.`post_author`, DATE_FORMAT(`wp_1_posts`.`post_date`, \'%d-%m-%Y\') as post_date, `wp_1_posts`.`post_date_gmt`, `wp_1_posts`.`post_content`, `wp_1_posts`.`post_title`, `wp_1_posts`.`post_category`, `wp_1_posts`.`post_excerpt`, `wp_1_posts`.`post_status`, `wp_1_posts`.`comment_status`, `wp_1_posts`.`ping_status`, `wp_1_posts`.`post_password`, `wp_1_posts`.`post_name`, `wp_1_posts`.`to_ping`, `wp_1_posts`.`pinged`, `wp_1_posts`.`post_modified`, `wp_1_posts`.`post_modified_gmt`, `wp_1_posts`.`post_content_filtered`, `wp_1_posts`.`post_parent`, `wp_1_posts`.`guid`, `wp_1_posts`.`menu_order`, `wp_1_posts`.`post_type`, `wp_1_posts`.`post_mime_type`, `wp_1_posts`.`comment_count`';
	$sql['from'] = 'FROM wp_1_posts inner join mulapress_gdsr_votes_log on wp_1_posts.ID = mulapress_gdsr_votes_log.id inner join wp_users on wp_1_posts.post_author = wp_users.ID';
	$sql['order_by'] = 'ORDER BY vote DESC';
	$sql['limit'] = 'LIMIT 0,1';
	
	$post = $wpdb->get_results(implode(' ', $sql));
	unset($sql);	
	return current($post);
}

function mostrar_columneros($insiders = 6, $outsiders = 3)
{
  global $wpdb;
  
  //Obtenemos los blogs de los usuarios
  	$sql['select'] = 'SELECT mulapress_default_blogs.blog_id AS blog';
  	$sql['from'] = 'FROM
					mulapress_default_blogs
					Inner Join wp_blogs ON wp_blogs.blog_id = mulapress_default_blogs.blog_id';
  	$sql['order_by'] = 'order by wp_blogs.last_updated DESC';
  	$sql['limit'] = 'limit 13';
  	$consulta = $wpdb->get_results(implode(' ', $sql));
  	foreach ($consulta as $cons)
  	{
  		$blogs[] = $cons->blog;	
  	}

    unset($sql);    		

  //Obtenemos cualquier otros
  	$consulta = $wpdb->get_results('SELECT option_value FROM mulapress_options WHERE option_name = \'bloggers_random\'');
	foreach ($consulta as $cons)
	{
		$outsiders = $cons->option_value;
	}
	
	
	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
  //$sql['where'] = 'WHERE blog_id not in (' . implode(',',$blogs) . ')';
	$sql['where'] = 'WHERE blog_id NOT in (' . implode(',',$blogs) . ') AND spam = "0"';
	$sql['order'] = 'order by wp_blogs.last_updated DESC';
	$sql['limit'] = 'LIMIT 0,' . $outsiders ;
	$outsiders_blogs = $wpdb->get_results(implode(' ', $sql));
	unset($sql);




  //se crean los <li> de insiders
  //if ($insiders_blogs) {
		foreach ($blogs as $key => $value) {
  
      $blog_id = $value;
      $blog_table = 'wp_' .$blog_id . '_posts';
      $blog_options_table = 'wp_' . $blog_id . '_options';
      
			$options = $wpdb->get_results("SELECT option_value 
			                               FROM $blog_options_table 
			                               WHERE option_name IN ('siteurl','blogname') 
				                             ORDER BY option_name DESC");
				                             
    	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_email, ' . $blog_table . '.ID, ' . $blog_table . '.post_content,   ' . $blog_table . '.post_title, DATE_FORMAT(' . $blog_table . '.post_date, \'%d-%m\') as postdate, ' . $blog_table . '.comment_count, ' . $blog_table . '.guid, wp_users.ID as user_id';
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
	  echo "<div class='columna_top'>";
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
      echo "</div>";
      echo "</div>";
      echo "<div class='columna_content'>";
	  echo "<div class='columna_meta'>";
	  echo "<span class='columna_date'>" . $blog_results->postdate . "</span>";
	  // echo "<span class='columna_comentarios'>" . $blog_results->comment_count . "</span>";
	  echo "</div>";
      echo "<div class='columna_excerpt'>";
	  echo "<h4><a href='". $blog_results->guid ."'>" . $blog_results->post_title . "</a></h4>";
      echo mulapress_trim_excerpt($blog_results->post_content, 30) . " <a href='" . $blog_results->guid ."'> leer</a></div>";
 	  echo "</div>";
      echo "</li>";
  
    }
    
  //}
  
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

         	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_email, ' . $blog_table . '.ID, ' . $blog_table . '.post_content,   ' . $blog_table . '.post_title, DATE_FORMAT(' . $blog_table . '.post_date, \'%d-%m\') as postdate, ' . $blog_table . '.comment_count, ' . $blog_table . '.guid, wp_users.ID as user_id';
        	$sql['from'] = 'FROM ' . $blog_table . '
        					inner join wp_users on ' . $blog_table . '.post_author = wp_users.ID';
        	$sql['where'] = 'where post_status = \'publish\'';	
        	$sql['order_by'] = 'ORDER BY post_modified DESC';
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
		  echo "<div class='columna_top'>";
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
	      echo "</div>";
	      echo "</div>";
	      echo "<div class='columna_content'>";
		  echo "<div class='columna_meta'>";
		  echo "<span class='columna_date'>" . $blog_results->postdate . "</span>";
		  // echo "<span class='columna_comentarios'>" . $blog_results->comment_count . "</span>";
		  echo "</div>";
	      echo "<div class='columna_excerpt'>";
		  echo "<h4><a href='". $blog_results->guid ."'>" . $blog_results->post_title . "</a></h4>";
	      echo mulapress_trim_excerpt($blog_results->post_content, 30) . " <a href='" . $blog_results->guid ."'> leer</a></div>";
	 	  echo "</div>";
	      echo "</li>";
  
    }
    
  }  
  
  // $sql['join'] = 'JOIN wp_bp_user_blog ON wp_blogs.blog_id = wp_bp_user_blog.blog_id ';
  // $sql['join2'] = 'JOIN wp_users ON wp_bp_user_blog.user_id = wp_users.user_id ';    

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
          echo "<h4>" . $options[1]->option_value . "</h4>";          
          echo "<div class='blogger_avatar'></div>";
          echo "<div class='blogger_last_post_content'>";
          echo "<h5><a href='". $current_post->guid . "' title='Enlace al articulo'> " . $current_post->post_title . " </a></h5>";

          $content = $current_post->post_content;

          $content = apply_filters('the_content', $content);
          $content = str_replace(']]>', ']]&gt;', $content);
                
          echo $content;
          echo "</div>";
          echo "</li>";
            					
  			}
 
  		}
  	
  	}
}

  	/**
	 * Obtiene un post
	 * @param integer $post_id id del post
	 * @return object
	 */
function get_a_post($post_id)
{
	global $wpdb;

	$blog = 'wp_1_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'
	                 and wp_1_posts.ID = ' . $post_id;	
	
	$sql['order_by'] = 'ORDER BY post_modified DESC';
	$sql['limit'] = 'LIMIT 0,1';	

	return $wpdb->get_results(implode(' ', $sql));
}

  	/**
	 * Obtiene un blog
	 * @param integer $blog_id id del blog
	 * @return object
	 */
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

	return $wpdb->get_results(implode(' ', $sql));	
}

  	/**
	 * Obtiene un blog de manera random
	 * @return object
	 */
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

	$blog = 'wp_' . $blog_id . '_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, wp_users.user_login, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'';	
	$sql['order_by'] = 'ORDER BY post_modified DESC';
	$sql['limit'] = 'LIMIT 0,1';	

	$post = $wpdb->get_results(implode(' ', $sql));
	unset($sql);
	return current($post);
}

  	/**
	 * Obtiene el tag de youtube
	 * @param string $content contenido
	 * @return boolean|string
	 */
function get_youtubetag($content)
{	
	$find = '[y';
	$prim = strpos($content, $find);
	
	$find = 'e]';
	$ult = strrpos($content, $find) + 1;
	
	$cant = $ult-$prim + 1;
	
	$youtube =  substr($content, $prim, $cant);
	
	if ($youtube != '')
	{
		return $youtube;
	}
	else
	{
		return false;
	}
}

  	/**
	 * Muestra un post en la portada
	 * @param object $new_post post
	 * @param string $type tipo de post
	 * @return void
	 */
function setup_featured_news($new_post,$type){ 
    
    $img_link = NULL;
    $img = NULL;

    $html = str_get_html($new_post->post_content);
    $img_link = $html->find('img',0)->src;
    $img = $html->find('img',0);
    $html->clear(); 
    unset($html);
    
    $youtube = get_youtubetag($new_post->post_content);
  ?>
  
    <div class="top_news_content">
      
		<h4><?php echo $type; ?></h4>
        <h3>
            <a href="<?php echo $new_post->guid ?>"><?php echo $new_post->post_title ?></a>
        </h3>
      
        <div>
        <?php if ($img_link != "") { ?>
          <div class="top_news_media">
            <img title="<?php if ($youtube != FALSE) echo $youtube; ?>" src="<?php echo $img_link; ?>" alt="" title=""/>                  
          </div>

          <div class="top_news_featured_companion_text">
            <?php if ($img->outertext != FALSE)
            {
            	$new_post->post_content = eregi_replace($img->outertext, ' ', $new_post->post_content);
            } ?>

            <?php echo mulapress_trim_excerpt($new_post->post_content, 30) ?>                 
		    <div class="top_news_featured_footer">
	      	<a href="<?php echo $new_post->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	      	<p class="comments"><a href="<?php echo $new_post->guid; ?>#comments" class="comments"><?php echo comments_number('ning&uacute;n comentario', 'un comentario', 'm&aacute;s comentarios', $new_post->comment_count); ?> </a></p>
		     <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>

		    </div>	          

          </div>
          <?php } 
        else 
        {  ?>
          <div class="top_news_featured_text">
            <?php echo mulapress_trim_excerpt($new_post->post_content, 30) ?>     

		    <div class="top_news_featured_footer">
	      	<a href="<?php echo $new_post->guid ?>" class="leer_mas_footer">Leer m&aacute;s</a>
	      	<p class="comments"><a href="<?php echo $new_post->guid; ?>#comments" class="comments"><?php echo comments_number('ning&uacute;n comentario', 'un comentario', 'm&aacute;s comentarios', $new_post->comment_count); ?> </a></p>
		     <p class="rate"><em><?php //wp_gdsr_render_article(); ?></em></p>

		    </div>	          

                                       
          </div>   
        <?php  }?>

        </div>
      <span class="author">enviado por <a href="http://lamula.pe/members/<?php echo $new_post->user_nicename; ?>" ><?php echo $new_post->user_nicename; ?></a> <em>el <?php echo $new_post->post_date; ?></em></span>

    </div>

  
<?php }

  	/**
	 * Muestra el ranking de un rango
	 * @param string $ranking rango a mostrar
	 * @param integer $limit cantidad de usuarios a mostrar
	 * @return void
	 */
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
			    <a href="http://lamula.pe/members/<?php echo $mulero->user_nicename ?>"><?php echo $mulero->user_nicename ?></a>
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

  	/**
	 * Muestra el nombre de un usuario
	 * @param object $person usuario
	 * @return void
	 */
function place_name($person){
  
    if (ISSET($person->user_nicename)){
      
        if ($person->user_nicename != ""){ return $person->user_nicename; }        
        else { return "anonimo"; }
      
    }
}

  	/**
	 * Muestra los post mas votados
	 * @param integer $limit cantidad de post a mostrar
	 * @return void
	 */
function mostrar_mas_votados($limit = 5){
  
  global $wpdb;
      
    $sql['select'] = 'SELECT user_votes + visitor_votes as votes, 
                             wp_1_posts.post_title, 
                             wp_1_posts.guid as post_url';
    $sql['from'] = 'FROM `mulapress_gdsr_data_article` 
                    JOIN wp_1_posts 
                    ON mulapress_gdsr_data_article.post_id = wp_1_posts.ID';
    $sql['where'] = 'where wp_1_posts.post_status = "publish"';                    
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

  	/**
	 * Muestra los ultimos comentarios
	 * @param integer $limit cantidad de comentarios a mostrar
	 * @return void
	 */
function mostrar_ultimos_comentarios($limit = 5){
  
  global $wpdb;
  
  $sql['select'] = 'SELECT wp_1_comments.comment_ID, 
                           wp_1_comments.comment_author, 
                           wp_1_comments.comment_content,  
                           wp_users.user_nicename, 
                           `wp_1_posts`.`post_author`, 
                           `wp_1_posts`.`post_title`,
                           `wp_1_posts`.`guid` as post_url';
                           
  $sql['from'] = 'FROM wp_1_comments
                 left join wp_users on wp_1_comments.user_id = wp_users.ID 
                 join wp_1_posts on wp_1_comments.comment_post_id = wp_1_posts.ID
                 ';
  $sql['order_by'] = 'ORDER BY post_modified DESC';
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

  	/**
	 * Muestra los ultimos comentarios
	 * @param integer $insiders
	 * @param integer $outsiders
	 * @return void
	 */
function show_sidebar_bloggers($insiders = 6, $outsiders = 3)
{
  global $wpdb;
  
  //Obtenemos los blogs de los usuarios
  	$consulta = $wpdb->get_results("SELECT blog_id as blog FROM mulapress_default_blogs");
  	foreach ($consulta as $cons)
  	{
  		$blogs[] = $cons->blog;	
  	}

  //Obtenemos cualquier otros
  	$consulta = $wpdb->get_results('SELECT option_value FROM mulapress_options WHERE option_name = \'bloggers_random\'');
	foreach ($consulta as $cons)
	{
		$outsiders = $cons->option_value;
	}
	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
	$sql['where'] = 'WHERE blog_id NOT in (' . implode(',',$blogs) . ')';
	$sql['order_by'] = 'ORDER BY RAND()';
	$sql['limit'] = 'LIMIT 0,' . $outsiders ;
	$outsiders_blogs = $wpdb->get_results(implode(' ', $sql));
	unset($sql);


  //se crean los <li> de insiders
		foreach ($blogs as $key => $value) {
  
      $blog_id = $value;
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
    	$sql['order_by'] = 'ORDER BY post_modified DESC';
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
        	$sql['order_by'] = 'ORDER BY post_modified DESC';
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

}

  	/**
	 * Muestra un blog
	 * @param integer $from_id id del blog
	 * @return array
	 */
function get_from_blog($from_id)
{
	global $wpdb;
	$blog_id = $from_id;
	$blog = 'wp_' . $blog_id . '_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status != \'draft\'';	
	$sql['order_by'] = 'ORDER BY post_modified DESC';
	$sql['limit'] = 'LIMIT 0,1';	
	$post = $wpdb->get_results(implode(' ', $sql));
	return current($post);
}

  	/**
	 * Muestra los blogs especiales
	 * @return array
	 */
function get_blog_special()
{
	global $wpdb;
	$blogs = array(16,26,40,41,45,47,51,57,59,62,64,67,71,72,75,78,79,85,87,96,153,208,213,214,222);

	$sql['select'] = 'SELECT blog_id';
	$sql['from'] = 'FROM wp_blogs';
	$sql['where'] = 'WHERE blog_id in (' . implode(',',$blogs) . ')';
	$sql['order_by'] = 'ORDER BY RAND()';
	$sql['limit'] = 'LIMIT 0,1';

	$blog_id = $wpdb->get_results(implode(' ', $sql));
	$blog_id = current($blog_id);
	$blog_id = $blog_id->blog_id;
	$blog = 'wp_' . $blog_id . '_posts';
	unset($sql);
	
	$sql['select'] = 'SELECT wp_users.user_nicename, ' . $blog . '.ID, post_author, DATE_FORMAT(post_date, \'%d-%m-%Y\') as post_date, post_date_gmt, post_content, post_title, post_category, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count';
	$sql['from'] = 'FROM ' . $blog . '
					inner join wp_users on ' . $blog . '.post_author = wp_users.ID';
	$sql['where'] = 'where post_status = \'publish\'';	
	$sql['order_by'] = 'ORDER BY post_date DESC';
	$sql['limit'] = 'LIMIT 0,1';	

	$post = $wpdb->get_results(implode(' ', $sql));
	return current($post);
}

?>

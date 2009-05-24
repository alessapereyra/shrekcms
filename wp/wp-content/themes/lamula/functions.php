<?php

include('simple_html_dom.php');

if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '1',
'after_widget' => '2',
'before_title' => '3',
'after_title' => '4',
));

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

?>
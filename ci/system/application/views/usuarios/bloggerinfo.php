<h2><?php 
		$tmp = ''; 
		if (isset($first_name)) $tmp .= $first_name;
		if (isset($last_name)) $tmp .= " " . $last_name;
    if ($tmp == "admin ") {  $tmp = "lamula";}
    if (isset($nombre_completo)) {echo $nombre_completo;}
		echo $tmp;
?></h2>

<h3>
  <?php if (isset($nickname)) 
        {   
          if ($nickname == "admin") { echo "lamula"; }  
          else { echo $nickname; }
          
        }
          
  ?>
</h3>

<p id="edit_profile">
  <?php echo $logged_id . " wp=" . $id ; ?>
<?php if ($logged_id == $id){
  echo anchor('Modificar tu perfil','usuarios/perfil');
} ?>
</p>

<h4>Blogger de:<?php if (isset($blogs)): ?> 
				<a href="http://<?php echo $blogs; ?>"><?php echo $blogs; ?></a>
				<?php endif; ?>
</h4> 
  
<p><?php if (isset($description)) echo "Sobre el mulero: " . $description; ?></p>

<div id="blogger_data">

  <p id="since">Mulero por convicci&oacute;n desde <?php echo $user['user_registered']; ?></p>

  <?php foreach($views as $view): ?>
    <p>Estuvo por aqu&iacute; <?php echo timeAgo($view['unixtime']); ?>
  <?php endforeach; ?>
  
  <p id="published">Notas publicadas: <?php echo $published_posts ?></p>
  <p id="url">Sitio web: <?php if (isset($url)) echo anchor($url,$url);  ?></p>
  

  <p id="comments_done">Comentarios Realizados: <?php echo $total_comments ?></p>

  <p id="mularanking">Ranking: <?php echo $mula_ranking ?></p>

  
</div>

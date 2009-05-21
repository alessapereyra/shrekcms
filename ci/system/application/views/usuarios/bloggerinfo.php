<h2><?php 
		$tmp = ''; 
		if (isset($first_name)) $tmp .= $first_name;
		if (isset($last_name)) $tmp .= " " . $last_name;
    if ($tmp == "admin") {  $tmp = "lamula";}

		echo $tmp;
?></h2>

<h3>
  <?php if (isset($nickname)) 
        {   
          if ($tmp == "admin") { echo "lamula"; }  
          else { echo $nickname; }
          
        }
          
  ?>
</h3>
<h4>Blogger de:<?php if (isset($blogs)): ?> 
				<a href="http://<?php echo $blogs; ?>"><?php echo $blogs; ?></a>
				<?php endif; ?>
</h4> 
  
<p><?php if (isset($description)) echo $description; ?></p>

<p>Mulero por convicci&oacute;n desde <?php echo $user['user_registered']; ?></p>

<?php foreach($views as $view): ?>
  <p>Estuvo por aqu&iacute; <?php echo timeAgo($view['unixtime']); ?>
<?php endforeach; ?>

<p>Notas publicadas: <?php echo $total_posts ?></p>
<p>Comentarios Realizados: <?php echo $total_comments ?></p>
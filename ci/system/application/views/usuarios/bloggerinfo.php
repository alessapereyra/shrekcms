<h2><?php 
		$tmp = ''; 
		if (isset($first_name)) echo $tmp .= $first_name;
		if (isset($last_name)) echo $tmp .= $last_name;
		echo $tmp;
?></h2>

<h3><?php if (isset($nickname)) echo $nickname; ?></h3>
<h4>Blogger de:<?php if (isset($blogs)): ?> 
				<a href="http://<?php echo $blogs; ?>"><?php echo $blogs; ?></a>
				<?php endif; ?>
</h4> 
  
<p><?php if (isset($descripcion)) echo $descripcion; ?></p>
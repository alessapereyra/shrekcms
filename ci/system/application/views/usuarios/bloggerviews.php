<ul class="bloggers_list">

	<?php foreach($views as $view): ?>
	<li>

	  <a href="<?php echo $view['guid'] ?>">
	  <?php echo $view['post_title'] ?>
	  </a>
		

	</li>
	<?php endforeach; ?>

</ul>

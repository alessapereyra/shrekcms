<?php include '/usr/local/www/wordpress-mu2/mulapress/ci/system/cidip/cidip_index.php';  ?>


<ul class="bloggers_list">
    
  <?php foreach($comments as $comment): ?>
	<li>
	  
	  <?php $current_post = $ci->post->seleccionar(array('post_id' => $comment['post_id'])); ?>
	  
	  
		<a href="<?php echo $comment['comment_author_email']; ?>">
		  <?php echo $comment['comment_author']; ?>
		</a> dijo 
		
		  <a href="<?php echo $current_post['guid'] . "#comment-"  . $comment['comment_ID']; ?>">
		    <?php echo $comment['comment_content']; ?>
		  </a>

	</li>
	<?php endforeach; ?>

</ul>
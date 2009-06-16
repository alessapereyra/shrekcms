<ul class="bloggers_list">
    
  <?php foreach($comments as $comment): ?>
	<li>
	  
		<a href="mailto:<?php echo $comment['comment_author_email']; ?>">
		  <?php echo $comment['comment_author']; ?>
		</a> dijo 
		
		  <a href="<?php echo $comment['guid'] . "#comment-"  . $comment['comment_ID']; ?>">
		    <?php echo $comment['comment_content']; ?>
		  </a>

	</li>
	<?php endforeach; ?>

</ul>
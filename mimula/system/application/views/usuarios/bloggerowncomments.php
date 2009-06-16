<ul class="bloggers_list">
    
  <?php foreach($comments as $comment): ?>
	<li>
	  
		En <a href="<?php echo $comment['guid']; ?>">
		  <?php echo $comment['post_title']; ?>
		</a> dijiste:  
		
		  <a href="<?php echo $comment['guid'] . "#comment-"  . $comment['comment_ID']; ?>">
		    <?php echo $comment['comment_content']; ?>
		  </a>

	</li>
	<?php endforeach; ?>

</ul>
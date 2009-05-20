	  	<div>
	  		<ul id="lasts_posts">
	  			<li><a href="#todo">Lo todo</a></li>
	  			<li><a href="#bueno">Lo bueno</a></li>
	  			<li><a href="#malo">Lo malo</a></li>
	  			<li><a href="#roca">Lo roca</a></li>	  			
	  		</ul>
	  		<?php foreach($posts as $cat): ?>
	  		<div class="posts_last_content">
				<?php foreach($cat as $post): ?>
					<?php //con esto lo debes estar imprimiendo > echo $post['post_title']; ?>
				<?php endforeach; ?>
	  		</div>
	  		<?php endforeach; ?>
	  	</div>
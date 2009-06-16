<div id="top_menu">
   <div>
     <span class="left">Mi mula</span>
     	<?php if ($log) : ?>
				<ul>
					<li><?php echo anchor('', 'Publicar'); ?></li>
					<li><?php echo anchor('usuario/perfil', 'Ver Perfil'); ?></li>
					<li><?php echo anchor('log/logout', 'Salir'); ?></li>
				</ul>
			<?php endif; ?>		
		
   </div>
</div> <!-- top_menu -->

<div id="content" class="foto">

	<div id="wrapper">
	  	<div id="lasts-posts">
	  		<ul>
	  			<li><a href="#todo">Lo todo</a></li>
	  			<li><a href="#bueno">Lo bueno</a></li>
	  			<li><a href="#malo">Lo malo</a></li>
	  			<li><a href="#roca">Lo roca</a></li>	  			
	  		</ul>
	  		<?php $names = array('todo', 'bueno', 'malo', 'roca'); ?>
	  		<?php foreach($names as $name): ?>
	  		<div id="<?php echo $name; ?>">
	  			<?php foreach($posts as $post): ?>
	  				<?php //print_r($post); ?>
	  			<?php endforeach;?>
	  		</div>
	  		<?php endforeach; ?>
	  	</div>		
	</div>

</div>
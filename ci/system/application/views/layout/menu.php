
	<div id="header">
		<div id="head">
			<h1>La mula</h1>
			<?php if ($log) : ?>
				<ul>
					<li>Publicar</li>
					<li>Ver Perfil</li>
					<li><?php echo anchor('log/logout', 'Salir'); ?></li>
				</ul>
			<?php endif; ?>		
		</div>
		
		<div id="menu">
			<ul>
				<li class="articulo"><?php echo anchor('articulos/formulario', 'Articulo') ?></li>
				<li class="foto"><?php echo anchor('fotos/formulario', 'foto') ?></li>
				<li class="video"><?php echo anchor('', 'video') ?></li>
				<li class="audio"><?php echo anchor('', 'audio') ?></li>
				<li class="document0"><?php echo anchor('', 'documento') ?></li>					
			</ul>
		</div>
		
	</div>

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
				<li class="foto"><?php echo anchor('', 'foto') ?></li>
				<li class="video"><?php echo anchor('tipo_propiedades/index', 'video') ?></li>
				<li class="audio"><?php echo anchor('propiedades/index', 'audio') ?></li>
				<li class="document0"><?php echo anchor('configuraciones/index', 'documento') ?></li>					
			</ul>
		</div>
		
	</div>
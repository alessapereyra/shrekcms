<?php

function active_controller($target) {

	if (in_array($this->uri->segment(1), $subidon))
	{
	
	    if ($this->uri->segment(1) != $target)
	    {
	      
	        return "class='selected'";
	      
	    }
	}
}

?>
<div id="top_menu">
   <div>
     <span class="left">lamula</span>
     	<?php if ($log) : ?>
				<ul>
					<li>Publicar</li>
					<li><?php echo anchor('usuario/perfil', 'Ver Perfil'); ?></li>
					<li><?php echo anchor('log/logout', 'Salir'); ?></li>
				</ul>
			<?php endif; ?>		
		
   </div>
</div> <!-- top_menu -->

	
		<div id="wrapper">
		  
		  <h2>Publicar</h2>
		  <ul id="menu">
				<li class="foto"><?php echo anchor('fotos/formulario', 'foto') ?></li>		    
				<li class="video"><?php echo anchor('', 'video') ?></li>
				<li class="articulo"><?php echo anchor('articulos/formulario', 'Articulo') ?></li>
				<li class="audio"><?php echo anchor('', 'audio') ?></li>
				<li class="documento"><?php echo anchor('documentos/formulario', 'documento') ?></li>					
			</ul> <!-- menu -->
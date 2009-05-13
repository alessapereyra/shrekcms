<?php $this->load->helper('url');
$this->load->library('layout');
?>
<div id="top_menu">
   <div>
     <span class="left">lamula</span>
     	<?php if ($log) : ?>
				<ul>
					<li>Publicar</li>
					<li>Ver Perfil</li>
					<li><?php echo anchor('log/logout', 'Salir'); ?></li>
				</ul>
			<?php endif; ?>		
		
   </div>
</div> <!-- top_menu -->

	
		<div id="wrapper">
		  
		  <h2>Publicar</h2>
		  <ul id="menu">
				<li class="foto <?php echo $this->layout->active_controller('fotos'); ?>" ><?php echo anchor('fotos/formulario', 'fotos') ?> </li>		    
				<li class="video <?php echo $this->layout->active_controller('videos'); ?>" ><?php echo anchor('videos/formulario', 'video') ?> </li>
				<li class="video <?php echo $this->layout->active_controller('articulo'); ?>" ><?php echo anchor('articulos/formulario', 'articulo') ?> </li>
	      		<li class="audio <?php echo $this->layout->active_controller('audios'); ?>" ><?php echo anchor('', 'audio') ?></li>
				<li class="documento <?php echo $this->layout->active_controller('documentos'); ?>" ><?php echo anchor('documentos/formulario', 'documento') ?></li>					
			</ul> <!-- menu -->
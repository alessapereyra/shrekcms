<?php

function active_controller($target) {

	if (in_array($this->uri->segment(1), $subidon)):


    if $this->uri->segment(1) == $target {
      
        return "class='selected'";
      
       }

  ?>


}
?>


<?php $this->load->helper('url'); ?>
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
				<li class="foto <?php echo active_controller('fotos'); ?>" </li>		    
				<li class="video <?php echo active_controller('videos'); ?> . <?php ac("fotos") ?>" <?php echo anchor('', 'video') ?> </li>
	      <li class="audio <?php echo active_controller('audios'); ?>"><?php echo anchor('', 'audio') ?></li>
				<li class="documento <?php echo active_controller('documentos'); ?>" ><?php echo anchor('documentos/formulario', 'documento') ?></li>					
			</ul> <!-- menu -->
			
		
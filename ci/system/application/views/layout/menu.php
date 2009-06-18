<?php

function active_controller($current,$target)
{
	    if ($current == $target)
	    {
	    	return "selected";
	    }
	
}


?>


    <div id="menu_container">
    

  		  <h2>Env&iacute;a a la mula... </h2>
  		  <ul id="menu">
  				<li class="foto <?php echo active_controller($current_controller,"fotos") ?>" ><?php echo anchor('fotos/formulario', 'foto') ?></li>		    
  				<li class="articulo <?php echo active_controller($current_controller,"articulos") ?>"><?php echo anchor('articulos/formulario', 'articulo') ?></li>
  				<li class="video <?php echo active_controller($current_controller,"videos") ?>"><?php echo anchor('videos/formulario', 'video') ?></li>
  				<li class="audio <?php echo active_controller($current_controller,"audios") ?>"><?php echo anchor('audios/formulario', 'audio') ?></li>
  				<li class="documento <?php echo active_controller($current_controller,"documentos") ?>"><?php echo anchor('documentos/formulario', 'documento') ?></li>					
  			</ul> <!-- menu -->

    </div>
			
		<?php //echo $this->session->flashdata('fileupload'); ?>			
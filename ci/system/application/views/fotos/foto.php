<div id="content" class="foto">

	<?php echo form_open('fotos/actualizar', array('class' => 'form'));
	
		if ($id != NULL)
		{
			echo form_hidden('id', $id);					
		}
	?>
	
	<div id="text_content">
	 
  	<fieldset>

  	<?php echo form_label('Titulo:', 'titulo');?>
  	<?php echo form_error('titulo'); ?>
  	<?php echo form_input(array('name' => 'titulo', 'value' => $titulo, 'id' => 'titulo')); ?>

  	<div id="upload-content">
  		<?php echo form_hidden('upload-content', 'subir'); ?>
  		<ul>
  			<li><a href="#subir">Subir</a></li>
  			<li><a href="#enlazar">Enlazar</a></li>
  		</ul>
  		<div id="subir">
  					
  					  <p>Selecciona la foto que desees subir:</p>
  						<span id="spanButtonPlaceholder"></span>
  						<em>máximo 2mb. formatos soportados: jpg, png, gif</em>
  		</div>
  		<div id="enlazar">
  			
            	<?php echo form_label('Ingresa la dirección de la imagen que desees enviar:', 'photolink');?> 
            	<?php echo form_error('photolink'); ?>
            	<?php echo form_input(array('name' => 'photolink', 'value' => $photolink, 'id' => 'photolink')); ?>
  			  
  		</div>		
  	</div>

  	<?php echo form_label('Descripci&oacute;n:', 'textos');?>
  	<?php echo form_error('textos'); ?>
  	<?php echo form_textarea(array('name' => 'textos', 'value' => $texto, 'id' => 'textos')); ?>

  	<?php echo form_label('Etiquetas (separadas por comas):', 'tags');?> 
  	<?php echo form_error('tags'); ?>
  	<?php echo form_input(array('name' => 'tags', 'value' => $tags, 'id' => 'tags')); ?>
  	<em>violencia, robos, denuncias, serenazgo, etc</em>
  	
  	</fieldset>
  	
    <div id="end_form">
  	  <?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'Enviar' )); ?>    
    </div>

  	
  		</div> <!-- text_content -->
	
	  <div id="sidebar_content">
	   
	  <h3>Categorizar</h3>
  	<fieldset id="categories">
  	<?php foreach($categorias as $key => $value): ?> 
  	    <span>
  		    <?php echo form_label($value . ':', $key);?> <?php echo form_checkbox(array('name' => $key, 'value' => TRUE, 'id' => $key)); ?>
  		 </span>
  	<?php endforeach; ?>	
  	</fieldset>
	
  	<fieldset id="localizar">
  	  
  	  <h3>Localizar</h3>
  		<?php echo form_hidden('localizar', 'peru'); ?>
  		<ul>
  			<li><a href="#peru">Perú</a></li>
  			<li><a href="#mundo">El mundo</a></li>
  		</ul>
  		<div id="peru">
  			<?php echo form_label('Provincia: ', 'provincia');?>
  			<?php echo form_dropdown('provincia', $provincias, NULL,'id="provincia"'); ?>
  			<?php echo form_label('Departamento: ', 'departamento');?>
  			<?php echo form_dropdown('departamento', $departamentos, NULL,'id="departamento"'); ?>
  			<?php echo form_label('Distrito: ', 'distrito');?>
  			<?php echo form_dropdown('distrito', $distritos, NULL,'id="distrito"'); ?>
  		</div>
  		<div id="mundo">
  			<?php echo form_label('País: ', 'pais');?>
  			<?php echo form_dropdown('pais', $paices, NULL,'id="pais"'); ?>
  		</div>	
  	</fieldset>	

	  </div> <!-- sidebar_content -->
	
	<?php echo form_close(); ?>

</div>
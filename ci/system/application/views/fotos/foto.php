<div id="content" class="foto">

	<?php echo form_open('fotos/actualizar', array('class' => 'form'));
	
		if ($id != NULL)
		{
			echo form_hidden('id', $id);					
		}
	?>
<<<<<<< HEAD:ci/system/application/views/fotos/foto.php
	<fieldset>
	<?php echo form_error('titulo'); ?>
	<?php echo form_label('Titulo:', 'titulo');?> <?php echo form_input(array('name' => 'titulo', 'value' => $titulo, 'id' => 'titulo')); ?>
	<div id="upload-content">
		<?php echo form_hidden('upload-content', 'subir'); ?>
		<ul>
			<li><a href="#subir">Subir</a></li>
			<li><a href="#enlazar">Enlazar</a></li>
		</ul>
		<div id="subir">

			<div class="fieldset flash" id="fsUploadProgress">
				<span class="legend">Upload Queue</span>
			</div>
			<div id="divStatus">0 Files Uploaded</div>
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>

		</div>
		<div id="enlazar">
			Enlazo
		</div>		
	</div>
	<?php echo form_error('textos'); ?>
	<?php echo form_label('Texto:', 'textos');?> <?php echo form_textarea(array('name' => 'textos', 'value' => $texto, 'id' => 'textos')); ?>
	<?php echo form_error('tags'); ?>
	<?php echo form_label('Tags:', 'tags');?> <?php echo form_input(array('name' => 'tags', 'value' => $tags, 'id' => 'tags')); ?>
	</fieldset>
=======
>>>>>>> c502f4e22451d1d3f32014b7ffb38a1429a8ea1c:ci/system/application/views/fotos/foto.php
	
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
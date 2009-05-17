<div id="content" class="foto">

	<?php 
	
		if ($ie6 == TRUE)
		{
			echo form_open_multipart('fotos/actualizar', array('class' => 'form'));
		}
		else
		{
			echo form_open('fotos/actualizar', array('class' => 'form'));
		}

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
  					<input type="hidden" id="files" name="files" value="" />
  					<p>Selecciona la foto que desees subir:</p>
  					<span id="spanButtonPlaceholder">
  					<?php if ($ie6 == TRUE): ?>
						<?php echo form_error('Filedata'); ?>
						<?php echo form_upload(array('name' => 'Filedata', 'value' => '', 'id' => 'Filedata')); ?>  						
  					<?php endif; ?>
  					</span>
  					<div class="fieldset flash" id="fsUploadProgress"></div>
  					<em>máximo 2mb. formatos soportados: jpg, png, gif</em>
  					<?php 
						$this->load->library('session');
						echo $this->session->flashdata('fileupload');  					  					
  					?>  					
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
        	  <?php
        	  $selected = FALSE;
        	  if (is_array($categorias_selected))
        	  {
        	  	$selected = in_array($key, $categorias_selected);
        	  }
        	  ?>
    		  <?php echo form_label($value . ':', $key);?> <?php echo form_checkbox(array('name' => $key, 'value' => TRUE, 'id' => $key, 'checked' => $selected)); ?>
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
    			<?php echo form_label('Departamento: ', 'departamento');?>
    			<?php echo form_dropdown('departamento', $departamentos, NULL,'id="departamento"'); ?>
    			<?php echo form_label('Provincia: ', 'provincia');?>
    			<select id="provincia" disabled="disabled"></select>
    			<?php echo form_label('Distrito: ', 'distrito');?>
    			<select id="distrito" disabled="disabled"></select>
  		</div>
  		<div id="mundo">
  			<?php echo form_label('País: ', 'pais');?>
  			<?php echo form_dropdown('pais', $paices, NULL,'id="pais"'); ?>
  		</div>	
  	</fieldset>	

	  </div> <!-- sidebar_content -->
	
	<?php echo form_close(); ?>

</div>
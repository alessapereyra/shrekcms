<div id="content" class="foto">

	<?php 
		if ($ie6 == TRUE)
		{
			echo form_open_multipart('videos/actualizar/1', array('class' => 'form'));
		}
		else
		{
			echo form_open('videos/actualizar', array('class' => 'form'));
		}	
	
		if ($id != NULL)
		{
			echo form_hidden('id', $id);					
		}
	?>
	
	<div id="text_content">
  	<fieldset>
    <h3><?php echo $id == NULL ? 'Enviando' : 'Editando'; ?> un video</h3>
    
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
  					<p>Selecciona el archivo que desees subir a Youtube:</p>
  					<input type="text" id="search_field" name="examinar" value="" />  					
  					<span <?php if ($ie6 != TRUE): ?>id="spanButtonPlaceholder"<?php endif; ?>>
  					<?php if ($ie6 == TRUE): ?>
						<?php echo form_error('Filedata'); ?>
						<?php echo form_upload(array('name' => 'Filedata', 'value' => '', 'id' => 'Filedata')); ?>  						
  					<?php endif; ?>
  					</span>
  					<div class="fieldset flash" id="fsUploadProgress"></div>
  					<em>formatos soportados: mov, mpg</em>
  					<?php if ($ie6 != TRUE): ?>
  				  <p id="traditional">
	  					Si tiene problemas para subir archivos, use la <?php echo anchor('videos/formulario/0/1', 'version tradicional') ?>
  				  </p>
  					<?php endif; ?>
  					<?php 
						$this->load->library('session');
						echo $this->session->flashdata('fileupload');  					  					
  					?>
  		</div>
  		<div id="enlazar">
            	<?php echo form_label('Ingresa la dirección del video que desees enlazar:', 'doclink');?> 
            	<?php echo form_error('doclink'); ?>
            	<?php echo form_input(array('name' => 'doclink', 'value' => $doclink, 'id' => 'doclink')); ?>
  		</div>		
  	</div>

  	<?php echo form_label('Descripci&oacute;n:', 'texto');?>
  	<?php echo form_error('texto'); ?>
  	<?php echo form_textarea(array('name' => 'texto', 'value' => $texto, 'id' => 'texto')); ?>

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
	   
	  <h3>&iquest;Qu&eacute; es esto? *</h3>
  	<fieldset id="categories">
    	<?php echo form_error('has_category'); ?>
    	<?php echo form_hidden('has_category', $has_category); ?>  	
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
  	  
  	  <h3>&iquest;D&oacute;nde ocurri&oacute;?</h3>
  		<?php echo form_hidden('localizar', 'peru'); ?>
  		<ul>
  			<li><a href="#peru">Perú</a></li>
  			<li><a href="#mundo">El mundo</a></li>
  		</ul>
  		<div id="peru">
    			<?php echo form_label('Departamento: ', 'departamento');?>
    			<?php echo form_dropdown('departamento', $departamentos, $departamentos_selected,'id="departamento"'); ?>
    			
    			<?php echo form_label('Provincia: ', 'provincia');?>
    			<?php if (isset($provincias)): ?>
    				<?php echo form_dropdown('provincia', $provincias, $provincias_selected,'id="provincia"'); ?>
    			<?php else: ?>
    				<select id="provincia" name="provincia" <?php if ($departamentos_selected == NULL): ?>disabled="disabled"<?php endif; ?>></select>
    			<?php endif; ?>
    			
    			<?php echo form_label('Distrito: ', 'distrito');?>
    			<?php if (isset($distritos)): ?>
    				<?php // die('asdf'); ?>
    				<?php echo form_dropdown('distrito', $distritos, $distritos_selected,'id="distrito"'); ?>
    			<?php else: ?>
    				<select id="distrito" name="distrito" <?php if ( ($provincias_selected == NULL) ): ?> disabled="disabled" <?php endif; ?>></select>
    			<?php endif; ?>
  		</div>
  		<div id="mundo">
  			<?php echo form_label('País: ', 'pais');?>
  			<?php echo form_dropdown('pais', $paices, NULL,'id="pais"'); ?>
  		</div>	
  	</fieldset>	

	  </div> <!-- sidebar_content -->
	
	<?php echo form_close(); ?>

</div>
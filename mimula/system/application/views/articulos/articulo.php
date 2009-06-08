<div id="content" class="articulo">

	<?php 
	
		if ($ie6 == TRUE)
		{
			echo form_open_multipart('articulos/actualizar/1', array('class' => 'form', 'id'=>'formulario_mula'));
		}
		else
		{
			echo form_open('articulos/actualizar', array('class' => 'form', 'id'=>'formulario_mula'));
		}	
	
		if ($id != NULL)
		{
			echo form_hidden('id', $id);					
		}
		
	?>

	<div id="text_content">	 
	
    	<fieldset id="articulo_content">
    	<h3>Creando un Art&iacute;culo</h3>
    	<?php echo form_label('Titulo:', 'titulo');?> 
    	<?php echo form_error('titulo'); ?>
    	<?php echo form_input(array('name' => 'titulo', 'value' => $titulo, 'id' => 'titulo')); ?>

    	<?php echo form_label('', 'textos');?>
    	<?php echo form_error('textos'); ?>
  	    <?php echo form_textarea(array('name' => 'textos', 'value' => $textos, 'id' => 'textos')); ?>
    	
    	<?php if ($ret === TRUE) { ?>	
	    	<p id="file_info">
	    	<?php echo anchor('articulos/formulario/0/1', 'Quiero agregar fotos') ?>
	    	adjunte o enlace imágenes y fotos complementarias a su artículo 
	    	</p>
	    	
		  	<div id="upload-content" class="articulo-upload">
		  		<?php echo form_hidden('upload-content', 'subir'); ?>
		  		<ul>
		  			<li><a href="#subir">Subir</a></li>
		  			<li><a href="#enlazar">Enlazar</a></li>
		  		</ul>
		  		<div id="subir">
		  					<input type="hidden" id="files" name="files" value="" />
		  					<p>Selecciona la foto que desees subir:</p>
		  					<input type="text" id="search_field" name="examinar" value="" />
		  					<span <?php if ($ie6 != TRUE): ?>id="spanButtonPlaceholder"<?php endif; ?>>
			  					<?php if ($ie6 == TRUE): ?>
									<?php echo form_error('Filedata'); ?>
									<?php echo form_upload(array('name' => 'Filedata', 'value' => '', 'id' => 'Filedata')); ?>  						
			  					<?php endif; ?>
		  					</span>
		  					<div class="fieldset flash" id="fsUploadProgress"></div>
		  					<em>máximo 2mb. formatos soportados: jpg, png, gif</em>
	
			  				<?php if ($ie6 != TRUE): ?>
			  				  <p id="traditional">
			  				    Si tiene problemas para subir archivos, use la <?php echo anchor('articulos/formulario/0/1', 'version tradicional') ?>
			  				  </p>
			  				<?php endif; ?>	  					
	
		  					<?php 
								$this->load->library('session');
								echo $this->session->flashdata('fileupload');  					  					
		  					?>	  					
		  		</div>
		  		<div id="enlazar">
		            	<?php echo form_label('Coloca la dirección de la imagen que desees enlazar:', 'photolink');?> 
		            	<?php echo form_error('photolink'); ?>
		            	<?php echo form_input(array('name' => 'photolink', 'value' => $photolink, 'id' => 'photolink')); ?>
	            	  <a href="#" class="add_to_note">A&ntilde;adir a la nota</a>		            	
		  		</div>		
		  	</div>
	  	<?php }?>
		<?php echo form_hidden('ret', $ret); ?>
		  	    	
    	<?php echo form_label('Etiquetas: (separadas por comas)', 'tags');?>
    	<?php echo form_error('tags'); ?>
  	    <?php echo form_input(array('name' => 'tags', 'value' => $tags, 'id' => 'tags')); ?>
    	<em>violencia, robos, denuncias, serenazgo, etc</em>
    	</fieldset>

      <div id="preview_content">

          <p class="title_preview" id="pv_titulo" >Titulo de la nota</p>
          <p class="published">enviado por ti, a&uacute;n sin publicar</p> 
          <div class="content_preview" id="pv_texto"/>Contenido</div>
          <span class="tags_preview">Etiquetas:</span><div class="tags_preview" id="pv_tags"></div>

      </div> <!-- preview_content -->


      <div id="end_form">
        <a href="#preview_content" id="link_to_preview" >vista previa</a>
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


  
</div>

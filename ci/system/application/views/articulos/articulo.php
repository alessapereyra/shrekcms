<div id="content">

	<?php echo form_open('articulos/actualizar', array('class' => 'form'));
	
		if ($id != NULL)
		{
			echo form_hidden('id', $id);					
		}
	?>
	<fieldset>
	<?php echo form_error('titulo'); ?>
	<?php echo form_label('Titulo:', 'titulo');?> <?php echo form_input(array('name' => 'titulo', 'value' => $titulo, 'id' => 'titulo')); ?>
	<?php echo form_error('texto'); ?>
	<?php echo form_label('Texto:', 'texto');?> <?php echo form_textarea(array('name' => 'texto', 'value' => $texto, 'id' => 'texto')); ?>
	<?php echo form_error('tags'); ?>
	<?php echo form_label('Tags:', 'tags');?> <?php echo form_input(array('name' => 'tags', 'value' => $tags, 'id' => 'tags')); ?>
	</fieldset>

	<fieldset>
	<?php foreach($categorias as $key => $value): ?> 
		 <?php echo form_label($value . ':', $key);?> <?php echo form_checkbox(array('name' => $key, 'value' => TRUE, 'id' => $key)); ?>
	<?php endforeach; ?>	
	</fieldset>
	
	<fieldset id="localizar">
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
	
	<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'Submit' )); ?>
	<?php echo form_close(); ?>

</div>
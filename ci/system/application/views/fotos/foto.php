<div id="content">

	<?php echo form_open('fotos/actualizar', array('class' => 'form'));
	
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
	
	<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'Submit' )); ?>
	<?php echo form_close(); ?>

</div>
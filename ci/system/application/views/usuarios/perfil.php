<div id="content" class="login_form">
  
	<h3>Completa tu perfil</h3>
		<div class="info">
			<?php if (isset($info)) { echo $info; } ?>
			<?php echo form_open('usuarios/grabar_perfil', array('class' => 'log'));
				if ($id != NULL)
				{
					echo form_hidden('id', $id);					
				}				
			?>
		<fieldset>

		<?php echo form_label('Nombre Completo:', 'nombre_completo');?> 
		<?php echo form_error('nombre_completo'); ?>
		<?php echo form_input(array('name' => 'nombre_completo', 'value' => $nombre_completo, 'id' => 'nombre_completo')); ?>
		<br />
		<?php echo form_label('Sobre ti:', 'descripcion');?>
		<?php echo form_error('descripcion'); ?>
		<?php echo form_textarea(array('name' => 'descripcion', 'value' => $descripcion, 'id' => 'descripcion')); ?>
		<br />
		<?php echo form_label('Tu sitio web:', 'url');?>
		<?php echo form_error('url'); ?>
		<?php echo form_input(array('name' => 'url', 'value' => $url, 'id' => 'url')); ?>
		<br />

		<?php echo form_label('Tu DNI:', 'dni');?>
		<?php echo form_error('dni'); ?>
		<?php echo form_input(array('name' => 'dni', 'value' => $dni,'id' => 'dni')); ?>
		<br />
		<?php echo form_label('Un  tel&eacute;fono:', 'telefono');?>
		<?php echo form_error('telefono'); ?>
		<?php echo form_input(array('name' => 'telefono', 'value' => $telefono, 'id' => 'telefono')); ?>


		</fieldset>	
      <?php echo anchor($perfil_address, 'cancelar') ?>
			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => '&iexcl;Grabar!' )); ?>

			<?php echo form_close(); ?>
		</div>
		<div id="pie"></div>

</div> <!-- content -->
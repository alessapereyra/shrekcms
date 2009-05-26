	<div id="content" class="login_form">
	  
		<h3>Crea tu cuenta en LaMula</h3>
  		<div class="info">
  			<?php if (isset($info)) { echo $info; } ?>
  			<?php echo form_open('usuarios/actualizar', array('class' => 'log'));
					if ($id != NULL)
					{
						echo form_hidden('id', $id);					
					}				
  			?>
			<fieldset>

			<?php echo form_label('Nombre de Usuario:', 'usuario');?> 
			<?php echo form_error('usuario'); ?>
			<?php echo form_input(array('name' => 'usuario', 'value' => $usuario, 'id' => 'usuario')); ?>
			<br />
			<?php echo form_label('Correo electr&oacute;nico:', 'email');?>
			<?php echo form_error('email'); ?>
			<?php echo form_input(array('name' => 'email', 'value' => $email, 'id' => 'email')); ?>
			<br />
			<?php echo form_label('Contrase&ntilde;a:', 'password');?>
			<?php echo form_error('password'); ?>			 
			<?php echo form_password(array('name' => 'password', 'id' => 'password')); ?>
			<br />
			<?php echo form_label('Repite la  contrase&ntilde;a:', 'password_check');?>
			<?php echo form_error('password_check'); ?>
			<?php echo form_password(array('name' => 'password_check', 'id' => 'password_check')); ?>
			<br />
			<?php echo form_label('Tu DNI:', 'dni');?>
			<?php echo form_error('dni'); ?>
			<?php echo form_input(array('name' => 'dni', 'id' => 'dni')); ?>
			<br />
			<?php echo form_label('Un  tel&eacute;fono:', 'telefono');?>
			<?php echo form_error('telefono'); ?>
			<?php echo form_input(array('name' => 'telefono', 'id' => 'telefono')); ?>


			</fieldset>	
        <?php echo anchor('log', 'cancelar ') ?>
  			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => '&iexcl;Registrarme!' )); ?>

  			<?php echo form_close(); ?>
  		</div>
  		<div id="pie"></div>

	</div> <!-- content -->
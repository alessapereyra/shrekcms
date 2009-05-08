	<div id="content" class="login_form">
	  
		<h3>Registro</h3>
  		<div class="info">
  			<?php if (isset($info)) { echo $info; } ?>
  			<?php echo form_open('usuarios/actualizar', array('class' => 'log'));
					if ($id != NULL)
					{
						echo form_hidden('id', $id);					
					}				
  			?>
			<fieldset>
			<?php echo form_error('usuario'); ?>
			<?php echo form_label('Nick:', 'usuario');?> <?php echo form_input(array('name' => 'usuario', 'value' => $usuario, 'id' => 'usuario')); ?>
			<br />
			<?php echo form_error('email'); ?>
			<?php echo form_label('Email:', 'email');?> <?php echo form_input(array('name' => 'email', 'value' => $email, 'id' => 'email')); ?>
			<br />
			<?php echo form_error('url'); ?>
			<?php echo form_label('Url:', 'url');?> <?php echo form_input(array('name' => 'url', 'value' => $url, 'id' => 'url')); ?>
			<br />
			<?php echo form_error('password'); ?>
			<?php echo form_label('Password:', 'password');?> <?php echo form_password(array('name' => 'password', 'id' => 'password')); ?>
			<br />
			<?php echo form_error('password_check'); ?>
			<?php echo form_label('Repetir Password:', 'password_check');?> <?php echo form_password(array('name' => 'password_check', 'id' => 'password_check')); ?>
			</fieldset>	
  			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'Registrarme' )); ?>
  			<?php echo form_close(); ?>
  		</div>
  		<div id="pie"></div>

	</div> <!-- content -->
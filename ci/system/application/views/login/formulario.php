
	<div id="content">
		<h2>Login</h2>
		<div class="info">
			<?php if (isset($info)) { echo $info; } ?>
			<?php echo form_open('log/login', array('class' => 'log'));
				echo form_hidden('destino', $destino);					
			?>
			<fieldset>
			<?php echo form_error('usuario'); ?>
			<?php echo form_label('Nick:', 'usuario');?> <?php echo form_input(array('id' => 'usuario', 'name' => 'usuario', 'value' => set_value('usuario'))); ?>
			</fieldset>
			<fieldset>
			<?php echo form_error('password'); ?>
			<?php echo form_label('Password:', 'password');?> <?php echo form_password(array('id' => 'password', 'name' => 'password')); ?>
			</fieldset>
			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'Submit' )); ?>
			<?php echo form_close(); ?>
		</div>
		<div id="pie"><?php echo anchor('log/olvido', 'Olvide mi contraseña >>') ?></div>
	</div>
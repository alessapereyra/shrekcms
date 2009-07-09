
	<div id="content" class="login_form">
	  
		  <h3>Entrando a LaMula</h3>
		  
		  <div id="notice">
		    Si ya has creado un blog en LaMula, puedes iniciar sesión usando los mismos datos.
		    Si no, <?php echo anchor('/usuarios/formulario', 'crea tu cuenta ahora') ?>. &iexcl;Es r&aacute;pido!
		  </div>
		  
  		<div class="info">
  			<?php if (isset($info)) { echo $info; } ?>
  			<form action="http://lamula.pe/wp-login.php" method="post" name="loginform">
  				<?php $destino = 'http://lamula.pe/mulapress/ci/index.php/' . $destino; ?>
	  			<?php echo form_hidden('redirect_to', $destino); ?>
	  			<fieldset>
		  			<?php echo form_label('Usuario:', 'usuario');?> 			
		  			<?php echo form_input(array('id' => 'usuario', 'name' => 'log', 'value' => set_value('usuario'))); ?>
	  			</fieldset>
	  			<fieldset>
		  			<?php echo form_label('Contraseña:', 'password');?> 			
		  			<?php echo form_password(array('id' => 'password', 'name' => 'pwd')); ?>
	  			</fieldset>
	  			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'iniciar' )); ?>
  			</form>
  		</div> <!-- info -->
  		
  		<div id="pie">
  		  <?php echo anchor('log/olvido', 'Olvid&eacute; mi contraseña >>') ?> <br />
  		  <?php echo anchor('/usuarios/formulario', 'Crear una cuenta >>') ?>
		  </div>

	</div> <!-- content -->
	

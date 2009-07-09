	<div id="content" class="login_form create_user">
	  
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

      <div id="main_data_fields">
          
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

      </div>

      <div id="secondary_data_fields">
        
        <div id="notice">
          
          <h4>&iquest;Por qu&eacute; solicitamos &eacute;stos datos?</h4>
          <p>
            &iexcl;No los compartiremos con nadie!
            Te identificar&aacute;n en LaMula y permitir&aacute;n participar en los r&aacute;nkings
          </p>
          
        </div>
    
    		<?php echo form_label('Nombre Completo:', 'full_name');?>
    		<?php echo form_error('full_name'); ?>
    		<?php echo form_input(array('name' => 'full_name', 'value' => "",'id' => 'full_name')); ?>

  			<?php echo form_label('Tu DNI:', 'dni');?>
			  <?php echo form_error('dni'); ?>
			  <?php echo form_input(array('name' => 'dni', 'id' => 'dni', 'value' => $dni)); ?>
  			<br />
  			
  			<?php echo form_label('Un  tel&eacute;fono:', 'telefono');?>
  			<?php echo form_error('telefono'); ?>
  			<?php echo form_input(array('name' => 'telefono', 'id' => 'telefono')); ?>
  			<br />
  			
  			<?php echo form_label('He leido las reglas', 'reglas');?>
  			<?php echo form_error('reglas'); ?>
  			<?php echo form_checkbox(array('name' => 'reglas', 'id' => 'reglas', 'value' => 'accept','checked' => FALSE)); ?>
      </div>

			</fieldset>	
        <?php echo anchor('log', 'cancelar ') ?>
  			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => '&iexcl;Registrarme!' )); ?>

  			<?php echo form_close(); ?>
  		</div>
  		<div id="pie"></div>

	</div> <!-- content -->
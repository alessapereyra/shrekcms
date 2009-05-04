
  <div id="content" class="login_form">

    <h3>Reestablecer contraseña</h3>
    <div class="info">
    	<?php echo form_open('backend/log/recuperar', array('class' => 'form')); ?>
    	<fieldset>
    	<?php echo form_error('usuario'); ?>
    	<?php echo form_label('Nick:', 'usuario');?> <?php echo form_input(array('id' => 'usuario', 'name' => 'usuario', 'value' => set_value('usuario'))); ?>
    	</fieldset>
    	<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'reestablecer &nbsp;' )); ?>
    	<?php echo form_close(); ?>
    </div>
    <div id="pie"><?php echo anchor('backend/log', 'Cancelar') ?></div>

  </div> <!-- content -->
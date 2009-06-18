<div id="content" class="login_form create_user">
  
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

      <div id="main_data_fields">

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
    		<br />
    		<?php echo form_label('Tu DNI:', 'dni');?>
    		<?php echo form_error('dni'); ?>
    		<?php echo form_input(array('name' => 'dni', 'value' => $dni,'id' => 'dni')); ?>
    		<br />
    		<?php echo form_label('Un  tel&eacute;fono:', 'telefono');?>
    		<?php echo form_error('telefono'); ?>
    		<?php echo form_input(array('name' => 'telefono', 'value' => $telefono, 'id' => 'telefono')); ?>

      </div>

		</fieldset>	
      <?php echo anchor($perfil_address, 'cancelar') ?>
			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => '&iexcl;Grabar!' )); ?>

			<?php echo form_close(); ?>
		</div>
		<div id="pie"></div>

</div> <!-- content -->

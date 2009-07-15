<div id="content" class="titulares">

	<div id="news_headers_main">
		 
		<h3>Definir Titulares de LaMula</h3>
        <?php echo form_open('usuarios/verificar'); ?>
        <?php echo form_hidden('page', $page); ?>
        <?php echo form_hidden('per_page', $per_page); ?>
        <table width="100%">
        	<thead>
        		<tr>
        			<th>Nick</th>
        			<th>Blog principal</th>
        			<th>Telefono</th>
        			<th>DNI</th>
        			<th>¿Aprobado?</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?php $row = 1?>
        	<?php foreach($users as $fila):?>
        		<tr>
        			<?php echo form_hidden('user_id['. $row . ']', $fila['ID']); ?>
        			<td><a href="http://lamula.pe/members/<?php echo $fila['user_url']; ?>"><?php echo $fila['user_login']; ?></a></td>
        			<td><?php echo $fila['user_url']; ?></td>
        			<?php //die(print_r($user_meta))?>
        			<?php $count = count($user_meta[$fila['ID']]); ?>
        			<?php if ($count != 0): ?>
        				<?php //die(print_r($user_meta[$fila['ID']])); ?>
        				<?php foreach ($user_meta[$fila['ID']] as $meta): ?>
	        				<?php
	        				switch ($meta['meta_key'])
	        				{
	        					case 'telefono':
	        					case 'dni':
	        						echo '<td>' . $meta['meta_value'] . '</td>';
	        					break;
	        					default:
	        						echo '<td></td>';	
	        				}	
	        					
							?>
    	    			<?php endforeach; ?>
        			<?php else: ?>
        				<td>&nbsp;</td>
        				<td>&nbsp;</td>
        			<?php endif; ?>
        			<?php $is_aproved = $fila['aproved'] == 1 ? TRUE : FALSE; ?>
        			<td><?php echo form_checkbox('aproved[' . $row  . ']', '1', $is_aproved); ?></td>
        			<?php $row++; ?>
        		</tr>
        	<?php endforeach;?>
        	</tbody>
        </table>
		<div id="pag-sel">
			<?php echo $paginador ?>
			<?php echo $selector ?>
		</div>
		<?php echo form_submit('submit', 'Actualizar'); ?>
     	<?php echo form_close(); ?>
	</div>
	
</div>
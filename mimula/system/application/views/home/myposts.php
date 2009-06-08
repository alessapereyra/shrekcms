<?php //$categorias = array(7 => 'articulos',8 => 'fotos', 9 => 'videos', 10 => 'documentos', 11 => 'audio')?>
<div id="content"  class="dashboard">
	<table width="100%">
		<thead>
			<th>Titulo</th>
			<th>Tipo</th>
			<th>Estado</th>
			<th>Accion</th>
		</thead>
		<tbody>
			<?php foreach($myposts as $post): ?>
			<tr>
				<td><?php echo $post['post_title']; ?></td>
				<td><?php echo $post['name']; ?></td>
				<td><?php
						switch ($post['post_status'])
						{
							case 'publish':
								$tmp = 'Publicado';
							break;
							case 'draft':
								$tmp = 'Esperando moderación';
							break;
							default:
								$tmp = NULL;
						}
						echo $tmp; ?></td>
				<td><a href="<?php echo $this->config->item('base_url') . $this->config->item('index_page') . '/' . $post['slug'] . '/formulario/' . $post['ID']; ?>">Editar</a></td>
			</tr>			
			<?php endforeach; ?>	
		</tbody>
	</table>
</div>
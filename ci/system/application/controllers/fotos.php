<?php

class Fotos extends DI_Controller {
	
	function formulario($id = NULL)
	{			
		$data['id'] = NULL;
		$data['titulo'] = NULL;
		$data['texto'] = NULL;
		$data['tags'] = NULL;
		$data['photolink'] = NULL;		
		$data['categorias_selected'] = NULL;
		$data['files'] = NULL;
		
		$this->load->library('combofiller');
		
		$data['categorias'] = $this->combofiller->categorias();
		$data['provincias'] = $this->combofiller->providences();
		$data['distritos'] = $this->combofiller->distrits();
		$data['departamentos'] = $this->combofiller->departments();		
		$data['paices'] = $this->combofiller->countries();				
		
		if ($id != NULL)
		{
			$data = $this->_show($id, $data);
		}
		$data['form'] = $this->form;
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('fotos/foto', $data);
		$this->__destruct();		
	}
		
	function actualizar()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('combofiller');
		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->_reglas());
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		 
		if ($this->form_validation->run() == FALSE)
		{
			$data['id'] = $this->input->post('id');
			$data['titulo'] = set_value('titulo');
			$data['texto'] = set_value('texto');
			$data['tags'] = set_value('tags');
			$data['files'] = set_value('files');

			$data['categorias'] = $this->combofiller->categorias();
			
			foreach($data['categorias'] as $key => $value)
			{
				if ($this->input->post('' . $key . ''))
				{
					$categorias_selected[] = $key;
				}
			}
			$data['categorias_selected'] = $categorias_selected;
			
			$data['provincias'] = $this->combofiller->providences();
			$data['provincias_selected'] = set_value('provincia');
			
			$data['distritos'] = $this->combofiller->distrits();
			$data['distritos_selected'] = set_value('distrito');
					
			$data['departamentos'] = $this->combofiller->departments();
			$data['departamentos_selected'] = set_value('departamento');
					
			$data['paices'] = $this->combofiller->countries();
			$data['paices_selected'] = set_value('pais');				
			
			$data['form'] = $this->form;			

			$this->load->view('fotos/foto', $data);
			$this->__destruct();		

		}
		else
		{
			
			$this->load->model('post');
			$this->load->model('postmeta');
			$this->load->model('terms');
			$this->load->model('term_relationships');
			$this->load->model('term_taxonomy');
			
			$id = $this->input->post('id');
			$data['post_title']  = $this->input->post('titulo');
			
			$data['post_content'] = '';	
	
			switch ($this->input->post('upload-content'))
			{
				//subir imagenes
				case 'subir':
					$images_id = split('-', $this->input->post('files'));
					unset($images_id[0]);
					
					foreach($images_id as $img)
					{
						$photo_data = $this->post->seleccionar(array('ID' => $img));
						$photo_data = $photo_data->row();
						
						$search_metadata['post_id'] = $img;
						$search_metadata['meta_key'] = '_wp_attached_file';
						
						$photo_name = $this->postmeta->seleccionar($search_metadata);
						$photo_name = $photo_name->row_array();
						$photo_name = split('/', $photo_name['meta_value']);
						$photo_name = $photo_name[count($photo_name)-1];

						$search_metadata['meta_key'] = '_wp_attachment_metadata';	
											
						$metadata = $this->postmeta->seleccionar($search_metadata);
						$metadata = $metadata->row_array();
						$metadata = unserialize($metadata['meta_value']);
						if ($metadata['sizes']['medium']['file'] != NULL)
						{
							$metadata = $metadata['sizes']['medium']['file'];
						}
						else
						{
							$metadata = $metadata['sizes']['thumbnail']['file'];
						}
						
						$photo = ereg_replace($photo_name, $metadata, $photo_data->guid);
						
						$tmp = '<a href="' . $photo_data->guid . '">';
						$tmp .= '<img class="alignnone size-medium wp-image-' . $img . '" src="' . $photo . '" />';
						$tmp .= '</a>';
						$tmp .= '<br />';
						$data['post_content'] .= $tmp;

					}	
					
				break;
				
				//enlazar
				case 'enlazar': 
					$tmp = '<a href="' . $this->input->post('photolink') . '">';
					$tmp .= '<img class="alignnone" src="' . $this->input->post('photolink') . '" />';
					$tmp .= '</a>';
					$tmp .= '<br />';
					$data['post_content'] .= $tmp;
					
				break;
			}
			
			$data['post_content'] = $data['post_content'] . 'descripcion';

			$data['tags'] = $this->input->post('tags');
			
			//consigue los id de las cata
			$this->load->library('combofiller');
			
			$categorias = $this->combofiller->categorias();	
			
			$terms_taxonomy_id = NULL;
			
			foreach($categorias as $key => $value)
			{
				if ($this->input->post('' . $key . ''))
				{
					$terms_taxonomy_id[] = $key;
				}
			}
			
			switch ($this->input->post('localizar'))
			{
				case 'mundo':
					$tmp = array('pais');
				break;
				case 'peru':
					$tmp = array('provincia', 'distrito', 'departamento');
				break;
			}
			
			foreach ($tmp as $custom)
			{
				
				if ($this->input->post($custom) != NULL)
				{
					$customs[$custom] = $this->input->post($custom);
				}	
			}

			$data['terms_taxonomy_id'] = $terms_taxonomy_id;
			
			if ($id == NULL)
			{
				$post_id = $this->post->insert_article($data, $customs);
				$this->term_relationships->insertar($post_id, array(8));
			}
			else
			{
				$where['id'] = $id;
				$this->post->actualizar($data, $where);
			}

			if ($this->is_ajax != TRUE)
			{
				redirect('fotos/formulario');
			}
			else
			{
				$data['accion'] = 'ok';
				$this->load->view('', $data);
			}
		}			
	}
	
	function _reglas()
	{
		$reglas[] = array('field'   => 'titulo', 'label'   => 'lang:field_titulo', 'rules'   => 'trim|required|max_length[100]');
		
		return $reglas;
	}

	function ajax($accion)
	{
		switch ($accion)
		{
			case 'upload':
				$this->_upload();
			break;
		}
	}
	
	function _upload()
	{
		$tmp['allowed_types'] = 'jpg|jpeg|gif|png';
		$tmp['encrypt_name'] = TRUE;
		
		$this->load->model('options');
		
		$tmp['upload_path'] = $this->options->get_('upload_path') . date('/Y/m/');
		$values['guid'] = $this->options->get_('upload_url') . date('/Y/m/');

		$this->load->library('upload', $tmp);
		
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors(),
							'upload_data' => $this->upload->data());
			
			//$this->load->view('upload_form', $error);
			echo 'error';
			die(print_r($error));
			
		}	
		else
		{			
			$photo = $this->upload->data();

			//debe insertar en un post, la imagen, ver wp_post id=18
			$this->load->model('post');
			$this->load->model('postmeta');
			$this->load->helper('inflector');
			
			$values['post_author'] = $this->input->post('id');
			$values['post_title'] = score(ereg_replace($photo['file_ext'], '' , $photo['file_name']));
			$values['post_name'] = $values['post_title'];
			$values['post_mime_type'] = 'image/' . ereg_replace('\.', '' , $photo['file_ext']);
			$values['guid'] = $values['guid'] . $photo['file_name'];
			
			$the_photo = $this->post->insert_attach($values);
			
			$meta['_wp_attached_file'] = date('Y/m/') . $photo['file_name'];;
			
			//debo manipular la imagen
			if (function_exists('getimagesize'))
			{
				//Configuraciones general
				$config['image_library'] = 'gd2';
				$config['maintain_ratio'] = TRUE;
				$config['master_dim'] = 'auto';
				$config['source_image'] = $photo['full_path'];
				$config['new_image'] = 'thumb_' . $photo['file_name'];
				
				$this->load->library('image_lib');
				
				//Consigo la info de la img
				if (FALSE !== ($D = @getimagesize($photo['full_path'])))
				{
					$from['w'] = $D['0'];
					$from['h'] = $D['1'];
				}
	
				
				$the_meta['width'] = strval($from['w']);
				$the_meta['height'] = strval($from['h']);
				$the_meta['hwstring_small'] = "height='96' width='96'" ;
				$the_meta['file'] = $meta['_wp_attached_file'];				
								
				//thumbnail
				$tmp_size = 'thumbnail_size';
				
				$to['w'] = $this->options->get_($tmp_size . '_w');
				$to['h'] = $this->options->get_($tmp_size . '_h');			
				
				$tmp = $this->_crop($from, $to, $photo, $config);
				if ($tmp != FALSE)
				{
					$the_meta['sizes']['thumbnail'] = $tmp;
				}						
				
				//medium_size
				$tmp_size = 'medium_size';
				$to['w'] = $this->options->get_($tmp_size . '_w');
				$to['h'] = $this->options->get_($tmp_size . '_h');			
				
				$tmp = $this->_resize($from, $to, $photo, $config);
				if ($tmp != FALSE)
				{
					$the_meta['sizes']['medium'] = $tmp;
				}

				//large_size
				$tmp_size = 'large_size';
				$to['w'] = $this->options->get_($tmp_size . '_w');
				$to['h'] = $this->options->get_($tmp_size . '_h');			
				
				$tmp = $this->_resize($from, $to, $photo, $config);
				if ($tmp != FALSE)
				{
					$the_meta['sizes']['large'] = $tmp;
				}
								
				$image_meta = array('aperture' => '0', 'credit' => '' , 'camera' => '',
						      'caption' => '', 'created_timestamp' => '0',
						      'copyright' => '', 'focal_length' => '0',
						      'iso' => '0', 'shutter_speed' => '0',
						      'title' => ''
				);
				
				$the_meta['image_meta'] = $image_meta;
				
				$this->load->library('wpshit');
				
				$meta['_wp_attachment_metadata'] = $this->wpshit->maybe_serialize($the_meta);				
			}
			
			$this->postmeta->insertar($meta, $the_photo);
			
			echo $the_photo;
		}
		
	}
	
	function _crop($from, $to, $photo, $config)
	{
		if (($from['h'] > $to['h']) OR ($from['w'] > $to['w']) )
		{
			//cargo los valores al config
			$config['width'] = $to['w'];
			$config['height'] = $to['h'];
			
			if($from['w'] < $from['h'])
			{
				$config['master_dim'] = 'width';				
			}
			else
			{
				$config['master_dim'] = 'height';
			}
			
			$this->image_lib->initialize($config); 
			
			$this->image_lib->resize();
			
			$thumb['name'] = $photo['file_path'] . 'thumb_' . $photo['file_name'];
			
			//leo el archivo para saber el nuevo tamaño
			if (FALSE !== ($e = @getimagesize( $thumb['name'] )))
			{				
				$thumb['w'] = $e['0'];
				$thumb['h'] = $e['1'];
				$thumb['from'] = $thumb['name'];
				$thumb['to'] = $photo['file_path'];
				$thumb['to'] .= ereg_replace($photo['file_ext'], '' , $photo['file_name']);
				$thumb['to'] .= '-150x150';
				$thumb['to'] .= $photo['file_ext'];
							
				//cropeo
				//$this->image_lib->clear();
				switch ($config['master_dim'])
				{
					case 'width':
						$config['x_axis'] = 0;
						$config['y_axis'] = ($thumb['h'] - $to['h']) / 2; 
						break;
					case 'height':
						$config['y_axis'] = 0;
						$config['x_axis'] = ($thumb['w'] - $to['w']) / 2; 
						break;
				}
				$config['source_image'] = $thumb['name'];
				$config['maintain_ratio'] = FALSE;
				
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				
				rename($thumb['from'], $thumb['to']);

				$tmp = split('/', $thumb['to']);
				$thumb['to'] = $tmp[count($tmp)-1];					
			}
			else
			{
				//dejo asi como esta, pero hago el thumb
			}													

			//cambio el nombre
			return array('file' => $thumb['to'], 'width' => strval($thumb['w']), 'height' => strval($thumb['h']));
		}

		return FALSE;		
	}
	
	function _resize($from, $to, $photo, $config)
	{
		if (($from['h'] > $to['h']) OR ($from['w'] > $to['w']) )
		{
			//redimensiono
			$config['width'] = $to['w'];
			$config['height'] = $to['h'];
			
			$this->image_lib->initialize($config); 
			
			$this->image_lib->resize();
			
			$thumb['name'] = $photo['file_path'] . 'thumb_' . $photo['file_name'];
			
			//leo el archivo para saber el nuevo tamaño
			if (FALSE !== ($e = @getimagesize( $thumb['name'] )))
			{				
				$thumb['w'] = $e['0'];
				$thumb['h'] = $e['1'];
				$thumb['from'] = $thumb['name'];
				$thumb['to'] = $photo['file_path'];
				$thumb['to'] .= ereg_replace($photo['file_ext'], '' , $photo['file_name']);
				$thumb['to'] .= '-' . $thumb['w'] .  'x' . $thumb['h'];
				$thumb['to'] .= $photo['file_ext'];
				
				rename($thumb['from'], $thumb['to']);
			}													

			$thumb['to'] = split('/', $thumb['to']);
			$thumb['to'] = $thumb['to'][count($thumb['to'])-1];		
			//cambio el nombre
			return array('file' => $thumb['to'], 'width' => strval($thumb['w']), 'height' => strval($thumb['h']));
		}

		return FALSE;
	}
		
	function borrar($id)
	{
		$this->load->model('zones');
		$this->session->set_userdata('info', $this->zones->borrar(array('id' => $id)));
				
		redirect('backend/zonas/index/');
	}

}

/* End of file monedas.php */
/* Location: ./system/application/controllers/backend/monedas.php */
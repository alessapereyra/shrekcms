<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de articulos
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de articulos
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Articulos extends DI_Controller {
	
	/**
	 * Muestra el formulario para agregar/editar un articulo
	 * @param integer $id id de un articulo
	 * @param boolean $ie6 es Internet Explorer 6
	 * @return void 
	 */	
	function formulario($id = NULL, $ie = NULL)
	{			
		if ($id == 0)
		{
			$id = NULL;
		}
		
		$data['id'] = NULL;
		$data['titulo'] = NULL;
		$data['textos'] = NULL;
		$data['tags'] = NULL;
		$data['photolink'] = NULL;
		$data['files'] = NULL;
		$data['ret'] = TRUE;
		$data['ie6'] = $ie != NULL ? TRUE:$this->_is_ie6();
		$data['has_category'] = FALSE; 
		
		$this->load->library('combofiller');
		
		$data['categorias'] = $this->combofiller->categorias();
		$data['categorias_selected'] = NULL;
		
		$data['departamentos'] = $this->combofiller->states(TRUE);	
		$data['departamentos_selected'] = NULL;
		$data['provincias_selected'] = NULL;
		$data['distritos_selected'] = NULL;
			
		$data['paices'] = $this->combofiller->countries();
		$data['paices_selected'] = NULL;
		
		if ($id != NULL)
		{
			$data = $this->_show($id, $data);
		}
		$data['form'] = $this->form;
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('articulos/articulo', $data);
		$this->__destruct();
	}
	
	/**
	 * Busca los datos de ese articulo
	 * @param integer $id id de un articulo
	 * @param array $data array a retornar
	 * @return array 
	 */		
	function _show($id, $data)
	{
		$this->load->model('post');
		$this->load->model('postmeta');
		$this->load->model('terms');
		include('system/application/libraries/Simplehtml.php');
		
		
		//Consigu los datos basico
		$post = $this->post->seleccionar(array('ID' => $id));
		$post = $post->result_array();
		$post = current($post);
	
		$data['id'] = $post['ID'];
		$data['titulo'] = $post['post_title'];
		$data['textos'] = $post['post_content'];
		
		$html = str_get_html($post['post_content']);
		$ret = $html->find('img',0);
		
		if ($ret == NULL)
		{
			$data['ret'] = TRUE;
			$data['textos'] = $post['post_content'];
		}
		else
		{
			$data['ret'] = $ret->outertext;	
			$data['textos'] = $html->plaintext;
		}
		
		//Consig los tags
		$tags = $this->terms->get_tags($id);
		$tags = $tags->result_array();
		$tmp = NULL;
		foreach($tags as $tag)
		{
			$tmp[] = $tag['name'];	
		}
		if ($tmp != NULL)
		{
			$data['tags'] = implode(', ', $tmp);
		}
		
		$cats = $this->terms->get_postcategories($id);

		if ($cats != NULL)
		{
			foreach($cats as $key => $value)
			{
				$categorias_selected[] = $key;
			}
		}
			
		if (isset($categorias_selected))
		{
			$data['categorias_selected'] = $categorias_selected == NULL ? NULL : $categorias_selected;
		}
		
		$customs = $this->postmeta->get_metas($id);
		
		if ($customs != NULL)
		{
			if (array_key_exists('pais', $customs))
			{
				$data['paices_selected'] = $customs['pais'];
			}
			
			if (array_key_exists('departamento', $customs))
			{
				if($customs['departamento'] != '')
				{
					$data['departamentos_selected'] = $this->combofiller->get_state($customs['departamento']);
					$data['provincias'] = $this->combofiller->provinces($data['departamentos_selected'], TRUE);
				}
			}
	
			if (array_key_exists('provincia', $customs))
			{
				if($customs['provincia'] != '')
				{
					$data['provincias_selected'] =  $this->combofiller->get_province($customs['provincia']);
					$data['distritos'] = $this->combofiller->districts($data['provincias_selected'], TRUE);
				}
			}
			
			if (array_key_exists('distrito', $customs))
			{
				if($customs['distrito'] != '')
				{
					$data['distritos_selected'] = $this->combofiller->get_district($customs['distrito']);
				}
			}
		}		
		return $data;
	}

	/**
	 * Agrega o modifica un articulo
	 * @param boolean $ie6 es Internet Explorer 6
	 * @return void 
	 */		
	function actualizar($ie = NULL)
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('inflector');		
		$this->load->library('combofiller');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules($this->_reglas());
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		 
		if ($this->form_validation->run() == FALSE)
		{
			$data['id'] = $this->input->post('id');
			$data['ret'] = $this->input->post('ret');
			$data['has_category'] = FALSE;
			
			$data['titulo'] = set_value('titulo');
			$data['textos'] = $this->input->post('textos');
			
			$data['tags'] = $this->input->post('tags');
			$data['files'] = $this->input->post('files');
			$data['ie6'] = $ie != NULL ? TRUE:$this->_is_ie6(); 

			$data['categorias'] = $this->combofiller->categorias();			
			foreach($data['categorias'] as $key => $value)
			{
				if ($this->input->post('' . $key . ''))
				{
					$categorias_selected[] = $key;		
				}
			}
			
			if (isset($categorias_selected))
			{
				$data['categorias_selected'] = $categorias_selected == NULL ? NULL : $categorias_selected;
				$data['has_category'] = TRUE;
			}
			else
			{
				$data['categorias_selected'] = NULL; 
			}
			
			$data['departamentos'] = $this->combofiller->states(TRUE);
			$data['departamentos_selected'] = NULL;
			$data['provincias_selected'] = NULL;
			$data['distritos_selected'] = NULL;
			
			if( $this->input->post('departamento') != 'null')
			{
				$data['departamentos_selected'] = $this->input->post('departamento');
			}
						
			if( $this->input->post('provincia') != NULL )
			{
			
				$data['provincias'] = $this->combofiller->provinces($this->input->post('departamento'), TRUE);
				if ($this->input->post('provincia') != 'null')
				{
					$data['provincias_selected'] = $this->input->post('provincia');
				}
			}
			
			if( $this->input->post('distrito') != NULL )
			{
				$data['distritos'] = $this->combofiller->districts($this->input->post('provincia'), TRUE);
				if( $this->input->post('distrito') != 'null' )
				{
					$data['distritos_selected'] = $this->input->post('distrito');
				}
			}			
			
			$data['form'] = $this->form;			

			$this->load->view('articulos/articulo', $data);
			$this->__destruct();		

		}
		else
		{
			$this->load->model('countries');
			$this->load->model('states');
			$this->load->model('districts');
			$this->load->model('provinces');
			$this->load->model('options');
			$this->load->model('postmeta');			
			$this->load->model('post');
			$this->load->model('term_relationships');
			$this->load->model('terms');			
			
			$id = $this->input->post('id');
			$data['post_title']  = $this->input->post('titulo');
			
			if ($this->input->post('id') == NULL)
			{
				$data['post_content'] = $this->input->post('textos');
			}
			else
			{
				$data['post_content'] =  $this->input->post('ret') . ' ' . $this->input->post('textos');

			}

			$data['tags'] = $this->input->post('tags');
			
			switch ($this->input->post('upload-content'))
			{
				//subir imagenes
				case 'subir':
					
					if ( ($this->_is_ie6() == TRUE) OR ($ie != null) )
					{
						if ($_FILES['Filedata']['error'] == 0)
						{
							$aceptados = array('image/jpeg','image/png','image/gif','image/pjpeg','image/x-png');
							if (in_array($_FILES['Filedata']['type'], $aceptados))
							{
								$images_id[] = $this->_upload($ie);
								if (is_null($images_id[0]))
								{
									//error y debo redireccionar
									$this->load->library('session');
									$this->session->set_flashdata('fileupload', 'Error en la carga');
									redirect('articulos/formulario');
								}
							}						
							else
							{
								$this->load->library('session');
								$this->session->set_flashdata('fileupload', 'Error en la carga');
								redirect('articulos/formulario');
							}
						}
					}
					else
					{
						$images_id = split('-', $this->input->post('files'));
						unset($images_id[0]);						
					}
					
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
						
						$tmp = '<br /><a rel="uploaded_image" href="' . $photo_data->guid . '">';
						$tmp .= '<img rel="uploaded_image" class="alignnone size-medium wp-image-' . $img . '" src="' . $photo . '" />';
						$tmp .= '</a>';
						$tmp .= '<br />';
						$data['post_content'] .= $tmp;
					}	
										
				break;
				
				//enlazar
				case 'enlazar': 
					$tmp = '<br /><a rel="uploaded_image" href="' . $this->input->post('photolink') . '">';
					$tmp .= '<img rel="uploaded_image" class="alignnone" src="' . $this->input->post('photolink') . '" />';
					$tmp .= '</a>';
					$tmp .= '<br />';
					$data['post_content'] .= $tmp;
					
				break;
			}
			$data['post_content'] = $data['post_content'] . '';      
						
			//consigue los id de las categorias
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
					$customs[$custom] = sanitize2url($this->input->post($custom));
				}	
			}
			
			$data['terms_taxonomy_id'] = $terms_taxonomy_id;
			
			if ($id == NULL)
			{
				$post_id = $this->post->insert_article($data, $customs);
				$this->term_relationships->insertar($post_id, array(30));
			}
			else
			{
				$where['id'] = $id;
				$this->post->actualizar($data, $customs, $where);
				$this->session->set_flashdata('notice', 'Nota actualizada exitosamente');	
				redirect('home/dashboard');
			}

			if ($this->is_ajax != TRUE)
			{

       		 $this->session->set_flashdata('notice', 'Nota enviada exitosamente');			  
				redirect('home/dashboard');
			}
			else
			{
				$data['accion'] = 'ok';
				$this->load->view('', $data);
			}
		}			
	}
	
	/**
	 * Setea las reglas de validacion para el formulario
	 * @return array 
	 */		
	function _reglas()
	{
		$reglas[] = array('field'   => 'titulo', 'label'   => 'lang:field_titulo', 'rules'   => 'trim|required|max_length[100]');
		$reglas[] = array('field'   => 'has_category', 'label'   => 'lang:field_has_category', 'rules'   => 'callback_has_categorys');
		
		
		return $reglas;
	}
	
	/**
	 * Regla de validacion; Obliga a que el usuario seleccione una categoria
	 * @return boolean 
	 */		
	function has_categorys()
	{
			$categorias = $this->combofiller->categorias();			
			foreach($categorias as $key => $value)
			{
				if ($this->input->post('' . $key . ''))
				{
					return TRUE;	
				}
			}
			return FALSE;	
	}
	
	/**
	 * Sube un archivo
	 * @param boolean $ie6 es Internet Explorer 6
	 * @return array 
	 */		
	function _upload($ie = NULL)
	{
		$tmp['allowed_types'] = 'jpg|jpeg|gif|png';
		$tmp['encrypt_name'] = TRUE;
		
		$this->load->model('options');
		
		$tmp['upload_path'] = $this->options->get_('upload_path') . date('/Y/m/');
		$values['guid'] = $this->options->get_('upload_url_path') . date('/Y/m/');

		$this->load->library('upload', $tmp);
		
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors(),
							'upload_data' => $this->upload->data());
			
			return NULL;
			
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
				//echo 'thum: ' . print_r($tmp);
				
				//medium_size
				$tmp_size = 'medium_size';
				$to['w'] = $this->options->get_($tmp_size . '_w');
				$to['h'] = $this->options->get_($tmp_size . '_h');			
				
				$tmp = $this->_resize($from, $to, $photo, $config);
				if ($tmp != FALSE)
				{
					$the_meta['sizes']['medium'] = $tmp;
				}
				//echo 'm: ' . print_r($tmp);
				
				//large_size
				$tmp_size = 'large_size';
				$to['w'] = $this->options->get_($tmp_size . '_w');
				$to['h'] = $this->options->get_($tmp_size . '_h');			
				
				$tmp = $this->_resize($from, $to, $photo, $config);
				if ($tmp != FALSE)
				{
					$the_meta['sizes']['large'] = $tmp;
				}
				//echo 'l: ' . print_r($tmp);
								
				$image_meta = array('aperture' => '0', 'credit' => '' , 'camera' => '',
						      'caption' => '', 'created_timestamp' => '0',
						      'copyright' => '', 'focal_length' => '0',
						      'iso' => '0', 'shutter_speed' => '0',
						      'title' => ''
				);
				
				$the_meta['image_meta'] = $image_meta;
				
				//die(print_r($image_meta));
				
				$this->load->library('wpfunctions');
				
				$meta['_wp_attachment_metadata'] = $this->wpfunctions->maybe_serialize($the_meta);				
			}
			
			$this->postmeta->insertar($meta, $the_photo);
			
			if ( ($this->_is_ie6() == TRUE) OR ($ie != NULL))
			{
				return $the_photo;
			}
			else
			{
				$tmp = '<img class="thumb-carga" src="' . $values['guid'] . '" />';
				echo $the_photo . '#' . $tmp;				
			}
		}
		
	}

	/**
	 * Recorta una imagen
	 * @param array $from dimensiones del archivo fuente
	 * @param array $to dimensiones del archivo destino
	 * @param array $photo datos de la imagen
	 * @param array $config configuracion
	 * @return array o boolean
	 */		
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

	/**
	 * Redimensiona una imagen
	 * @param array $from dimensiones del archivo fuente
	 * @param array $to dimensiones del archivo destino
	 * @param array $photo datos de la imagen
	 * @param array $config configuracion
	 * @return array or boolean
	 */		
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

}

/* End of file articulos.php */
/* Location: ./system/application/controllers/articulos.php */
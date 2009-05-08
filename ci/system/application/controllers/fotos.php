<?php

class Fotos extends DI_Controller {
	
	function index($page = 1, $per_page = NULL)
	{
		if ($per_page == NULL)
		{
			$per_page = $this->config->item('per_page');
		}
		
		$this->load->model('zones');
		
		//arma el paginador
		$data['consulta'] = $this->zones->seleccionar();
		$data['paginador'] = $this->_paginador($data['consulta']->num_rows(), $per_page);
		$data['selector'] = $this->pagination->create_selector($per_page);
		
		//calcula cuantos mostrar
		$limit['show'] = $per_page;
		$limit['from'] = ($page - 1) * $per_page;
		
		//consulta
		$data['consulta'] = $this->zones->seleccionar(NULL, $limit);
		$data['consulta'] = $data['consulta']->result_array();
		
		$data['error'] = $this->error;
		
		$this->load->view('backend/zonas/index', $data);
		
		$this->__destruct();
	}
	
	function formulario($id = NULL)
	{			
		$data['id'] = NULL;
		$data['titulo'] = NULL;
		$data['texto'] = NULL;
		$data['tags'] = NULL;
		$data['photolink'] = NULL;		
		$data['categorias'] = $this->_categorias();	
		
		$data['provincias'] = array('Lima' => 'Lima', 'Callao' => 'Callao');
		$data['provincias_selected'] = '';
		
		$data['distritos'] = $data['provincias'];
		$data['distritos_selected'] = '';
				
		//Dientuki:  Esto no se debería resolver simplemente creando un array de la primera 
		// y luego creando un array adicional que repita el key/value de éste? 
		$data['departamentos'] = array('Amazonas' => 'Amazonas', 
		                                'Ancash' => 'Ancash', 
		                                'Apurimac' => 'Apurimac', 
		                                'Arequipa' => 'Arequipa', 
		                                'Ancash' => 'Ancash', 			                                			                                			                                
		                                'Ayacucho' => 'Ayacucho', 
		                                'Cajamarca' => 'Cajamarca', 			                                			                                			                                
		                                'Callao' => 'Callao', 
		                                'Cusco' => 'Cusco', 			                                			                                			                                
		                                'Huancavelica' => 'Huancavelica', 
		                                'Ica' => 'Ica', 			                                			                                			                                
		                                'Junin' => 'Junin', 
		                                'La Libertad' => 'La Libertad', 			                                			                                			                                
		                                'Lambayeque' => 'Lambayeque', 
		                                'Lima' => 'Lima', 			                                			                                			                                
		                                'Loreto' => 'Loreto', 
		                                'Madrededios' => 'Madrededios', 			                                			                                			                                
		                                'Moquegua' => 'Moquegua', 
		                                'Pasco' => 'Pasco', 			                                			                                			                                
		                                'Piura' => 'Piura', 
		                                'Puno' => 'Puno', 			                                			                                			                                
		                                'San Martin' => 'San Martin', 
		                                'Tacna' => 'Tacna', 			                                			                                			                                
		                                'Tumbes' => 'Tumbes', 
		                                'Ucayali' => 'Ucayali'
		                                );
		$data['departamentos_selected'] = '';
				
		$data['paices'] = array('Argentina' => 'Argentina',
                            'Brasil' => 'Brasil',
		                        'Chile' => 'Chile',
		                        'Perú' => 'Perú'
		                        );
		$data['paices_selected'] = '';		
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

	function _show($id, $data)
	{
		$this->load->model('zones');
		$consulta = $this->zones->seleccionar(array('id' => $id));
		if ($consulta->num_rows() > 0)
		{
		   $fila = $consulta->row();
		
		   $data['id'] = $fila->id;
		   $data['zona'] = $fila->zona;
		}
		return $data;		
	}

	function _categorias()
	{
		$this->load->model('terms');
		return $this->terms->get_categories();	
	}
		
	function actualizar()
	{
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->_reglas());
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		 
		if ($this->form_validation->run() == FALSE)
		{
			$data['id'] = $this->input->post('id');
			$data['titulo'] = set_value('titulo');
			$data['texto'] = set_value('texto');
			$data['tags'] = set_value('tags');
			$data['categorias'] = $this->_categorias();					

			$this->load->view('fotos/foto', $data);
			$this->__destruct();		

		}
		else
		{
			die('debo crear el post con toda la cosa');
			$this->load->model('post');
			$this->load->model('postmeta');
			$this->load->model('terms');
			$this->load->model('term_relationships');
			$this->load->model('term_taxonomy');
			
			$id = $this->input->post('id');
			$data['post_title']  = $this->input->post('titulo');
			
			//Debo armar el texto con las img
			//$data['post_content'] = $this->input->post('texto');
			$data['tags'] = $this->input->post('tags');
			
			//consigue los id de las cata
			$categorias = $this->_categorias();
			
			$terms_taxonomy_id = NULL;
			
			foreach($categorias as $key => $value)
			{
				if ($this->input->post('' . $key . ''))
				{
					$terms_taxonomy_id[] = $key;
				}
			}
			
			$tmp = array('provincia', 'distrito', 'pais', 'departamento');
			
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
				$time = $this->post->insert_article($data, $customs);
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
			die(print_r($error));
			
		}	
		else
		{
			$photo = $this->upload->data();

			//debe insertar en un post, la imagen, ver wp_post id=18
			$this->load->model('post');
			$this->load->helper('inflector');
			
			$values['post_author'] = $this->input->post('id');
			$values['post_name'] = score(ereg_replace($photo['file_ext'], '' , $photo['orig_name']));
			$values['post_mime_type'] = 'image/' . ereg_replace($photo['file_ext'], '' , $photo['orig_name']);;
			$values['guid'] = $values['guid'] . $photo['file_name'];
			
			$the_photo = $this->post->insert_attach($values);
			
			//debo manipular la imagen
			if (function_exists('getimagesize'))
			{
				//Consigo la info de la img
				if (FALSE !== ($D = @getimagesize($photo['full_path'])))
				{
					$image_info['w'] = $D['0'];
					$image_info['h'] = $D['1'];
				}
				
				$sizes_name = array('thumbnail_size', 'medium_size', 'large_size');
				 
				foreach($sizes_name as $tmp_size)
				{
					$h = $tmp_size . '_h';
					$w = $tmp_size . '_w';
					$tmp[$w] = $this->options->get_($w);
					$tmp[$h] = $this->options->get_($h);
					
					if (($h > $image_info['h']) OR ($w > $image_info['w']) )
					{
						//redimensiono
					}
				}
			}			
			
			//debo crear el texto para el  post (img + descripcion)
			
			//debo poner un post con el texto
			
			//die(print_r($photo));
		}
		
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
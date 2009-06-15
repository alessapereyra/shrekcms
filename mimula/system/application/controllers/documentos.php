<?php
class Documentos extends DI_Controller {
	
	function formulario($id = NULL, $ie = NULL)
	{			
		if ($id == 0)
		{
			$id = NULL;
		}
		
		$data['id'] = NULL;
		$data['titulo'] = NULL;
		$data['texto'] = NULL;
		$data['tags'] = NULL;
		$data['doclink'] = NULL;		
		$data['categorias_selected'] = NULL;
		$data['files'] = NULL;
		$data['ret'] = TRUE;
		$data['ie6'] = $ie != NULL ? TRUE:$this->_is_ie6(); 
		//$data['ie6'] = $this->_is_ie6();
		
		$this->load->library('combofiller');
		
		$data['categorias'] = $this->combofiller->categorias();
		$data['categorias_selected'] = NULL;
		
		$data['departamentos'] = $this->combofiller->departments(TRUE);	
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
		$this->load->view('documentos/documento', $data);
		$this->__destruct();		
	}
	
	function _show($id, $data)
	{
		$this->load->model('post');
		$this->load->model('postmeta');
		$this->load->model('terms');
		include('system/application/libraries/Simplehtml.php');
		
		
		//Consigo los datos basico
		$post = $this->post->seleccionar(array('ID' => $id));
		$post = $post->result_array();
		$post = current($post);
	
		$data['id'] = $post['ID'];
		$data['titulo'] = $post['post_title'];
		
		$html = str_get_html($post['post_content']);
		//die($post['post_content']);
		$ret = $html->find('img',0);
		
		if ($ret == NULL)
		{
			$data['ret'] = TRUE;
			$data['texto'] = $post['post_content'];
		}
		else
		{
			$data['ret'] = $ret->outertext;	
			$data['texto'] = $html->plaintext;
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
		
		if (array_key_exists('pais', $customs))
		{
			$data['paices_selected'] = $customs['pais'];
		}
		
		if (array_key_exists('departamento', $customs))
		{	
			$data['departamentos_selected'] = $customs['departamento'];
			$data['provincias'] = $this->combofiller->providences($customs['departamento'], TRUE);
		}

		
		if (array_key_exists('provincia', $customs))
		{
			$data['provincias_selected'] = $customs['provincia'];
			$data['distritos'] = $this->combofiller->distrits($customs['provincia'], TRUE);
		}
		
		if (array_key_exists('distrito', $customs))
		{
			$data['distritos_selected'] = $customs['distrito'];
		}		
		return $data;		
	}
			
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
			
			$data['titulo'] = set_value('titulo');
			$data['texto'] = $this->input->post('textos');

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
			}
			else
			{
				$data['categorias_selected'] = NULL; 
			}
			
			$data['departamentos'] = $this->combofiller->departments(TRUE);
			$data['departamentos_selected'] = NULL;
			$data['provincias_selected'] = NULL;
			$data['distritos_selected'] = NULL;
			
			if( $this->input->post('departamento') != 'null')
			{
				$data['departamentos_selected'] = $this->input->post('departamento');
			}
						
			if( $this->input->post('provincia') != NULL )
			{
			
				$data['provincias'] = $this->combofiller->providences($this->input->post('departamento'), TRUE);
				if ($this->input->post('provincia') != 'null')
				{
					$data['provincias_selected'] = $this->input->post('provincia');
				}
			}
			
			if( $this->input->post('distrito') != NULL )
			{
				$data['distritos'] = $this->combofiller->distrits($this->input->post('provincia'), TRUE);
				if( $this->input->post('distrito') != 'null' )
				{
					$data['distritos_selected'] = $this->input->post('distrito');
				}
			}			
					
			$data['paices'] = $this->combofiller->countries();
			$data['paices_selected'] = $this->input->post('pais');				
			
			$data['form'] = $this->form;			
			
			$this->load->view('documentos/documento', $data);
			$this->__destruct();		

		}
		else
		{
			$this->load->model('countries');
			$this->load->model('departments');
			$this->load->model('distrits');
			$this->load->model('providences');
			$this->load->model('options');			
			$this->load->model('post');
			$this->load->model('postmeta');
			$this->load->model('terms');
			$this->load->model('term_relationships');
			$this->load->model('term_taxonomy');
	    $this->load->model('options');
			    
			$id = $this->input->post('id');
			$data['post_title']  = $this->input->post('titulo');
			
			if ($this->input->post('id') == NULL)
			{
				$data['post_content'] = $this->input->post('textos');
			}
			else
			{
				$data['post_content'] =  $this->input->post('ret') . ' ' . $this->input->post('textos');
				
				//$data['post_content'] = $this->input->post('textos');
			}
	
			switch ($this->input->post('upload-content'))
			{
				//subir documentos
				case 'subir':
					if ( ($this->_is_ie6() == TRUE) OR ($ie != null) )
					{
						if ($_FILES['Filedata']['error'] == 0)
						{
							$aceptados = array('application/pdf','application/msword');
							if (in_array($_FILES['Filedata']['type'], $aceptados))
							{
								$docs_id[] = $this->_upload($ie);
								if (is_null($docs_id[0]))
								{
									//error y debo redireccionar
									$this->load->library('session');
									$this->session->set_flashdata('fileupload', 'Error en la carga');
									redirect('documentos/formulario');
								}
							}						
							else
							{
								$this->load->library('session');
								$this->session->set_flashdata('fileupload', 'Error en la carga');
								redirect('documentos/formulario');
							}
						}
					}
					else
					{
						$docs_id = split('-', $this->input->post('files'));
						unset($docs_id[0]);						
					}					
					
					foreach($docs_id as $doc)
					{
						$doc_data = $this->post->seleccionar(array('ID' => $doc));
						$doc_data = $doc_data->row();
						
						$search_metadata['post_id'] = $doc;
						$search_metadata['meta_key'] = '_wp_attached_file';
						
						$doc_name = $this->postmeta->seleccionar($search_metadata);
						$doc_name = $doc_name->row_array();
						$doc_name = split('/', $doc_name['meta_value']);
						$doc_name = $doc_name[count($doc_name)-1];
						
						$tmp = '<br />';						
						$tmp .= '<a rel="uploaded_doc" href="' . $doc_data->guid . '" title="'. $doc_name .'">';
						$tmp .= $this->input->post('titulo');
						$tmp .= '</a>';
						$tmp .= '<br />';
						$data['post_content'] .= $tmp;
					}	
					
				break;
				
				//enlazar
				case 'enlazar': 
					$tmp = '<a rel="uploaded_doc" href="' . $this->input->post('doclink') . '">';
					$tmp .= $this->input->post('titulo');
					$tmp .= '</a>';
					$tmp .= '<br />';
					$data['post_content'] .= $tmp;
					
				break;
			}
			
			$data['post_content'] = $data['post_content'] . '';
			
			//Debo armar el texto con las img
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
					$customs[$custom] = sanitize2url($this->input->post($custom));
				}	
			}

			$data['terms_taxonomy_id'] = $terms_taxonomy_id;
			
			if ($id == NULL)
			{
				$post_id = $this->post->insert_article($data, $customs);
				$this->term_relationships->insertar($post_id, array(33));
			}
			else
			{
				$where['id'] = $id;
				//@_@
				$this->post->actualizar($data, $where);
				$this->session->set_flashdata('notice', 'Documento actualizado exitosamente');	
				redirect('home/dashboard');
			}

       		 $this->session->set_flashdata('notice', 'Documento enviado exitosamente');			  
				redirect('home/dashboard');		
			
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
	
	function _upload($ie = NULL)
	{
		$tmp['allowed_types'] = 'doc|pdf';
		$tmp['encrypt_name'] = TRUE;
		
		$this->load->model('options');
		
		$tmp['upload_path'] = $this->options->get_('upload_path') . date('/Y/m/');
		$values['guid'] = $this->options->get_('upload_url_path') . date('/Y/m/');

		$this->load->library('upload', $tmp);
		
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors(),
							'upload_data' => $this->upload->data());
			print_r($error);
			return NULL;	
			
		}	
		else
		{			
			$doc = $this->upload->data();

			//debe insertar en un post, la imagen, ver wp_post id=18
			$this->load->model('post');
			$this->load->model('postmeta');
			$this->load->helper('inflector');
			
			$values['post_author'] = $this->input->post('id');
			$values['post_title'] = score(ereg_replace($doc['file_ext'], '' , $doc['file_name']));
			$values['post_name'] = $values['post_title']; 
			$values['post_mime_type'] = 'application/' . ereg_replace('\.', '' , $doc['file_ext']);
			$values['guid'] = $values['guid'] . $doc['file_name'];
			
			$the_doc = $this->post->insert_attach($values);
			//hasta aca viene bien
			
			$meta['_wp_attached_file'] = date('Y/m/') . $doc['file_name'];
			$meta['_wp_attachment_metadata'] = 'a:0{}';
			
			$this->postmeta->insertar($meta, $the_doc);
			
			if ( ($this->_is_ie6() == TRUE) OR ($ie != NULL))
			{
				return $the_doc;
			}
			else
			{
				echo $the_doc;				
			}			
		}
		
	}
	
}

/* End of file monedas.php */
/* Location: ./system/application/controllers/backend/monedas.php */
<?php

class Documentos extends DI_Controller {
	
	function formulario($id = NULL)
	{			
		$data['id'] = NULL;
		$data['titulo'] = NULL;
		$data['texto'] = NULL;
		$data['tags'] = NULL;
		$data['doclink'] = NULL;		
		$data['categorias_selected'] = NULL;	
		
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
		$this->load->view('documentos/documento', $data);
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
			
			$this->load->view('documentos/documento', $data);
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
					$docs_id = split('-', $this->input->post('files'));
					unset($docs_id[0]);
					
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
						
						$tmp = '<a href="' . $doc_data->guid . '">';
						$tmp .= $this->input->post('titulo');
						$tmp .= '</a>';
						$tmp .= '<br />';
						$data['post_content'] .= $tmp;

					}	
					
				break;
				
				//enlazar
				case 'enlazar': 
					$tmp = '<a href="' . $this->input->post('doclink') . '">';
					$tmp .= $this->input->post('titulo');
					$tmp .= '</a>';
					$tmp .= '<br />';
					$data['post_content'] .= $tmp;
					
				break;
			}
			
			$data['post_content'] = $data['post_content'] . 'descripcion';
			
			//Debo armar el texto con las img
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
				redirect('documentos/formulario');
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
		$tmp['allowed_types'] = 'doc|pdf';
		$tmp['encrypt_name'] = TRUE;
		
		$this->load->model('options');
		
		$tmp['upload_path'] = $this->options->get_('upload_path') . date('/Y/m/');
		$values['guid'] = $this->options->get_('upload_url') . date('/Y/m/');

		$this->load->library('upload', $tmp);
		
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors(),
							'upload_data' => $this->upload->data());
			
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
			
			$meta['_wp_attached_file'] = date('Y/m/') . $doc['file_name'];
			$meta['_wp_attachment_metadata'] = 'a:0{}';
						
			$this->postmeta->insertar($meta, $the_doc);
			
			echo $the_doc;
		}
		
	}
	
}

/* End of file monedas.php */
/* Location: ./system/application/controllers/backend/monedas.php */
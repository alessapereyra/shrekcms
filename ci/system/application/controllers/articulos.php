<?php
class Articulos extends DI_Controller {
	
	function formulario($id = NULL)
	{
		$data['id'] = NULL;
		$data['titulo'] = NULL;
		$data['texto'] = NULL;
		$data['tags'] = NULL;
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
		$this->load->view('articulos/articulo', $data);
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

			$this->load->view('articulos/articulo', $data);
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
			$data['post_content'] = $this->input->post('texto');
			$data['tags'] = $this->input->post('tags');
			
			//consigue los id de las cata
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
				$time = $this->post->insert_article($data, $customs);
			}
			else
			{
				$where['id'] = $id;
				$this->post->actualizar($data, $where);
			}

			if ($this->is_ajax != TRUE)
			{
				redirect('articulos/formulario');
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
	
	function zona_check($value)
	{
		$this->load->model('zones');
		
		$consulta = $this->zones->seleccionar(array('zona' => $value));
		
		if ($consulta->num_rows() > 0)		
		{
			//$this->form_validation->set_message('zona_check', 'La %s ya existe');
			return false;
		}
		else
		{
			return true;
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
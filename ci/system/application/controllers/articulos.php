<?php

class Articulos extends DI_Controller {
	
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
		$data['categorias'] = $this->_categorias();			
		
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

			$this->load->view('articulos/articulo', $data);
			$this->__destruct();		

		}
		else
		{
			$this->load->model('post');
			$this->load->model('terms');
			$this->load->model('term_relationships');
			$this->load->model('term_taxonomy');
			
			$id = $this->input->post('id');
			$data['post_title']  = $this->input->post('titulo');
			$data['post_content'] = $this->input->post('texto');
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

			$data['terms_taxonomy_id'] = $terms_taxonomy_id;
			
			if ($id == NULL)
			{
				$time = $this->post->insert_article($data);
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
		$reglas[] = array('field'   => 'titulo', 'label'   => 'lang:field_titulo', 'rules'   => 'trim|required|max_length[20]');
		
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
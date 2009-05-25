<?php
class Videos extends DI_Controller {

	
	
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
		$this->load->view('videos/video', $data);
		
			  
		
		$this->__destruct();		
	}
	
	function _show($id, $data)
	{
		return $data;
	}
			
	function actualizar($ie = NULL)
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
			$data['paices_selected'] = set_value('pais');				
			
			$data['form'] = $this->form;			
			
			$this->load->view('videos/video', $data);
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
			$data['post_content'] = "<p>" . $this->input->post('textos') . "</p>"; 
			$data['tags'] = $this->input->post('tags');
	
			switch ($this->input->post('upload-content'))
			{
			  
			          
			
				//subir documentos
				case 'subir':
				
				
					if ( ($this->_is_ie6() == TRUE) OR ($ie != null) )
					{
						if ($_FILES['Filedata']['error'] == 0)
						{
							$aceptados = array('video/quicktime','video/mpeg');
							if (in_array($_FILES['Filedata']['type'], $aceptados))
							{
								$docs_id[] = $this->_upload($ie);
								if (is_null($docs_id[0]))
								{
									//error y debo redireccionar
									$this->load->library('session');
									$this->session->set_flashdata('fileupload', 'Error en la carga');
									redirect('videos/formulario');
								}
							}						
							else
							{
								$this->load->library('session');
								$this->session->set_flashdata('fileupload', 'Error en la carga');
								redirect('videos/formulario');
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

            $tmp = '<br />';
            $tmp .= '<object width="425" height="350">';
            $tmp .= '<param name="movie" value="' . $doc . '&autoplay=1"></param>';
            $tmp .= '<param name="wmode" value="transparent"></param>';
            $tmp .= '<embed src="'. $doc .'&autoplay=1" type="application/x-shockwave-flash" wmode="transparent"';
            $tmp .= 'width="425" height="350"></embed>';
                      
						$data['post_content'] = $tmp . $data['post_content']; 
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
			
			//$data['post_content'] = $data['post_content'];
						
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
				$this->term_relationships->insertar($post_id, array(32));
			}
			else
			{
				$where['id'] = $id;
				$this->post->actualizar($data, $where);
			}

      $this->session->set_flashdata('notice', 'Video enviado exitosamente');			  
			redirect('videos/formulario');			
			
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
	
	function findFlashUrl( $entry )
  {
      foreach ($entry->mediaGroup->content as $content) {
          if ($content->type === 'application/x-shockwave-flash') {
              return $content->url;
          }
      }
      return null;
  }	
	
	
	function _upload($ie = NULL)
	{
		
		 $this->load->library('zend');
     $this->zend->load('Zend/Gdata/YouTube');		
     $this->zend->load('Zend/Gdata/ClientLogin');	
     
     $authenticationURL= 'https://www.google.com/youtube/accounts/ClientLogin';
     $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                                               $username = 'alvaropereyra.storage1@gmail.com',
                                               $password = 'vossosalvarox',
                                               $service = 'youtube',
                                               $client = null,
                                               $source = 'LaMula', // a short string identifying your application
                                               $loginToken = null,
                                               $loginCaptcha = null,
                                               $authenticationURL);     


  	 $clientId = "ytapi-AlvaroPereyraRab-WebPublishing-afg0bc0f-0";

     $developerKey = "AI39si77SKdfoJ3spb7HZHe_tUVcOKX_TAn7Fne7BU8ux6ixJ6E8ZdNmZ7UeJs7y3ZGOfVyNAzSe4nYJqIX3Lu7RNryf-dOn9A";
     $httpClient->setHeaders('X-GData-Key', "key=${developerKey}");

     $applicationId = "SRD-LaMula-1.0";

     $yt = new Zend_Gdata_YouTube($httpClient);

     $filesource = $yt->newMediaFileSource($_FILES["Filedata"]['tmp_name']);
     $filesource->setContentType('video/quicktime');
     // set slug header
     $filesource->setSlug($_FILES["Filedata"]['tmp_name']);

     $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
     // add the filesource to the video entry
     $myVideoEntry->setMediaSource($filesource);


     // create a new Zend_Gdata_YouTube_MediaGroup object
     $mediaGroup = $yt->newMediaGroup();
     $mediaGroup->title = $yt->newMediaTitle()->setText('LaMula');
     $mediaGroup->description = $yt->newMediaDescription()->setText('Subido desde LaMula');

     $mediaGroup->keywords = $yt->newMediaKeywords()->setText('lamula');

     // the category must be a valid YouTube category
     // optionally set some developer tags (see Searching by Developer Tags for more details)
     $mediaGroup->category = array(
     $yt->newMediaCategory()->setText('Autos')->setScheme('http://gdata.youtube.com/schemas/2007/categories.cat'),
     );

     // set keywords
//     $mediaGroup->keywords = $service->newMediaKeywords()->setText('cars, funny');
     $myVideoEntry->mediaGroup = $mediaGroup;

     // upload URL for the currently authenticated user
     $uploadUrl = 'http://uploads.gdata.youtube.com/feeds/users/default/uploads';

     try {
       
       $newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
     
        if ( ($this->_is_ie6() == TRUE) OR ($ie != NULL))
        {
            return htmlspecialchars($this->findFlashUrl($newEntry));
            
        }
        else
        {
          echo htmlspecialchars($this->findFlashUrl($newEntry));
        }     
   


     

     } catch (Zend_Gdata_App_Exception $e) {
   
        return $e->getMessage();
        
     }
  
  
  
		
	}
	
  
	
	
}

/* End of file monedas.php */
/* Location: ./system/application/controllers/backend/monedas.php */
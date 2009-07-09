<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Controlador de videos
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controlador de videos
 *
 *
 * @package		mulapress
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Videos extends DI_Controller {

	/**
	 * Muestra el formulario para agregar/editar un video
	 * @param integer $id id de un video
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
		$data['texto'] = NULL;
		$data['tags'] = NULL;
		$data['doclink'] = NULL;		
		$data['categorias_selected'] = NULL;
		$data['files'] = NULL;
		$data['ie6'] = $ie != NULL ? TRUE:$this->_is_ie6();
		$data['has_category'] = FALSE; 
		//$data['ie6'] = $this->_is_ie6();
		
		$this->load->library('combofiller');
		
		$data['categorias'] = $this->combofiller->categorias();
		$data['categorias_selected'] = NULL;
		
		$data['departamentos'] = $this->combofiller->states(TRUE);	
		$data['departamentos_selected'] = NULL;
		$data['provincias_selected'] = NULL;
		$data['distritos_selected'] = NULL;
			
		$data['paices'] = $this->combofiller->countries(TRUE);
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

	/**
	 * Busca los datos de ese video
	 * @param integer $id id de un video
	 * @param array $data array a retornar
	 * @return array 
	 */		
	function _show($id, $data)
	{
		return $data;
	}

	/**
	 * Agrega o modifica un video
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
			$data['titulo'] = set_value('titulo');
			$data['texto'] = set_value('texto');
			$data['tags'] = set_value('tags');
			$data['files'] = set_value('files');
			$data['doclink'] = set_value('doclink');
			$data['ie6'] = $ie != NULL ? TRUE:$this->_is_ie6(); 
			$data['has_category'] = FALSE;
			
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
					
			$data['paices'] = $this->combofiller->countries();
			$data['paices_selected'] = set_value('pais');				
			
			$data['form'] = $this->form;			
			
			$this->load->view('videos/video', $data);
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
			$this->load->model('terms');
			$this->load->model('term_relationships');
			$this->load->model('term_taxonomy');
	    	
			$id = $this->input->post('id');
			$data['post_title']  = $this->input->post('titulo');
			$data['post_content'] = "<p>" . $this->input->post('textos') . "</p>"; 
			$data['tags'] = $this->input->post('tags');
			
      
          $this->load->library('zend');         
          $this->zend->load('Zend/Gdata/YouTube');    
          $this->zend->load('Zend/Gdata/ClientLogin');  

          $authenticationURL= 'https://www.google.com/youtube/accounts/ClientLogin';
          $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                                                   $username = 'alvaropereyra.storage1@gmail.com',
                                                   $password = 'vossosalvarox',
                                                   $service = 'youtube',
                                                   $client = null,
                                                   $source = 'LaMulaSRD', // a short string identifying your application
                                                   $loginToken = null,
                                                   $loginCaptcha = null,
                                                   $authenticationURL);     


         $clientId = "ytapi-AlvaroPereyraRab-WebPublishing-afg0bc0f-0";

         $developerKey = "AI39si77SKdfoJ3spb7HZHe_tUVcOKX_TAn7Fne7BU8ux6ixJ6E8ZdNmZ7UeJs7y3ZGOfVyNAzSe4nYJqIX3Lu7RNryf-dOn9A";
         $httpClient->setHeaders('X-GData-Key', "key=${developerKey}");

         $applicationId = "SRD-LaMula-1.0";

         $yt = new Zend_Gdata_YouTube($httpClient);		
	
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

  				  $youtube = substr($doc,31);
        	  $videoEntry = $yt->getVideoEntry($youtube);
  	 			  $videoThumbnails = $videoEntry->getVideoThumbnails();

            $photo_url = $videoThumbnails[0]["url"];		    

      		 	$tmp = '<img rel="from_video" class="alignnone fromvideo" src="' . $photo_url . '" />';
            $tmp .= '<br />';
            $tmp .= "[youtube]";
            $tmp .= $doc;
            $tmp .= '[/youtube]';
                      
						$data['post_content'] = $tmp . $data['post_content']; 
					}	
					
				break;
				
				//enlazar
				case 'enlazar': 
				
				  $url = $this->input->post('doclink');
				  $youtube = substr($url,31);
      	  $videoEntry = $yt->getVideoEntry($youtube);
	 			  $videoThumbnails = $videoEntry->getVideoThumbnails();

               $photo_url = $videoThumbnails[0]["url"];		    
		     
  			 	$tmp = '<img rel="from_video" class="alignnone fromvideo" src="' . $photo_url . '" />';
  				$tmp .= '[youtube]' . $url . '[/youtube]';
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
					$customs[$custom] = sanitize2url($this->input->post($custom));
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
				$this->post->actualizar($data, $customs, $where);
				$this->session->set_flashdata('notice', 'Documento actualizado exitosamente');	
				redirect('home/dashboard');				
			}

      		$this->session->set_flashdata('notice', 'Video enviado exitosamente');			  
			redirect('home/dashboard');			
			
			
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
	 * Funciones ajaxs
	 * @return void 
	 */		
	function ajax($accion)
	{
		switch ($accion)
		{
			case 'upload':
				$this->_upload();
			break;
		}
	}
	
	/**
	 * Funciones ajaxs
     * @param object $entry objeto de youtube
	 * @return void | string
	 */		
	function findFlashUrl( $entry )
  {
      foreach ($entry->mediaGroup->content as $content) {
          if ($content->type === 'application/x-shockwave-flash') {
              return $content->url;
          }
      }
      return null;
  }	
	
	/**
	 * Sube un archivo
	 * @param boolean $ie6 es Internet Explorer 6
	 * @return array 
	 */		
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
                                               $source = 'LaMulaSRD', // a short string identifying your application
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
     $mediaGroup->title = $yt->newMediaTitle()->setText('LaMula ');
     $mediaGroup->description = $yt->newMediaDescription()->setText('Subido desde LaMula');

     $mediaGroup->keywords = $yt->newMediaKeywords()->setText('lamula');

     // the category must be a valid YouTube category
     // optionally set some developer tags (see Searching by Developer Tags for more details)
     $mediaGroup->category = array(
     $yt->newMediaCategory()->setText('Entertainment')->setScheme('http://gdata.youtube.com/schemas/2007/categories.cat'),
     );

     // set keywords
//     $mediaGroup->keywords = $service->newMediaKeywords()->setText('cars, funny');
     $myVideoEntry->mediaGroup = $mediaGroup;

     // upload URL for the currently authenticated user
     $uploadUrl = 'http://uploads.gdata.youtube.com/feeds/users/default/uploads';

     try {
       
       $newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
     
        //returns the video URL and the thumbnail URB
        getVideoThumbnails();
     
        if ( ($this->_is_ie6() == TRUE) OR ($ie != NULL))
        {
            //return htmlspecialchars($this->findFlashUrl($newEntry));
            return htmlspecialchars($newEntry->getVideoWatchPageUrl());
            
        }
        else
        {
          echo htmlspecialchars($newEntry->getVideoWatchPageUrl());
        }     
   


     

     } catch (Zend_Gdata_App_Exception $e) {
   
        return $e->getMessage();
        
     }
  
  
  
		
	}
	
  
	
	
}

/* End of file videos.php */
/* Location: ./system/application/controllers/backend/videos.php */
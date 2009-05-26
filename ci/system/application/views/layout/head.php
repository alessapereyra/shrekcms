<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load->helper('html'); ?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->config->item('charset'); ?>" />
<title><?php echo $seccion; ?></title>
<?php echo link_tag('css/reset.css'); ?>
<?php echo link_tag('css/style.css'); ?>

<!--  jQuery -->
<script src="<?php echo $this->config->item('base_url'); ?>/js/jquery.js" type="text/javascript" language="javascript"></script>

<!--  jQuery UI -->
<script src="<?php echo $this->config->item('base_url'); ?>/js/jquery-ui.js" type="text/javascript" language="javascript"></script>

<!--  jQuery UI CSS-->
<?php echo link_tag('css/jquery-ui.css'); ?>

<!--  magicpreview -->
<script src="<?php echo $this->config->item('base_url'); ?>/js/magicpreview.js" type="text/javascript" language="javascript"></script>


<!--  tiny editor -->
<script src="<?php echo $this->config->item('base_url'); ?>/js/tiny_mce/tiny_mce.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">

tinyMCE.init({
	theme_advanced_toolbar_location : "top",
	theme : "advanced",
	mode : "exact",
	elements : "texto, textos",
	extended_valid_elements:"a[name|href|target|title|onclick]",
  theme_advanced_buttons1 : "bold,italic,underline,separator,cut,copy,paste,separator,undo,redo,separator,justifycenter,justifyright,justifyfull,separator,link,unlink,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	height : "280"
});



</script>

<?php
if ($ie6 == FALSE)
{

	$subidon = array('fotos', 'documentos', 'articulos','videos','audios');
	$current_controller = $this->uri->segment(1);	
	if (in_array($this->uri->segment(1), $subidon)):
	switch ($current_controller)
	{
		case 'articulos':
			$name = 'Imagenes';
			$ext = '*.jpg;*.jpeg;*.png;*.gif';
			$url = ereg_replace('articulos', 'fotos', $this->me_url);	
		break;
		
		case 'fotos':
			$url = $this->me_url;
			$name = 'Imagenes';
			$ext = '*.jpg;*.jpeg;*.png;*.gif';
		break;

		case 'audios':
			$url = $this->me_url;
			$name = 'Audios';
			$ext = '*.mp3';
		break;

		case 'videos':
			$url = $this->me_url;
			$name = 'Videos';
			$ext = '*.mov';
		break;
		
		case 'documentos':
			$url = $this->me_url;
			$name = 'Documentos';
			$ext = '*.doc;*.pdf';
		break;
	}
	
	

	
	?>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/js/swfupload.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/js/swfupload.queue.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/js/fileprogress.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/js/handlers.js"></script>
	<?php echo link_tag('css/swfupload.css'); ?>
	
	<script type="text/javascript" language="javascript">
	var swfu;
	window.onload = function () {
		swfu = new SWFUpload({
			// Backend settings
			flash_url : "<?php echo $this->config->item('base_url'); ?>/mmedia/swfupload.swf",
			upload_url: "<?php echo $url; ?>ajax/upload",
			post_params: {"id" : "<?php echo $this->session->userdata('id'); ?>", 
						"PHPSESSID" : "<?php echo session_id(); ?>"},
			file_size_limit : "10 MB",
			file_types : "<?php echo $ext; ?>",
			file_types_description : "<?php echo $name?>",
			file_upload_limit : 10,
			file_queue_limit : 0,
			custom_settings : {
				progressTarget : "fsUploadProgress"
			},		
			debug: false,
	
			// Button settings
			button_image_url: "<?php echo $this->config->item('base_url'); ?>/images/XPButtonUploadText.png",
			button_width: 61,
			button_height: 22,
			button_placeholder_id: "spanButtonPlaceholder",
			
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete
		});
	};
	</script>
	<?php endif; ?>
<?php } ?>

<!--[if lte IE 7]>
	<?php echo link_tag('css/ie6.css'); ?>

<![endif]-->

<!--  form -->
<script type="text/javascript" language="javascript">
	var base_url = "<?php echo $this->config->item('base_url'); ?>";
	var site_url = "<?php echo $this->config->item('base_url') . $this->config->item('index_page'); ?>";
</script>
<script src="<?php echo $this->config->item('base_url'); ?>js/jquery.form.js" type="text/javascript" language="javascript"></script>

<!--[if !IE]><!-->

  <!--  theMagic -->
  <script src="<?php echo $this->config->item('base_url'); ?>/js/application.js" type="text/javascript" language="javascript"></script>

<!-- <![endif]-->


<!--[if IE]><!-- >

  <!--  theMagic -->
  <script src="<?php echo $this->config->item('base_url'); ?>/js/applicationie.js" type="text/javascript" language="javascript"></script>
	
	
<!-- <![endif]-->





</head>
<body>
  
  <div id="top_menu">
    <p>
      <span class="left">resistencia ciudadana | mi&eacute;rcoles, 29 de abril de 2009</span>
      <span class="right">
        <a href="http://lamula.pe/crear-blog/">crea tu blog</a> |
        <a href="http://lamula.pe/mulapress/ci">mándanos tu noticia</a>
      </span>
    </p>
  </div> <!-- top_menu -->

  <div id="wrapper">

      <div id="top_ad">
        <!-- <img src="/images/ad_bcp.png" alt="Ad BCP" title="AD BCP"/> -->
      </div> <!-- top_ad -->

      <div id="logo_bar">

        <h1><a href="http://lamula.pe/mulapress">La Mula</a></h1> 

        <div id="search_bar">
 
         	<?php if ($log) : ?>
    				<ul>
    					<li><a href="<?php echo "http://lamula.pe/mulapress/author/" . $user_name ?>" >Ver Perfil</a></li>
    					<li><?php echo anchor('log/logout', 'Salir'); ?></li>
    				</ul>
    			<?php endif; ?>		

      </div> <!-- search_bar -->

      </div> <!-- logo_bar -->

      <div id="status_bar">
          <h2 id="status">lamula est&aacute;... <strong>desaznadamente en linea</strong></h2>        
          <p id="site_stats">241 noticias enviadas, <a href="http://lamula.pe/mulapress/ci">env&iacute;a la tuya</a></p>
      </div> <!-- status_bar -->
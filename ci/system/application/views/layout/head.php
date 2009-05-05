<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load->helper('html'); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->config->item('charset'); ?>" />
<title><?php echo $seccion; ?></title>
<?php echo link_tag('css/reset.css'); ?>
<?php echo link_tag('css/style.css'); ?>

<!--  jQuery -->
<script src="<?php echo $this->config->item('base_url'); ?>js/jquery.js" type="text/javascript" language="javascript"></script>

<!--  jQuery UI -->
<script src="<?php echo $this->config->item('base_url'); ?>js/jquery-ui.js" type="text/javascript" language="javascript"></script>

<!--  jQuery UI CSS-->
<?php echo link_tag('css/jquery-ui.css'); ?>

<!--  tiny editor -->
<script src="<?php echo $this->config->item('base_url'); ?>js/tiny_mce/tiny_mce.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
tinyMCE.init({
	mode : "exact",
	elements : "texto"
});
</script>


<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/handlers.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/fileprogress.js"></script>


<script type="text/javascript" language="javascript">
var swfu;
window.onload = function () {
	swfu = new SWFUpload({
		// Backend settings
		flash_url : "<?php echo $this->config->item('base_url'); ?>mmedia/swfupload.swf",
		upload_url: "<?php echo $this->me_url; ?>ajax/upload",
		post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
		file_size_limit : "100 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button settings
		button_image_url: "<?php echo $this->config->item('base_url'); ?>images/XPButtonUploadText.png",
		button_width: "61",
		button_height: "22",
		button_placeholder_id: "spanButtonPlaceHolder",
		
		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event		
				
	});
};
</script>

<!--[if lte IE 6]>
	<?php echo link_tag('css/ie6.css'); ?>

<![endif]-->

<!--  theMagic -->
<script src="<?php echo $this->config->item('base_url'); ?>js/application.js" type="text/javascript" language="javascript"></script>


</head>
<body>


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


<script type="text/javascript" language="javascript">
	var swfu;

	// The uploadStart event handler. This function variable is assigned to upload_start_handler in the settings object 
	var myCustomUploadStartEventHandler = function (file) { var continue_with_upload; if (file.name === "the sky is blue") { continue_with_upload = true; } else { continue_with_upload = false; } return continue_with_upload; };

	 // The uploadSuccess event handler. This function variable is assigned to upload_success_handler in the settings object 
	 var myCustomUploadSuccessEventHandler = function (file, server_data, receivedResponse) { alert("The file " + file.name + " has been delivered to the server. The server responded with " + server_data); }; 
		
	window.onload = function () {
		var settings_object = {
				upload_url : "<?php echo $this->config->item('base_url'); ?>",
				flash_url : "<?php echo $this->config->item('base_url'); ?>mmedia/swfupload.swf",
				file_size_limit : "20 MB",

				upload_start_handler : myCustomUploadStartEventHandler,
				upload_success_handler : myCustomUploadSuccessEventHandler 					
		}; 

		swfu = new SWFUpload(settings_object); 
};
</script>

<!--[if lte IE 6]>
	<?php echo link_tag('css/ie6.css'); ?>

<![endif]-->

<!--  theMagic -->
<script src="<?php echo $this->config->item('base_url'); ?>js/application.js" type="text/javascript" language="javascript"></script>


</head>
<body>

	<div id="wrap">
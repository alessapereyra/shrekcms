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

<!--  tiny editor -->
<script src="<?php echo $this->config->item('base_url'); ?>/js/tiny_mce/tiny_mce.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
tinyMCE.init({
	mode : "exact",
	elements : "texto"
});
</script>


<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/js/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/js/handlers.js"></script>

<script type="text/javascript" language="javascript">
var swfu;
window.onload = function () {
	swfu = new SWFUpload({
		// Backend Settings
		upload_url: "<?php echo $this->me_url; ?>upload",
		post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},

		// File Upload Settings
		file_size_limit : "2 MB",	// 2MB
		file_types : "*.jpg",
		file_types_description : "JPG Images",
		file_upload_limit : "0",

		// Event Handler Settings - these functions as defined in Handlers.js
		//  The handlers are not part of SWFUpload but are part of my website and control how
		//  my website reacts to the SWFUpload events.
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_image_url : "<?php echo $this->config->item('base_url'); ?>/images/XPButtonUploadText.png",
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 180,
		button_height: 18,
		button_text : '<span class="button">Select Images <span class="buttonSmall">(2 MB Max)</span></span>',
		button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		
		// Flash Settings
		flash_url : "<?php echo $this->config->item('base_url'); ?>/mmedia/swfupload.swf",

		custom_settings : {
			upload_target : "divFileProgressContainer"
		},
		
		// Debug Settings
		debug: false
	});
};
</script>

<!--[if lte IE 6]>
	<?php echo link_tag('css/ie6.css'); ?>

<![endif]-->

<!--  theMagic -->
<script src="<?php echo $this->config->item('base_url'); ?>/js/application.js" type="text/javascript" language="javascript"></script>


</head>
<body>


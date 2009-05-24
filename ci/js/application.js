$(document).ready(function(){
	
     jQuery.fn.toggleText = function(a, b) {
     return this.each(function() {
     jQuery(this).text(jQuery(this).text() == a ? b : a);
     });
     };
	
	$("#localizar").tabs(
	{
		select: function(event, ui)
		{
			$("input[name='localizar']").attr("value", ui.panel.id);
		}
	});
	
	$("#lasts-posts").tabs();			
	
	$("#upload-content").tabs(
	{
		select: function(event, ui)
		{
			$("input[name='upload-content']").attr("value", ui.panel.id);
		}
	});
	
	function limpiarcombo(combo)
	{
		combo.attr("disabled","disabled");
		combo.html('');
	}
	
	function llenarcombo(combo, id)
	{
		limpiarcombo(combo);
		
		var combo_url = site_url + '/combo/' + combo.attr('id') + '/' + id; 

		html = $.ajax({
			  url: combo_url,
			  async: false
			 }).responseText;
		
		combo.html(html);
		
		combo.removeAttr("disabled");
	}
	
	$("#departamento").change( function () {

		llenarcombo($('#provincia'), $(this).val());

		limpiarcombo($('#distrito'));
	});
	

	$("#provincia").change( function () {
		
		llenarcombo($('#distrito'), $(this).val());
	});
	
	
	$("div#preview_content").hide();
	$("div#upload-content").hide();
	
	$('form#formulario_mula :text').magicpreview('pv_');
	$('form#formulario_mula :checkbox').magicpreview('pv_');
	$('form#formulario_mula :select').magicpreview('pv_');

	$("p#file_info a").click( function(){
		
		$("div#upload-content").toggle("fast");
		$(this).toggleText("Realmente no quería","Quiero agregar fotos")
		return false;
		
	})

 	$("a#link_to_preview").click( function(){
	
	$(this).toggleText("vista previa","continuar editando");
	$("div#preview_content").toggle("slow");
	$("fieldset#articulo_content").toggle("slow")
		
	$("#pv_texto").html("");
	content = tinyMCE.activeEditor.getContent({format : 'raw'});
	$("#pv_texto").html(content);
		
		return false;
	
});	
	
});
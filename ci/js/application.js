$(document).ready(function(){
	
	$("#localizar").tabs(
	{
		select: function(event, ui)
		{
			$("input[name='localizar']").attr("value", ui.panel.id);
		}
	});
	
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

	
});
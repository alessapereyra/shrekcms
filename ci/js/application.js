$(document).ready(function(){
	
	$("#localizar").tabs(
	{
		select: function(event, ui)
		{
			$("input[name='localizar']").attr("value", ui.panel.id);
		}
	});
	
});
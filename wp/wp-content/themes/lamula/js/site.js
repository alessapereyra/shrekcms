jQuery.noConflict();


jQuery(document).ready(function($) {
	
	 BACK = "todas";
	 BACK_STATES = "regresar";
   from_outside = true;
	 f_outside = true;
	 s_outside = true;
	 t_outside = true;
	
	 LAST_STATE = "";

	   jQuery.fn.toggleText = function(a, b) {
     return this.each(function() {
     jQuery(this).text(jQuery(this).text() == a ? b : a);
     });
     };
	 
   $("div.scrollable").scrollable({
	
			 size: 3
	
		});     
	
		//TODO agregarle los nombres de los enlazados.. ahora mismo :D
		 //fancybox
		 $('div.post_content a[rel="uploaded_photo"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		 $('div.post_content a[rel="uploaded_image"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		 
		 $('div.post_content a[rel="uploaded_audio"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		 $('div.post_content a[rel="uploaded_doc"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		$("div.top_news_featured:not(:first)").hide();
		$("div.class_content:not(:first)").hide();
		$("div.tab_content:not(:first)").hide();
		$("#ranking_usuarios .sidebox_content:not(:last)").hide();
		$("#articulos .sidebox_content:not(:last)").hide();
		$("div.posts_last_content:not(:first)").hide();
				
		$("ul#ranking_menu li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#ranking_menu li a").index(this);
				
				$("#ranking_usuarios .sidebox_content").hide("slow");
				$("#ranking_usuarios .sidebox_content:eq(" + index + ")").fadeIn("fast");
				return false;
		});
		
		$("div.top_news_item h3 a").click(function(){
			
			$(this).parent().parent().siblings().removeClass("portada-active");
			$(this).parent().parent().addClass("portada-active");
			
			var index = $("div.top_news_item h3 a").index(this);
			
			$(".top_news_featured").hide();
			
			$(".top_news_featured:eq(" + index + ")").show();					
				
			return false;
		});
		
		$("ul#articulos_menu li a").click(function(){
			
			$(this).parent().siblings().find("a").removeClass("selected");
			$(this).addClass("selected");
			
			var index = $("ul#articulos_menu li a").index(this);
			
			$("#articulos .sidebox_content").hide("slow");
			$("#articulos .sidebox_content:eq(" + index + ")").fadeIn("fast");
			return false;
		});		
		
		$("ul#lasts_posts li a").click(function(){
			
			$(this).parent().siblings().find("a").removeClass("active");
			$(this).addClass("active");
			
			var index = $("ul#lasts_posts li a").index(this);
			
			$(".posts_last_content").hide("slow");
			
			$(".posts_last_content:eq(" + index + ")").show("fast");					
				
			return false;
		})
	
		$("ul#category_tabs li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("active");
				$(this).addClass("active");
				
				var index = $("ul#category_tabs li a").index(this);
				
				$(".class_content").hide("slow");
				
				$(".class_content:eq(" + index + ")").show("fast");					
					
				return false;
		})
		
		$("ul#corresponsales li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#corresponsales li a").index(this);
				
				$(".tab_content").hide("slow");
				$(".tab_content:eq(" + index + ")").fadeIn("fast");
				return false;
		});
		
		$("ul#geomula li").hide();
		$("ul#geomula li.top").show();

		$("a.geomula").click(function(){
			$("ul#geomula li").hide();
			$("ul#geomula li.top").show();
			$("ul#geomula a").removeClass("current");
			return false;
		});
		
		$("ul#geomula a").click(function(){

			

			if ($(this).hasClass("last") != true)
			{
				//quita el current a todos
				$("ul#geomula a").removeClass("current");
				//Esconder a los hermanos
				$(this).parent().siblings().hide("fast");
				//Esconde a los hijos
				$(this).parent().find('li').hide("fast");
	
				//Muestra a los hijos
				$(this).next().children().show("fast");

				//agrega el current al actual
				$(this).addClass('current');
			}
   	      $.get(this.href, function(data){
   	     	  alert("Data Loaded: " + data);
  	     	  $('div#featured').html(data);
   	     	  $('div#featured').innerHtml(data);
   	     	});
	  
			return false;
		});
			
});

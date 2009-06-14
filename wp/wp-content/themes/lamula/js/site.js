jQuery.noConflict();


jQuery(document).ready(function($) {
	
	var geomula_html = '';
	
	 BACK = "todas";
	 BACK_STATES = "regresar";
   from_outside = true;
	 f_outside = true;
	 s_outside = true;
	 t_outside = true;
	
	 LAST_STATE = "";
	
	
			$('#bagua').flash({   
				
				// test.swf is the flash document 
				 swf: 'http://lamula.pe/mulapress/wp/wp-content/themes/lamula/bagua.swf',
				 width: 200,
		     wmode: "transparent"
			 });
	

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
		$("#ranking_usuarios .sidebox_content:not(:first)").hide();
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
		/*
		$("div.top_news_item h3 a").click(function(){
			
			$(this).parent().parent().siblings().removeClass("portada-active");
			$(this).parent().parent().addClass("portada-active");
			
			var index = $("div.top_news_item h3 a").index(this);
			
			$(".top_news_featured").hide();
			
			$(".top_news_featured:eq(" + index + ")").show();					
				
			return false;
		});
		*/
		/*
		function show_featured()
		{
			alert('asdf');
			$("div.top_news_item h3 a").parent().parent().siblings().removeClass("portada-active");
			$("div.top_news_item h3 a").parent().parent().addClass("portada-active");
			
			var index = $("div.top_news_item h3 a").index("div.top_news_item h3 a");
			
			$(".top_news_featured").hide();
			
			$(".top_news_featured:eq(" + index + ")").show();					
				
			return false;			
		}
		*/
		$("div.top_news_item h3 a").live("click",alert('asssssf'));
		
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
		$("ul#geomula").show("fast");
		
		$("a.geomula").click(function(){
			$("ul#geomula li").hide();
			$("ul#geomula li.top").show();
			$("ul#geomula a").removeClass("current");
			$("ul#geomula a").removeClass("current_father");
			$("ul#geomula a").removeClass("current_grandfather");
 	    	  if (geomula_html != '')
   	    	  {
 	    		 $('div#top_news').html(geomula_html);
   	    	  }				
			return false;
		});
		
		$("ul#geomula a").click(function(){

			$("a.geomula").addClass("current");
			//quita el current a todos
			$("ul#geomula a").removeClass("current");
			$("ul#geomula a").removeClass("current_father");
			$("ul#geomula a").removeClass("current_grandfather");
			//agrega el current al actual
			$(this).addClass('current');
			$(this).parent().parent().parent().find("a:first").addClass('current_father');				
			$(this).parent().parent().parent().parent().parent().find("a:first").addClass('current_grandfather');			

			//return false;
			window.location.hash = $(this).attr("rel");

			if ($(this).hasClass("last") != true)
			{
				//Esconder a los hermanos
				$(this).parent().siblings().hide("fast");
				//Esconde a los hijos
				$(this).parent().find('li').hide("fast");
	
				//Muestra a los hijos
				$(this).next().children().show("fast");
			}
			
			if (this.href != 'http://localhost/shrekcms/wp/#')
			{
				//alert(this.href);
		   	      $.get(this.href, function(data){
		   	    	  if (geomula_html == '')
		   	    	  {
		   	    		geomula_html = $('div#top_news').html();
		   	    	  }
		  	     	  $('div#top_news').html(data);
		   	     	  //$('div#featured').innerHtml(data);
		  	     	  //alert(geomula_html);
		   	     	});
			}
			
			return false;
		});
		
		$("div#top_news_media img").click(function(){
			
			//TODO aca carga el video
			$youtube_link = $(this).attr("title");
			
			if ( $youtube_link != '')
			{
						var Color1 = "";
						var Color2 = "";
						var FS = "";
						var Border = "";
						var Autoplay = "";
						var Loop = "";
						var ShowSearch = "";
						var ShowInfo = "";
						var HD = "";
						swfobject.embedSWF(
							"http://www.youtube.com/v/" + PreviewID + Color1 + Color2 + Autoplay + Loop + Border + "&rel=" + Rel + "&showsearch=" + ShowSearch + "&showinfo=" + ShowInfo + FS + HD,
							"top_news_media",
							200,
							300,
							"9"
						);
			}
			return false;
		});
			
});

jQuery.noConflict();

jQuery(document).ready(function($) {
	
	var geomula_html = '';
	
	 
	jQuery.fn.toggleText = function(a, b)
							{
								return this.each(function()
								{
									jQuery(this).text(jQuery(this).text() == a ? b : a);
								});
							};	
	
	
	    // initialize scrollable  
	   $("div.scrollable").scrollable({

				 size: 3

			});
		 
		 //fancybox
	   	/*
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
		*/
		$("div.class_content").hide();
		$("div.class_content:first").show();
		
		$("div.tab_content").hide();
		$("div.tab_content:first").show();
	
		$(".sidebox_content").hide();
		//$("div.first").show();
		$("#ranking_usuarios .sidebox_content:first").show();
		$("#articulos .sidebox_content:first").show();
	
		$("div.posts_last_content").hide();
		$("div.posts_last_content:first").show();
		
		$("div.top_news_featured").hide();
		$("div.top_news_featured:first").show();
	
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

			if ($(this).attr("rel") != '')
			{
				location.hash = $(this).attr("rel");
			}
			
			if ($(this).hasClass("last") != true)
			{
				//Esconder a los hermanos
				$(this).parent().siblings().hide("fast");
				//Esconde a los hijos
				$(this).parent().find('li').hide("fast");
	
				//Muestra a los hijos
				$(this).next().children().show("fast");
			}
			
			if (this.href != 'http://lamula.pe/mulapress/#')
			{
		   	      $.get(this.href, function(data){
		   	    	  if (geomula_html == '')
		   	    	  {
		   	    		geomula_html = $('div#top_news').html();
		   	    	  }
		  	     	  $('div#top_news').html(data);
			  			$("div.top_news_featured").hide();
			  			$("div.top_news_featured:first").show();
		   	     	});
			}
			
			return false;
		});		
	
		$("ul#ranking_menu li a").click(function(){
			
			$(this).parent().siblings().find("a").removeClass("selected");
			$(this).addClass("selected");
			
			var index = $("ul#ranking_menu li a").index(this);
			
			$("#ranking_usuarios .sidebox_content").hide();
			$("#ranking_usuarios .sidebox_content:eq(" + index + ")").show();
			return false;
	});
	
		$("div.top_news_item h3 a").live("click", function(){
		
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
		
		$("#articulos .sidebox_content").hide();
		$("#articulos .sidebox_content:eq(" + index + ")").show();
		return false;
	});		
	
		$("ul#lasts_posts li a").click(function(){
			
			$(this).parent().siblings().find("a").removeClass("active");
			$(this).addClass("active");
			
			var index = $("ul#lasts_posts li a").index(this);
			
			$(".posts_last_content").hide();
			
			$(".posts_last_content:eq(" + index + ")").show();					
				
			return false;
		});
	
		$("ul#category_tabs li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("active");
				$(this).addClass("active");
				
				var index = $("ul#category_tabs li a").index(this);
				
				$(".class_content").hide();
				
				$(".class_content:eq(" + index + ")").show();					
					
				return false;
		});
		
		$("ul#corresponsales li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#corresponsales li a").index(this);
				
				$(".tab_content").hide();
				$(".tab_content:eq(" + index + ")").show();
				return false;
		});
					
				/*

		*/
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
			       // 
			       // 			
			       // 
			       // var skin = {};
			       //             skin['BORDER_COLOR'] = 'transparent';
			       //             skin['ENDCAP_BG_COLOR'] = 'transparent';
			       //             skin['ENDCAP_TEXT_COLOR'] = '#333333';
			       //             skin['ENDCAP_LINK_COLOR'] = '#0000cc';
			       //             skin['ALTERNATE_BG_COLOR'] = 'transparent';
			       //             skin['CONTENT_BG_COLOR'] = 'transparent';
			       //             skin['CONTENT_LINK_COLOR'] = '#0000cc';
			       //             skin['CONTENT_TEXT_COLOR'] = '#333333';
			       //             skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
			       //             skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
			       //             skin['CONTENT_HEADLINE_COLOR'] = '#333333';
			       //             skin['HEADER_TEXT'] = 'Historias recomendadas';
			       //             skin['RECOMMENDATIONS_PER_PAGE'] = '5';
			       //             google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
			       //             google.friendconnect.container.renderOpenSocialGadget(
			       //              { id: 'div-6886351088514799323',
			       //                url:'http://www.google.com/friendconnect/gadgets/recommended_pages.xml',
			       //                site: '18025864853307811361',
			       //                'view-params':{"docId":"recommendedPages"}
			       //              },
			       //               skin);
	
});

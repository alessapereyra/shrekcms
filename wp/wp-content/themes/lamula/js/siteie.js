$(document).ready(function() {
	
	 BACK = "todas";
	 BACK_STATES = "regresar";
  from_outside = true;
	 LAST_STATE = "";
	
	    // initialize scrollable  
	    $("div.scrollable").scrollable();     

		 
		 //fancybox
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
	
		$("div.class_content").hide();
		$("div.class_content:first").show();
		$("div.tab_content").hide();
		$("div.tab_content:first").show();
	
		$("div.sidebox_content").hide();
		$("div.sidebox_content:first").show();
	
		$("div.posts_last_content").hide();
		$("div.posts_last_content:first").show();
	 
		$("ul#lasts_posts li a").click(function(){
			
			$(this).parent().siblings().find("a").removeClass("active");
			$(this).addClass("active");
			
			var index = $("ul#lasts_posts li a").index(this);
			
			$(".posts_last_content").hide();
			
			$(".posts_last_content:eq(" + index + ")").show();					
				
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
		})


		$("ul#articulos_menu li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#articulos li a").index(this);
				
				$("articulos .sidebox_content").hide("slow");
				$("articulos .sidebox_content:eq(" + index + ")").fadeIn("fast");
				return false;
		})	

		$("ul#ranking_menu li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#articulos li a").index(this);
				
				$("ranking .sidebox_content").hide("slow");
				$("ranking .sidebox_content:eq(" + index + ")").fadeIn("fast");
				return false;
		})	


		$("ul#menu > li > a").click(function(){
			
			
						father = $(this).parent();

						//Hides all the siblings
						father.siblings().toggle("fast");
			
						//Shows all the childs "li"
						childs = father.find("li");
						childs.toggle("fast");
		
						//Setups get back content
						//TODO: I hate how this works
						if ($(this)[0].textContent != BACK){
				
							$(this)[0].textContent = BACK;
							$(this)[0].addClass("current_option");
				
						}
						else {
				
							$(this)[0].textContent = childs[0].innerHTML;
							$(this)[0].removeClass("current_option");				
						}
		
			
		});
		
		
			$("ul#menu li ul > li a").click(function(){

				//alert();

					father = $(this).parent();

					//Hides all the siblings
					//Shows all the childs "li"
					childs = father.find("ul");
			//		alert ( childs.children().length );

						if (childs.children().length > 1 ) { 

						father.siblings().toggle("fast");
						father.siblings().removeClass("current");
						$("li.s a").removeClass("current_option");
						$(father.siblings()[0]).addClass("current");

						childs.toggle("fast");

						//Setups get back content
						//TODO: I hate how this works

			//				$(this)[0].textContent = BACK_STATES;
						if (from_outside)
						{
								from_outside = false;
								$(this).addClass("current_option");							
						}
						else 
							{
								from_outside = true;
							}

					
					}

			});
	
	
});

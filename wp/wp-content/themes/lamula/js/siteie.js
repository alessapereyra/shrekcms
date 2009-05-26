$(document).ready(function() {
	
	 BACK = "todas"
	 BACK_STATES = "regresar"
		 
		 //fancybox
		 $('div.post_content a[rel="fancybox"]').fancybox({
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

		$("ul#articulos li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#articulos li a").index(this);
				
				$(".sidebox_content").hide("slow");
				$(".sidebox_content:eq(" + index + ")").fadeIn("fast");
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
				
						}
						else {
				
							$(this)[0].textContent = childs[0].innerHTML;
				
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

						childs.toggle("fast");

						//Setups get back content
						//TODO: I hate how this works
						if ($(this)[0].textContent != BACK_STATES ){

							$(this)[0].textContent = BACK_STATES;

						}
						else {

							$(this)[0].textContent = childs.children()[0].children()[1].innerHTML;

						}
					
					}

			});
	
	
});

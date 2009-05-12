$(document).ready(function() {
	
	 BACK = "todas"
	 BACK_STATES = "regresar"
	
		 $("div.class_content:not(:first)").hide("slow");
	 //$("div.class_content:first").show("fast");
	 
		 
		$("ul#category_tabs li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("active");
				$(this).addClass("active");
				
				var index = $("ul#category_tabs li a").index(this);
				
				$(".class_content").hide("slow");
				$(".class_content:eq(" + index + ")").fadeIn("fast");
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

							$(this)[0].textContent = childs.children()[0].innerHTML;

						}
					
					}

			});
	
	
});

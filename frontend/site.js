$(document).ready(function() {
	
	
		$("ul#menu > li > a").click(function(){
			
						alert("hi");	
			
						father = $(this).parent();

						//Hides all the siblings
						father.siblings().toggle("fast");
			
						//Shows all the childs "li"
						childs = father.find("li");
						childs.toggle("fast");
		
						//Setups get back content
						//TODO: I hate how this works
						if ($(this)[0].textContent != "<"){
				
							$(this)[0].textContent = "<";
				
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
					childs = father.find("li");
					alert ( childs.length );

						if (childs.length > 1 ) { 

						father.siblings().toggle("fast");

						childs.toggle("fast");

						//Setups get back content
						//TODO: I hate how this works
						if ($(this)[0].textContent != "<"){

							$(this)[0].textContent = "<";

						}
						else {

							$(this)[0].textContent = childs[0].innerHTML;

						}
					
					}

			});
	
	
});
